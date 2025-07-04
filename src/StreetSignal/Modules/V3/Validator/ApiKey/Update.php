<?php

/**
 * StreetSignal ApiKey Validator
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Validator\ApiKey;

use StreetSignal\Modules\V3\Validator\LegacyValidator;

class Update extends LegacyValidator
{
    protected $default_error_source = 'apikey';

    protected function getRules()
    {
        return [

        ];
    }
}
