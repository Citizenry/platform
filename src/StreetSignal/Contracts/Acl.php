<?php

/**
 * StreetSignal Platform Acl interface
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts;

interface Acl
{
    /**
     * Check if user has permissions
     *
     * @param \StreetSignal\Contracts\Entity $user
     * @param string $permission The permission to check for
     * @return boolean
     */
    public function hasPermission(Entity $user, $permission);
}
