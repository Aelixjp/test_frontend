<?php
	
	require 'connection.php';

	//Data for DB connection
	define("DB_HOST_NAME", 'localhost');
	define("DB_USERNAME", "root");
	define("DB_PASSWORD", "");
	define("DB_NAME", "test_users");
	define("CONNECTION_DATA", array(DB_HOST_NAME,DB_NAME,DB_USERNAME,DB_PASSWORD));

	$connection = connect(...CONNECTION_DATA);

	if(!$connection){
		echo "no connection!";
	}

?>