<?php
require 'header.php';
require 'common.php';

$burl = 'http://localhost:8001/allstock';
$ds = file_get_contents($burl);
$ds = json_decode($ds);

for($i=0; $i<count($ds->data);$i++){
    $data = $ds->data[$i];
    $temp = strtolower($data[0]);
    $code = substr($temp, 7, 2) . substr($temp, 0, 6);
    
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

function recordWave($code){
    global $mysql, $kv, $ycode;
    $gw = null;
    $ct = date('Y-m-d');
    // 	$burl = "http://table.finance.yahoo.com/table.csv?s=$ycode";
    $burl = "http://localhost:8001/daily/$ycode";
    $baseUrl = "http://hq.sinajs.cn/list=";
    
    $sql = "SELECT code FROM waverecord WHERE code = '$code'";
    
    $result = $mysql -> query($sql);
    if($row = $result -> fetch_row()){
        return false;
    }else{
        echo $code;
    }
    
    $csv = array();
    
    // 	$url = $baseUrl . $code;
    // 	$html = file_get_contents($url);
    
    // 	$stock = str_replace("\"", "", $html);
    // 	$items = explode(',', $stock);
    
    // 	$ct = date('Y-m-d');
    // 	$csv[] = array($ct, $items[3]);
    
    $burl = str_replace($ycode, substr($code, 2) . "." . substr($code, 0, 2), $burl);
    // 	$burl = str_replace('sh', 'ss', $burl);
    
    // 	$burl = 'http://www.baidu.com';
    
    $ds = file_get_contents($burl);
    
    $ds = json_decode($ds);
    
    for($i=0; $i<count($ds->data);$i++){
        $data = $ds->data[$i];
        if (is_numeric($data[5]))
            $csv[] = array(substr($data[1], 0, 4) . '-' . substr($data[1], 4, 2) . '-' . substr($data[1], 6, 2) . ' ', $data[5]);
    }
    
    for ($i = count($csv) - 1; $i > 0; $i--) {
        $f = $csv[$i];
        $l = $csv[$i - 1];
        $w = new Wave();
        $w -> id = uniqid();
        $w -> level = 5;
        $w -> asc = ($l[1] >= $f[1] ? 1 : 0);
        
        $n = $csv[$i - 2];
        while ((($n[1] >= $l[1]) == $w -> asc) && $i > 1) {
            $i--;
            $l = $csv[$i - 1];
            $n = $csv[$i - 2];
        }
        
        $w -> high = max($f[1], $l[1]);
        $w -> low = min($f[1], $l[1]);
        $w -> beginTime = strtotime($f[0] . "15:00:00");
        $w -> endTime = strtotime($l[0] . "15:00:00");
        
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
    
    if(empty($gw)){
        return false;
    }else{
        $arrow = getArrow($gw);
        $ac = countArrow($gw);
        $strQuery = "INSERT INTO wavedaily (code,dt,gw,arrow,ac) VALUES('$code','" . $ct . "','" . json_encode($gw) . "','" . $arrow . "'," . $ac . ")";
        $mysql -> query($strQuery);
        return true;
    }
}