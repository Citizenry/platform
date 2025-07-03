<?php

/**
 * Repository for Creating Many Entities
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html
 *             GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts;

use Illuminate\Support\Collection;

interface EntityCreateMany
{
    /**
     * @param \Illuminate\Support\Collection $collection
     * @return array|\Illuminate\Support\Collection ids of rows created
     */
    public function createMany(Collection $collection);
}
