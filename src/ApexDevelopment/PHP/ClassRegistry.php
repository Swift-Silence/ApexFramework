<?php

// Stores classes for use on the global scale.

namespace ApexDevelopment\PHP;

class ClassRegistry
{

	// The instance of the class, if it exists.
	private static $instance = null;

	// Container for all classes.
	private $objs = [];

	// Empty constructor so class can only be instantiated once.
	private function __construct()
	{

	}

	// Creates an instance if there isn't one, and returns it.
	public static function singleton()
	{
		if (static::$instance == null)
		{
			static::$instance = new static();
		}

		return static::$instance;
	}

	// Adds class to container.
	public function push($obj)
	{
		$ref = new \ReflectionClass($obj);

		if (isset($this -> objs[$ref -> getShortName()]))
		{
			unset($obj);
			return $this -> pull($ref -> getShortName());
		}

		$this -> objs[$ref -> getShortName()] = &$obj;
		return $this -> objs[$ref -> getShortName()];
	}

	public function pull($obj)
	{
		if (isset($this -> objs[$obj]))
		{
			return $this -> objs[$obj];
		}

		return 0;
	}

}
