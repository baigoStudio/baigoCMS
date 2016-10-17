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

include_once(BG_PATH_CONTROL . "admin/ajax/spec.class.php"); //载入登录控制器

$ajax_spec = new AJAX_SPEC();

switch ($GLOBALS["act_post"]) {
    case "show":
    case "hide":
        $ajax_spec->ajax_status();
    break;

    case "submit":
        $ajax_spec->ajax_submit();
    break;

    case "del":
        $ajax_spec->ajax_del();
    break;

    case "belongDel":
        $ajax_spec->ajax_belongDel();
    break;

    case "belongAdd":
        $ajax_spec->ajax_belongAdd();
    break;

    default:
        switch ($GLOBALS["act_get"]) {
            case "list":
                $ajax_spec->ajax_list();
            break;
        }
    break;
}
