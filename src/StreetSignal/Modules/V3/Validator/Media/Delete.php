<?php

/**
 * StreetSignal Media Validator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\Media;

use StreetSignal\Modules\V3\Validator\LegacyValidator;

class Delete extends LegacyValidator
{
    protected $default_error_source = 'media';

    protected function getRules()
    {
        return [
            'id' => [
                ['not_empty'],
                ['digit'],
            ],
        ];
    }
}
