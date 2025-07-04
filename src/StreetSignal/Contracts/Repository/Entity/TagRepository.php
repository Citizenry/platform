<?php

/**
 * Repository for Tags
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2022 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Entity;

use StreetSignal\Contracts\EntityCreate;
use StreetSignal\Contracts\EntityCreateMany;
use StreetSignal\Contracts\EntityGet;
use StreetSignal\Contracts\EntityExists;

interface TagRepository extends
    EntityGet,
    EntityCreate,
    EntityCreateMany,
    EntityExists
{
    public function doesTagExist($value);
}
