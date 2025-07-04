<?php

namespace StreetSignal\Modules\V3\Http\Controllers\API\Forms;

use Illuminate\Http\Request;
use StreetSignal\Modules\V3\Http\Controllers\RESTController;

/**
 * StreetSignal API Forms Attributes Controller
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @copyright  2013 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */
class AttributesController extends RESTController
{
    protected function getResource()
    {
        return 'form_attributes';
    }

    public function index(Request $request)
    {
        $params = $this->getRouteParams($request);
        $this->usecase = $this->usecaseFactory
            ->get($this->getResource(), 'search')
            ->setIdentifiers($params)
            ->setFilters($request->query() + [
                'form_id' => isset($params['form_id']) ? $params['form_id'] : null,
            ]);

        return $this->prepResponse($this->executeUsecase($request), $request);
    }

    public function store(Request $request)
    {
        $params = $this->getRouteParams($request);
        $this->usecase = $this->usecaseFactory
            ->get($this->getResource(), 'create')
            ->setIdentifiers($params)
            ->setPayload($request->json()->all());

        return $this->prepResponse($this->executeUsecase($request), $request);
    }
}
