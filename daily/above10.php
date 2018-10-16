<?php
require '../header.php';
require '../common.php';

$flag = $_REQUEST['flag'];
if(empty($flag)){
	$flag = 0;
}

$day0 = dayBefore(0, $flag);
$day1 = dayBefore(1, $flag);

echo $day1 . "<br>";
$day5 = dayBefore(5, $flag);
$day10 = dayBefore(10, $flag);
$day20 = dayBefore(20, $flag);
$day30 = dayBefore(30, $flag);
$day60 = dayBefore(60, $flag);
$day250 = dayBefore(250, $flag);


$sql = "DELETE FROM weak WHERE 1 = 1";
$mysql -> query($sql);

$sql = "select c5.code,a.name,c1.current,c5.avg5,c10.avg10,c20.avg20,c30.avg30,c60.avg60 from (select code, current from daily where date =(select max(date) from daily where date >= '$day1') and current < open) c1 inner join (select code, avg(current) as avg5, max(clmn) as maxclmn5 from daily where date > '$day5' and date <= '$day0' group by code) c5 on c1.code = c5.code inner join (select code, avg(current) as avg10 from daily where date > '$day10' and date <= '$day0' group by code) c10 on c5.code=c10.code inner join (select code, avg(current) as avg20 from daily where date > '$day20' and date <= '$day0' group by code) c20 on c5.code=c20.code inner join (select code, avg(current) as avg30 from daily where date > '$day30' and date <= '$day0' group by code) c30 on c5.code=c30.code inner join (select code, avg(current) as avg60, avg(clmn) as avgclmn60 from daily where date > '$day60' and date <= '$day0' group by code) c60 on c5.code=c60.code inner join (select code, avg(current) as avg250 from daily where date > '$day250' and date <= '$day0' group by code) c250 on c5.code=c250.code inner join allstock a on c5.code=a.code inner join (select l.code from (select y.code, avg(y.clmn) as clmn from (select code,clmn from daily where date <= '$day10' and date > '$day20' and clmn>0) y group by code) l inner join (select a.code,avg(clmn) as clmn from (SELECT code,clmn FROM daily where date > '$day250' and clmn>0) a group by code) t on l.code=t.code order by l.clmn / t.clmn limit 1000) c on c5.code=c.code where c1.current > c10.avg10 and c5.maxclmn5 > 2 * c60.avgclmn60 and c5.avg5 < c250.avg250";


echo $sql . "</br>";

$result = $mysql->query ( $sql );

$data = array();

while ($result && $mr = $result -> fetch_array(MYSQLI_ASSOC)) {
	$data[] =  substr($mr['code'], 2);

	$sqlInsert = "INSERT INTO weak (code, name, time) values('" . $mr['code'] . "','" . $mr['name'] . "',now())";
	echo $sqlInsert . "<br>";
	$mysql -> query($sqlInsert);

	// $sqlInsert = "INSERT INTO collect (code, name, date, flag) values('" . $mr['code'] . "','" . $mr['name'] . "',now(), $flag)";
	// echo $sqlInsert . "<br>";
	// $mysql -> query($sqlInsert);
}
print_r(count($data));
print_r(join($data,','));

mysqli_free_result ( $result );
$mysql->close ();
?>