<?php

/**
 * StreetSignal Password Hasher
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Tool\Hasher;

use StreetSignal\Contracts\Hasher;

class Password implements Hasher
{
    public function hash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
}
