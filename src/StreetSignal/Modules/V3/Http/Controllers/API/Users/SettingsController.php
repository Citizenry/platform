<?php

namespace StreetSignal\Modules\V3\Http\Controllers\API\Users;

use Illuminate\Http\Request;
use StreetSignal\Modules\V3\Http\Controllers\RESTController;

/**
 * StreetSignal API User SettingsTags Controller
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @copyright  2018 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */
class SettingsController extends RESTController
{
    protected function getResource()
    {
        return 'user_settings';
    }

    public function index(Request $request)
    {
        $params = $this->getRouteParams($request);

        $this->usecase = $this->usecaseFactory
            ->get($this->getResource(), 'search')
            ->setFilters($request->query() + [
                'user_id' => $params['user_id'],
            ]);

        return $this->prepResponse($this->executeUsecase($request), $request);
    }
}
