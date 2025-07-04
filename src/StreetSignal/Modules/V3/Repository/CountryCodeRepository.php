<?php

/**
 * StreetSignal Config Repository, using Kohana::$config
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Repository;

use StreetSignal\Core\Tool\SearchData;
use StreetSignal\Core\Entity\CountryCode;
use StreetSignal\Contracts\Repository\ReadRepository;
use StreetSignal\Contracts\Repository\SearchRepository;
use StreetSignal\Contracts\Repository\Entity\CountryCodeRepository as CountryCodeRepositoryContract;

class CountryCodeRepository extends OhanzeeRepository implements
    CountryCodeRepositoryContract,
    ReadRepository,
    SearchRepository
{
    // OhanzeeRepository
    protected function getTable()
    {
        return 'country_codes';
    }

    public function getSearchFields()
    {
        return ['country_code', 'dial_code'];
    }

    public function setSearchConditions(SearchData $search)
    {
        $query = $this->search_query;
        return $query;
    }

    public function getEntity(array $data = null)
    {
        return new CountryCode($data);
    }
}
