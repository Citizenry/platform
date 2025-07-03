<?php

/**
 * StreetSignal Layer Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Repository;

use StreetSignal\Contracts\Entity;
use StreetSignal\Core\Entity\Layer;
use StreetSignal\Core\Tool\SearchData;

class LayerRepository extends OhanzeeRepository
{
    // Use the JSON transcoder to encode properties
    use Concerns\JsonTranscode;

    // OhanzeeRepository
    protected function getTable()
    {
        return 'layers';
    }

    // OhanzeeRepository
    public function getEntity(array $data = null)
    {
        return new Layer($data);
    }

    // Concerns\JsonTranscode
    protected function getJsonProperties()
    {
        return ['options'];
    }

    // SearchRepository
    public function getSearchFields()
    {
        return ['active', 'type'];
    }

    // OhanzeeRepository
    protected function setSearchConditions(SearchData $search)
    {
        $query = $this->search_query;

        if ($search->active !== null) {
            $query->where('active', '=', $search->active);
        }

        if ($search->type) {
            $query->where('type', '=', $search->type);
        }
    }

    // CreateRepository
    public function create(Entity $entity)
    {
        $record = array_filter($entity->asArray());
        $record['created'] = time();

        return $this->executeInsert($this->removeNullValues($record));
    }

    // UpdateRepository
    public function update(Entity $entity)
    {
        $update = $entity->getChanged();
        $update['updated'] = time();

        return $this->executeUpdate(['id' => $entity->id], $update);
    }
}
