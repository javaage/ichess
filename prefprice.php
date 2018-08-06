<?php
	require 'header.php';
	require 'common.php';
    $code = $_REQUEST["code"];

    if($code=="sh000001" || $code=="sz399001" || $code=="sz399006"){
    	$pref = prefIndex($code);
    }else{
    	 $pref = prefPrice($code);
    }

	echo json_encode($pref);
?>