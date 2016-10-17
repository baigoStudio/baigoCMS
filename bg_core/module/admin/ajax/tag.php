<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
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

include_once(BG_PATH_CONTROL . "admin/ajax/tag.class.php"); //载入登录控制器

$ajax_tag = new AJAX_TAG();

switch ($GLOBALS["act_post"]) {
    case "submit":
        $ajax_tag->ajax_submit();
    break;

    case "show":
    case "hide":
        $ajax_tag->ajax_status();
    break;

    case "del":
        $ajax_tag->ajax_del();
    break;

    default:
        switch ($GLOBALS["act_get"]) {
            case "chkname":
                $ajax_tag->ajax_chkname();
            break;

            case "list":
                $ajax_tag->ajax_list();
            break;
        }
    break;
}
