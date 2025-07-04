<?php

/**
 * Import Mapping Repo
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2018 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V2\Contracts;

use StreetSignal\Modules\V2\ImportMapping;
use StreetSignal\Modules\V2\ManifestSchemas\Mappings as ManifestMappings;

use Illuminate\Support\Collection;

interface ImportMappingRepository
{
    public function create(ImportMapping $model) : int;

    public function createMany(Collection $collection) : array;

    public function hasMapping(int $importId, string $sourceType, $sourceId);

    public function getMapping(int $importId, string $sourceType, $sourceId);

    public function getDestId(int $importId, string $sourceType, $sourceId);

    public function getMetadata(int $importId, string $sourceType, $sourceId);

    public function getAllMappingIDs(int $importId, string $sourceType);
}
