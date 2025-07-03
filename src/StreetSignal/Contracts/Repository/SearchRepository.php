<?php

/**
 * StreetSignal Search Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository;

use StreetSignal\Contracts\Search;

interface SearchRepository
{
    /**
     * Converts an array of entity data into an object.
     * @param array $data
     * @return \StreetSignal\Contracts\Entity
     */
    public function getEntity(array $data = null);

    /**
     * Get fields that can be used for searches.
     * @return array
     */
    public function getSearchFields();

    /**
     * @param \StreetSignal\Contracts\Search $search
     *
     * @return $this
     */
    public function setSearchParams(Search $search);

    /**
     * @return [StreetSignal\Core\Entity, ...]
     */
    public function getSearchResults();

    /**
     * @return Integer
     */
    public function getSearchTotal();
}
