<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

require(BG_PATH_INC . "common.inc.php");
$arr_set = array(
    "base"          => true,
    "ssin"          => true,
    "db"            => true,
);
fn_chkPHP($arr_set);

require(BG_PATH_FUNC . "init.func.php"); //验证是否已登录
fn_init($arr_set);

$ctrl_admin = new CONTROL_CONSOLE_UI_ADMIN();

switch ($GLOBALS["act"]) {
    case "toGroup":
        $ctrl_admin->ctrl_toGroup();
    break;

    case "form":
        $ctrl_admin->ctrl_form();
    break;

    case "show":
        $ctrl_admin->ctrl_show();
    break;

    case "auth":
        $ctrl_admin->ctrl_auth();
    break;

    default:
        $ctrl_admin->ctrl_list();
    break;
}
