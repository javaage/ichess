<?php
require 'header.php';
require 'common.php';

$q = $_REQUEST["q"];

$sql = "select code,name from allstock where code like '%$q%' or name like '%$q%' or py like '%$q%' order by code limit 10";

$result = $mysql -> query($sql);
$codes = array();
while ($result && $mr = $result -> fetch_array(MYSQLI_ASSOC)) {
	array_push($codes, $mr);
}
echo json_encode($codes, JSON_UNESCAPED_UNICODE);

mysqli_free_result($result);

$mysql -> close();
?>