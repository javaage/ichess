<?php
require '../header.php';
require '../common.php';

$sql = "select 'ascend', avg(d.rate) from (select code,current/open as rate from daily where date=(select max(date) from daily)) d inner join weak w on d.code=w.code union (select 'holder', avg(d.rate) from (select code,current/open as rate from daily where date=(select max(date) from daily)) d inner join holder w on d.code=w.code) union (select 'attend', avg(d.rate) from (select code,current/open as rate from daily where date=(select max(date) from daily)) d inner join attend w on d.code=w.code) union (select 'all', avg(d.rate) from (select code,current/open as rate from daily where date=(select max(date) from daily)) d)";

echo $sql . "</br>";

$result = $mysql->query ( $sql );

$data = array();

while ($result && $mr = $result -> fetch_array(MYSQLI_ASSOC)) {
	$data[] =  $mr;
}
print_r(count($data));
print_r($data);

mysqli_free_result ( $result );
$mysql->close ();
?>