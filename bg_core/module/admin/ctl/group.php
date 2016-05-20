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
include_once(BG_PATH_CONTROL . "admin/ctl/group.class.php"); //载入模板类

$ctl_group = new CONTROL_GROUP();

switch ($GLOBALS["act_get"]) {
    case "show":
        $arr_groupRow = $ctl_group->ctl_show();
        if ($arr_groupRow["alert"] != "y040102") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_groupRow["alert"]);
            exit;
        }
    break;

    case "form":
        $arr_groupRow = $ctl_group->ctl_form();
        if ($arr_groupRow["alert"] != "y040102") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_groupRow["alert"]);
            exit;
        }
    break;

    default:
        $arr_groupRow = $ctl_group->ctl_list();
        if ($arr_groupRow["alert"] != "y040301") {
            header("Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $arr_groupRow["alert"]);
            exit;
        }
    break;
}
