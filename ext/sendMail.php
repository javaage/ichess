<?php
require '../header.php';
require '../common.php';

if($_REQUEST["title"])
	$title = $_REQUEST["title"];
else 
	$title = 'mail';

if($_REQUEST["content"])
	$content = $_REQUEST["content"];
else
	$content = 'content';

sendMail($title,$content);