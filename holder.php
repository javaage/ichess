<?php
require 'header.php';
require 'common.php';
$a = $_REQUEST['a'];

if($a=='d'){
	$code = $_REQUEST['c'];
	$sql = "DELETE FROM holder WHERE code = '$code'";
	$mysql -> query($sql);
} else if ($a == 'a') {
	$c = $_REQUEST['c'];
	$codes = explode(',',$c);
	//$name = $_REQUEST['n'];
	foreach ($codes as $key => $code) {
		$sqlPrefer = "update candidate set preflist = concat(preflist, ',' , '$code') where locate( '$code',preflist) = 0";
		$mysql -> query($sqlPrefer);

		$sql = "INSERT INTO holder (code, name, time) select code, name, now() from allstock where code = '$code'";
		$mysql -> query($sql);
	}
	
} else{
	$sql = "SELECT a.code,a.name,a.ascrate,a.time,a.descrate,a.equalrate,s.sell as `signal`,'' as arrow,r.current,r.rate,r.current/r.avg as gate from holder a left JOIN sign s on a.code = s.code  left join (SELECT code,name, current,avg,100*(current-close)/close as rate FROM stockrecord WHERE time = (SELECT max(time) from stockrecord)) r on a.code = r.code order by s.sell desc";

	$result = $mysql -> query($sql);
	$codes = array();
	while ($result && $mr = $result -> fetch_array(MYSQLI_ASSOC)) {
		$code = strtolower($mr['code']);
		$gw = $kv->get($code . 'gw');
		//echo json_encode($gw);
		$mr['arrow'] = getArrow($gw);
		array_push($codes, $mr);
	}
	echo json_encode($codes, JSON_UNESCAPED_UNICODE);
	
	mysqli_free_result($result);	
}

$mysql -> close();
?>