<?php
require '../header.php';
require '../common.php';

$sql = "select w.code,a.name,a.py,w.min,w.max,w.duration,w.ac,w.arrow,a.ttm,a.pb from (select * from wavestock where time = (select max(time) from wavestock)) w inner join allstock a on w.code =a.code where a.ttm>0 and a.pb>0 order by w.duration desc";
$result = $mysql -> query($sql);
$codes = array();
while ($result && $mr = $result->fetch_array(MYSQLI_ASSOC)) {
    $codes[] = $mr;
}

mysqli_free_result($result);
$mysql->close();

echo json_encode($codes);