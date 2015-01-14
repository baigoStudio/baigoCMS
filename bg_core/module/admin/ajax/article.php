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
include_once(BG_PATH_CONTROL_ADMIN . "ajax/article.class.php"); //载入文章类

$ajax_article = new AJAX_ARTICLE();

switch ($GLOBALS["act_post"]) {
	case "submit":
		$ajax_article->ajax_submit();
	break;

	case "top":
	case "untop":
		$ajax_article->ajax_top();

	case "hide":
	case "pub":
	case "wait":
		$ajax_article->ajax_status();

	case "normal":
	case "draft":
	case "recycle":
		$ajax_article->ajax_box();
	break;

	case "empty":
		$ajax_article->ajax_empty();
	break;

	case "del":
		$ajax_article->ajax_del();
	break;
}
?>