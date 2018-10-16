<?php
require '../header.php';
require '../common.php';

$n = $_REQUEST["n"];
$t = $_REQUEST["t"];
$code = $_REQUEST["code"];

$y = $_REQUEST["y"];

if(empty($y)){
	$ct = date('Y-m-d');
	$ct = $ct . " 15:00:00";
	$time = strtotime($ct);
	
}else{
	$ct = date('Y-m-d');
	$time = strtotime($ct);
}



if(empty($n)){
	$n = 26 * 240;
}
if(empty($t)){
	$t = 0;
}
if(empty($code)){
	$code = 'sz399006';
	$rate = 1.489;
}

switch ($code) {
		case 'sz399001':
			$rate = 0.295;
			break;
		case 'sz399006':
			$rate = 1.489;
			break;
		case 'sz399678':
			$rate = 1.822;
			break;
		case 'sz399959':
			$rate = 0.482;
			break;
		case 'sz399991':
			$rate = 0.548;
			break;
		case 'sz399232':
			$rate = 0.82;
			break;
		case 'sz399239':
			$rate = 0.741;
			break;
		case 'sz399240':
			$rate = 0.384;
			break;
		case 'sz399806':
			$rate = 0.87;
			break;
		default:
			break;
	}

$sql = "select p.dex,p.clmn,p.strong,p.szclmn/1000,p.t from (select sh.rownum,sh.current as dex, sh.clmn as clmn, (sz.current -sh.current + (SELECT avg(current) from indexrecord where code='sh000001' order by id desc)) as strong,sz.time as t,sz.clmn as szclmn from (SELECT id, code,current * $rate as current,time,clmn FROM indexrecord WHERE code='$code') sz inner join (select i2.rownum,i1.code,i1.current,i1.time,(case when i2.clmn-i1.clmn > 0 then i2.clmn - i1.clmn else i2.clmn end) as clmn from (SELECT i.code,i.current,i.time,i.clmn,@rownum1:=@rownum1+1 as rownum FROM (select @rownum1:=0) a,indexrecord i WHERE code='sh000001' order by id desc) i1 inner join (SELECT i.code,i.current,i.time,i.clmn,@rownum2:=@rownum2+1 as rownum FROM (select @rownum2:=0) a,indexrecord i WHERE code='sh000001' order by id desc) i2 on i1.rownum = i2.rownum + 1) sh on sz.time = sh.time where sh.time > $t and sh.time < $time ORDER by t desc limit $n) p order by p.t ";

$result = $mysql -> query($sql);
$strongs = array();
$temps = array();
while ($result && $mr = $result -> fetch_array(MYSQLI_NUM)) {
	$temps[] = [ doubleval($mr[0]),doubleval($mr[1]),round(doubleval($mr[2]),2),doubleval($mr[3])];
}

for($i=0; $i < count($temps)/5; $i++){
	$strongs[] = [($temps[5*$i][0]+$temps[5*$i+1][0]+$temps[5*$i+2][0]+$temps[5*$i+3][0]+$temps[5*$i+4][0])/5,
		($temps[5*$i][1]+$temps[5*$i+1][1]+$temps[5*$i+2][1]+$temps[5*$i+3][1]+$temps[5*$i+4][1])/5,
		($temps[5*$i][2]+$temps[5*$i+1][2]+$temps[5*$i+2][2]+$temps[5*$i+3][2]+$temps[5*$i+4][2])/5,
		($temps[5*$i][3]+$temps[5*$i+1][3]+$temps[5*$i+2][3]+$temps[5*$i+3][3]+$temps[5*$i+4][3])/5];
}

echo json_encode($strongs);
mysqli_free_result($result);

$mysql -> close();
?>