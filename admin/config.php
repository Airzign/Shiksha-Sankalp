<?php
	define('DB_HOST', 'localhost');
    define('DB_USER', 'shiksha_airzign');
    define('DB_PASSWORD', 'kyamazaak');
    define('DB_DATABASE', 'shiksha_sankalpdb');
    define('SMALL_IMG_FILE_SIZE',1048576);
    define('MEETING_FILE_SIZE',2097152);
	define('RESEARCH_PAPERS_FILE_SIZE',2097152);
    define('COMMUNICATION_MATERIALS_FILE_SIZE',2097152);
    define('OPERATIONAL_MATERIALS_FILE_SIZE',2097152);
    define('TESTING_MATERIALS_FILE_SIZE',2097152);
    define('NEWSLETTERS_FILE_SIZE',2097152);
    define('ANNUAL_REPORTS_FILE_SIZE',2097152);
    define('TAX_RETURNS_FILE_SIZE',2097152);
    define('LARGE_IMG_FILE_SIZE',2097152);
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
