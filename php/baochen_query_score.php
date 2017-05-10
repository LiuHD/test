<?php 
header('charset: utf-8');
@ini_set('display_errors', 'on');
error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT ^ E_DEPRECATED);
$sn = isset($_REQUEST['student_number']) ? trim($_REQUEST['student_number']) : '';
$name = isset($_REQUEST['name']) ? trim($_REQUEST['name']) : '';
$error = 0;
if(!empty($sn) && !empty($name)) {
	include('config.php');
	$db = new mysqli($host, $username, $password, $db_name);
	if ($db->connect_error) {
    	die('连接数据库错误，请通知管理员');
	}
	$sql = "select score FROM student_score WHERE name = ? and student_number = ? limit 1";
	if ($stmt = $db->prepare($sql)) {
	    /* bind parameters for markers */
	    $stmt->bind_param("ss", $name, $sn);
	    /* execute query */
	    $stmt->execute();
	    /* bind result variables */
	    $stmt->bind_result($score);
	    $stmt->store_result();
	    if($stmt->num_rows <= 0) {
	    	$error = 1;
	    	$msg = '没有记录';
	    } else {
		    /* fetch value */
		    $stmt->fetch();
		    var_dump($score);
	    }
	    $stmt->close();
		/* close connection */
		$db->close();
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>成绩查询</title>
</head>
<body>
<form method="post">
	<input type="text" name="student_number">
	<input type="text" name="name">
	<button type="submit">查询</button>
</form>
<script type="text/javascript">
	document.getElementsByTagName('form')[0].addEventListener('submit', function() {
		var name = this.getElementsByName('name')[0].value,
			sn = this.getElementsByName('student_number')[0].value;
		if(name.length <= 0 || sn.length <= 0) {
			alert('学号和姓名都不能为空');
			return false;
		}
	});
</script>
</body>
</html>