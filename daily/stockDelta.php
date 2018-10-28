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

function countStockArrow($gw,$factor=0.382)
{
    $cw = json_decode(json_encode($gw));
    $r = null;
    $targetMin = null;
    $targetMax = null;
    $duration = null;
    if (empty($gw)) {
        return [null,null,null,null];
    } else {
        $r = 0;
        while ($gw->level > 5) {
            $cn = count($gw->childWave);
            if ($gw->asc) {
                $r ++;
            } else {
                $r = 0;
                if($cn>1){
                    $targetMin = $factor * ($gw->childWave[$cn - 2]->high - $gw->childWave[$cn - 2]->low) + $gw->childWave[$cn - 2]->low;
                    $targetMax = $gw->childWave[$cn - 2]->high;
                    $duration = ($gw->childWave[$cn - 2]->endTime - $gw->childWave[$cn - 2]-> beginTime) - ($gw->childWave[$cn - 1]->endTime - $gw->childWave[$cn - 1]-> beginTime);
                }
            }
            $gw = $gw->childWave[$cn - 1];
        }
        if($r>0){
            return [$r,$targetMin,$targetMax,$duration/24/60/60];
        }else{
            $r = 0;
            while ($cw->level > 5) {
                $cn = count($cw->childWave);
                if (!$cw->asc) {
                    $r --;
                } else {
                    $r = 0;
                    if($cn>1){
                        $targetMax = (1-$factor) * ($gw->childWave[$cn - 2]->high - $gw->childWave[$cn - 2]->low) + $gw->childWave[$cn - 2]->low;
                        $targetMin = $gw->childWave[$cn - 2]->low;
                        $duration = ($gw->childWave[$cn - 2]->endTime - $gw->childWave[$cn - 2]-> beginTime) - ($gw->childWave[$cn - 1]->endTime - $gw->childWave[$cn - 1]-> beginTime);
                    }
                }
                
                $cw = $cw->childWave[$cn - 1];
            }
            return [$r,$targetMin,$targetMax,$duration/24/60/60];
        }
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
        $format="INSERT INTO wavestock (code,dt,gw,arrow,ac,min,max,duration) VALUES('%s','%s','%s','%s',%d,%f,%f,%d) ON DUPLICATE KEY UPDATE dt='%s',gw='%s',arrow='%s',ac=%d,min=%f,max=%f,duration=%d";
        $strQuery = sprintf($format,$code,formatDate($csv[0][0]),json_encode($gw),$arrow,$target[0],$target[1]/$current-1,$target[2]/$current-1,$target[3],formatDate($csv[0][0]),json_encode($gw),$arrow,$target[0],$target[1]/$current-1,$target[2]/$current-1,$target[3]);

        $mysql -> query($strQuery);
    }
}