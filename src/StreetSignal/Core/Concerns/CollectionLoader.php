<?php

/**
 * StreetSignal Collection Loader Trait
 *
 * Provides a `getCollection(Array $results)` method for repositories.
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Concerns;

trait CollectionLoader
{
    /**
     * Get the entity for this repository.
     * @param  array  $data
     * @return \StreetSignal\Contracts\Entity
     */
    abstract public function getEntity(array $data = null);

    /**
     * Converts an array of results into an array of entities,
     * indexed by the entity id.
     * @param  array $results
     * @return array
     */
    protected function getCollection(array $results)
    {
        $collection = [];
        foreach ($results as $row) {
            $entity = $this->getEntity($row);
            $collection[$entity->getId()] = $entity;
        }
        return $collection;
    }
}
