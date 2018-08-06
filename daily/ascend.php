<?php
require '../header.php';
require '../common.php';

$ct = date("Y-m-d",strtotime("-20 day")); 

$sql = "select s.code,s.name,s.current/s.close as rate,s.current/s.avg as gate,s.current from (select code,name,close,current,avg from stockrecord where time=(select max(time) from stockrecord)) s
inner join (select code,date,current from daily where date > '$ct') a
on s.code = a.code
inner join (SELECT code, max(date) as mdate FROM daily where date > '$ct' and current <= open group by code) g on a.code=g.code where a.date > g.mdate  group by a.code having max(a.current)/min(a.current) < 1.1 order by count(a.code) desc limit 30";

$result = $mysql -> query($sql);

$list = array();

$import = array();

while ($mr = $result -> fetch_array(MYSQLI_ASSOC)) {
	array_push($list, $mr);
	array_push($import, substr($mr['code'],2));
}

if(empty($_GET['import']))
	echo json_encode($list, JSON_UNESCAPED_UNICODE);
else
	echo join(' ',$import);



mysqli_free_result($result);

$mysql -> close();
?>