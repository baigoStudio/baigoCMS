<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_FUNC . "init.func.php"); //验证是否已登录
$arr_set = array(
    "base"          => true,
    "ssin"          => true,
    "header"        => "Content-type: application/json; charset=utf-8",
    "db"            => true,
    "type"          => "ajax",
    "ssin_begin"    => true,
);
fn_init($arr_set);

include_once(BG_PATH_CONTROL . "admin/ajax/article.class.php"); //载入文章类

$ajax_article = new AJAX_ARTICLE();

switch ($GLOBALS["act_post"]) {
    case "submit":
        $ajax_article->ajax_submit();
    break;

    case "primary":
        $ajax_article->ajax_primary();
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
