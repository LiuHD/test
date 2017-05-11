<?php 
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
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
	<style type="text/css">
		body{
			padding: 10px 50px;
		}
		input{
			margin-top: 10px;
			line-height: 20px;
		}
		button{
	    font-size: 18px;
    	margin-top: 10px;
    	margin-left: 100px;
    }
		table{
			text-align: center;
		}
		td{
			border: solid black 1px;
		}
	</style>
</head>
<body>
<h3>成绩查询</h3>
<form method="post">
	<label>学号:<input type="text" name="student_number"></label>
	<br>
	<label>姓名:<input type="text" name="name"></label>
	<br>
	<button type="submit">查询</button>
</form>
<?php 
if($error) {
	echo '<hr><p>'.$msg.'</p>';
	die;
} else if(isset($score)) { ?>
<hr>
<table>
	<tr>
		<th>姓名</th>
		<th>学号</th>
		<th>成绩</th>
	</tr>
	<tr>
		<td><?php echo $name;?></td>
		<td><?php echo $sn;?></td>
		<td><?php echo $score;?></td>
	</tr>
</table>
<?php } ?>
<script type="text/javascript">
	document.getElementsByTagName('form')[0].addEventListener('submit', function(event) {
		var name = document.getElementsByName('name')[0].value,
			sn = document.getElementsByName('student_number')[0].value;
		if(name.length <= 0 || sn.length <= 0) {
			alert('学号和姓名都不能为空');
			event.preventDefault();
			return false;
		}
	});
</script>
</body>
</html>