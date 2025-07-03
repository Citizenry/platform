<?php

/**
 * StreetSignal Platform User Registration Repository
 *
 * Extra repository methods for checking if user details are unique
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Usecase;

use StreetSignal\Contracts\Entity;

interface UserRegisterRepository
{
    public function isUniqueEmail($email);

    public function register(Entity $entity);
}
