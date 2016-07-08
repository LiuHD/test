<?php
if(isset($_REQUEST['test']))
{
	echo 'yes';
	die();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>hello</title>
</head>
<body>
<form method="get">
<form>
	<input type="text" name="test">
</form>
<button type="submit">submit</button>
</form>
</body>
</html>
<?php
die();
?>


