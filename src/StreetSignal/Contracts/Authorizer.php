<?php

/**
 * StreetSignal Platform Authorizer
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts;

use StreetSignal\Contracts\Entity;

interface Authorizer
{
    /**
     * Get a list of the allowed privileges for a given entity.
     *
     * @return array
     */
    public function getAllowedPrivs(Entity $entity);

    /**
     * Check if access to an entity is allowed.
     *
     * @param  \StreetSignal\Contracts\Entity  $entity     Entity being accessed
     * @param  string  $privilege  Privilege that is requested
     * @return boolean
     */
    public function isAllowed(Entity $entity, $privilege);

    /**
     * Get the user for the current authorization context.
     *
     * @return \StreetSignal\Contracts\Entity
     */
    public function getUser();

    /**
     * Get the userid for the current authorization context.
     *
     * @return integer
     */
    public function getUserId();
}
