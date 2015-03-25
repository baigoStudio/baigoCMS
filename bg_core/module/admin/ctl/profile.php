<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_admin_ctl.inc.php"); //载入全局通用
include_once(BG_PATH_INC . "is_install.inc.php"); //验证是否已登录
include_once(BG_PATH_INC . "is_admin.inc.php"); //载入后台通用
include_once(BG_PATH_CONTROL_ADMIN . "ctl/profile.class.php"); //载入用户类

$ctl_profile = new CONTROL_PROFILE();

switch ($GLOBALS["act_get"]) {
	case "pass":
		$arr_profileRow = $ctl_profile->ctl_pass();
		if ($arr_profileRow["str_alert"] != "y020109") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=display&alert=" . $arr_profileRow["str_alert"]);
			exit;
		}
	break;

	default:
		$arr_profileRow = $ctl_profile->ctl_info();
		if ($arr_profileRow["str_alert"] != "y020108") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=display&alert=" . $arr_profileRow["str_alert"]);
			exit;
		}
	break;
}
