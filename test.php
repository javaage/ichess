<?php
require 'header.php';
require 'common.php';

// $sql = "insert into test_table(name,age) values('inteval',20)";
// $mysql -> query($sql);
// $mysql -> close();
// echo 'success';



$arr = array();
$arr[] = "hello";
$arr[] = "world";

$kv->set('hello',$arr);

echo $kv->get('hello');
