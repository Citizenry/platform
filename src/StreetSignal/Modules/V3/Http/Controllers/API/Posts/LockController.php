<?php
/**
 * StreetSignal API Post Lock Controller
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @copyright  2017 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Http\Controllers\API\Posts;

use Illuminate\Http\Request;

class LockController extends PostsController
{
    // StreetSignal_Rest
    protected function getResource()
    {
        return 'posts_lock';
    }

    // Get Lock
    public function store(Request $request)
    {
        $this->usecase = $this->usecaseFactory
            ->get($this->getResource(), 'create')
            ->setPayload($this->getPayload($request))
            ->setIdentifiers($this->getIdentifiers($request))
            ->setFormatter(service('formatter.entity.post.lock'));

        return $this->prepResponse($this->executeUsecase($request), $request);
    }

    // Break Lock
    public function destroy(Request $request)
    {
        $this->usecase = $this->usecaseFactory
            ->get($this->getResource(), 'delete')
            ->setIdentifiers($this->getIdentifiers($request))
            ->setFormatter(service('formatter.entity.post.lock'));

        return $this->prepResponse($this->executeUsecase($request), $request);
    }
}
