<?php

/**
 * StreetSignal Guest Access Trait
 *
 * Gives objects one new method:
 * `isUserGuest(User $user)`
 *
 * This checks if `$user` is not logged in.
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Concerns;

use StreetSignal\Contracts\Entity;

trait GuestAccess
{
    /**
     * Check if $user is unloaded or has the "guest" role
     */
    protected function isUserGuest(Entity $user)
    {
        return (!$user->id || $user->role === 'guest');
    }
}
