<?php

namespace StreetSignal\Modules\V3\Http\Controllers\API\CSV;

use StreetSignal\Modules\V3\Http\Controllers\API\MediaController;

/**
 * StreetSignal API CSV Controller
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @copyright  2013 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */
class CSVController extends MediaController
{
    protected function getResource()
    {
        return 'csv';
    }
}
