<?php

/**
 * StreetSignal Ensure User Entity trait
 *
 * Gives objects one new method:
 * `ensureUserIsEntity($user)`
 *
 * This checks if `$user` is a User Entity and loads
 * an entity if its not.
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Concerns;

use StreetSignal\Contracts\EntityGet;
use StreetSignal\Contracts\Entity;

trait EnsureUserEntity
{
    protected $user_repo;

    public function __construct(EntityGet $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    /**
     * Ensure user is a User Entity, or load it from the user repo
     * @param  integer|\StreetSignal\Contracts\Entity $user  User id or entity object
     * @return \StreetSignal\Contracts\Entity
     */
    protected function ensureUserIsEntity(&$user)
    {
        // Check if the user is an instance of `User`
        if (! $user instanceof Entity) {
            // If we only have a user id, we load the full entity.
            $user = $this->user_repo->get($user);
        }

        return $user;
    }
}
