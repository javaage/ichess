<?php
require 'header.php';
require 'common.php';

$codes = array();
$codes['spring'] = 1;
$codes['amber'] = 2;
$str = json_encode($codes);
$cs = json_decode($str,true);
// echo $cs;
echo $cs['spring'];