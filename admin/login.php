<?php
	session_start();
	$form_token = md5(uniqid('auth', true));
	$_SESSION['token'] = $form_token;


	if (isset($_SESSION['login_token'])) {
		print "You're already Logged In<br/>";
		print "<a href='logout.php'>Logout Here</a>";
		exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<?php
		include 'styles.html';
	?>
</head>
<body>
<!-- LOGIN FORM -->
	<section class="login-form-wrapper">
		<div class="login-form mdl-shadow--6dp">
			<form action="processing/loginajax.php" method="post" class="login">
				<div class="login-header text-center"><h5 style="padding:5px 0px;">Login</h5>
				<p style="font-size: 11px;">// Admin Section</p>
				</div>
				<br/>
				<table>

				<tr><td><p>Username :</td><td> <input type="text" maxlength='20' name="username" id="username"></p></td></tr>
				<tr><td><p>Password :</td><td><input type="password" maxlength='20' name="password" id="password"></p></td></tr>
				<input type="hidden" value="<?php print $form_token?>" name = "token" id="token">
				<tr>
				</table>
				<br/>
				<p class="text-center">
					<input type="submit" value="Login">
				</p>
				<div id="warning" class="mdl-shadow--3dp"></div>
			</form>
		</div>
	</section>

</body>
</html>