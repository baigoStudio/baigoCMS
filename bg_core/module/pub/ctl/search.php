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
include_once(BG_PATH_CONTROL_PUB . "ctl/search.class.php"); //载入文章类

$ctl_search = new CONTROL_SEARCH();

switch ($GLOBALS["act_get"]) {
	default:
		$arr_searchRow = $ctl_search->ctl_show();
	break;
}
?>