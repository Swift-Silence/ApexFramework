<?php

// Framework core routing class.

namespace ApexDevelopment\Networking;

use ApexDevelopment\Networking\Networking;
use ApexDevelopment\Networking\Request;
use ApexDevelopment\PHP\ClassRegistry;

class Routing
{

	// Holds the request data.
	private $request = [];

	// Holds the controller path
	private $controllerPath = null;

	// Holds the controller object.
	private $Controller = null;

	// Holds the method name.
	private $method = null;

	private $params = [];

	// Gets the request and parses it.
	public function __construct()
	{
		$cr = ClassRegistry::singleton();
		$cr -> push(new Request(Networking::$uri));

		$this -> request = $cr -> pull('Request') -> request;

		$this -> parseRequest();
	}

	public function executeRequest()
	{
		$controller = $this -> Controller;
		$method = $this -> method;
		$controller -> sendURI($this -> request['controller'], $this -> request['method']);
		$controller -> $method($this -> params);
	}

	// Pulls information from the request and assigns values.
	private function parseRequest()
	{
		$controller = ucfirst($this -> request['controller']) . 'Controller';

		$this -> controllerPath = CONTROLLERS . $controller . '.php';
		if (!@include($this -> controllerPath))
		{
			$controller = 'E404Controller';
			include(CONTROLLERS . $controller . '.php');
			$this -> request['method'] = 'index';
		}

		$controller = 'Controllers\\' . $controller;
		$this -> Controller = new $controller();

		if (method_exists($this -> Controller, $this -> request['method']))
		{
			$this -> method = $this -> request['method'];
		}
		else
		{
			Networking::redirect(URL . '404');
		}

		$this -> params = $this -> request['params'];
	}

}
