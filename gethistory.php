<?php
require 'header.php';
$type = $_REQUEST['type'];

$lm = date("Y-m-d H:i:s", strtotime("-5 minute"));

$strQuery = "SELECT time FROM `stockaction` where type = 0 and date_format(time,'%Y%m%d') = date_format((select max(time) from stockaction),'%Y%m%d') ORDER by time desc";

$result = $mysql->query ( $strQuery );
$history = array();
while($row = $result->fetch_row()){
	array_push($history, $row[0]);
}
echo json_encode($history);
if( $mysql->error != 0 )
{
	die( "Error:" . $mysql->errmsg() );
}
$mysql->close();
?>