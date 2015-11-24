<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "include.func.php");
fn_include(true, false, "Content-Type: text/html; charset=utf-8", true, "ctl", false, true);

include_once(BG_PATH_CONTROL . "pub/ctl/alert.class.php"); //载入模板类

$ctl_alert = new CONTROL_ALERT(); //设置模板对象

switch ($GLOBALS["act_get"]) {
	case "show":
		$ctl_alert->ctl_show();
	break;
}
