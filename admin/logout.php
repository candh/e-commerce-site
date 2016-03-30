<?php
	session_start();
	session_unset();
	session_destroy();
	print "You've been successfully logged out...<a href='login.php'>Log In Back</a>";
?>