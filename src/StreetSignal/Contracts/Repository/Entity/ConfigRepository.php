<?php

/**
 * Repository for Config
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2022 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Entity;

use StreetSignal\Contracts\Repository\DeleteRepository;
use StreetSignal\Contracts\Repository\ReadRepository;
use StreetSignal\Contracts\Repository\UpdateRepository;

interface ConfigRepository extends ReadRepository, UpdateRepository, DeleteRepository
{
    /**
     * @return array
     */
    public function groups();

    /**
     * @param  array $groups
     * @return array
     */
    public function all(array $groups = null);
}
