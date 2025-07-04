<?php

/**
 * StreetSignal Platform Post Delete Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Post;

use StreetSignal\Core\Usecase\DeleteUsecase;
use StreetSignal\Core\Usecase\Post\Concerns\FindPost;

class DeletePost extends DeleteUsecase
{
    use FindPost;
}
