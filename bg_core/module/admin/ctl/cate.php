<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_admin.inc.php"); //载入全局通用
include_once(BG_PATH_INC . "is_admin.inc.php"); //载入后台通用
include_once(BG_PATH_CONTROL_ADMIN . "ctl/cate.class.php"); //载入设置类

$ctl_cate = new CONTROL_CATE(); //初始化设置对象

switch ($GLOBALS["act_get"]) {
	case "order":
		$arr_cateRow = $ctl_cate->ctl_order();
		if ($arr_cateRow["str_alert"] != "y110102") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=display&alert=" . $arr_cateRow["str_alert"]);
			exit;
		}
	break;

	case "form":
		$arr_cateRow = $ctl_cate->ctl_form();
		if ($arr_cateRow["str_alert"] != "y110102") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=display&alert=" . $arr_cateRow["str_alert"]);
			exit;
		}
	break;

	default:
		$arr_cateRow = $ctl_cate->ctl_list();
		if ($arr_cateRow["str_alert"] != "y110301") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=display&alert=" . $arr_cateRow["str_alert"]);
			exit;
		}
	break;
}
