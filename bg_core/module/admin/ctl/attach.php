<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_FUNC . "init.func.php");
$arr_set = array(
    "base"          => true,
    "ssin"          => true,
    "header"        => "Content-Type: text/html; charset=utf-8",
    "db"            => true,
    "type"          => "ctl",
    "ssin_begin"    => true,
);
fn_init($arr_set);

include_once(BG_PATH_INC . "is_install.inc.php"); //验证是否已登录
include_once(BG_PATH_INC . "is_admin.inc.php"); //载入后台通用
include_once(BG_PATH_CONTROL . "admin/ctl/attach.class.php"); //载入模板类

$ctl_attach = new CONTROL_ATTACH(); //初始化设置对象

switch ($GLOBALS["act_get"]) {
    case "article":
        $arr_attachRow = $ctl_attach->ctl_article();
        if ($arr_attachRow["alert"] != "y120102") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_attachRow["alert"]);
            exit;
        }
    break;

    case "form":
        $arr_attachRow = $ctl_attach->ctl_form();
        if ($arr_attachRow["alert"] != "y070302") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_attachRow["alert"] . $_url_attach);
            exit;
        }
    break;

    default:
        $arr_attachRow = $ctl_attach->ctl_list();
        if ($arr_attachRow["alert"] != "y070301") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_attachRow["alert"]);
            exit;
        }
    break;
}
