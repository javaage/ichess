<?php
require 'header.php';
require 'common.php';

$a = $_REQUEST['a'];
$f = $_REQUEST['f'];

if($a=='d'){
	$id = $_REQUEST['id'];
	$sql = "DELETE FROM inspect WHERE id = '$id'";
	$mysql -> query($sql);
} else if ($a == 'a') {
	$code = $_REQUEST['code'];
	$name = $_REQUEST['name'];
	$type = $_REQUEST['type'];
	$opt = $_REQUEST['opt'];
	$val = $_REQUEST['value'];

	$sql = "INSERT INTO inspect (code, name, type, opt, value, create_date, flag) values('$code','$name','$type','$opt',$val,now(),0)";

	echo $sql;

	$mysql -> query($sql);
} else{
	if(empty($f)){
		$sql = "select * from inspect";
	}else{
		$sql = "select * from inspect where flag=$f";
	}

	

	$result = $mysql -> query($sql);
	$codes = array();
	while ($result && $mr = $result -> fetch_array(MYSQLI_ASSOC)) {
		$code = strtolower($mr['code']);
		
		array_push($codes, $mr);
	}
	echo json_encode($codes, JSON_UNESCAPED_UNICODE);
	mysqli_free_result($result);
}

$mysql -> close();
?>