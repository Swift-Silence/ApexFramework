<?php

// The model factory.

namespace ApexDevelopment\Core;

use ApexDevelopment\Database\DB;
use ApexDevelopment\PHP\ClassRegistry;

class Model
{

    // Holds the database object.
    private $DB = null;

    private $Models = [];

    // Creates the database object and stores it.
    public function __construct()
    {
        $cr = ClassRegistry::singleton();
        $this -> DB = $cr -> push(new DB());
    }

    // Loads a model located in the models folder.
    public function loadModel($modelName)
    {
        $filepath = MODELS . ucfirst($modelName) . 'Model.php';

        if (!file_exists($filepath))
        {
            throw new \Exception("Model '$modelName' not found.");
        }

        include($filepath);

        $modelClass = "Models\\" . ucfirst($modelName) . 'Model';

        $this -> Models[ucfirst($modelName)] = new $modelClass($this -> DB);

        return $this -> Models[ucfirst($modelName)];

    }

    // Inits all the models.
    public function init()
    {
        foreach ($this -> Models as $modelName => $Model)
        {
            if (method_exists($Model, 'init'))
            {
                $Model -> init();
            }
            else
            {
                throw new \Exception("'$modelName' Model does not have an init function!!");
            }
        }
    }

    // Returns the model
    public function getModel($modelName)
    {
        $modelName = ucfirst($modelName);

        if (isset($this -> Models[$modelName]))
        {
            return $this -> Models[$modelName];
        }

        return 0;
    }

}
