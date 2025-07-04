<?php

/**
 * Import Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2020 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V2\Contracts;

use StreetSignal\Modules\V2\ImportSourceData;

interface ImportSourceDataRepository
{
    public function create(ImportSourceData $model) : int;
}
