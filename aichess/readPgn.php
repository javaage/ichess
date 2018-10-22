<?php
require 'header.php';
require 'common.php';

$id = $_REQUEST['id'];

$sql = 'select * from qipu where id = ' . $id;
$result = $mysql->query ( $sql );

while (!empty($result) && $mr = $result->fetch_array ( MYSQLI_ASSOC ) ) {
    echo json_encode($mr);
    break;
}

mysqli_free_result ( $result );

$mysql->close ();
