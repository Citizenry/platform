<?php

/**
 * StreetSignal Platform Search Form Role Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Form;

class SearchFormRole extends SearchFormAttribute
{
    /**
     * Get filter parameters and default values that are used for paging.
     *
     * @return Array
     */
    protected function getPagingFields()
    {
        return [
            'orderby' => 'role_id',
            'order'   => 'asc',
            'limit'   => null,
            'offset'  => 0
        ];
    }
}
