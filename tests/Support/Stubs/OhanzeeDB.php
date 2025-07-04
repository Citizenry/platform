<?php

namespace Ohanzee;

/**
 * Stub implementation of Ohanzee DB for testing
 */
class DB
{
    public static function select($columns = null)
    {
        return new DatabaseQueryBuilderSelect($columns);
    }

    public static function insert($table)
    {
        return new DatabaseQueryBuilderInsert($table);
    }

    public static function update($table)
    {
        return new DatabaseQueryBuilderUpdate($table);
    }

    public static function delete($table)
    {
        return new DatabaseQueryBuilderDelete($table);
    }

    public static function expr($expression)
    {
        return new DatabaseExpression($expression);
    }

    public static function query($type, $sql = null, $as_object = null)
    {
        return new DatabaseQuery($type, $sql, $as_object);
    }
}

class DatabaseQueryBuilderSelect
{
    protected $columns;
    protected $table;
    protected $wheres = [];
    protected $limit;
    protected $offset;
    protected $orderBy = [];

    public function __construct($columns)
    {
        $this->columns = $columns;
    }

    public function from($table)
    {
        $this->table = $table;
        return $this;
    }

    public function where($column, $operator, $value = null)
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        $this->wheres[] = [$column, $operator, $value];
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function order_by($column, $direction = 'ASC')
    {
        $this->orderBy[] = [$column, $direction];
        return $this;
    }

    public function resetSelect()
    {
        $this->columns = null;
        return $this;
    }

    public function select($columns)
    {
        $this->columns = $columns;
        return $this;
    }

    public function resetOrderBy()
    {
        $this->orderBy = [];
        return $this;
    }

    public function distinct($distinct = true)
    {
        return $this;
    }

    public function join($table, $type = null)
    {
        return $this;
    }

    public function on($c1, $op, $c2)
    {
        return $this;
    }

    public function execute($db = null)
    {
        // For SELECT queries, return DatabaseResult object
        $mockData = [
            ['Value' => '1', 'uid' => 1] // Mock data for common queries
        ];
        return new DatabaseResult($mockData, 1, 1);
    }

    public function compile($db = null)
    {
        return "SELECT * FROM table";
    }
}

class DatabaseQueryBuilderInsert
{
    protected $table;
    protected $columns = [];
    protected $values = [];

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function columns($columns)
    {
        $this->columns = $columns;
        return $this;
    }

    public function values($values)
    {
        // Handle both single value set and array of value sets
        if (is_array($values) && isset($values[0]) && is_array($values[0])) {
            // Multiple value sets passed at once
            $this->values = array_merge($this->values, $values);
        } else {
            // Single value set
            $this->values[] = $values;
        }
        return $this;
    }

    public function execute($db = null)
    {
        // INSERT queries return [insert_id, affected_rows]
        // Count how many value sets were added
        $rowCount = count($this->values);
        
        // Debug logging
        error_log("DatabaseQueryBuilderInsert::execute() - values count: " . $rowCount);
        error_log("DatabaseQueryBuilderInsert::execute() - values: " . print_r($this->values, true));
        
        return [1, $rowCount];
    }
}

class DatabaseQueryBuilderUpdate
{
    protected $table;
    protected $set = [];
    protected $wheres = [];

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function set($data)
    {
        $this->set = $data;
        return $this;
    }

    public function where($column, $operator, $value)
    {
        $this->wheres[] = [$column, $operator, $value];
        return $this;
    }

    public function execute($db = null)
    {
        // UPDATE queries return affected rows count
        return 1;
    }
}

class DatabaseQueryBuilderDelete
{
    protected $table;
    protected $wheres = [];

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function where($column, $operator, $value)
    {
        $this->wheres[] = [$column, $operator, $value];
        return $this;
    }

    public function execute($db = null)
    {
        // UPDATE queries return affected rows count
        return 1;
    }
}

class DatabaseExpression
{
    protected $expression;

    public function __construct($expression)
    {
        $this->expression = $expression;
    }

    public function __toString()
    {
        return $this->expression;
    }
}

class Database
{
    const INSERT = 'INSERT';
    const UPDATE = 'UPDATE';
    const DELETE = 'DELETE';
    const SELECT = 'SELECT';
}

class DatabaseQuery
{
    protected $type;
    protected $sql;
    protected $as_object;

    public function __construct($type, $sql = null, $as_object = null)
    {
        $this->type = $type;
        $this->sql = $sql;
        $this->as_object = $as_object;
    }

    public function execute($db = null)
    {
        // Return appropriate mock data based on query type
        if ($this->type === Database::SELECT) {
            $mockData = [
                ['Value' => '1', 'uid' => 1] // Mock data for common queries
            ];
            return new DatabaseResult($mockData, 1, 1);
        }
        
        // For INSERT queries, return array [insert_id, affected_rows]
        if ($this->type === Database::INSERT) {
            return [1, 1]; // [insert_id, affected_rows]
        }
        
        // For UPDATE/DELETE queries, return affected rows count
        return 1;
    }
}