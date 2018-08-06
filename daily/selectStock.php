<?php
require '../header.php';
require '../common.php';

$url = "http://localhost/web_services.php";
$post_data = array ("username" => "bob","key" => "12345");
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$output = curl_exec($ch);
curl_close($ch);

print_r($output);


// $data = array ('page' => '1',
// 	'num' => '20',
// 	'asc' => '0',
// 	'filed0' => 'stocktype',
// 	'filed1' => 'sinahy',
// 	'filed2' => 'diyu',
// 	'value0' => '*',
// 	'value1' => '*',
// 	'value2' => '*'
// );

// $data = http_build_query($data);

// echo $data;
// //exit();
// $opts = array (
// 'http' => array (
// 'method' => 'POST',
// 'header' => 'Content-type: application/json; charset=gbk\r\n' . 
// 			'Content-Length:' . strlen($data) . '\r\n',
// 'content' => $data
// )
// );

// //$opts = '';
// $context = stream_context_create($opts);
// $url = 'http://screener.finance.sina.com.cn/znxg/data/json.php/SSCore.doView';
// $html = file_get_contents($url, false, $context);
// echo $html;

?>