<?php

/**
 * StreetSignal Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Repository;

use DB;
use RuntimeException;
use StreetSignal\Contracts\Entity;
use StreetSignal\Contracts\Search;
use StreetSignal\Contracts\Repository;
use StreetSignal\Core\Tool\SearchData;
use StreetSignal\Core\Tool\OhanzeeResolver;
use StreetSignal\Core\Concerns\CollectionLoader;

abstract class BaseRepository implements
    Repository\CreateRepository,
    Repository\ReadRepository,
    Repository\UpdateRepository,
    Repository\DeleteRepository,
    Repository\SearchRepository,
    Repository\ImportRepository
{

    use CollectionLoader;

    protected $search_query;
    protected $resolver;

    public function __construct(OhanzeeResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Get current connection
     *
     * @return \Ohanzee\Database;
     */
    protected function db()
    {
        return $this->resolver->connection();
    }

    /**
     * Get the entity for this repository.
     *
     * @param  array  $data
     * @return \StreetSignal\Contracts\Entity
     */
    abstract public function getEntity(array $data = null);

    /**
     * Get the table name for this repository.
     *
     * @return String
     */
    abstract protected function getTable();

    /**
     * Apply search conditions from input data.
     * Must be overloaded to enable searching.
     *
     * @throws LogicException
     * @param  SearchData $search
     * @return void
     */
    protected function setSearchConditions(SearchData $search)
    {
        throw new \LogicException('Not implemented by this repository');
    }

    // CreateRepository
    // ReadRepository
    // UpdateRepository
    // DeleteRepository
    public function get($id)
    {
        return $this->getEntity($this->selectOne(['id' => $id]));
    }

    // CreateRepository
    public function create(Entity $entity)
    {
        return $this->executeInsert($this->removeNullValues($entity->asArray()));
    }

    // UpdateRepository
    public function update(Entity $entity)
    {
        return $this->executeUpdate(['id' => $entity->id], $entity->getChanged());
    }

    // DeleteRepository
    public function delete(Entity $entity)
    {
        return $this->executeDelete(['id' => $entity->id]);
    }

    // SearchRepository
    public function setSearchParams(Search $search)
    {
        $this->search_query = $this->selectQuery();

        $sorting = $search->getSorting();

        if (!empty($sorting['orderby'])) {
            $order = isset($sorting['order']) ? strtoupper($sorting['order']) : 'ASC';
            $this->search_query->orderBy(
                $sorting['orderby'],
                ($order == 'DESC' ? 'DESC' : 'ASC')
            );
        }

        if (!empty($sorting['offset'])) {
            $this->search_query->offset(intval($sorting['offset']));
        }
        if (!empty($sorting['limit'])) {
            $this->search_query->limit(intval($sorting['limit']));
        }

        // apply the unique conditions of the search
        $this->setSearchConditions($search);
    }

    // SearchRepository
    public function getSearchResults()
    {
        $query = $this->getSearchQuery();

        $results = $query->distinct()->get();

        return $this->getCollection($results->toArray());
    }

    // SearchRepository
    public function getSearchTotal()
    {
        // Assume we can simply count the results to get a total
        $query = $this->getSearchQuery(true);
        
        // Return the count
        return (int) $query->count();
    }

    /**
     * Remove all `null` values, to allow the database to set defaults.
     *
     * @param  Array $data
     * @return Array
     */
    protected function removeNullValues(array $data)
    {
        return array_filter($data, function ($val) {
            return isset($val);
        });
    }

    /**
     * Get a copy of the current search query, optionally removing the LIMIT,
     * OFFSET, and ORDER BY parameters (for query that can be COUNT'ed).
     * @throws RuntimeException if called before search parameters are set
     * @param  Boolean $countable  remove limit/offset/orderby
     * @return Database_Query_Select
     */
    protected function getSearchQuery($countable = false)
    {
        if (!$this->search_query) {
            throw new \RuntimeException('Cannot get search results until setSearchParams has been called');
        }

        // We always clone the query, because once search parameters have been set,
        // the query cannot be modified until new parameters are applied.
        $query = clone $this->search_query;

        if ($countable) {
            $query
                ->limit(null)
                ->offset(null)
                ->resetOrderBy();
        }

        return $query;
    }

    /**
     * Get a single record meeting some conditions.
     * @param  Array $where hash of conditions
     * @return Array
     */
    protected function selectOne(array $where = [])
    {
        $result = $this->selectQuery($where)
            ->limit(1)
            ->first();
        return $result ? (array) $result : null;
    }

    /**
     * Get a count of records meeting some conditions.
     * @param  Array $where hash of conditions
     * @return Integer
     */
    protected function selectCount(array $where = [])
    {
        return $this->selectQuery($where)->count();
    }

    /**
     * Return a SELECT query, optionally with preconditions.
     * @param  Array $where optional hash of conditions
     * @return \Illuminate\Database\Query\Builder
     */
    protected function selectQuery(array $where = [])
    {
        $query = $this->db()->table($this->getTable());
        foreach ($where as $column => $value) {
            if (is_array($value)) {
                $query->whereIn($column, $value);
            } else {
                $query->where($column, '=', $value);
            }
        }
        return $query;
    }

    /**
     * Create a single record from input and return the created ID.
     * @param  Array $input hash of input
     * @return Integer
     */
    protected function executeInsert(array $input)
    {
        if (!$input) {
            throw new \RuntimeException(sprintf(
                'Cannot create an empty record in table "%s"',
                $this->getTable()
            ));
        }

        return $this->db()->table($this->getTable())->insertGetId($input);
    }

    /**
     * Update records from input with conditions and return the number affected.
     * @param  Array $where hash of conditions
     * @param  Array $input hash of input
     * @return Integer
     */
    protected function executeUpdate(array $where, array $input)
    {
        if (!$where) {
            throw new \RuntimeException(sprintf(
                'Cannot update every record in table "%s"',
                $this->getTable()
            ));
        }

        // Prevent overwriting created timestamp
        // Probably not needed if `created` is set immutable in Entity
        if (array_key_exists('created', $input)) {
            unset($input['created']);
        }

        if (!$input) {
            return 0; // nothing would be updated, just ignore
        }

        $query = $this->db()->table($this->getTable());
        foreach ($where as $column => $value) {
            if (is_array($value)) {
                $query->whereIn($column, $value);
            } else {
                $query->where($column, '=', $value);
            }
        }

        return $query->update($input);
    }

    /**
     * Delete records with conditions and return the number affected.
     * @param  Array $where hash of conditions
     * @return Integer
     */
    protected function executeDelete(array $where)
    {

        if (!$where) {
            throw new \RuntimeException(sprintf(
                'Cannot delete every record in table "%s"',
                $this->getTable()
            ));
        }

        $query = $this->db()->table($this->getTable());
        foreach ($where as $column => $value) {
            if (is_array($value)) {
                $query->whereIn($column, $value);
            } else {
                $query->where($column, '=', $value);
            }
        }

        return $query->delete();
    }


    /**
     * Check if an entity with the given id exists
     * @param  int $id
     * @return bool
     */
    public function exists($id)
    {
        return (bool) $this->selectCount(['id' => $id]);
    }
}
