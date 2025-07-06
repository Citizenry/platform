<?php

/**
 * StreetSignal User Repository
 *
 * Also implements registration checks
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Repository;

use DB;
use Illuminate\Support\Str;
use StreetSignal\Contracts\Entity;
use StreetSignal\Contracts\Hasher;
use StreetSignal\Core\Entity\User;
use StreetSignal\Core\Concerns\Event;
use StreetSignal\Core\Entity\Contact;
use Illuminate\Support\Collection;
use StreetSignal\Core\Tool\SearchData;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use StreetSignal\Contracts\Repository\Usecase\UserRegisterRepository;
use StreetSignal\Contracts\Repository\Usecase\UserResetPasswordRepository;
use StreetSignal\Contracts\Repository\Entity\UserRepository as UserRepositoryContract;

class UserRepository extends BaseRepository implements
    UserRepositoryContract,
    UserRegisterRepository,
    UserResetPasswordRepository
{
    /**
     * @var Hasher
     */
    protected $hasher;

    // Use Event trait to trigger events
    use Event;

    use Concerns\UsesBulkAutoIncrement;

    /**
     * @param  Hasher $hasher
     * @return $this
     */
    public function setHasher(Hasher $hasher)
    {
        $this->hasher = $hasher;
        return $this;
    }

    // OhanzeeRepository
    protected function getTable()
    {
        return 'users';
    }

    // OhanzeeRepository
    public function getEntity(array $data = null)
    {
        if (!empty($data['id'])) {
            $data += [
                'contacts' => $this->getContacts($data['id']),
            ];
        }
        return new User($data);
    }

    protected function getContacts($entity_id)
    {
        // Unfortunately there is a circular reference created if the Contact repo is
        // injected into the User repo to avoid this we access the table directly
        // NOTE: This creates a hard coded dependency on the table naming for contacts
        $results = $this->db()->table('contacts')
                    ->where('user_id', '=', $entity_id)
                    ->get();

        return $results->toArray();
    }

    // CreateRepository
    public function create(Entity $entity)
    {
        $state = [
            'created'  => time(),
            'password' => $this->hasher->hash($entity->password),
        ];
        $entity->setState($state);
        if ($entity->role === 'admin') {
                $this->updateIntercomAdminUsers($entity);
        }
        return parent::create($entity);
    }

    // CreateRepository
    public function createWithHash(Entity $entity)
    {
        $state = [
            'created'  => time()
        ];
        $entity->setState($state);
        if ($entity->role === 'admin') {
                $this->updateIntercomAdminUsers($entity);
        }

        return parent::create($entity);
    }

    public function createMany(Collection $collection) : array
    {
        $this->checkAutoIncMode();

        $first = $collection->first()->asArray();
        unset($first['contacts']);
        $columns = array_keys($first);

        $values = $collection->map(function ($entity) {
            $data = $entity->asArray();

            if ($data['password']) {
                $data['password'] = $this->hasher->hash($data['password']);
            }

            unset($data['contacts']);
            $data['created'] = time();

            return $data;
        })->all();

        // For multiple inserts, we need to insert them one by one to get IDs
        $newIds = [];
        foreach ($values as $value) {
            $newIds[] = $this->db()->table($this->getTable())->insertGetId($value);
        }
        $insertId = $newIds[0];
        $created = count($values);
        // Use the actual IDs we collected during insertion

        $contacts = collect($newIds)
            ->combine($collection)
            ->map(function ($entity, $id) {
                return collect($entity->contacts)->map(function ($data) use ($id) {
                    return new Contact($data + ['user_id' => $id]);
                })->all();
            })
            ->flatten(1);

        if ($contacts->isNotEmpty()) {
            service('repository.contact')->createMany($contacts);
        }

        return $newIds;
    }

    // UpdateRepository
    public function update(Entity $entity)
    {
        $user = $entity->getChanged();

        unset($user['contacts']);

        $user['updated'] = time();

        if ($entity->hasChanged('password')) {
            $user['password'] = $this->hasher->hash($entity->password);
        }

        if ($entity->role === 'admin') {
            $this->updateIntercomAdminUsers($entity);
        }

        return $this->executeUpdate(['id' => $entity->id], $user);
    }

    // SearchRepository
    public function getSearchFields()
    {
        return ['email', 'role', 'q' /* LIKE realname, email */];
    }

    // SearchRepository
    public function setSearchConditions(SearchData $search)
    {
        $query = $this->search_query;
        $table = $this->getTable();

        if ($search->q) {
            $query->where(function($q) use ($search) {
                $q->where('email', 'LIKE', "%" . $search->q . "%")
                  ->orWhere('realname', 'LIKE', "%" . $search->q . "%");
            });

            // Adding search contacts
            $query->leftJoin('contacts', "$table.id", '=', 'contacts.user_id')
                  ->orWhere('contacts.contact', 'like', '%' . $search->q . '%');
        }

        if ($search->role) {
            $role = $search->role;
            if (!is_array($search->role)) {
                $role = explode(',', $search->role);
            }

            $query->whereIn('role', $role);
        }

        return $query;
    }

    // UserRepository
    public function getByEmail($email)
    {
        return $this->getEntity($this->selectOne(compact('email')));
    }

    // RegisterRepository
    public function isUniqueEmail($email)
    {
        return $this->selectCount(compact('email')) === 0;
    }

    // RegisterRepository
    public function register(Entity $entity)
    {

        return $this->executeInsert([
            'realname' => $entity->realname,
            'email'    => $entity->email,
            'password' => $this->hasher->hash($entity->password),
            'created'  => time()
            ]);
    }

    // ResetPasswordRepository
    public function getResetToken(Entity $entity)
    {
        $token = sprintf('%06X', mt_rand(0, 16777215));

        $input = [
            'reset_token' => $token,
            'user_id' => $entity->id,
            'created' => time()
        ];

        // Save the token
        $this->db()->table('user_reset_tokens')->insert($input);

        return $token;
    }

    // ResetPasswordRepository
    public function isValidResetToken($token): bool
    {
        $count = $this->db()->table('user_reset_tokens')
            ->where('reset_token', '=', $token)
            ->where('created', '>', time() - 1800) // Expire tokens after less than 30 mins
            ->count();

        return $count !== 0;
    }

    // ResetPasswordRepository
    public function setPassword($token, $password)
    {
        $userId = $this->db()->table('user_reset_tokens')
            ->where('reset_token', '=', $token)
            ->value('user_id');

        if ($userId) {
            $this->executeUpdate(['id' => $userId], [
                'password' => $this->hasher->hash($password)
            ]);
        }
    }

    // ResetPasswordRepository
    public function deleteResetToken($token)
    {
        $this->db()->table('user_reset_tokens')
            ->where('reset_token', '=', $token)
            ->delete();
    }

    /**
     * Get total count of entities
     * @param  array $where
     *
     * @return int
     */
    public function getTotalCount(array $where = [])
    {
        return $this->selectCount($where);
    }

    // DeleteRepository
    public function delete(Entity $entity)
    {
        if ($entity->role === 'admin') {
                $this->updateIntercomAdminUsers($entity);
        }
        return parent::delete($entity);
    }

    /**
     * Pass User count to Intercom
     * takes a postive/negative offset by which to increase/decrease count for create/delete
     * @param Integer $offset
     * @return void
     */
    protected function updateIntercomAdminUsers($user)
    {
        $this->emit($this->event, $user);
    }
}
