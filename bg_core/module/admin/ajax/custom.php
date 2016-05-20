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

include_once(BG_PATH_CONTROL . "admin/ajax/custom.class.php"); //载入登录控制器

$ajax_custom = new AJAX_CUSTOM();

switch ($GLOBALS["act_post"]) {
    case "order":
        $ajax_custom->ajax_order();
    break;

    case "submit":
        $ajax_custom->ajax_submit();
    break;

    case "cache":
        $ajax_custom->ajax_cache();
    break;

    case "del":
        $ajax_custom->ajax_del();
    break;

    case "enable":
    case "disable":
        $ajax_custom->ajax_status();
    break;

    default:
        switch ($GLOBALS["act_get"]) {
            case "chkname":
                $ajax_custom->ajax_chkname();
            break;
        }
    break;
}
