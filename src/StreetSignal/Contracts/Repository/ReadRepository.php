<?php

/**
 * StreetSignal Platform Read Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository;

use StreetSignal\Contracts\EntityExists;
use StreetSignal\Contracts\EntityGet;

interface ReadRepository extends EntityGet, EntityExists
{
}
