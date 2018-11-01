<?php
require '../header.php';
require '../common.php';

$sql = "select code,name,min,max,duration,ac,arrow from waveindex where time = (select max(time) from waveindex) order by duration desc ";
$result = $mysql -> query($sql);
$codes = array();
while ($result && $mr = $result->fetch_array(MYSQLI_ASSOC)) {
    $codes[] = $mr;
}

mysqli_free_result($result);
$mysql->close();

echo json_encode($codes);