<?php
require 'header.php';
require 'common.php';

$t = $_REQUEST['t'];

if($t){
	$sql = "SELECT id,time FROM `stockaction` where date_format(time,'%Y%m%d') = date_format((select max(time) from stockaction),'%Y%m%d') ORDER by time desc";

	$result = $mysql->query ( $sql );
	$times = array ();
	while (!empty($result) && $mr = $result->fetch_array ( MYSQLI_ASSOC ) ) {
		array_push ( $times, $mr );
	}
	echo json_encode ( $times, JSON_UNESCAPED_UNICODE );

	mysqli_free_result ( $result );

	$mysql->close ();

	exit();
}

$id = $_REQUEST['id'];

if(empty($id)){
	$sql = "SELECT pref1 FROM stockaction where id = (SELECT MAX(id) from stockaction)"; 
}else{
	$sql = "SELECT pref1 FROM stockaction where id >= $id order by id limit 1"; 
}

$result = $mysql -> query($sql);

if ($mr = $result -> fetch_array()) {
	$list = $mr[0];
}

$sql = "SELECT s.code,a.name,s.buy as `signal`,a.current,a.rate,a.current/a.avg as gate from (SELECT code,buy,current/avg as fiverate from sign where INSTR('$list',code) > 0) s INNER JOIN (SELECT code,name, current,avg, 100*(current-close)/close as rate FROM stockrecord WHERE time = (SELECT max(time) from stockrecord) ) a on s.code = a.code order by s.fiverate ";

$result = $mysql -> query($sql);
$codes = array();
while ($mr = $result -> fetch_array(MYSQLI_ASSOC)) {
	$code = strtolower($mr['code']);
	$gw = $kv -> get($code . 'gw');
	$mr['arrow'] = getArrow($gw);
	array_push($codes, $mr);
}
echo json_encode($codes, JSON_UNESCAPED_UNICODE);

mysqli_free_result($result);

$mysql -> close();
?>