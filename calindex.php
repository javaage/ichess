<?php
require 'header.php';
require 'common.php';
$n = $_REQUEST["n"];
$gw = $kv -> get("g");

$l2 = $gw;
while ($l2 -> level > $n + 1) {
	$l2 = $l2 -> childWave[count($l2 -> childWave) - 1];
}
$cl2 = count($l2 -> childWave);
$asc = $l2 -> childWave[0] -> asc;
$indexs = array();

for ($i = 0; $i < $cl2; $i++) {
	if ($asc) {
		if ($i % 2 == 0) {
			$indexs[] = array( 1000 * $l2 -> childWave[$i] -> beginTime, $l2 -> childWave[$i] -> low);
		} else {
			$indexs[] = array( 1000 * $l2 -> childWave[$i] -> beginTime, $l2 -> childWave[$i] -> high);
		}
	} else {
		if ($i % 2 == 0) {
			$indexs[] = array( 1000 * $l2 -> childWave[$i] -> beginTime, $l2 -> childWave[$i] -> high);
		} else {
			$indexs[] = array( 1000 * $l2 -> childWave[$i] -> beginTime, $l2 -> childWave[$i] -> low);
		}
	}
}

$reals = $indexs;
$last = $l2 -> childWave[$cl2 - 1];
if ($last -> asc) {
	$reals[] = array( 1000 * $last -> endTime, $last -> high);
} else {
	$reals[] = array( 1000 * $last -> endTime, $last -> low);
}
$cals = calNext($indexs);
$cals = calNext($cals);
$r = new stdClass();
$r -> reals = $reals;
$r -> cals = $cals;
echo json_encode($r,JSON_NUMERIC_CHECK);
exit(0);

function calNext($a) {
	if (count($a) < 3) {
		return $a;
	} else {
		if (count($a) % 2 == 0) {
			$b = 1;
		} else {
			$b = 0;
		}
		$gc = floor((count($a) - $b) / 2);
		$deltaIndex = 0;

		for ($i = 0; $i < $gc; $i++) {
			$deltaIndex += ($a[2 * $i + 1 + $b][1] - $a[2 * $i + $b][1]);
		}
		$deltaIndex /= $gc;
		$deltaTime = $a[count($a) - 1][0] - $a[0][0];

		$day = floor($deltaTime * 1.0/ (24*60*60*1000));
		
		$deltaTime -= $day * 20 * 60 * 60 * 1000;
		$deltaTime /= (count($a) - 1);

		$a[] = array($a[count($a) - 1][0] + $deltaTime, $a[count($a) - 1][1] + $deltaIndex);
		return $a;
	}
}
