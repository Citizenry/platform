<?php

/**
 * StreetSignal Platform Post Read Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Post;

use StreetSignal\Core\Usecase\ReadUsecase;
use StreetSignal\Core\Usecase\Post\Concerns\FindPost as FindPostTrait;

class ReadPost extends ReadUsecase
{
    use FindPostTrait;
}
