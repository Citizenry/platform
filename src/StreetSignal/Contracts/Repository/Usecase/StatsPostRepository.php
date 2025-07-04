<?php

/**
 * StreetSignal Platform Stats Post Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Usecase;

use StreetSignal\Core\Tool\SearchData;

interface StatsPostRepository
{

    /**
     * Get grouped totals for stats
     * @param  SearchData $search
     * @return Array
     */
    public function getGroupedTotals(SearchData $search);
}
