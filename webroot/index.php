<?php

/**
 * webroot/index.php
 *
 * Loads in the configuration and autoloader.
 *
 * @author  Tyler Smith
 * @since   1.0.0
 */

require dirname(__DIR__) . '/config/bootstrap.php';

use ApexDevelopment\Core\App;
$App = new App('App Name', 'Version');
$App->run();
exit();

?>
