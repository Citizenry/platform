<?php

namespace StreetSignal\Modules\V3\Http\Controllers\API;

use Illuminate\Http\Request;
use StreetSignal\Core\Facade\Feature;
use StreetSignal\Multisite\Facade\Multisite;
use StreetSignal\Modules\V3\Http\Controllers\RESTController;

/**
 * StreetSignal API Register Controller
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @copyright  2015 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */
class RegisterController extends RESTController
{
    protected function getResource()
    {
        return 'users';
    }

    /**
     * Register a user
     *
     * POST /api/v3/register
     *
     * @return void
     */
    public function store(Request $request)
    {
        // If the disable registration feature is enabled and site registration is disabled in config
        if (Feature::isEnabled('disable_registration')
            && Multisite::getSite()->getSiteConfig('disable_registration', false)) {
            abort(403, 'Registration Disabled');
        }

        $this->usecase = $this->usecaseFactory
            ->get($this->getResource(), 'register')
            ->setPayload($request->json()->all());

        return $this->prepResponse($this->executeUsecase($request), $request);
    }
}
