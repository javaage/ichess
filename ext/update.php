<?php
require '../header.php';
require '../common.php';
$code = $_REQUEST['code'];
$flag = $_REQUEST['flag'];

$code = strtolower($code);

updateMessage($code,$flag);

?>