<?php
	session_start();
	$form_token = $_SESSION['token'];
	$response = "";
	$server = "localhost";
	$usrname = "root";
	$pass = "";
	$db_name = "auth";

	$db = new mysqli($server, $usrname, $pass, $db_name);

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

	$stmt = $db->prepare("SELECT username FROM users WHERE username = ? AND pswd = ?");
	$stmt->bind_param('ss', $username, $pswd);
	$stmt->execute();

	$result = $stmt->get_result();
	if ($result->num_rows > 0) {
		$response .= "Successfully Logged In";
		while ($row = $result->fetch_assoc()) {
			$_SESSION['login_token'] = sha1($row['username']);
		}
	}
	else {
		$response .= "Invalid Username or Password";
	}
	print $response;
?>