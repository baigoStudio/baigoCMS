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
    "is_install"    => true,
);

switch ($GLOBALS["act"]) {
    case "dbtable":
    case "auth":
    case "admin":
    case "base":
    case "sso":
    case "upload":
    case "visit":
    case "ssoAuto":
    case "ssoAdmin":
    case "over":
    case "spec":
        $arr_set["db"] = true;
    break;

    default:
        $arr_set["ssin_file"] = true;
    break;
}
fn_chkPHP($arr_set);

require(BG_PATH_FUNC . "init.func.php"); //验证是否已登录
fn_init($arr_set);

$ctrl_setup = new CONTROL_INSTALL_UI_SETUP(); //初始化商家

switch ($GLOBALS["act"]) {
    case "dbconfig":
        $ctrl_setup->ctrl_dbconfig();
    break;

    case "dbtable":
        $ctrl_setup->ctrl_dbtable();
    break;

    case "auth":
        $ctrl_setup->ctrl_auth();
    break;

    case "admin":
        $ctrl_setup->ctrl_admin();
    break;

    case "ssoAuto":
        $ctrl_setup->ctrl_ssoAuto();
    break;

    case "ssoAdmin":
        $ctrl_setup->ctrl_ssoAdmin();
    break;

    case "base":
    case "sso":
    case "upload":
    case "visit":
    case "spec":
        $ctrl_setup->ctrl_form();
    break;

    case "over":
        $ctrl_setup->ctrl_over();
    break;

    default:
        $ctrl_setup->ctrl_ext();
    break;
}
