<?php

/**
 * Import Repo
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2020 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V2\Repositories;

use StreetSignal\Modules\V2\ImportSourceData;
use StreetSignal\Modules\V2\Contracts\ImportSourceDataRepository as ImportSourceDataRepositoryContract;

class ImportSourceDataRepository implements ImportSourceDataRepositoryContract
{
    public function create(ImportSourceData $model) : int
    {
        return $model->save() ? $model->id : false;
    }

    public function insert(array $models)
    {
        ImportSourceData::insert($models);
    }
}
