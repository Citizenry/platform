<?php

/**
 * Import Repo
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2018 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V2\Repositories;

use StreetSignal\Modules\V2\Import;
use StreetSignal\Modules\V2\Contracts\ImportRepository as ImportRepositoryContract;

class ImportRepository /*extends EloquentRepository*/ implements ImportRepositoryContract
{

    public function create(Import $model) : int
    {
        return $model->save() ? $model->id : false;
    }

    public function update(Import $model) : bool
    {
        return $model->save();
    }

    public function find(int $id) : ?Import
    {
        return Import::find($id);
    }
}
