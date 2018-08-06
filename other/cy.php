<?php
require '../header.php';
require '../common.php';

$n = $_REQUEST["n"];
$t = $_REQUEST["t"];
$code = $_REQUEST["code"];

if(empty($n)){
	$n = 1;
}
if(empty($t)){
	$t = 0;
}
if(empty($code)){
	$code = 'sz399006';
	$rate = 1.489;
}else{
	$sqlRate = 'select max(high) as high,min(low) as low,code from indexrecord where code="' . $code . '" or code="sh000001" group by code ';
	$result = $mysqlt -> query($sqlRate);
	$strongs = array();
	while ($mr = $result -> fetch_array(MYSQLI_ASSOC)) {
		if($mr['code'] == 'sh000001'){
			$base = (float)$mr['high'] + (float)$mr['low'];
		}else{
			$rating = (float)$mr['high'] + (float)$mr['low'];
		}
	}

	$rate = $base / $rating;
}

$sql = "select p.dex,p.clmn,p.strong,p.t from (select sh.rownum,sh.current as dex, sh.clmn as clmn, (sz.current -sh.current + (SELECT avg(current) from indexrecord where code='sh000001' order by id desc)) as strong,sz.time as t from (SELECT id, code,current * $rate as current,time FROM indexrecord WHERE code='$code') sz inner join (select i2.rownum,i1.code,i1.current,i1.time,(case when i2.clmn-i1.clmn > 0 then i2.clmn - i1.clmn else i2.clmn end) as clmn from (SELECT i.code,i.current,i.time,i.clmn,@rownum1:=@rownum1+1 as rownum FROM (select @rownum1:=0) a,indexrecord i WHERE code='sh000001' order by id desc) i1 inner join (SELECT i.code,i.current,i.time,i.clmn,@rownum2:=@rownum2+1 as rownum FROM (select @rownum2:=0) a,indexrecord i WHERE code='sh000001' order by id desc) i2 on i1.rownum = i2.rownum + 1) sh on sz.time = sh.time where sh.rownum%$n=$n-1 and sh.time > $t ORDER by t desc limit 240) p order by p.t ";

$result = $mysqlt -> query($sql);
$strongs = array();
while ($mr = $result -> fetch_array(MYSQLI_ASSOC)) {
	$mr['time'] = date('d H:i',$mr['t']);
	$strongs[] = $mr;
}
echo json_encode($strongs);
mysqli_free_result($result);

$mysqlt -> close();
?>