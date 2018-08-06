<?php
require '../header.php';
require '../common.php';

$channel = new SaeChannel();
$connection = $channel->createChannel('ichess',18000);

echo $connection;
?>