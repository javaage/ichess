<?php
require 'header.php';
require 'common.php';
$list = $_REQUEST['list'];


	$sql = "SELECT code,name,current,time FROM stockrecord WHERE code in ('sh000001','sh000002') order by time asc";

	$result = $mysql -> query($sql);
	$codes = array();
	while ($mr = $result -> fetch_array(MYSQLI_ASSOC)) {
		$code = strtolower($mr['code']);
		$gw = $kv->get($code . 'gw');
		//echo json_encode($gw);
		$mr['arrow'] = getArrow($gw);
		array_push($codes, $mr);
	}
	echo json_encode($codes, JSON_UNESCAPED_UNICODE);
	
	mysqli_free_result($result);	

$mysql -> close();
?>