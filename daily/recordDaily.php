<?php
require '../header.php';
require '../common.php';

$stocks_req = $_REQUEST['stocks'];


$stocks = json_decode($stocks_req);

$sqlInsert = "INSERT INTO `daily`(`code`, `open`, `current`, `high`, `low`, `clmn`, `date`) VALUES ";

$inserts = array();

foreach ($stocks as $key => $value) {
	$stocks[$key]->clmn = $stocks[$key]->clmn * 100;
	$inserts[] = "('" . $stocks[$key]->code . "','" . $stocks[$key]->open . "','" . $stocks[$key]->current . "','" . $stocks[$key]->high . "','" . $stocks[$key]->low . "','" . $stocks[$key]->clmn . "','" . $stocks[$key]->date . "')";
}

$sqlInsert = $sqlInsert . join(',', $inserts);
$mysql -> query($sqlInsert);
