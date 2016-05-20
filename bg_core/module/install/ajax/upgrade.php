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
switch ($GLOBALS["act_post"]) {
    case "dbconfig":
        $arr_set = array(
            "base"      => true,
            "ssin"      => true,
            "header"    => "Content-type: application/json; charset=utf-8",
            "ssin_file" => true,
        );
    break;

    default:
        $arr_set = array(
            "base"      => true,
            "ssin"      => true,
            "header"    => "Content-type: application/json; charset=utf-8",
            "db"        => true,
            "type"      => "ajax",
        );
    break;
}
fn_init($arr_set);

include_once(BG_PATH_CLASS . "mysqli.class.php"); //载入数据库类
include_once(BG_PATH_CONTROL . "install/ajax/upgrade.class.php"); //载入栏目控制器

$ajax_upgrade           = new AJAX_UPGRADE(); //初始化商家

switch ($GLOBALS["act_post"]) {
    case "dbconfig":
        $ajax_upgrade->ajax_dbconfig();
    break;

    case "over":
        $ajax_upgrade->ajax_over();
    break;

    case "sso":
    case "upload":
    case "visit":
    case "base":
        $ajax_upgrade->ajax_submit();
    break;
}
