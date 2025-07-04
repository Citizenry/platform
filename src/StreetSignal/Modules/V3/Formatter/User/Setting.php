<?php

/**
 * StreetSignal API Formatter for User Setting
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2018 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Formatter\User;

use StreetSignal\Modules\V3\Formatter\API;
use StreetSignal\Core\Concerns\FormatterAuthorizerMetadata;

class Setting extends API
{
    use FormatterAuthorizerMetadata;

    protected function formatConfigValueWithFields($value, $fields)
    {
        // If Config Key contains a keywords
        // then we redact some of the information
        // Ideally, we would define some kind of flag for sensitive
        // User setting data to make it more straightforward to identify
        if (strpos($fields['config_key'], 'api') !== false) {
            $value = substr_replace($value, str_repeat('*', strlen($value) - 4), 0, -4);
        }

        return $value;
    }
}
