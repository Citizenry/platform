<?php

/**
 * StreetSignal Platform Admin Update Message Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Usecase;

interface UpdateMessageRepository
{
    /**
     * @param  String $status
     * @param  String $direction
     * @return Boolean
     */
    public function checkStatus($status, $direction);
}
