<?php

/**
 * Repository for CSV
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2022 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Entity;

use StreetSignal\Contracts\Entity;
use StreetSignal\Contracts\EntityCreate;
use StreetSignal\Contracts\EntityGet;
use StreetSignal\Contracts\EntityExists;

interface TosRepository extends
    EntityGet,
    EntityCreate,
    EntityExists
{

}
