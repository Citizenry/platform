<?php

/**
 * StreetSignal Admin Access Trait
 *
 * Gives objects one new method:
 * `isUserAdmin(User $user)`
 *
 * This checks if `$user` has an admin role
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Concerns;

use StreetSignal\Contracts\Entity as User;

trait AdminAccess
{
    /**
     * Check if the user has an Admin role
     * @param  \StreetSignal\Contracts\Entity  $user
     * @return boolean
     */
    protected function isUserAdmin(User $user)
    {
        return ($user->id && $user->role === 'admin');
    }
}
