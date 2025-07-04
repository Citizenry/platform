<?php

/**
 * StreetSignal Platform User Login Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\User;

use StreetSignal\Core\Usecase\CreateUsecase;
use StreetSignal\Contracts\Entity;
use StreetSignal\Contracts\RateLimiter;

class RegisterUser extends CreateUsecase
{
    /**
     * @var RateLimiter
     */
    protected $rateLimiter;

    /**
     * @param RateLimiter $rateLimiter
     */
    public function setRateLimiter(RateLimiter $rateLimiter)
    {
        $this->rateLimiter = $rateLimiter;
    }

    public function interact()
    {
        // fetch entity
        $entity = $this->getEntity();

        // Rate limit registration attempts
        $this->rateLimiter->limit($entity);

        // verify that registration can be done in this case
        $this->verifyRegisterAuth($entity);

        // verify that the entity is in a valid state
        $this->verifyValid($entity);

        // persist the new entity
        $id = $this->repo->register($entity);

        // get the newly created entity
        $entity = $this->getCreatedEntity($id);

        // return the formatted entity
        return $this->formatter->__invoke($entity);
    }

    protected function verifyRegisterAuth(Entity $entity)
    {
        $this->verifyAuth($entity, 'register');
    }
}
