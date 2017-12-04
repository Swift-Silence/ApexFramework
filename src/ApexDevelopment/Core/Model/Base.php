<?php

// Base Model class

namespace ApexDevelopment\Core\Model;

use ApexDevelopment\PHP\ClassRegistry;

class Base
{

    // Holds the DB object
    private $DB = null;

    // Holds the current model name
    private $modelName = null;

    private $tableStructure;

    // Gets the DB object and sets it.
    public function __construct($DB)
    {
        $cr = ClassRegistry::singleton();
        $this -> DB = $cr -> pull('DB');

        $className = get_class($this);
        $shortName = str_replace('Models\\', '', $className);
        $tableName = str_replace("Model", '', $shortName);
        $this -> modelName = strtolower($tableName);
    }

    protected function create($structure)
    {
        $this -> tableStructure = $structure;

        if (!$this -> DB)
        {
            echo $this -> modelName;
        }

        return $this -> DB -> createTable($this -> modelName, $structure);
    }

    public function insert($data)
    {
        foreach ($data as $col => $val)
        {
            $method = 'before' . ucfirst($col);

            if (method_exists($this, $method))
            {
                $data[$col] = $this -> $method($val);
            }
        }

        return $this -> DB -> insert($this -> modelName, $data);
    }

    public function get($conditions = [], $limit = "", $order = "")
    {
        return $this -> DB -> read($this -> modelName, $conditions, $limit, $order);
    }

    public function erase($conditions = [])
    {
        return $this -> DB -> delete($this -> modelName, $conditions);
    }

    public function update($changes, $conditions = [])
    {
        return $this -> DB -> update($this -> modelName, $changes, $conditions);
    }

}
