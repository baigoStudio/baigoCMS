<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_FUNC . "init.func.php");
$arr_set = array(
    "base"      => true,
    "header"    => "Content-Type: text/html; charset=utf-8",
    "db"        => true,
    "type"      => "ctl",
    "pub"       => true,
);
fn_init($arr_set);

include_once(BG_PATH_CONTROL . "pub/ctl/article.class.php"); //载入文章类

$ctl_article = new CONTROL_ARTICLE();

switch ($GLOBALS["act_get"]) {
    default:
        $arr_articleRow = $ctl_article->ctl_show();
        if ($arr_articleRow["alert"] != "y120102") {
            if ($arr_articleRow["alert"] == "x110218" && isset($arr_articleRow["cate_link"]) && !fn_isEmpty($arr_articleRow["cate_link"])) {
                $_str_linkUrl = $arr_articleRow["cate_link"];
            } else {
                if ($arr_articleRow["alert"] == "x120213" && isset($arr_articleRow["article_link"]) && !fn_isEmpty($arr_articleRow["article_link"])) {
                    $_str_linkUrl = $arr_articleRow["article_link"];
                } else {
                    $_str_linkUrl = BG_URL_ROOT . "index.php?mod=alert&act_get=show&alert=" . $arr_articleRow["alert"];
                }
            }
            header("Location: " . $_str_linkUrl);
            exit;
        }
    break;
}
