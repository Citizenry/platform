<?php

namespace StreetSignal\Modules\V3\Http\Controllers\API;

use Illuminate\Http\Request;
use StreetSignal\Modules\V3\Http\Controllers\RESTController;

/**
 * StreetSignal API Tags Controller
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @copyright  2013 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */
class PasswordResetController extends RESTController
{
    protected function getResource()
    {
        return 'users';
    }

    public function store(Request $request)
    {
        $this->usecase = $this->usecaseFactory
            ->get($this->getResource(), 'getresettoken')
            ->setPayload($request->json()->all());

        return $this->prepResponse($this->executeUsecase($request), $request);
    }

    public function confirmOptions()
    {
        //$this->action_options_index_collection();
    }

    public function confirm(Request $request)
    {
        $this->usecase = $this->usecaseFactory
            ->get($this->getResource(), 'passwordreset')
            ->setPayload($request->json()->all());

        return $this->prepResponse($this->executeUsecase($request), $request);
    }
}
