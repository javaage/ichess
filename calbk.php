<?php 
require 'header.php';
require 'common.php';

checkHoliday();
$ct = date ( 'Y-m-d' );
$mb = $ct . " 09:30:00";
$me = $ct . " 11:30:00";

$ab = $ct . " 13:00:00";
$ae = $ct . " 15:00:00";
if (! ((time () >= strtotime ( $mb ) && time () <= strtotime ( $me )) || (time () >= strtotime ( $ab ) && time () <= strtotime ( $ae )))) {
	exit(0);
}

$strbk = memcache_get ( $mmc, 'calbk' );
echo $strbk . "</br>";
if (empty ( $strbk )) {
	exit(0);
}

$flTime = json_decode($strbk);

$fTime = floor($flTime->firstT/60) * 60;
$lTime = floor($flTime->lastT/60) * 60;

if($fTime >= $lTime)
	exit(0);
$rt = date ( 'Y-m-d H:i:s' );

$sql = "INSERT bk_trans (code, name,increase,trans,time) SELECT r.code,r.name,r.increase,r.trans,now() from (select f.code as code,f.name as name, f.increase as increase, (l.increase - f.increase) as trans from (SELECT code,name,increase FROM bkrecord WHERE date='" . $ct . "' AND time >= " . $fTime . " and time < " . ($fTime + 60) . ") f LEFT JOIN (SELECT code,name,increase FROM bkrecord WHERE date='" . $ct . "' AND time >= " . $lTime . " AND time < " . ($lTime+60) . ") l ON f.code = l.code) r ";
echo $sql;
$mysql->query ( $sql );

$mysql->close ();
memcache_set ( $mmc, "calbk", "", 0, 60 * 100 );
?>