<?php
require 'header.php';
require 'common.php';

$str='2140111121401111112110';
$pattern='/0(11)*2110$/';  /*因为/为特殊字符，需要转移*/
$str=preg_split ($pattern, $str);


// $str='http://blog.csdn.net/hsd2012/article/details/51152810';
// $pattern='/\//';  /*因为/为特殊字符，需要转移*/
// $str=preg_split ($pattern, $str);

echo json_encode($str);