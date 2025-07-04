<?php

/**
 * StreetSignal API Formatter for CSV
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Formatter;

use DateTime;
use StreetSignal\Core\Concerns\FormatterAuthorizerMetadata;

class Tos extends API
{
    use FormatterAuthorizerMetadata;

    protected function formatAgreementDate($value)
    {
        return $value ? $value->format(DateTime::W3C) : null;
    }

    protected function formatTosVersionDate($value)
    {
        return $value ? $value->format(DateTime::W3C) : null;
    }
}
