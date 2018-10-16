<?php
require 'header.php';
require 'common.php';

$days = $_REQUEST['days'];

if(empty($days))
	$days = 60;

$days -= 1;

$label = $days . date('Y-m-d');

$ct60 = date("Y-m-d",strtotime("-60 day")); 
$ct120 = date("Y-m-d",strtotime("-120 day"));
$ct240 = date("Y-m-d",strtotime("-240 day"));

	
	$sqlDate = "select min(d.date) as mindate,max(d.date) as maxdate from (select distinct date from daily order by date desc limit $days) d";	
	$result = $mysql -> query($sqlDate);

	if ($result && $mr = $result -> fetch_array(MYSQLI_ASSOC)) {
		$mindate = $mr['mindate'];
		$maxdate = $mr['maxdate'];
		
		$sqlFilter = "select code from daily where date='$mindate' and locate(code,'$candidate')>0 ";

		$result = $mysql -> query($sqlFilter);
		$cands = array();
		while($result && $mr = $result -> fetch_array(MYSQLI_ASSOC)) {
			$cands[] = $mr['code'];
		}

		$candidate = join(",",$cands);


		$sqlavg = "select lcase(code) as code from holder union select lcase(code) as code from attend union select lcase(code) as code from weak union select lcase(code) as code from inspect union select t.code as code from (select av.code from (select d.code,avg(d.current) as current from (select code,current from daily where date >= '$mindate') d group by code) av inner join (select code,current from daily where date = '$maxdate') t on av.code=t.code inner join ( select n.code,min(n.current) as current from (select code,current from daily where date > '$ct240') n group by n.code ) nn on av.code = nn.code where t.current/av.current > 1.03 and locate(t.code,'$candidate')>0 order by t.current/nn.current limit 200) t "; //near 60's avg

		$r = $mysql -> query($sqlavg);

		$tings = array();
		while ($result && $m = $r -> fetch_array(MYSQLI_ASSOC)) {
			array_push($tings,$m['code']);
		}
		
		$sql = "select z.code,count(z.code) as count from (select b.code from 
		(SELECT code,current,date,@rownum1:=@rownum1+1 as rownum FROM (select @rownum1:=0) a, daily where date > '$ct120' ORDER by code,date DESC ) b
		INNER JOIN (SELECT code,current,date,@rownum2:=@rownum2+1 as rownum FROM (select @rownum2:=0) a, daily where date > '$ct120' ORDER by code,date DESC) t
		on b.rownum-1=t.rownum and b.code=t.code where t.current/b.current > 1.095) z group by z.code"; //120 days agressive

		$result = $mysql -> query($sql);
		$list = array();
		$codes = array();
		while ($result && $mr = $result -> fetch_array(MYSQLI_ASSOC)) {
			$codes[] = "'" . $mr['code'] . "'";
		}

		$codes120 = join(",",$codes);

		$sql120 = "select c.code,c.current/a.current from (SELECT d.code,d.date,d.current FROM daily d inner join (select code,max(date) as date from daily group by code) m on d.code = m.code and d.date = m.date where d.code in ($codes120) and d.date='$maxdate' and locate(d.code,'$candidate')>0) c inner join (select code,avg(current) as current from daily where date > '$ct60' group by code) a on c.code=a.code and c.current > a.current inner join ( select n.code,min(n.current) as current from (select code,current from daily where date > '$ct240') n group by n.code ) nn on c.code = nn.code order by c.current/nn.current limit 300"; //agressive but not high

		$result = $mysql -> query($sql120);

		while ($row = $result -> fetch_row()) {
			if(!in_array($row[0], $tings)){
				array_push($tings,$row[0]);
			}
		}


		$preflist = join(",", $tings);
		$sqlInsert = "INSERT INTO candidate(preflist, time) values('$preflist',now())";
		echo $sqlInsert;

		//$mysql -> query($sqlInsert);
		
		$queue = new SaeTaskQueue('daily');

		//添加单个任务{
		for($i=0;$i<10;$i++){
			$queue->addTask("http://ichess.sinaapp.com/stockWave.php");
		}
		//将任务推入队列
		$ret = $queue->push();
		var_dump($ret);

	}

$mysql -> close();
?>