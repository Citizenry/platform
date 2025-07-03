<?php

/**
 * StreetSignal Platform Admin Read Tos Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2017 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Entity;

interface ReadTosRepository
{
    /**
     * @param  int $id
     * @return \StreetSignal\Contracts\Entity
     */
    public function get($id);
}
