<?php
require '../header.php';
require '../common.php';

$sql = "select l.code from (select code,clmn from daily where date=(select max(date) from daily) and locate(code,'$candidate')>0 ) l inner join (select a.code,avg(clmn) as clmn from (SELECT code,clmn FROM daily where clmn>0) a group by code) avg on l.code=avg.code order by l.clmn/avg.clmn limit 300";

$result = $mysql -> query($sql);

$codes = array();

while ($mr = $result -> fetch_array(MYSQLI_ASSOC)) {
	$codes[] = substr($mr['code'],2);
}

echo join(",",$codes);

mysqli_free_result($result);

$mysql -> close();
?>