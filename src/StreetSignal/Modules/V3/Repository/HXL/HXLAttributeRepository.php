<?php

/**
 * StreetSignal HXLTag Repository, using Kohana::$config
 *
 * @author    StreetSignal Team <team@streetsignal.com>
 * @package   StreetSignal\Application
 * @copyright 2014 Ushahidi
 * @license   https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Repository\HXL;

use Ohanzee\Database;
use StreetSignal\Core\Tool\SearchData;
use StreetSignal\Core\Entity\HXL\HXLAttribute;
use StreetSignal\Modules\V3\Repository\OhanzeeRepository;
use StreetSignal\Contracts\Repository\ReadRepository;
use StreetSignal\Contracts\Repository\SearchRepository;
use StreetSignal\Contracts\Repository\Entity\HXLAttributeRepository as HXLAttributeRepositoryContract;

class HXLAttributeRepository extends OhanzeeRepository implements
    HXLAttributeRepositoryContract,
    SearchRepository,
    ReadRepository
{
    private $tags_attributes;

    public function __construct(\StreetSignal\Core\Tool\OhanzeeResolver $resolver)
    {
        parent::__construct($resolver);
    }

    // OhanzeeRepository
    protected function getTable()
    {
        return 'hxl_attributes';
    }

    public function getSearchFields()
    {
        return ['attribute'];
    }

    public function setSearchConditions(SearchData $search)
    {
        $query = $this->search_query;
        return $query;
    }

    /**
     * @param array|null $data
     * @return \StreetSignal\Contracts\Entity
     */
    public function getEntity(array $data = null)
    {
        return new HXLAttribute($data);
    }
}
