<?php
header ( "Content-Type", "application/x-www-form-urlencoded; charset=utf8" );

require 'header.php';
$t = $_REQUEST['t'];

if(empty($t))
	$sql = "select code,name,increase,trans,time from bk_trans where time = (select max(time) from bk_trans) order by trans desc";
else 
	$sql = "select code,name,increase,trans,time from bk_trans where time = '$t' order by trans desc";
	
$result = $mysql->query ( $sql );
$codes = array ();
while ( $result && $mr = $result->fetch_array ( MYSQLI_ASSOC ) ) {
	array_push ( $codes, $mr );
}
echo json_encode ( $codes, JSON_UNESCAPED_UNICODE );

mysqli_free_result ( $result );

$mysql->close ();

?>