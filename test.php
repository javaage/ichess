<?php
require 'header.php';
require 'common.php';

function exception_handler( Throwable $e){
    echo 'catch Error:'.$e->getCode().':'.$e->getMessage().'<br/>';
    error_log("Oracle database not available!", 0);
}

set_exception_handler('exception_handler');

error();
