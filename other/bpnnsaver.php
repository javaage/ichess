<?php
require '../header.php';
require '../common.php';

$saver = $_REQUEST["saver"];
echo $saver;

echo 1;

if(empty($saver)){
	echo $kv->get('bpnnsaver');
	echo 3;
}
else{
	$kv->set('bpnnsaver',$saver);
	echo 2;
}
