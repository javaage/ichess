<?php
require '../header.php';
require '../common.php';

$day40 = dayBefore(40);

$day5 = dayBefore(5);
$day10 = dayBefore(10);
$day20 = dayBefore(20);
$day30 = dayBefore(30);
$day60 = dayBefore(60);
$day150 = dayBefore(150);

//$sql = "DELETE FROM weak WHERE 1 = 1";
//$mysql -> query($sql);

$sql = "select code, current from daily where date > '$day40' order by code, date desc";

// $sql = "select c5.code,a.name,c5.avg5,c10.avg10,c20.avg20,c30.avg30,c60.avg60 from (select code, avg(current) as avg5 from daily where date > '$day5' group by code) c5 inner join (select code, avg(current) as avg10 from daily where date > '$day10' group by code) c10 on c5.code=c10.code inner join (select code, avg(current) as avg20 from daily where date > '$day20' group by code) c20 on c5.code=c20.code inner join (select code, avg(current) as avg30 from daily where date > '$day30' group by code) c30 on c5.code=c30.code inner join (select code, avg(current) as avg60 from daily where date > '$day60' group by code) c60 on c5.code=c60.code inner join (select code, avg(current) as avg150 from daily where date > '$day150' group by code) c150 on c5.code=c150.code inner join allstock a on c5.code=a.code where c5.avg5 > c10.avg10 and c10.avg10 > c20.avg20 and c20.avg20 > c30.avg30 and c60.avg60 < c5.avg5 and c60.avg60 *1.05 > c5.avg5 and c5.avg5 < c150.avg150 order by c5.avg5/c60.avg60";

echo $sql . "</br>";

$result = $mysql->query ( $sql );

$data = array();

while ($mr = $result -> fetch_array(MYSQLI_ASSOC)) {
	$data[$mr['code']][] =  $mr['current'];
}

foreach ($data as $key => $value) {
	echo $key . "</br>";
	for($i = 0; $i < 20; $i++){
		$sum = 0;
		for($j = $i; $j < $i+20; $j++){
			$sum += $value[$j];
		}
		$avg = $sum/20;
	}
	
}


mysqli_free_result ( $result );
$mysql->close ();
?>