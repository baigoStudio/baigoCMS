<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_api.inc.php"); //验证是否已登录
include_once(BG_PATH_CONTROL_API . "mark.class.php"); //载入商家控制器

$api_mark = new API_MARK();

switch ($GLOBALS["act_get"]) {
	default:
		$api_mark->api_list();
	break;
}
