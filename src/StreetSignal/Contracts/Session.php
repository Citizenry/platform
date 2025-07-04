<?php

/**
 * StreetSignal Platform Session
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts;

interface Session
{

    /**
     * Get the user entity
     *
     * @return \StreetSignal\Contracts\Entity
     */
    public function getUser();

    /**
     * Override the user set in oauth / lumen auth layer
     * with something else.
     *
     * This is primarily used to when running background jobs in a user
     * context. ie. an export that needs to run with the same permissions
     * as a user who triggered it
     *
     * @param int $userId
     */
    public function setUser(int $userId);
}
