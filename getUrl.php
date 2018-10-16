<?php
header("Content-Type: text/html; charset=utf8");
require 'header.php';
require 'common.php';
$urls = getUrl(true);
echo json_encode($urls);
?>