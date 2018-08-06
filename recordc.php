<?php 

header ( "Content-Type: text/html; charset=utf8" );
require 'header.php';
require 'common.php';

checkHoliday();

$ct = date ( 'Y-m-d' );
$mb = $ct . " 09:30:00";
$me = $ct . " 11:30:00";

$ab = $ct . " 13:00:00";
$ae = $ct . " 15:01:00";

$urlswhy = "http://money.finance.sina.com.cn/q/view/newFLJK.php?param=class";
$urlbkstock = "http://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getHQNodeData?page=1&num=100&sort=symbol&asc=1&node=sw_cm&symbol=&_s_r_a=init";
$type = "newFLJK";

$htmlswbk = file_get_contents ( $urlswhy );

$cswbk = explode("=", $htmlswbk);
$qian = array (
		" ",
		"��",
		"\t",
		"\n",
		"\r"
);
$hou = array (
		"",
		"",
		"",
		"",
		""
);

$keyqian = array(
		'symbol',
		'code',
		'name',
		'trade',
		'pricechange',
		',per',
		'changepercent',
		'buy',
		'sell',
		'settlement',
		'open',
		'high',
		'low',
		'volume',
		'amount',
		'ticktime',
		'pb',
		'mktcap',
		'nmc',
		'turnoverratio'
);
$keyhou = array(
		'"symbol"',
		'"code"',
		'"name"',
		'"trade"',
		'"pricechange"',
		',"per"',
		'"changepercent"',
		'"buy"',
		'"sell"',
		'"settlement"',
		'"open"',
		'"high"',
		'"low"',
		'"volume"',
		'"amount"',
		'"ticktime"',
		'"pb"',
		'"mktcap"',
		'"nmc"',
		'"turnoverratio"'
);

$strbk = str_replace ( $qian, $hou, $cswbk[1] );
$strbk = iconv('GB2312', 'utf-8//IGNORE', $strbk);

$swbk = json_decode($strbk);
$time = strtotime(date('Y-m-d H:i'));

foreach ($swbk as $bk){
	$items = explode(",", $bk);
	$code = $items[0];
	$name = $items[1];
	$urlbk = str_replace("sw_cm", $code, $urlbkstock);
	$codes = [];
	for($count = 1; $count < 30; $count += 1){
		$urlbk = str_replace("page=1", "page=" . $count, $urlbk);
		$bkContent = file_get_contents($urlbk);
		if(empty($bkContent))
			break;
		$bkContent = str_replace ( $qian, $hou, $bkContent );
		$bkContent = str_replace ( $keyqian, $keyhou, $bkContent );
		$bkContent = iconv('GB2312', 'utf-8//IGNORE', $bkContent);

		$bkObject = json_decode($bkContent);
		if(empty($bkObject))
			break;
		foreach ($bkObject as $object){
			array_push($codes, $object->symbol);
		}
		
	}
	$content = join(",", $codes);
	$sql = 'INSERT INTO category (code, name, type, content) VALUES ("' . $code . '","' . $name . '","' . $type . '","' . $content . '")';

	$mysql->query ( $sql );
}

if ($mysql->error != 0) {
	die ( "Error:" . $mysql->errmsg () );
}
$mysql->close ();
?>