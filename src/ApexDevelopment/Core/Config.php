<?php

// Configuration Handler

namespace ApexDevelopment\Core;

class Config
{

    // Holds all loaded config files by filename.
    private static $config = [];

    // Loads in a config file.
    public static function load($filename)
    {
        $path = CONFIG . $filename . '.php';

        if (!file_exists($path))
        {
            throw new \Exception("Config file '$filename' not found.");
        }

        if ($configLoad = include($path))
        {
            static::$config[$filename] = $configLoad;
            return 1;
        }
        else
        {
            throw new \Exception("Config file '$filename' could not be loaded.");
        }
    }

    // Gets the value of a config var.
    public static function get($var)
    {
        $config = static::$config;
        $var = explode('.', $var);

        foreach ($var as $bit)
        {
            if (isset($config[$bit]))
            {
                $config = $config[$bit];
            }
        }

        return $config;
    }

}
