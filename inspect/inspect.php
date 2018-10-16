<?php
require '../header.php';
require '../common.php';

checkHoliday();

$rt = date('Y-m-d H:i:s');
$ct = date('Y-m-d');
$mb = $ct . " 09:30:00";
$me = $ct . " 11:30:00";

$ab = $ct . " 13:00:00";
$as = $ct . " 14:59:00";
$ae = $ct . " 15:00:00";

if (!((time() >= strtotime($mb) && time() <= strtotime($me)) || (time() >= strtotime($ab) && time() <= strtotime($ae)))) {
	exit(0);
}

$code = "sh600025";

$urlQueryIndex = "http://hq.sinajs.cn/list=$code";

$time = strtotime(date('Y-m-d H:i'));
$rt = date('Y-m-d');
$html = file_get_contents($urlQueryIndex);
$html = str_replace("\"", "", $html);
$stocks = explode(';', $html);

for ($i = 0; $i < count($stocks) - 1; $i++) {
	$shItems = explode(',', $stocks[$i]);

	$shCurrentPrice = $shItems[3];
	$shClosePrice = $shItems[2];
	$openPrice = $shItems[1];

	$names = explode('=', $shItems[0]);
	$names[1] = iconv('GB2312', 'utf-8//IGNORE', $names[1]);
	$code = substr($names[0], -8);

	$clmn = $shItems[8];
	$cover = $shItems[10]+1;

	$rate = $clmn/$cover;
	echo $rate . "</br>";
	if($rate > 0.1 && !$kv->get('ting' . $ct . $code)){
		$kv->set('ting' . $ct . $code,true);
		$obj = new stdClass();
		$obj->title = $code;
		$obj->message = 'You need to inspect it';

		saveMessage($code,$names[1],$obj->message,0);

	}
}


$sqlHolder = "select code from holder";

$result = $mysql -> query($sqlHolder);
$codes = array();
while ($result && $mr = $result -> fetch_array(MYSQLI_ASSOC)) {
	$code = strtolower($mr['code']);
	array_push($codes, $code);
}
mysqli_free_result($result);

$urlHolder = "http://hq.sinajs.cn/list=" . join(",",$codes);

$html = file_get_contents($urlHolder);
$html = str_replace("\"", "", $html);
$stocks = explode(';', $html);

