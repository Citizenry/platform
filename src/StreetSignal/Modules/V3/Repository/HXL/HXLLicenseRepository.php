<?php

/**
 * StreetSignal HXLTag Repository, using Kohana::$config
 *
 * @author    StreetSignal Team <team@streetsignal.com>
 * @package   StreetSignal\Application
 * @copyright 2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license   https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Repository\HXL;

use StreetSignal\Core\Tool\SearchData;
use StreetSignal\Core\Entity\HXL\HXLLicense;
use StreetSignal\Contracts\Repository\Entity\HXLLicenseRepository as HXLLicenseRepositoryContract;
use StreetSignal\Modules\V3\Repository\BaseRepository;

class HXLLicenseRepository extends BaseRepository implements
    HXLLicenseRepositoryContract
{
    // OhanzeeRepository
    protected function getTable()
    {
        return 'hxl_license';
    }

    public function getSearchFields()
    {
        return ['name', 'code'];
    }


    /**
     * @param SearchData $search
     * Search by license code
     */
    public function setSearchConditions(SearchData $search)
    {
        $query = $this->search_query;
        if ($search->code) {
            $query->where('code', '=', $search->code);
        }
        if ($search->name) {
            $query->where('name', '=', $search->name);
        }
        return $query;
    }

    public function getEntity(array $data = null)
    {
        return new HXLLicense($data);
    }
}
