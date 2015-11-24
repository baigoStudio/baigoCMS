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

include_once(BG_PATH_CONTROL . "pub/ctl/cate.class.php"); //载入文章类

$ctl_cate = new CONTROL_CATE();

switch ($GLOBALS["act_get"]) {
	default:
		$arr_cateRow = $ctl_cate->ctl_show();
		if ($arr_cateRow["alert"] != "y110102") {
			if ($arr_cateRow["cate_type"] == "link" && $arr_cateRow["cate_link"]) {
				$_str_linkUrl = $arr_cateRow["cate_link"];
			} else {
				$_str_linkUrl = BG_URL_ROOT . "index.php?mod=alert&act_get=show&alert=" . $arr_cateRow["alert"];
			}
			header("Location: " . $_str_linkUrl);
			exit;
		}
	break;
}
