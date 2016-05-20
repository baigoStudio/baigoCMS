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
include_once(BG_PATH_CONTROL . "admin/ctl/thumb.class.php"); //载入模板类

$ctl_thumb = new CONTROL_THUMB(); //初始化设置对象

switch ($GLOBALS["act_get"]) {
    case "show":
        $arr_thumbRow = $ctl_thumb->ctl_show();
        if ($arr_thumbRow["alert"] != "y090102") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_thumbRow["alert"]);
            exit;
        }
    break;

    case "form":
        $arr_thumbRow = $ctl_thumb->ctl_form();
        if ($arr_thumbRow["alert"] != "y090102") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_thumbRow["alert"] . $_url_attach);
            exit;
        }
    break;

    default:
        $arr_thumbRow = $ctl_thumb->ctl_list();
        if ($arr_thumbRow["alert"] != "y090301") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_thumbRow["alert"]);
            exit;
        }
    break;
}
