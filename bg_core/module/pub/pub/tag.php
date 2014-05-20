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
include_once(BG_PATH_CONTROL_PUB . "pub/tag.class.php"); //载入文章类

$ctl_tag = new CONTROL_TAG();

switch ($act_get) {
	case "show":
		$arr_tagRow = $ctl_tag->ctl_show();
		if ($arr_tagRow["str_alert"] != "y130102") {
			header("Location: " . BG_URL_PUB . "index.php?mod=alert&act_get=display&alert=" . $arr_tagRow["str_alert"]);
			exit;
		}
	break;

	default:
		$arr_tagRow = $ctl_tag->ctl_list();
	break;
}
?>