<?php
	// connecting to the database 
	$server = "localhost";
	$username = "root";
	$password = "";
	$db_name = "store";

	$db = new mysqli($server, $username, $password, $db_name);
	if($db->connect_error) {
		die("Connection not Succesful".' '.$db->connect_error);
		exit; 
	}


	// INITIALIZATION LOGIC
	$rootDir = dirname(__FILE__);

	// server timestamps
	$server_timezone = date_default_timezone_set('Asia/Karachi');
	$current_timestamp = date('m-d-Y, l, h:i:s a');
?>