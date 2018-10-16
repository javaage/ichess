<?php
require '../header.php';
require '../common.php';

$filename = 'http://ichess-file.stor.sinaapp.com/Table.xls';

$handle = fopen($filename, 'r'); 
$out = array (); 
    $n = 0; 
    //$data = fgetcsv($handle, "\r\n");
    while ($data = fgetcsv($handle,0," ")) {  //, 4000, " "
    	print_r($data);
        // $code = $data[0]; 
        // $name = iconv('gb2312', 'utf-8', $data[1]);
        // //$py = $data[0]; 
        // $industry = $data[35];
        // $pe = $data[17]; 
        // $pb = $data[19];
        // $totalvalue = $data[11]; 
        // $currency = $data[12];
        // $out[] = "('$code','$name','','$industry',$pe,$pb,$totalvalue,$currency)";
        break;
    } 

//print_r(join($out,','));
   
fclose($handle); //关闭指针 
    