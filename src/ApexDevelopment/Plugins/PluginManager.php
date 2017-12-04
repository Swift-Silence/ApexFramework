<?php

// Plugin Manager

namespace ApexDevelopment\Plugins;

class PluginManager
{

    public function load($name, array $params = [])
    {
        $name = ucfirst($name);
        $path = PLUGINS . $name . DS . $name . '.php';

        if (file_exists($path))
        {
            include($path);
            $call = "\\Plugins\\{$name}\\{$name}";

            return new $call($params);
        }

        return false;
    }

}
