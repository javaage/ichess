<?php
require '../header.php';
require '../common.php';

$sql = "select code from wavestock order by ac desc";
$result = $mysql -> query($sql);
$codes = array();
while ($result && $mr = $result->fetch_array(MYSQLI_ASSOC)) {
    $codes[] = $mr['code'];
}

mysqli_free_result($result);
$mysql->close();

echo json_encode($codes);