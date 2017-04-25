<?php

	// this will avoid mysql_connect() deprecation error.
	error_reporting( ~E_DEPRECATED & ~E_NOTICE );
	// but I strongly suggest you to use PDO or MySQLi.
	
	define('DBHOST', 'mariadb-140.wc1.ord1.stabletransit.com');
	define('DBUSER', '804758_stgmwest');
	define('DBPASS', 'Stg_mw3st');
	define('DBNAME', '804758_stgmwest');
	
	$conn = mysql_connect(DBHOST,DBUSER,DBPASS);
	$dbcon = mysql_select_db(DBNAME);
	
	if ( !$conn ) {
		die("Connection failed : " . mysql_error());
	}
	
	if ( !$dbcon ) {
		die("Database Connection failed : " . mysql_error());
	}