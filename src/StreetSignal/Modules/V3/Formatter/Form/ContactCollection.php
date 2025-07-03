<?php

/**
 * StreetSignal API Formatter for Form Role
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Formatter\Form;

use StreetSignal\Modules\V3\Formatter\API;
use StreetSignal\Core\Concerns\FormatterAuthorizerMetadata;
use StreetSignal\Core\Tool\SearchData;

class ContactCollection extends API
{
    use FormatterAuthorizerMetadata;

    public function __invoke($entities = [])
    {
        $data = [];
        foreach ($entities as $entity) {
            $data[] = $entity->asArray();
        }
        return $data;
    }

    /**
     * Store paging parameters.
     *
     * @param  SearchData $search
     * @param  Integer    $total
     * @return $this
     */
    public function setSearch(SearchData $search, $total = null)
    {
        $this->search = $search;
        $this->total  = $total;
        return $this;
    }
}
