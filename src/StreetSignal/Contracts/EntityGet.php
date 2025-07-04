<?php

/**
 * Repository for Gettable Entities
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2022 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html
 *             GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts;

interface EntityGet
{
    /**
     * @param  mixed $id
     * @param  array $options
     *
     * @return \StreetSignal\Contracts\Entity
     */
    public function get($id);

    /**
     * Converts an array of entity data into an object.
     * @param  array $data
     * @return \StreetSignal\Contracts\Entity
     */
    public function getEntity(array $data = null);
}
