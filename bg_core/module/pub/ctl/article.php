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
include_once(BG_PATH_CONTROL_PUB . "ctl/article.class.php"); //载入文章类

$ctl_article = new CONTROL_ARTICLE();

switch ($act_get) {
	default:
		$arr_articleRow = $ctl_article->ctl_show();
		if ($arr_articleRow["str_alert"] != "y120102") {
			if ($arr_articleRow["cate_link"]) {
				$_str_linkUrl = $arr_articleRow["cate_link"];
			} else {
				if ($arr_articleRow["article_link"]) {
					$_str_linkUrl = $arr_articleRow["article_link"];
				} else {
					$_str_linkUrl = BG_URL_ROOT . "index.php?mod=alert&act_get=display&alert=" . $arr_articleRow["str_alert"];
				}
			}
			header("Location: " . $_str_linkUrl);
			exit;
		}
	break;
}
?>