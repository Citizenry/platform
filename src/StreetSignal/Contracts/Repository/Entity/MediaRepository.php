<?php

/**
 * Repository for Media
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Core
 * @copyright  2022 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Entity;

use StreetSignal\Contracts\EntityGet;
use StreetSignal\Contracts\EntityExists;
use StreetSignal\Contracts\Repository\SearchRepository;

interface MediaRepository extends
    EntityGet,
    EntityExists,
    SearchRepository
{

}
