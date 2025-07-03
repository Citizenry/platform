<?php

/**
 * Repository for Extant Entities
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2022 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html
 *             GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts;

interface EntityExists
{
    /**
     * @param  mixed $id
     *
     * @return boolean
     */
    public function exists($id);
}
