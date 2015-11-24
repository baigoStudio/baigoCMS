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
fn_include(true, true, "Content-Type: text/html; charset=utf-8", true, "ctl", true);

include_once(BG_PATH_INC . "is_install.inc.php"); //验证是否已登录
include_once(BG_PATH_INC . "is_admin.inc.php"); //载入后台通用
include_once(BG_PATH_CONTROL . "admin/ctl/spec.class.php"); //载入模板类

$ctl_spec = new CONTROL_SPEC(); //初始化设置对象

switch ($GLOBALS["act_get"]) {
	case "select":
		$arr_specRow = $ctl_spec->ctl_select();
		if ($arr_specRow["alert"] != "y180102") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_specRow["alert"]);
			exit;
		}
	break;

	case "form":
		$arr_specRow = $ctl_spec->ctl_form();
		if ($arr_specRow["alert"] != "y180102") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_specRow["alert"]);
			exit;
		}
	break;

	default:
		$arr_specRow = $ctl_spec->ctl_list();
		if ($arr_specRow["alert"] != "y180301") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_specRow["alert"]);
			exit;
		}
	break;
}
