<?php

// Apex Request Handler

namespace ApexDevelopment\Networking;

class Request
{

	public $request = [];

	private $gets = [];
	private $posts = [];

	public function __construct($uri)
	{
		$this -> request = [
			'controller' => 'home',
			'method' => 'index',
			'params' => []
		];

		$uri = explode('/', $uri);

		if (!empty($uri[0]))
		{
			$this -> request['controller'] = $uri[0];
			array_shift($uri);
		}

		if (!empty($uri[0]))
		{
			$this -> request['method'] = $uri[0];
			array_shift($uri);
		}

		$this -> request['params'] = $uri;

		// Assignt the $_POST and $_GET to member vars

		$this -> gets = $_GET;
		$this -> posts = $_POST;

	}

	public function isPost()
	{
		if (!empty($this -> posts))
		{
			return true;
		}

		return false;
	}

	public function isGet()
	{
		if (!empty($this -> gets))
		{
			return true;
		}

		return false;
	}

	// Used to get the get vars
	public function get($name = "")
	{
		if (empty($name))
		{
			return $this -> gets;
		}
		else
		{
			if (isset($this -> gets[$name]))
			{
				return $this -> gets[$name];
			}
			else
			{
				return false;
			}
		}
	}

	// Used to get the post vars
	public function post($name = "")
	{
		if (empty($name))
		{
			return $this -> posts;
		}
		else
		{
			if (isset($this -> posts[$name]))
			{
				return $this -> posts[$name];
			}
			else
			{
				return false;
			}
		}
	}

}
