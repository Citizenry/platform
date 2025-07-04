<?php

/**
 * StreetSignal API Formatter for Form Stats
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2018 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Formatter\Form;

use StreetSignal\Modules\V3\Formatter\API;
use StreetSignal\Core\Concerns\FormatterAuthorizerMetadata;

class Stats extends API
{
    use FormatterAuthorizerMetadata;
}
