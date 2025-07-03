<?php

namespace StreetSignal\Modules\V3\Http\Controllers\API;

use StreetSignal\Modules\V3\Http\Controllers\RESTController;

/**
 * StreetSignal API Notifications Controller
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @copyright  2013 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */
class NotificationsController extends RESTController
{
    protected function getResource()
    {
        return 'notifications';
    }
}
