<?php
	define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'kyamazaak');
    define('DB_DATABASE', 'shiksha_sankalpdb');
    define('SMALL_IMG_FILE_SIZE',100000);
    define('LARGE_IMG_FILE_SIZE',100000);
    	//Connect to mysql server
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}
?>
