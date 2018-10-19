<?php
require 'header.php';
require 'common.php';

// $title = "title";
// $content = "content";

// sendMail($title, $content);

$sendMail = "https://dm.aliyuncs.com/?Action=SingleSendMail&AccountName=hb_java@sina.com&ReplyToAddress=true&AddressType=1&ToAddress=11228856@qq.com&Subject=Subject&HtmlBody=body";

$html = file_get_contents($sendMail);

echo $html;
