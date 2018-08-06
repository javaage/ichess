<?php
require '../header.php';
require '../common.php';

$obj = new stdClass();
$obj->type = 'update';
$obj->title = 'sz000531 穗恒运Ａ';
$obj->message = 'message';

$msg = json_encode($obj);

echo $msg;

sendMessage($msg);
?>