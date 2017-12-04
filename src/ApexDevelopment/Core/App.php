<?php

// Core Application class

namespace ApexDevelopment\Core;

use ApexDevelopment\Networking\Networking;
use ApexDevelopment\Networking\Routing;
use ApexDevelopment\PHP\ClassRegistry;

class App
{
	// Stores the app name and version.
	private $appName,
			$appVersion;

	// Sets the app name and version.
	public function __construct($appName, $appVersion)
	{
		$this -> appName = $appName;
		$this -> appVersion = $appVersion;
	}

	// Begins running the framework.
	public function run()
	{
		$cr = ClassRegistry::singleton();

		Networking::init();

		$cr -> push(new Routing());

		$cr -> pull('Routing') -> executeRequest();

		return;
	}

}
