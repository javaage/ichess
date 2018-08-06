<?php
header ( "Content-Type", "application/x-www-form-urlencoded; charset=utf8" );
require 'header.php';
$t = $_REQUEST['t'];

$sql = "SELECT action,id,time,content,detail,arrow,pref,pref1,strong FROM `stockaction` where date_format(time,'%Y%m%d') = date_format((select max(time) from stockaction),'%Y%m%d') ORDER by time desc";

$result = $mysql->query ( $sql );
$codes = array ();
while (!empty($result) && $mr = $result->fetch_array ( MYSQLI_ASSOC ) ) {
	array_push ( $codes, $mr );
}
echo json_encode ( $codes, JSON_UNESCAPED_UNICODE );

mysqli_free_result ( $result );

$mysql->close ();

?>