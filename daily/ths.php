<?php
require '../header.php';
require '../common.php';


// $sql = "select preflist from candidate order by id desc limit 1";
// $result = $mysql -> query($sql);

// if ($row = $result -> fetch_row()) {

// 	$candidates = preg_replace('/\s/', '', $row[0]);
// 	$candidates = str_replace("sh", "", $candidates);
// 	$candidates = str_replace("sz", "", $candidates);
// 	echo $candidates;

// }

// mysqli_free_result($result);

// $mysql -> close();

$sql = "select distinct code from collect order by date desc, flag limit 500";
$result = $mysql -> query($sql);

$codes = array();

while ($row = $result -> fetch_row()) {

	$candidates = preg_replace('/\s/', '', $row[0]);
	$candidates = str_replace("sh", "", $candidates);
	$candidates = str_replace("sz", "", $candidates);
	$codes[] = $candidates;

}

mysqli_free_result($result);

$mysql -> close();

echo join($codes, ',');

?>