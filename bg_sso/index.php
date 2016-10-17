<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/
$base = dirname(__FILE__) . "/";

include_once($base . "config/init.class.php");

$obj_init = new CLASS_INIT();

$obj_init->config_gen();
