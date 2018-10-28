<?php
require '../header.php';
require '../common.php';

$sql = "select w.code,a.name,a.py from wavestock w inner join allstock a on substr(w.code,1,6) =substr(a.code,3,6) order by w.ac desc";
$result = $mysql -> query($sql);
$codes = array();
while ($result && $mr = $result->fetch_array(MYSQLI_ASSOC)) {
    $codes[] = $mr;
}

mysqli_free_result($result);
$mysql->close();

echo json_encode($codes);