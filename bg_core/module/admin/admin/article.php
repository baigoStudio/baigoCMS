<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_admin.inc.php"); //载入后台通用
include_once(BG_PATH_INC . "is_admin.inc.php"); //载入后台通用
include_once(BG_PATH_CONTROL_ADMIN . "admin/article.class.php"); //载入文章类

$ctl_article = new CONTROL_ARTICLE();

switch ($act_get) {
	case "show":
		$arr_articleRow = $ctl_article->ctl_show();
		if ($arr_articleRow["str_alert"] != "y120102") {
			header("Location: " . BG_URL_ADMIN . "admin.php?mod=alert&act_get=display&alert=" . $arr_articleRow["str_alert"]);
			exit;
		}
	break;

	case "form":
		$arr_articleRow = $ctl_article->ctl_form();
		if ($arr_articleRow["str_alert"] != "y120102") {
			header("Location: " . BG_URL_ADMIN . "admin.php?mod=alert&act_get=display&alert=" . $arr_articleRow["str_alert"]);
			exit;
		}
	break;

	default:
		$arr_articleRow = $ctl_article->ctl_list();
		if ($arr_articleRow["str_alert"] != "y120301") {
			header("Location: " . BG_URL_ADMIN . "admin.php?mod=alert&act_get=display&alert=" . $arr_articleRow["str_alert"]);
			exit;
		}
	break;
}
?>