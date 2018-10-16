<?php
require '../header.php';
require '../common.php';

$n = $_REQUEST["n"];
$t = $_REQUEST["t"];

if(empty($n)){
	$n = 1;
}
if(empty($t)){
	$t = 0;
}


	$sqlRate = 'select min(a.time) as time from (select distinct(time) as time from indexrecord order by time desc limit 240) a ';
	$result = $mysql -> query($sqlRate);
	
	if ($result && $mr = $result -> fetch_array(MYSQLI_ASSOC)) {
		$time = $mr['time'];
	}


$sql = "select i.code,i.current*2/v.total as strong,i.time from indexrecord i inner join (select max(high) + min(low) as total,code from indexrecord group by code) v on i.code = v.code where i.time >= $time order by i.time, i.code";

//echo $sql . "<br>";

$result = $mysql -> query($sql);
$strongs = array();
$first = array();
while ($result && $mr = $result -> fetch_array(MYSQLI_ASSOC)) {
	if($mr['code'] == 'sh000001')
		$strong = (float)(100 * $mr['strong']);
	else{
		if(empty($first[$mr['code']]))
			$first[$mr['code']] = (float)(100 * $mr['strong'])-$strong;

		$strongs[$mr['code']][] = [1000*(int)($mr['time']),(float)(100 * $mr['strong'])-$strong - $first[$mr['code']]];
	}
}
echo json_encode($strongs);
mysqli_free_result($result);

$mysql -> close();
?>