<?php

namespace StreetSignal\Modules\V3\Http\Controllers\API\Forms;

use Illuminate\Http\Request;
use StreetSignal\Modules\V3\Http\Controllers\RESTController;

/**
 * StreetSignal API Forms Controller
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @copyright  2013 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */
class FormsController extends RESTController
{
    protected function getResource()
    {
        return 'forms';
    }
}
