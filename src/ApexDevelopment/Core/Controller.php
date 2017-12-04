<?php

// Core Controller class

namespace ApexDevelopment\Core;

use ApexDevelopment\Core\Model;
use ApexDevelopment\HTML\Flash;
use ApexDevelopment\HTML\Helpers;
use ApexDevelopment\PHP\ClassRegistry;
use ApexDevelopment\Plugins\PluginManager;

class Controller
{

    // Front-end variables;
    private $vars = [];

    // Holds URI of current page.
    private $URI = null;

    // View name.
    private $view = null;

    // Model class
    protected $Model = null;

    // Request
    protected $Request = null;

    protected $PluginManager = null;

    protected $Flash = null;

    // Set your plugin containers:
    protected $Auth = null;

    // Sets the view and loads the model factory into the Controller.
    public function __construct()
    {
        $cr = ClassRegistry::singleton();
        $this -> Request = $cr -> pull('Request');

        $this -> view = str_replace('Controller', '', str_replace("Controllers\\", '', get_class($this))) . 'View';

        $this -> Model = new Model();
        $this -> Helpers = new Helpers();
        $this -> PluginManager = new PluginManager();
        $this -> Flash = new Flash();

        // Load your plugins:
        $this -> Auth = $this -> PluginManager -> load('Auth', ['loginRedirect' => $this -> interlink(['dashboard', 'index']),
                                                                'logoutRedirect' => $this -> interlink(['home', 'index'])]);
    }

    // Loads a template.
    protected function _($templateName)
    {
        $path = TEMPLATES . $templateName . '.php';
        $path = str_replace('/', DS, $path);

        if (file_exists($path))
        {
            include($path);
        }
        else
        {
            throw new \Exception("Template '$templateName' not found!");
        }
    }

    // Add or read a var.
    protected function v($name, $value = null)
    {
        if ($value == null)
        {
            if (isset($this -> vars[$name]))
            {
                return $this -> vars[$name];
            }
            else
            {
                return false;
            }
        }
        else
        {
            $this -> vars[$name] = $value;
        }
    }

    // Returns a link to within the site based on controller and method.
    protected function interlink(array $request)
    {
        $str = URL . $request[0] . '/' . $request[1];

        unset($request[0], $request[1]);
        $request = array_values($request);

        foreach ($request as $param)
        {
            $str .= '/' . $param;
        }

        return $str;
    }

    // Executes the view, and you can append other params to it.
    protected function executeView($view = null)
    {
        $fullViewClassname = DS . 'Views' . $this -> view;

        if ($view == null)
        {
            if (!include(VIEWS . $this -> view . '.php'))
            {
                throw new \Exception('View does not exist.');
            }
        }
        else
        {
            if (!@include(VIEWS . $this -> view . DS . $view . '.php'))
            {
                throw new \Exception('View does not exist.');
            }
        }
    }

    // Sets the current URI
    public function sendURI($c, $m)
    {
        $this -> URI = $c . '/' . $m;
    }

    // Returns the URL.
    public function __toString()
    {
        return URL . $this -> URI;
    }

}
