<!DOCTYPE html>
<html>
<head>
	<title>Uploading Multiple Files With PHP</title>
</head>
<body>
<form method="post" action="submit.php" enctype="multipart/form-data">
<input type="file" name='files[]' multiple='multiple'>
<input type="submit" name="submit" value="Upload">
</form>


</body>
</html>