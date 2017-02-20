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
    "dsp_type"      => "result",
);

switch ($GLOBALS["act"]) {
    case "dbconfig":
        $arr_set["ssin_file"] = true; //可能 session 数据表表尚未创建，故临时采用文件形式的 session
    break;

    default:
        $arr_set["db"] = true;
    break;
}
fn_chkPHP($arr_set);

require(BG_PATH_FUNC . "init.func.php"); //验证是否已登录
fn_init($arr_set);

$ctrl_setup = new CONTROL_INSTALL_REQUEST_SETUP(); //初始化商家

switch ($GLOBALS["method"]) {
    case "POST":
        switch ($GLOBALS["act"]) {
            case "dbconfig":
                $ctrl_setup->ctrl_dbconfig();
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

            case "over":
                $ctrl_setup->ctrl_over();
            break;

            case "sso":
            case "upload":
            case "visit":
            case "base":
                $ctrl_setup->ctrl_submit();
            break;
        }
    break;

    default:
        switch ($GLOBALS["act"]) {
            case "chkname":
                $ctrl_setup->ctrl_chkname();
            break;

            case "chkauth":
                $ctrl_setup->ctrl_chkauth();
            break;
        }
    break;
}
