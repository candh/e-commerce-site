<?php
	$server = "localhost";
	$usrname = "root";
	$pass = "";
	$db_name = "store";

	$db = new mysqli($server, $usrname, $pass, $db_name);

	if ($db) {
	}
	else{
		die("Please check your connection parameters $db->error");
	}
?>