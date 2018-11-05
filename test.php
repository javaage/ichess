<?php
require 'header.php';
require 'common.php';

class Stock
{
    var $code = "";
    var $name = "";
}

$arr = array();

foreach ($indexList as $indexCode){
    $code1T = $indexCode[0];
    $name1 = $indexCode[1];
    $code1 = strtolower($code1T);
    $code1 = substr($code1,7,9) . substr($code1,0,6);
    
    $urlQueryIndex = "http://hq.sinajs.cn/list=$code1";
    
    $time = strtotime(date('Y-m-d H:i'));
    $rt = date('Y-m-d H:i:s');
    $html = file_get_contents($urlQueryIndex);
    $html = str_replace("\"", "", $html);
    $stocks = explode(';', $html);
    $action = - 1;
    
    $stock = new Stock();
    for ($i = 0; $i < count($stocks) - 1; $i ++) {
        $shItems = explode(',', $stocks[$i]);
        
        if(count($shItems)>=30){
            $stock->code = $code1T;
            $stock->name = $name1;
            $arr[] = $stock;
        }
    }
}

echo json_encode($arr);
// echo join(',',$arr);