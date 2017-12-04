<?php

// Database handler

namespace ApexDevelopment\Database;

use ApexDevelopment\Core\Config;

class DB
{

    // Stores the mysqli connection variable so we only have to connect once.
    private $con = null;

    // Loads the config file and connects to the database.
    public function __construct()
    {
        Config::load('database');

        $this -> con = new \mysqli(Config::get('database.host'),
                                   Config::get('database.username'),
                                   Config::get('database.password'),
                                   Config::get('database.database'));
    }

    // Creates a table.
    public function createTable($tableName, array $fields = [])
    {
        $sql = "CREATE TABLE IF NOT EXISTS `$tableName` ";

        if (!empty($fields))
        {
            $sql .= "(";
            foreach ($fields as $name => $type)
            {
                $sql .= "$name $type, ";
            }
            $sql = substr($sql, 0, -2) . ');';
        }

        return $this -> con -> query($sql);
    }

    // Inserts data into a table.
    public function insert($table, array $values)
    {
        $sql = "INSERT INTO `$table` (";

        foreach ($values as $col => $val)
        {
            $sql .= "`$col`, ";
        }

        $sql = substr($sql, 0, -2) . ") VALUES (";

        foreach ($values as $col => $val)
        {
            $val = $this -> clean($val);

            if (is_numeric($val))
            {
                $sql .= "$val, ";
            }
            else
            {
                $sql .= "'$val', ";
            }
        }

        $sql = substr($sql, 0, -2) . ")";

        return $this -> con -> query($sql);
        //echo $sql;
    }

    // Pulls data from table based on conditions.
    public function read($tableName, array $conditions, $limit, $order)
    {
        $sql = "SELECT * FROM `$tableName` ";

        $sql .= $this -> parseWhere($conditions);

        if (!empty($limit))
        {
            $sql .= "LIMIT $limit ";
        }

        if (!empty($order))
        {
            $sql .= "ORDER BY $order ";
        }

        $sql = substr($sql, 0, -1);

        return $this -> con -> query($sql);
    }

    // Deletes a row from a given table based on a condition
    public function delete($tableName, array $conditions)
    {
        $sql = "DELETE FROM `$tableName` ";

        $sql .= $this -> parseWhere($conditions);

        $sql = substr($sql, 0, -1);

        return $this -> con -> query($sql);
    }

    public function update($tableName, array $changes, array $conditions)
    {
        $sql = "UPDATE `$tableName` SET ";

        foreach ($changes as $field => $val)
        {
            $sql .= "`$field`=";

            $val = $this -> clean($val);

            if (is_numeric($val))
            {
                $sql .= $val . " ";
            }
            else
            {
                $sql .= "'$val' ";
            }
        }

        $sql .= $this -> parseWhere($conditions);

        $sql = substr($sql, 0, -1);

        //echo $sql;
        return $this -> con -> query($sql);
    }

    // Parses the where statement
    private function parseWhere(array $conditions)
    {
        if (!empty($conditions))
        {
            $sql = "WHERE ";

            foreach ($conditions as $field => $val)
            {
                if (substr($field,0,1) == "&")
                {
                    $sql .= "AND ";
                    $field = ltrim($field, '&');
                }
                else if (substr($field,0,1) == "|")
                {
                    $sql .= "OR ";
                    $field = ltrim($field, '|');
                }

                $sql .= $field;

                $oe = false;
                if (substr($val,0,1) == "<")
                {
                    $oe = true;
                    $sql .= "<";
                    $val = ltrim($val, "<");
                }
                else if (substr($val,0,1) == ">")
                {
                    $oe = true;
                    $sql .= ">";
                    $val = ltrim($val, ">");
                }
                else if (substr($val,0,1) == "=")
                {
                    $sql .= "=";
                    $val = ltrim($val, "=");
                }

                if ($oe == true)
                {
                    if (substr($val,0,1) == "=")
                    {
                        $sql .= "=";
                        $val = ltrim($val, "=");
                    }
                }

                $val = $this -> clean($val);

                if (is_numeric($val))
                {
                    $sql .= $val . " ";
                }
                else
                {
                    $sql .= "'$val' ";
                }
            }

            return $sql;
        }

        return null;
    }

    private function clean($val)
    {
        return $this -> con -> real_escape_string($val);
    }

}
