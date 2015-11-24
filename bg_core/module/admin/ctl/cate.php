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
include_once(BG_PATH_CONTROL . "admin/ctl/cate.class.php"); //载入设置类

$ctl_cate = new CONTROL_CATE(); //初始化设置对象

switch ($GLOBALS["act_get"]) {
	case "order":
		$arr_cateRow = $ctl_cate->ctl_order();
		if ($arr_cateRow["alert"] != "y110102") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_cateRow["alert"] . $_url_attach);
			exit;
		}
	break;

	case "form":
		$arr_cateRow = $ctl_cate->ctl_form();
		if ($arr_cateRow["alert"] != "y110102") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_cateRow["alert"]);
			exit;
		}
	break;

	default:
		$arr_cateRow = $ctl_cate->ctl_list();
		if ($arr_cateRow["alert"] != "y110301") {
			header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_cateRow["alert"]);
			exit;
		}
	break;
}
