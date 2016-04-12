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

	if (empty($_POST['username']) || empty($_POST['password'])) {
		$response .= "Please enter a username and password";
		print $response;
		exit;
	}
	elseif ($form_token !== $_POST['token']) {
		$response .= "Invalid form submission";
		print $response;
		exit;
	}
	else {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$pswd = sha1($password);
	}

/*	$stmt = $db->prepare("SELECT `username` FROM `harshitc_candheshop`.`users` WHERE `username` = ? AND `pswd` = ?");
	$stmt->bind_param('ss', $username, $pswd);
	$stmt->execute();
*/

$q = "SELECT `username` FROM `{$db_name}`.`users` WHERE `username` = '".$username."' AND `pswd` = '".$pswd."'";

// WHAT THE FUCK NIGGA? WHAT'S this {$dbname} bullshit? It's not even fucking defined anywhere. I'm so mad
// If you were trying to refrence the $db_name, you better prepare your body bag cuz nigga you missed a motherfucking underscore


$result = $db->query($q);
	if ($result->num_rows > 0) {
		$response .= "Successfully Logged In";
		while ($row = $result->fetch_assoc()) {
			$_SESSION['login_token'] = sha1($row['username']);
			$_SESSION['user'] = $row['username'];		
		}
	}
	else {
		$response .= "Invalid Username or Password";
	}
	print $response;
?>
