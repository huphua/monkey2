<?php
	error_reporting(E_ALL);
	define('APP_DEBUG', true);
	define('SHOW_PAGE_TRACE', true);
	define('NO_CACHE_RUNTIME',True);
	define('THINK_PATH','../ThinkPHP/');
	define('APP_NAME','app');
	define('APP_PATH','../app/');
	require(THINK_PATH."/ThinkPHP.php");
	//App::run();
?>