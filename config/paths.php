<?php

// Set all of the paths for the application.

// Directory Separator
define('DS', DIRECTORY_SEPARATOR);

// Root Directory
define('ROOT', dirname(__DIR__));

// Config DIRECTORY
define('CONFIG', ROOT . DS . 'config' . DS);

// Source
define('SRC', ROOT . DS . 'src' . DS);

// App
define('APP', ROOT . DS . 'app' . DS);

// Controllers
define('CONTROLLERS', APP . 'controllers' . DS);

// Models
define('MODELS', APP . 'models' . DS);

// Views
define('VIEWS', APP . 'views' . DS);

// Views Templates
define('TEMPLATES', VIEWS . 'templates' . DS);

// Plugins
define('PLUGINS', APP . 'plugins' . DS);

// Protocol
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http');

// url
define('URL', $protocol . '://' . $_SERVER['HTTP_HOST'] . '/');
