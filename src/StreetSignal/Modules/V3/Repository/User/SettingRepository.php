<?php

/**
 * StreetSignal User Setting Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2018 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Repository\User;

use StreetSignal\Contracts\Entity;
use StreetSignal\Core\Tool\SearchData;
use StreetSignal\Core\Entity\UserSetting;
use StreetSignal\Contracts\Repository\Entity\UserSettingRepository as UserSettingRepositoryContract;
use StreetSignal\Modules\V3\Repository\OhanzeeRepository;

class SettingRepository extends OhanzeeRepository implements
    UserSettingRepositoryContract
{
    // OhanzeeRepository
    protected function getTable()
    {
        return 'user_settings';
    }

    // CreateRepository
        // ReadRepository
    public function getEntity(array $data = null)
    {
        return new UserSetting($data);
    }

    // SearchRepository
    public function getSearchFields()
    {
        return ['user_id'];
    }

    // OhanzeeRepository
    protected function setSearchConditions(SearchData $search)
    {
        $query = $this->search_query;

        if ($search->user_id) {
            $query->where('user_id', '=', $search->user_id);
        }
    }

    // UserSettingRepository
    public function getByUser($user_id)
    {
        $query = $this->selectQuery(compact($user_id));
        $results = $query->execute($this->db());

        return $this->getCollection($results->as_array());
    }

    // UserSettingRepository
    public function getConfigKeyByUser($user_id, $config_key)
    {
        $entity = $this->getEntity(
            $this->selectOne(['user_id' => $user_id, 'config_key' =>  $config_key])
        );
        return $entity;
    }

    // UserSettingRepository
    public function existsInUserSetting($user_id)
    {
        return (bool) $this->selectCount(compact('user_id'));
    }

    public function create(Entity $entity)
    {
        $record = $entity->asArray();
        $record['created'] = time();

        $id = $this->executeInsert($this->removeNullValues($record));

        return $id;
    }

    public function update(Entity $entity)
    {
        $record = $entity->asArray();
        $record['updated'] = time();

        return $this->executeUpdate(['id' => $entity->id], $record);
    }

    public function userConfigKeyPairExists($user_id, $config_key)
    {
        return (bool) $this->selectCount(compact('user_id', 'config_key'));
    }
}
