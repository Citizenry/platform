<?php

/**
 * StreetSignal Platform User Get Reset Token Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\User;

use StreetSignal\Contracts\Mailer;
use StreetSignal\Contracts\Usecase;
use StreetSignal\Core\Usecase\Concerns\ModifyRecords;
use StreetSignal\Core\Usecase\Concerns\Formatter as FormatterTrait;
use StreetSignal\Core\Usecase\Concerns\Authorizer as AuthorizerTrait;
use StreetSignal\Core\Usecase\Concerns\Translator as TranslatorTrait;
use StreetSignal\Contracts\Repository\Usecase\UserResetPasswordRepository;

class GetResetToken implements Usecase
{
    // Uses several traits to assign tools. Each of these traits provides a
    // setter method for the tool. For example, the AuthorizerTrait provides
    // a `setAuthorizer` method which only accepts `Authorizer` instances.
    use AuthorizerTrait,
        FormatterTrait,
        TranslatorTrait;

    // - ModifyRecords for setting entity modification parameters
    use ModifyRecords;

    // Usecase
    public function isWrite()
    {
        return false;
    }

    // Usecase
    public function isSearch()
    {
        return false;
    }

    /**
     * @var \StreetSignal\Contracts\Repository\Usecase\UserResetPasswordRepository
     */
    protected $repo;

    /**
     * Inject a repository
     *
     */
    public function setRepository(UserResetPasswordRepository $repo)
    {
        $this->repo = $repo;
        return $this;
    }

    /**
     * @var Mailer
     */
    protected $mailer;

    /**
     * Inject a mailer
     *
     * @param  $mailer Mailer
     * @return $this
     */
    public function setMailer(Mailer $mailer)
    {
        $this->mailer = $mailer;
        return $this;
    }

    public function interact()
    {
        // Fetch user by email
        $entity = $this->getEntity();

        if ($entity->getId()) {
            // Get the reset code on the user
            $code = $this->repo->getResetToken($entity);

            // Email the reset token
            $this->mailer->send(
                $entity->email,
                'resetpassword',
                [
                    'user_name' => $entity->realname,
                    'code' => $code,
                    'string' => base64_encode($code),
                    'duration' => 30,
                ]
            );
        }

        // Return an empty success response regardless
        // if the user was found or not
        return [];
    }

    protected function getEntity()
    {
        // Entity will be loaded using the provided email
        $email = $this->getPayload('email');

        // ... attempt to load the user by email
        $entity = $this->repo->getByEmail($email);

        // ... then return it
        return $entity;
    }
}