for ($i = 0; $i < count($stocks) - 1; $i++) {
	$shItems = explode(',', $stocks[$i]);

	$names = explode('=', $shItems[0]);
	$names[1] = iconv('GB2312', 'utf-8//IGNORE', $names[1]);
	$code = substr($names[0], -8);

	$close = $shItems[2];
	$current = $shItems[3];
	$clmn = $shItems[8];
	$money = $shItems[9];

	$sell1Clmn = $shItems[20];
	$sell1Price = $shItems[21];
	$buy1Clmn = $shItems[10];
	$buy1Price = $shItems[11];

	$middle = ($sell1Price + $buy1Price)/2;

	$oldTape = $kv->get('tape' . $code);

	if($oldTape){
		$buyTotalAsc = $oldTape[1]; 
		$sellTotalAsc = $oldTape[2]; 
		$buyTotalDesc = $oldTape[3]; 
		$sellTotalDesc = $oldTape[4]; 
		$buyTotalEqual = $oldTape[5]; 
		$sellTotalEqual = $oldTape[6];

		if($middle > $oldTape[0]){ //asc
			$buyTotalAsc += $buy1Clmn;
			$sellTotalAsc += $sell1Clmn;
		}else if($middle < $oldTape[0]){ //desc
			$buyTotalDesc += $buy1Clmn;
			$sellTotalDesc += $sell1Clmn;
		}else{
			$buyTotalEqual += $buy1Clmn;
			$sellTotalEqual += $sell1Clmn;
		}
	}else{
		$buyTotalAsc = 0; 
		$sellTotalAsc = 0; 
		$buyTotalDesc = 0; 
		$sellTotalDesc = 0; 
		$buyTotalEqual = 0; 
		$sellTotalEqual = 0;
	}

	$tape = [$middle, $buyTotalAsc, $sellTotalAsc, $buyTotalDesc, $sellTotalDesc, $buyTotalEqual, $sellTotalEqual];

	$kv->set('tape' . $code, $tape);

	if($sellTotalAsc)
		$asc = $buyTotalAsc/$sellTotalAsc;
	else
		$asc = 0;
	if($sellTotalDesc)
		$desc = $buyTotalDesc/$sellTotalDesc;
	else
		$desc = 0;

	if($sellTotalEqual)
		$equal = $buyTotalEqual/$sellTotalEqual;
	else
		$equal = 0;

	$sqlUpdate = "update holder set ascrate = $asc, descrate = $desc, equalrate = $equal where code = '$code'";

	echo $sqlUpdate . "</br>";

	$mysql -> query($sqlUpdate);

	$avg = $money/$clmn;

	echo $current/$avg . "</br>";

	if($current/$avg > 1.01 && !$kv->get('holderAvg' . $ct . $code)){
		$kv->set('holderAvg' . $ct . $code,true);
		$obj = new stdClass();
		$obj->title = $code . ' ' . $names[1];
		$obj->message = 'Above average 1%.';
		saveMessage($code,$names[1],$obj->message,0);
	}

	if($current/$close > 1.06 && !$kv->get('holderHigh' . $ct . $code)){
		$kv->set('holderHigh' . $ct . $code,true);
		$obj = new stdClass();
		$obj->title = $code . ' ' . $names[1];
		$obj->message = 'Rate is above 6%.';
		saveMessage($code,$names[1],$obj->message,0);
	}
}

$sqlAttend = "select code from weak";

$result = $mysql -> query($sqlAttend);
$codes = array();
while ($result && $mr = $result -> fetch_array(MYSQLI_ASSOC)) {
	$code = strtolower($mr['code']);
	array_push($codes, $code);
}
mysqli_free_result($result);

$urlHolder = "http://hq.sinajs.cn/list=" . join(",",$codes);

$html = file_get_contents($urlHolder);
$html = str_replace("\"", "", $html);
$stocks = explode(';', $html);

for ($i = 0; $i < count($stocks) - 1; $i++) {
	$shItems = explode(',', $stocks[$i]);

	$names = explode('=', $shItems[0]);
	$names[1] = iconv('GB2312', 'utf-8//IGNORE', $names[1]);
	$code = substr($names[0], -8);

	$clmn = $shItems[8];
	$money = $shItems[9];
	$current = $shItems[3];

	$sell1Clmn = $shItems[20];
	$sell1Price = $shItems[21];
	$buy1Clmn = $shItems[10];
	$buy1Price = $shItems[11];

	$middle = ($sell1Price + $buy1Price)/2;

	$oldTape = $kv->get('tape' . $code);

	if($oldTape){
		$buyTotalAsc = $oldTape[1]; 
		$sellTotalAsc = $oldTape[2]; 
		$buyTotalDesc = $oldTape[3]; 
		$sellTotalDesc = $oldTape[4]; 
		$buyTotalEqual = $oldTape[5]; 
		$sellTotalEqual = $oldTape[6];

		if($middle > $oldTape[0]){ //asc
			$buyTotalAsc += $buy1Clmn;
			$sellTotalAsc += $sell1Clmn;
		}else if($middle < $oldTape[0]){ //desc
			$buyTotalDesc += $buy1Clmn;
			$sellTotalDesc += $sell1Clmn;
		}else{
			$buyTotalEqual += $buy1Clmn;
			$sellTotalEqual += $sell1Clmn;
		}
	}else{
		$buyTotalAsc = 0; 
		$sellTotalAsc = 0; 
		$buyTotalDesc = 0; 
		$sellTotalDesc = 0; 
		$buyTotalEqual = 0; 
		$sellTotalEqual = 0;
	}

	$tape = [$middle, $buyTotalAsc, $sellTotalAsc, $buyTotalDesc, $sellTotalDesc, $buyTotalEqual, $sellTotalEqual];

	$kv->set('tape' . $code, $tape);

	if($sellTotalAsc)
		$asc = $buyTotalAsc/$sellTotalAsc;
	else
		$asc = 0;
	if($sellTotalDesc)
		$desc = $buyTotalDesc/$sellTotalDesc;
	else
		$desc = 0;

	if($sellTotalEqual)
		$equal = $buyTotalEqual/$sellTotalEqual;
	else
		$equal = 0;

	$sqlUpdate = "update weak set ascrate = $asc, descrate = $desc, equalrate = $equal where code = '$code'";

	echo $sqlUpdate . "</br>";

	$mysql -> query($sqlUpdate);

	$avg = $money/$clmn;

	echo $current/$avg . "</br>";

	if($current/$avg < 0.985 && !$kv->get('weak' . $ct . $code)){
		$kv->set('weak' . $ct . $code,true);
		$obj = new stdClass();
		$obj->title = $code . ' ' . $names[1];
		$obj->message = 'Weak below average 1.5%.';
		saveMessage($code,$names[1],$obj->message,0);
	}
}

