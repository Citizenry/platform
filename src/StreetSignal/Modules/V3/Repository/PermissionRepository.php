<?php

/**
 * StreetSignal Permission Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Repository;

use StreetSignal\Core\Tool\SearchData;
use StreetSignal\Core\Entity\Permission;
use StreetSignal\Contracts\Repository\Entity\PermissionRepository as PermissionRepositoryContract;

class PermissionRepository extends OhanzeeRepository implements
    PermissionRepositoryContract
{
    // OhanzeeRepository
    protected function getTable()
    {
        return 'permissions';
    }

    // OhanzeeRepository
    public function getEntity(array $data = null)
    {
        return new Permission($data);
    }

    public function getSearchFields()
    {
        return ['q', /* LIKE name */];
    }

    // SearchRepository
    public function setSearchConditions(SearchData $search)
    {
        $query = $this->search_query;

        if ($search->q) {
            $query->where('name', 'LIKE', "%" .$search->q ."%");
        }

        return $query;
    }

    // StreetSignalRepository
    public function exists($permission)
    {
        return (bool) $this->selectCount(['name' => $permission]);
    }
}
