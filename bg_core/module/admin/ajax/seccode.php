<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "include.func.php"); //验证是否已登录
fn_include(true, true, "Content-type: application/json; charset=utf-8");

include_once(BG_PATH_CONTROL . "admin/ajax/seccode.class.php"); //载入登录控制器

$ajax_seccode           = new AJAX_SECCODE();

switch ($GLOBALS["act_get"]) {
	case "chk":
		$ajax_seccode->ajax_check();
	break;
}
