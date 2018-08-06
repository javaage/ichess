<?php
require '../header.php';
require '../common.php';


$sql = "SELECT d.code,d.a,d.b,d.r,100 * (l.current-l.close)/l.close as rate,l.current/l.avg as gate FROM daily_rate d inner join (select code,name,close,current,avg from stockrecord where time=(select max(time) from stockrecord) and current>avg) l on d.code=l.code WHERE a>0 and a<100 and r>0.7 and r < 0.99 and date = (select max(date) from daily_rate) ORDER by r DESC";

$result = $mysql -> query($sql);
$codes = array();
while ($mr = $result -> fetch_array(MYSQLI_ASSOC)) {
	array_push($codes, $mr);
}
echo json_encode($codes, JSON_UNESCAPED_UNICODE);
mysqli_free_result($result);

$mysql -> close();
?>