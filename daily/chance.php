<?php
require '../header.php';
require '../common.php';

$sql = "SELECT DATE_FORMAT(time,'%Y-%m-%d') FROM stockaction ORDER by time desc LIMIT 1";
$result = $mysql -> query($sql);
$row = $result -> fetch_row();

//$sql50 = "SELECT pref FROM stockaction WHERE time > '$row[0]'";
$sql50 = "SELECT pref FROM stockaction WHERE time > '2017-01-26 11:25:00'";

$result = $mysql -> query($sql50);
$chance = array();

while ($mr = $result -> fetch_array(MYSQLI_ASSOC)) {
	$pref = $mr['pref'];
	$codes = explode(',',$pref);
	foreach ($codes as $key => $value) {
		$chance[$value] += 1;
	}
	
}

arsort($chance);

print_r($chance);

mysqli_free_result($result);

$mysql -> close();
?>