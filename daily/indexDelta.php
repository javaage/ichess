<?php
require '../header.php';
require '../common.php';

$time = time();
foreach ($indexList as $indexCode){
    $code = $indexCode[0];
    $name = $indexCode[1];
    echo $code;
    recordWave($code,$name);
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
    $cw = json_decode(json_encode($gw));
    $r = null;
    $targetMin = null;
    $targetMax = null;
    if (empty($gw)) {
        return [0,0,0];
    } else {
        $r = 0;
        while ($gw->level > 5) {
            $cn = count($gw->childWave);
            if ($gw->asc) {
                $r ++;
            } else {
                $r = 0;
                $targetMin = $gw->low;
                $targetMax = $gw->high;
            }
            $gw = $gw->childWave[$cn - 1];
        }
        if($r>0){
            return [$r,$targetMin,$targetMax];
        }else{
            $r = 0;
            while ($cw->level > 5) {
                $cn = count($cw->childWave);
                if (!$cw->asc) {
                    $r --;
                } else {
                    $r = 0;
                    $targetMin = $cw->low;
                    $targetMax = $cw->high;
                }
                
                $cw = $cw->childWave[$cn - 1];
            }
            return [$r,$targetMin,$targetMax];
        }
    }
}

function recordWave($code,$name){
    global $mysql, $kv, $time;
    
    $queryFormat = 'http://47.94.203.104:8001/indexDelta/%s';
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
    
    $current = $csv[0][2];
    
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
        $target = countStockArrow($gw);
        
        $pattern='/0(11)*[2110,1111]$/';
        $arr=preg_split ($pattern, $arrow);
        $reverse = 0;
        if(count($arr)>0){
            $reverse = (strlen($arrow) - strlen($arr[0]) - 1)/2;
        }
        
        $format="INSERT INTO waveindex (code,name,dt,gw,arrow,ac,min,max,duration,time) VALUES('%s','%s','%s','%s',%d,%f,%f,%d,%d) ON DUPLICATE KEY UPDATE gw='%s',arrow='%s',ac=%d,min=%f,max=%f,duration=%d,time=%d";
        $strQuery = sprintf($format,$code,$name,formatDate($csv[0][0]),json_encode($gw),$arrow,$target[0],$target[1],$target[2],$reverse,$time,json_encode($gw),$arrow,$target[0],$target[1],$target[2],$reverse,$time);
        $mysql -> query($strQuery);
    }
}