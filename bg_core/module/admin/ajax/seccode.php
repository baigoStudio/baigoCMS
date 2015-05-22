<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

if (isset($_GET["ssid"])) {
	session_id($_GET["ssid"]); //将当前的SessionId设置成客户端传递回来的SessionId
}

session_start(); //开启session
$GLOBALS["ssid"] = session_id();

header("Content-type: application/json");
include_once(BG_PATH_INC . "common_global.inc.php"); //载入通用
include_once(BG_PATH_CONTROL_ADMIN . "ajax/seccode.class.php"); //载入登录控制器

$ajax_seccode           = new AJAX_SECCODE();

switch ($GLOBALS["act_get"]) {
	case "chk":
		$ajax_seccode->ajax_check();
	break;
}
