<?php

/**
 * StreetSignal Platform User Login Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\User;

use StreetSignal\Contracts\RateLimiter;
use StreetSignal\Core\Usecase\ReadUsecase;
use StreetSignal\Contracts\PasswordAuthenticator;
use StreetSignal\Contracts\Repository\Entity\UserRepository;

class LoginUser extends ReadUsecase
{
    /**
     *
     * @var \StreetSignal\Contracts\Repository\Entity\UserRepository
     */
    protected $repo;

    /**
     * @var \StreetSignal\Contracts\PasswordAuthenticator
     */
    protected $authenticator;

    /**
     * @var \StreetSignal\Contracts\RateLimiter
     */
    protected $rateLimiter;

    public function setAuthenticator(PasswordAuthenticator $authenticator)
    {
        $this->authenticator = $authenticator;
        return $this;
    }

    /**
     * @param RateLimiter $rateLimiter
     */
    public function setRateLimiter(RateLimiter $rateLimiter)
    {
        $this->rateLimiter = $rateLimiter;
    }

    // Usecase
    public function interact()
    {
        // Fetch the entity, using provided identifiers...
        $entity = $this->getEntity();

        // Rate limit login attempts
        if ($this->rateLimiter) {
            $this->rateLimiter->limit($entity);
        }

        // ... verify that the password matches
        $this->authenticator->checkPassword($this->getRequiredIdentifier('password'), $entity->password);

        // ... and return the formatted result.
        return $this->formatter ? ($this->formatter)($entity) : $entity;
    }

    // ReadUsecase
    protected function getEntity()
    {
        // Make sure the repository has then methods necessary.
        $this->verifyUserRepository($this->repo);

        // Entity will be loaded using the provided email
        $email = $this->getRequiredIdentifier('email');

        // ... attempt to load the entity
        $entity = $this->repo->getByEmail($email);

        // ... and verify that the entity was actually loaded
        $this->verifyEntityLoaded($entity, compact('email'));

        // ... then return it
        return $entity;
    }

    /**
     * Verify that the given repository is a the correct type.
     * (PHP is weird about overloaded type hinting.)
     * @return UserRepository
     */
    private function verifyUserRepository(UserRepository $repo)
    {
        return true;
    }
}
