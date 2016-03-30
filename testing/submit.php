<?php


	for ($i=0; $i < count($_FILES['files']['tmp_name']) ; $i++) { 
		print $i;
	}


	if(isset($_FILES['files'])) {
		foreach ($_FILES['files']['name'] as $key => $name) {
			print $key;
		}
	}

?>