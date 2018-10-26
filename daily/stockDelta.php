<?php
require '../header.php';
require '../common.php';

$queryUrl = 'http://47.94.203.104:8001/allstock';
$html = file_get_contents($queryUrl);
$result = json_decode($html);
$stocks = $result->data;

foreach ($stocks as $stock){
    $code = $stock[0];
    echo $code;
    recordWave($code);
    break;
}

function saveHistory(&$node) {
    global $mysql;
    if (empty($node))
        return;
        for ($i = 0; $i < count($node -> childWave); $i++) {
            $cw = $node -> childWave[$i];
            if (!empty($cw -> childWave)) {
                $cw -> count = count($cw -> childWave);
                $cw -> childWave = array();
            }
        }
}

function saveGlobal($g) {
    
}

function countStockArrow($gw)
{
    if (empty($gw)) {
        return 0;
    } else {
        $r = 0;
        while ($gw->level > 5) {
            if ($gw->asc) {
                $r ++;
            } else {
                $r = 0;
            }
            $cn = count($gw->childWave);
            $gw = $gw->childWave[$cn - 1];
        }
        return $r;
    }
}

function recordWave($code){
    global $mysql, $kv;
    
    $queryFormat = 'http://47.94.203.104:8001/stockDelta/%s';
    $queryUrl = sprintf($queryFormat,$code);
    $html = file_get_contents($queryUrl);
    $csv = json_decode($html);
    
    for ($i = count($csv) - 1; $i > 0; $i--) {
        $f = $csv[$i];
        $l = $csv[$i - 1];
        $w = new Wave();
        $w -> id = uniqid();
        $w -> level = 5;
        $w -> asc = ($l[2] >= $f[2] ? 1 : 0);
        
        $n = $csv[$i - 2];
        while ((($n[2] >= $l[2]) == $w -> asc) && $i > 1) {
            $i--;
            $l = $csv[$i - 1];
            $n = $csv[$i - 2];
        }
        
        $w -> high = max($f[2], $l[2]);
        $w -> low = min($f[2], $l[2]);
        $w -> beginTime = strtotime(formatDate($f[0]) . " 15:00:00");
        $w -> endTime = strtotime(formatDate($l[0]) . " 15:00:00");
        
        saveWave($gw, $w);
    }
    
    $nw = $gw;
    while(count($nw->childWave)>0){
        $nw = $nw->childWave[count($nw->childWave)-1];
    }
    
    while($nw->level > 2){
        $child = json_decode(json_encode($nw));
        $child->id = uniqid();
        $child->pid = $nw->id;
        $child->level = $nw->level - 1;
        $nw->childWave[] = $child;
        $nw = $child;
    }
    
    if(empty($csv)){
        return false;
    }else{
        $arrow = getArrow($gw);
        $ac = countStockArrow($gw);
        $format="INSERT INTO wavedaily (code,dt,gw,arrow,ac) VALUES('%s','%s','%s','%s',%d) ON DUPLICATE KEY UPDATE dt='%s',gw='%s',arrow='%s',ac=%d";
        $strQuery = sprintf($format,$code,formatDate($csv[0][0]),json_encode($gw),$arrow,$ac,formatDate($csv[0][0]),json_encode($gw),$arrow,$ac);
        echo $strQuery;
        $mysql -> query($strQuery);
    }
}