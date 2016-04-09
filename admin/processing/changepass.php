<?php
	session_start();
	$form_token = $_SESSION['token'];
	$response = "";
	include("../../db.php");

	if ($db) {
	}
	else {
		die("Please check your connection parameters $db->error");
	}

	if (empty($_POST['currentpass']) || empty($_POST['newpass']) || empty($_POST['rnewpass'])) {
		$response .= "Please fill in all fields.";
		print $response;
		exit;
	}
	elseif ($_POST['newpass'] != $_POST['rnewpass']) {
		$response .= "Passwords don't match.";
		print $response;
		exit;
	}
/*	elseif ($form_token !== $_POST['token']) {
		$response .= "Invalid form submission";
		print $response;
		exit;
	}*/
	else {
		$password = $_POST['newpass'];
		$pswd = sha1($password);
	}

$q = "SELECT `username` FROM `{$db_name}`.`users` WHERE `username` = '".$_SESSION['user']."' AND `pswd` = '".sha1($_POST['currentpass'])."'";
$result = $db->query($q);
	if ($result->num_rows > 0) {
		$r = "UPDATE `{$db_name}`.`users` SET `pswd` = '".$pswd."' WHERE `username` = '".$_SESSION['user']."'";
		$result2 = $db->query($r);
		if ($result2) {
			$response .= "Password change successful!";
		} else {$response .= "Password change unsuccessful!";}
	}
	else {
		$response .= "Wrong password.. you may go back and try again.";
	}
	print $response;
