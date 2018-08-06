<?php
require '../header.php';
require '../common.php';

$rt = date ( 'Y-m-d' );
$ct40 = date("Y-m-d",strtotime("-40 day")); 

$sql = "select code,date,current from daily where date > '$ct40' ORDER by code,date";

$result = $mysql->query ( $sql );

$data = array();

while ($row = $result->fetch_row ()) {
	$code = $row [0];
	$date = $row [1];
	$current = $row [2];

	$data[$code][] = $current;
}

mysqli_free_result ( $result );
$ivalue = array();
	foreach ($data as $code => $arr){
		if(count($arr)<2)
			continue;

		$metric = array();
		foreach ($arr as $key => $value) {
			$metric[] = [$key,$value/$arr[0]];
		}
			$sx = 0;
			$sy = 0;
			$sxy = 0;
			$sx2 = 0;
			$sy2 = 0;
			$xavg = 0;
			$yavg = 0;
			$sxd = 0;
			$syd = 0;
			$sxd2 = 0;
			$syd2 = 0;
			$sxyd = 0;
			for($j = 0; $j < count ( $metric ); $j ++) {
				$sx += $metric [$j] [0];
				$sy += $metric [$j] [1];
				$sxy += $metric [$j] [0] * $metric [$j] [1];
				$sx2 += $metric [$j] [0] * $metric [$j] [0];
				$sy2 += $metric [$j] [1] * $metric [$j] [1];
			}
			$xavg = $sx / count ( $metric );
			$yavg = $sy / count ( $metric );
			for($j = 0; $j < count ( $metric ); $j ++) {
				$sxd += abs($metric [$j] [0] - $xavg);
				$syd += abs($metric [$j] [1] - $yavg);

				$sxyd += ($metric [$j] [0] - $xavg)*($metric [$j] [1] - $yavg);
				$sxd2 += pow ( ($metric [$j] [0] - $xavg), 2 );
				$syd2 += pow ( ($metric [$j] [1] - $yavg), 2 );
			}
			
			$a = 10000 * (count ( $metric ) * $sxy - $sx * $sy) / (count ( $metric ) * $sx2 - $sx * $sx);
			$b = ($sx2 * $sy - $sx * $sxy) / (count ( $metric ) * $sx2 - $sx * $sx);
			$r = sqrt ( $sxd2 ) * sqrt ( $syd2 ) == 0 ? 1 : abs($sxyd) / (sqrt ( $sxd2 ) * sqrt ( $syd2 ));

			array_push ( $ivalue, "('" . $code . "', " . $a . ", " . $b . ", " . $r . ", '" . $rt . "')" );
	}

$sqlsave = "insert into daily_rate (code, a, b, r, date) values " . join ( ",", $ivalue );

$mysql->query ( $sqlsave );

$mysql->close ();
?>