$sqlInspect = "select id, code,name,type,opt,value from inspect where flag=0";

$result = $mysql->query($sqlInspect);
$actions = array();
$codes = array();
while ($result && $mr = $result->fetch_array(MYSQLI_ASSOC)) {
	$code = strtolower($mr['code']);
	array_push($codes, $code);
	$actions[$code] = $mr;
}
mysqli_free_result($result);

$urlInspect = "http://hq.sinajs.cn/list=" . join(",",$codes);

echo $urlInspect . "<br>";

$html = file_get_contents($urlInspect);
$html = str_replace("\"", "", $html);
$stocks = explode(';', $html);

for ($i = 0; $i < count($stocks) - 1; $i++) {
	$shItems = explode(',', $stocks[$i]);

	$names = explode('=', $shItems[0]);
	$names[1] = iconv('GB2312', 'utf-8//IGNORE', $names[1]);
	$code = substr($names[0], -8);

	$clmn = $shItems[8];
	$money = $shItems[9];
	$current = $shItems[3];
	echo $current;
	$close = $shItems[2];

	$rate = $current/$close;

	echo $actions[$code]['type'];
	if($actions[$code]['type'] == 'val'){
		echo 0;
		if($actions[$code]['opt'] == '>'){
			echo 1;
			echo $current;
			print_r($actions[$code]);
			echo $actions[$code]['value'];

			if($current > $actions[$code]['value'] ){
				echo 2;
				$obj = new stdClass();
				$obj->title = $code . ' ' . $names[1];
				$obj->message = 'Price is greater than ' . $current;
				saveMessage($code,$names[1],$obj->message,0);
				updateInspect($actions[$code]['id']);
			}
		}else{
			if($current < $actions[$code]['value'] ){
				echo 3;
				$obj = new stdClass();
				$obj->title = $code . ' ' . $names[1];
				$obj->message = 'Price is less than ' . $current;
				saveMessage($code,$names[1],$obj->message,0);
				updateInspect($actions[$code]['id']);
			}
		}

	}else{
		if($actions[$code]['opt'] == '>'){
			if($rate > $actions[$code]['value'] ){
				echo 4;
				$obj = new stdClass();
				$obj->title = $code . ' ' . $names[1];
				$obj->message = 'Rate is greater than ' . $rate;
				saveMessage($code,$names[1],$obj->message,0);
				updateInspect($actions[$code]['id']);
			}
		}else{
			if($rate < $actions[$code]['value'] ){
				echo 5;
				$obj = new stdClass();
				$obj->title = $code . ' ' . $names[1];
				$obj->message = 'Rate is less than ' . $rate;
				saveMessage($code,$names[1],$obj->message,0);
				updateInspect($actions[$code]['id']);
			}
		}

	}
}


?>