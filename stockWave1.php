<?php
require 'header.php';
require 'common.php';

ignore_user_abort(true);
set_time_limit(0);

$sql = "select distinct sd.code from allstock sd left join daily d on lower(sd.code)=d.code where d.code is null";
$result = $mysql -> query($sql);
while ($row = $result -> fetch_row()) {
	$code = $row[0];
	recordWave($code);
}

//http://table.finance.yahoo.com/table.csv?s=300567.sz
//http://table.finance.yahoo.com/table.csv?s=600166.ss
//Date	Open	High	Low	Close	Volume	Adj Close
/**
id
code
name
close
open
current
high
low
clmn
money
avg
date
time
flag
*/
function recordWave($code){
	global $ycode,$mysql;
	$burl = "http://table.finance.yahoo.com/table.csv?s=$ycode";
	
	$burl = str_replace($ycode, substr($code, 2) . "." . substr($code, 0, 2), $burl);
	$burl = str_replace('sh', 'ss', $burl);

	$file = fopen($burl, 'r');
	$sqlSaves = array();

	while ($data = fgetcsv($file)) {
		if (is_numeric($data[6])){
			$date = $data[0];
			$open = $data[1];
			$high = $data[2];
			$low = $data[3];
			$clmn = $data[5];
			$current = $data[6];
			array_push($sqlSaves, "('$code','$open','$high','$low','$current','$clmn','$date')");
		}
	}		
	if(count($sqlSaves) > 0){
		$sqlInsert = "INSERT INTO daily (code,open,high,low,current,clmn,date) VALUES " . join(",", $sqlSaves);	

		$mysql -> query($sqlInsert);
		

		if ($mysql -> error != 0) {
			die("Error:" . $mysql -> errmsg());
		} 
	}else{
		echo $code . "</br>";
	}	
}
?>