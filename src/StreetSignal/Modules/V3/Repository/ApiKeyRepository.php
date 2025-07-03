<?php

/**
 * StreetSignal ApiKey Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Repository;

use Ramsey\Uuid\Uuid;
use StreetSignal\Contracts\Entity;
use StreetSignal\Core\Tool\SearchData;
use StreetSignal\Core\Entity\ApiKey;
use StreetSignal\Contracts\Repository\Entity\ApiKeyRepository as ApiKeyRepositoryContract;
use StreetSignal\Core\Concerns\AdminAccess;

class ApiKeyRepository extends OhanzeeRepository implements ApiKeyRepositoryContract
{
    use AdminAccess;

    protected function getTable()
    {
        return 'apikeys';
    }

    public function getEntity(array $data = null)
    {
        return new ApiKey($data);
    }

    // OhanzeeRepository
    public function setSearchConditions(SearchData $search)
    {
        $query = $this->search_query;

        return $query;
    }

    // CreateRepository
    public function create(Entity $entity)
    {

        $record = $entity->asArray();

        $uuid = Uuid::uuid4();
        $record['api_key'] = $uuid->toString();

        $state = [
            'created' => time(),
        ];

        return $this->executeInsert($this->removeNullValues($record));
    }

    // UpdateRepository
    public function update(Entity $entity)
    {
        $record = $entity->asArray();
        $record['updated'] = time();

        $uuid = Uuid::uuid4();
        $record['api_key'] = $uuid->toString();

        return $this->executeUpdate(['id' => $entity->id], $record);
    }

    public function apiKeyExists($api_key)
    {
        return (bool) $this->selectCount(compact('api_key'));
    }

    public function getSearchFields()
    {
        return [
        ];
    }
}
