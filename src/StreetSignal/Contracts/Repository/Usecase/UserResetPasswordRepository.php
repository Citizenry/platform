<?php

/**
 * StreetSignal Platform User Password Reset Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Usecase;

use StreetSignal\Contracts\Entity;
use StreetSignal\Contracts\Repository\Entity\UserRepository;

interface UserResetPasswordRepository extends UserRepository
{
    public function getResetToken(Entity $entity);

    public function isValidResetToken($token);

    public function setPassword($token, $password);

    public function deleteResetToken($token);
}
