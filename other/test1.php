<?php
require '../header.php';
require '../common.php';

	$day1 = dayBefore(1, 0);
		$day10 = dayBefore(10, 0);

		$sql = "select r.code,r.name from (select code,name,current from stockrecord where time = (select max(time) from stockrecord) and current < close) r inner join (select code, avg(current) as avg10 from daily where date > '$day10' group by code) d on r.code=d.code inner join (select code from daily where date = '$day1' and current < open) c on d.code=c.code where d.avg10 < r.current order by r.current/d.avg10";

		echo $sql . '<br>';

		$result = $mysql -> query($sql);
		$names = array();
		$codes = array();
		while ($result && $mr = $result -> fetch_array(MYSQLI_ASSOC)) {
			$name = strtolower($mr['name']);
			$code = strtolower($mr['code']);

			$ting = ting1();
			$suff = '-' . $ting[$code];

			array_push($names, $name . $suff);
			array_push($codes, $code . $suff);
		}
		$pref = join(",", $names);
		$pref1 = join(",", $codes);

		echo $pref . '<br>';
		echo $pref1 . '<br>'; 