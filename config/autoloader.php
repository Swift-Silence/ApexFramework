<?php 

// Autoloader 

spl_autoload_register(function($class) {
	$file = str_replace('\\', DS, $class);
	if (!include(SRC . $file . '.php')) {
		echo '<pre>Autoload Error. Data: <br />';
		print_r(debug_backtrace());
	}
});