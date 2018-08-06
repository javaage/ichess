<?php
header("Content-Type: text/html; charset=utf8");
require 'header.php';
require 'common.php';

checkHoliday();

$ct = date('Y-m-d');

$time = strtotime(date('Y-m-d H:i'));

$sqlInserts = array();
$count = 0;
$urls = getAllUrl();

for ($i = 0; $i < count($urls); $i++) {
	$qian = array(" ", "��", "\t", "\n", "\r");
	$hou = array("", "", "", "", "");
	$url = str_replace($qian, $hou, $urls[$i]);
	$html = file_get_contents($url);
	$stocks = explode(';', $html);

	foreach ($stocks as $stock) {
		$stock = str_replace("\"", "", $stock);
		$items = explode(',', $stock);
		if (count($items) < 33 || $items[1] <= 0 || $items[2] <= 0 || $items[3] <= 0 || $items[4] <= 0 || $items[5] <= 0 || $items[6] <= 0) {
			continue;
		}
		$names = explode('=', $items[0]);
		$names[1] = iconv('GB2312', 'utf-8//IGNORE', $names[1]);
		$code = substr($names[0], -8);
		array_push($sqlInserts, " ('" . $code . "' , '" . $items[30] . "' ,  '" . $items[1] . "' ,  '" . $items[3] . "' , '" . $items[4] . "' , '" . $items[5] . "' , '" . $items[8] . "' ) ");
		$count++;

		if($count > 100){
			$sql = "INSERT INTO daily (code, date, open, current, high, low, clmn) VALUES " . join(",", $sqlInserts);
			$mysql -> query($sql);
			$count = 0;
			$sqlInserts = array();
		}
	}
}

if($count>0){
	$sql = "INSERT INTO daily (code, date, open, current, high, low, clmn) VALUES " . join(",", $sqlInserts);
	$mysql -> query($sql);
}

$day0 = dayBefore(0, 0);
$day20 = dayBefore(60, 0);

$sqlSearch= "select c.code,max(c.date) as dt from
(SELECT d.code,d.high,d.date,t.current FROM daily d inner join (select code,current from daily where date = '$day0') t on d.code = t.code and d.high > t.current) c group by c.code having dt < '$day20'";

$result = $mysql -> query($sqlSearch);

$inserts = array();
$deletes = array();
while ($mr = $result -> fetch_array(MYSQLI_ASSOC)) {
    $code = $mr["code"];
    $dt = $mr["dt"];
    $inserts[] = "('$code','$dt')";
    $deletes = "'" . $code . "'";
}

if(count($inserts)>0){
	$sqlDelete = "delete from attend where code in (" . join(',',$deletes) .")";
	$mysql -> query($sqlDelete);

	$sqlInsert = "insert into attend(code,time) values " . join(',',$inserts);

	$mysql -> query($sqlInsert);

	$sqlUpdate = "update attend d inner join allstock a on d.code = a.code set d.name = a.name";

	$mysql -> query($sqlUpdate);	
}


if ($mysql -> error != 0) {
	die("Error:" . $mysql -> errmsg());
}
$mysql -> close();
?>