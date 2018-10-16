<?php
require 'header.php';
require 'common.php';

checkHoliday();

$lm = date("Y-m-d", strtotime("-8 days"));
$lm5 = date("Y-m-d", strtotime("-5 days"));
$strQuery = "DELETE FROM cand_rate where time < '$lm' LIMIT 80000";
$mysql -> query($strQuery);
if ($mysql -> error != 0) {
	die("Error:" . $mysql -> errmsg());
}
$strQuery = "DELETE FROM cand_trans where time < '$lm' LIMIT 80000";
$mysql -> query($strQuery);
if ($mysql -> error != 0) {
	die("Error:" . $mysql -> errmsg());
}
$strQuery = "DELETE FROM stockrecord where date < '$lm5' LIMIT 80000";
$mysql -> query($strQuery);
if ($mysql -> error != 0) {
	die("Error:" . $mysql -> errmsg());
}
$strQuery = "DELETE FROM bkrecord where date < '$lm' LIMIT 80000";
$mysql -> query($strQuery);
if ($mysql -> error != 0) {
	die("Error:" . $mysql -> errmsg());
}
$strQuery = "DELETE FROM bk_trans where time < '$lm' LIMIT 80000";
$mysql -> query($strQuery);
if ($mysql -> error != 0) {
	die("Error:" . $mysql -> errmsg());
}
$strQuery = "DELETE FROM crecord where date < '$lm' LIMIT 80000";
$mysql -> query($strQuery);
if ($mysql -> error != 0) {
	die("Error:" . $mysql -> errmsg());
}
$strQuery = "DELETE FROM c_trans where time < '$lm' LIMIT 80000";
$mysql -> query($strQuery);
if ($mysql -> error != 0) {
	die("Error:" . $mysql -> errmsg());
}
$strQuery = "DELETE FROM director where time < '$lm' LIMIT 80000";
$mysql -> query($strQuery);
if ($mysql -> error != 0) {
	die("Error:" . $mysql -> errmsg());
}

$strQuery = "DELETE FROM waverecord where dt < '$lm' LIMIT 80000";
$mysql -> query($strQuery);
if ($mysql -> error != 0) {
	die("Error:" . $mysql -> errmsg());
}

$sql = "select preflist from candidate order by id desc limit 1";
$result = $mysql -> query($sql);
$row = $result -> fetch_row();
$strCodes = str_replace(",", "','", $row[0]);

// $sqlDelete = "DELETE FROM attend WHERE code not in ('$strCodes')";
// $mysql -> query($sqlDelete);
// if ($mysql -> error != 0) {
// 	die("Error:" . $mysql -> errmsg());
// }

$sqlDelete = "DELETE FROM sign WHERE  code not in ('$strCodes')";
$mysql -> query($sqlDelete);
if ($mysql -> error != 0) {
	die("Error:" . $mysql -> errmsg());
}

$sql = "SELECT DISTINCT w.code from waverecord w LEFT join sign s on w.code = s.code WHERE (LEFT(w.code,2)='sh' or LEFT(w.code,2)='sz') and w.code <> '$icode' and s.code is null";

$result = $mysql -> query($sql);

$arr = array();

while ($row = $result -> fetch_row()) {
	$code = $row[0];
	$arr[] = "('$code')";
}

$sqlInserts = "insert into sign (code) values " . join(",", $arr);
$mysql -> query($sqlInserts);

if ($mysql -> error != 0) {
	die("Error:" . $mysql -> errmsg());
}

// $sqlAll = 'select preflist from candidate limit 1';

// $result = $mysql -> query($sqlAll);

// if ($result && $mr = $result -> fetch_array(MYSQLI_ASSOC)) {
// 	$preflist = $mr['preflist'];

// 	$codeAll = explode(',', $preflist);
// }
$burl = 'http://localhost:5000/allstock';

$ds = file_get_contents($burl);

$ds = json_decode($ds);

for($i=0; $i<count($ds->data);$i++){
    $data = $ds->data[$i];
    $temp = strtolower($data[0]);
    $codeAll[] = substr($temp, 7, 2) . substr($temp, 0, 6);
}

$sqlExist = 'select code from allstock';
$result = $mysql -> query($sqlExist);	
$codes = array();
while($result && $mr = $result -> fetch_array(MYSQLI_ASSOC)){
	$codes[] = $mr['code'];	
}

mysqli_free_result($result);

//print_r($codes);

$codeDiff = array_diff($codeAll, $codes);

//print_r($codeDiff);

foreach ($codeDiff as $key => $code) {
	$code = strtolower($code);
	$urlQueryIndex = 'http://hq.sinajs.cn/list=' . $code;
	//echo $urlQueryIndex . '<br>';
	$html = file_get_contents($urlQueryIndex);
	$html = str_replace("\"", "", $html);

	$shItems = explode(',', $html);

	$names = explode('=', $shItems[0]);
	$name = iconv('GB2312', 'utf-8//IGNORE', $names[1]);
	$code = strtoupper(substr($names[0], -8));

	if(!empty($code) && strlen($name)>3){
	    $code = strtolower($code);
		$sqlInsert = "insert into allstock(code,name,py) values('$code','$name','')";
		echo $sqlInsert . '<br>';

		$mysql -> query($sqlInsert);
	}
	
}


$mysql -> close();
?>