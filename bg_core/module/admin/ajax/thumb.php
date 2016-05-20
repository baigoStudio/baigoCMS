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

include_once(BG_PATH_CONTROL . "admin/ajax/thumb.class.php"); //载入登录控制器

$ajax_thumb = new AJAX_THUMB();

switch ($GLOBALS["act_post"]) {
    case "submit":
        $ajax_thumb->ajax_submit();
    break;

    case "cache":
        $ajax_thumb->ajax_cache();
    break;

    case "del":
        $ajax_thumb->ajax_del();
    break;

    default:
        switch ($GLOBALS["act_get"]) {
            case "chk":
                $ajax_thumb->ajax_chk();
            break;
        }
    break;
}
