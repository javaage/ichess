<?php
require 'header.php';
require 'common.php';

$sql = "select r.code,r.name from (select code,name,current from stockrecord where time = (select max(time) from stockrecord) and current < close) r inner join (select code, avg(current) as avg10 from daily where date > '$day10' group by code) d on r.code=d.code inner join (select code from daily where date = '$day1' and current < open) c on d.code=c.code where d.avg10 < r.current order by r.current/d.avg10";
error_log($sql);
$result = $mysql->query($sql);
$names = array();
$codes = array();
while ($result && $mr = $result->fetch_array(MYSQLI_ASSOC)) {
    $name = strtolower($mr['name']);
    $code = strtolower($mr['code']);
    
    $ting = ting1();
    $suff = '-' . $ting[$code];
    
    array_push($names, $name . $suff);
    array_push($codes, $code . $suff);
}
$pref = join(",", $names);
$pref1 = join(",", $codes);
mysqli_free_result($result);
$strong = popular($cloneWave->beginTime, $w->endTime, $w->asc);

$content = $n . "、" . $tls[min($lchild->level, 17)] . $dir[$lchild->asc] . $todoList[$action];
$detail = $tls[min($nw->level, 17)] . $dir[$nw->asc] . "，关键点" . number_format($p, 0);

