<?php

/**
 * Import Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2018 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V2\Contracts;

use StreetSignal\Modules\V2\Import;

interface ImportRepository
{
    public function create(Import $model) : int;

    public function update(Import $model) : bool;

    public function find(int $id) : ?Import;
}
