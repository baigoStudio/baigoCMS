<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_pub.inc.php"); //载入后台通用
include_once(BG_PATH_CONTROL_PUB . "ctl/index.class.php"); //载入文章类

$ctl_index = new CONTROL_INDEX();

switch ($GLOBALS["act_get"]) {
	default:
		$ctl_index->ctl_index();
	break;
}
