<?php

/**
 * StreetSignal Platform Entity Search Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2017 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Tos;

use StreetSignal\Core\Usecase\SearchUsecase;

class SearchTos extends SearchUsecase
{
    /**
     * Get filter parameters that are used for paging.
     *
     * @return Array
     */
    protected function getPagingFields()
    {
        return [
            'orderby' => 'agreement_date',
            'order'   => 'desc',
            'limit'   => 1,
            'offset'  => 0
        ];
    }
}
