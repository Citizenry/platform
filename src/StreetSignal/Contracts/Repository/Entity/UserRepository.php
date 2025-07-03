<?php

/**
 * Repository for Users
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2022 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Entity;

use StreetSignal\Contracts\Entity;
use StreetSignal\Contracts\EntityCreate;
use StreetSignal\Contracts\EntityCreateMany;
use StreetSignal\Contracts\Repository\DeleteRepository;
use StreetSignal\Contracts\Repository\ReadRepository;

interface UserRepository extends
    ReadRepository,
    EntityCreate,
    EntityCreateMany,
    DeleteRepository
{
    /**
     * @param string $email
     *
     * @return \StreetSignal\Contracts\Entity
     */
    public function getByEmail($email);

    /**
     *
     * @param [type] $token
     *
     * @return bool
     */
    public function isValidResetToken($token);

    /**
     * Undocumented function
     *
     * @param array $array
     *
     * @return int
     */
    public function getTotalCount(array $array);
}
