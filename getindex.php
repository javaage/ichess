<?php
require 'header.php';
$lt = $_REQUEST['lt'];
$codes = $_REQUEST['codes'];
if(empty($codes)){
	$codes = "sz002594";
}

$lstCode = explode(",",$codes);

$lstTrans = array();

for($i=0;$i<count($lstCode);$i++){
	$lstTrans[$i] = "'" . $lstCode[$i] . "'";
}

$codes = join(",",$lstTrans);

$lst = array();

foreach ($lstCode as $code) {
	$lst[$code] = array();
}
$lst['sh000001'] = array();

if(empty($lt)){
	$lt = 1000 * strtotime("-24 hour");
}

$strQuery = "SELECT code,time*1000 as time,name,current,clmn,avg from stockrecord where code in ($codes) and time in (select distinct(time) from stockrecord where time + 31 * 60 * 60 > (select max(time) from stockrecord) and time in (select distinct(time) from indexrecord))   union SELECT code,time*1000 as time,name,current,clmn,avg from indexrecord where code = 'sh000001' and time in (select distinct(time) from stockrecord where time + 31 * 60 * 60 > (select max(time) from stockrecord) and time in (select distinct(time) from indexrecord)) order by time";

$result = $mysql->query($strQuery);

while($mr = $result->fetch_array(MYSQLI_ASSOC)){

	$lst[$mr['code']][] = [(int)$mr['time'],(float)$mr['current']];
	if($mr['code']!='sh000001'){
		$lst['avg'][] = [(int)$mr['time'],(float)$mr['avg']];
		$name = $mr['name'];
	}
}

$result = array();
foreach ($lstCode as $code){
	if(count($lst[$code])>0){
		$obj = new StdClass();
		$obj->name = $code;
		$obj->yAxis = 0;
		$obj->data = $lst[$code];
		$result[] = $obj;

		$obj1 = new StdClass();
		$obj1->name = $name;
		$obj1->yAxis = 0;
		$obj1->data = $lst['avg'];
		$result[] = $obj1;


		$first = $lst["sh000001"][0][1];
		for($k=0; $k<count($lst["sh000001"]); $k++){
			//$lst["sh000001"][$k][1] = $lst["sh000001"][$k][1];
			if($lst[$code][$k][1])
				$lst["sh000001"][$k][1] = $lst[$code][0][1] + $lst[$code][$k][1] - $lst[$code][0][1] * (($lst["sh000001"][$k][1]/$first-1)*5+1);
			else
				$lst["sh000001"][$k][1] = $lst[count($lst[$code])-1][0][1];
			// if($lst["sh000001"][$k][1] < 1){
			// 	echo $k . "<br>";
			// 	echo $lst[$code][0][1] . "<br>";
			// 	echo count($lst[$code]) . "<br>";
			// 	echo $lst[$code][$k][1] . "<br>";
			// 	echo $lst[$code][0][1] . "<br>";
			// 	echo $lst["sh000001"][$k][1] . "<br>";
			// 	echo (($lst["sh000001"][$k][1]/$first-1)*5+1) . "<br>";
			// 	exit();
			// }
		}

		$obj = new StdClass();
		$obj->name = $code . " polular";
		$obj->yAxis = 1;
		$obj->data = $lst["sh000001"];
		$result[] = $obj;
	}
}


echo json_encode($result);

if( $mysql->error != 0 )
{
	die( "Error:" . $mysql->errmsg() );
}
$mysql->close();
?>