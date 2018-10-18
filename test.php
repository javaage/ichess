<?php
require 'header.php';
require 'common.php';

function exception_handler( Throwable $e){
    echo 'catch Error:'.$e->getCode().':'.$e->getMessage().'<br/>';
}

set_exception_handler('exception_handler');

error();
