<?php
require 'header.php';
require 'common.php';

$min = $_REQUEST['min'];
$count = $_REQUEST['count'];
$ecco = $_REQUEST['ecco'];
$result = $_REQUEST['result'];
$keyword = $_REQUEST['keyword'];

if(empty($min)){
    $min = 0;
}
if(empty($count)){
    $count = 10;
}

$where = 'where 1=1 ';
if(!empty($ecco)){
    $where = $where . " and ecco like '%" . $ecco . "%' ";
}
if(!empty($result)){
    if($result=='1'){
        $result='1-0';
    }else if($result=='2'){
        $result='1/2-1/2';
    }else{
        $result='0-1';
    }        
    $where = $where . " and result = '" . $result . "' ";
}
if(!empty($keyword)){
    $where = $where . "and(`date` like '%".$keyword."%' or blackTeam like '%".$keyword."%' or black like '%".$keyword."%' or redTeam like '%".$keyword."%' or red like '%".$keyword."%' or event like '%".$keyword."%' or opening like '%".$keyword."%')";
}

$sql = sprintf('select * from qipu %s limit %d offset %d',$where, $count,$min);
$result = $mysql->query ( $sql );

$arr = array();

while (!empty($result) && $mr = $result->fetch_array ( MYSQLI_ASSOC ) ) {
	$arr[] = $mr;
}

echo json_encode($arr);

mysqli_free_result ( $result );

$mysql->close ();
