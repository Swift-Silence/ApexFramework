<?php

namespace ApexDevelopment\Plugins;

/**
 * The plugins' parent class.
 *
 * Provides extended functionality to all plugins so they can load subclasses
 * and more.
 */

class Plugin {

    private $pluginName = null;
    private $pluginPath = null;

    public function __construct()
    {
        $ref = new \ReflectionClass($this);
        $this -> pluginName = $ref -> getShortName();
        $this -> pluginPath = PLUGINS . $this -> pluginName . DS;
    }

    protected function loadSubClass($className, $params = [])
    {
        $className = ucfirst($className);
        $path = $this -> pluginPath . $className . '.php';

        if (file_exists($path))
        {
            include($path);

            $className = "\\Plugins\\{$this -> pluginName}\\{$className}";
            return new $className($params);
        }
        else
        {
            throw new \Exception("Could not load plugin subclass from '{$path}'.");
        }
    }

}
