<?php

/**
 * StreetSignal Console Formatter
 *
 * Takes an entity object and returns an array.
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Formatter\Post;

use StreetSignal\Core\Concerns\FormatterAuthorizerMetadata;
use StreetSignal\Modules\V3\Formatter\API;

class Lock extends API
{
    use FormatterAuthorizerMetadata;
}
