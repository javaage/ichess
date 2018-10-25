<?php
$queue = new SaeTaskQueue('inspect');//此处的test队列需要在在线管理平台事先建好
//添加单个任务{
for($i=0;$i<1800;$i++){
	$queue->addTask("http://ichess.sinaapp.com/inspect/inspect.php");
}
//将任务推入队列
$ret = $queue->push();
var_dump($ret);
?>