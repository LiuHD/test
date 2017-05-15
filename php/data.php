<?php 
ini_set('display_errors', 'on');
error_reporting(E_ALL);
header('charset=utf-8');
$sn = isset($_REQUEST['user_number']) ? trim($_REQUEST['user_number']) : '';
$res = array(
	'error' => 0,
	'msg' => ''
 );
if(!empty($sn)) {
	include('config.php');
	$db = new mysqli($host, $username, $password, $db_name);
	if ($db->connect_error) {
		$res['error'] = 1;
		$res['msg'] = '连接数据库错误，请通知管理员';
    	echo json_encode($res);
    	die;
	}
	$sql = "select user_name, floor, department FROM staff_data WHERE user_number = ? limit 1";
	if ($stmt = $db->prepare($sql)) {
	    /* bind parameters for markers */
	    $stmt->bind_param("s", $sn);
	    /* execute query */
	    $stmt->execute();
	    /* bind result variables */
	    $stmt->bind_result($user_name, $floor, $department);
	    $stmt->store_result();
	    if($stmt->num_rows <= 0) {
	    	$res['error'] = 1;
	    	$res['msg'] = '没有记录';
	    	echo json_encode($res);
	    	die;
	    } else {
		    /* fetch value */
		    $stmt->fetch();
		    $res['data'] = array(
		    	'user_name' => $user_name, 
		    	'floor' => $floor,
		    	'department' => $department
		    	);
		    echo json_encode($res);
		    die;
	    }
	    $stmt->close();
		/* close connection */
		$db->close();
	}
}