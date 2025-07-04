<?php

namespace Ohanzee;

class DatabaseResult implements \Countable
{
    private $data;
    private $insertId;
    private $affectedRows;

    public function __construct($data = [], $insertId = 1, $affectedRows = 1)
    {
        $this->data = $data;
        $this->insertId = $insertId;
        $this->affectedRows = $affectedRows;
    }

    public function as_array()
    {
        return $this->data;
    }

    public function get($key, $default = null)
    {
        if (is_array($this->data) && isset($this->data[0][$key])) {
            return $this->data[0][$key];
        }
        return $default;
    }

    public function count()
    {
        return count($this->data);
    }

    // For insert operations, return array [insertId, affectedRows]
    public function getInsertResult()
    {
        return [$this->insertId, $this->affectedRows];
    }

    public function current()
    {
        return current($this->data) ?: null;
    }

    public function execute($db = null)
    {
        // For queries that call execute() on the result, return array with [insertId, affectedRows]
        return [1, 1];
    }
}