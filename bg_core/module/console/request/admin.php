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
    "dsp_type"      => "result",
);
fn_chkPHP($arr_set);

require(BG_PATH_FUNC . "init.func.php");
fn_init($arr_set);

$ctrl_admin = new CONTROL_CONSOLE_REQUEST_ADMIN();

switch ($GLOBALS["method"]) {
    case "POST":
        switch ($GLOBALS["act"]) {
            case "toGroup":
                $ctrl_admin->ctrl_toGroup();
            break;

            case "submit":
                $ctrl_admin->ctrl_submit();
            break;

            case "auth":
                $ctrl_admin->ctrl_auth();
            break;

            case "enable":
            case "disable":
                $ctrl_admin->ctrl_status();
            break;

            case "del":
                $ctrl_admin->ctrl_del();
            break;
        }
    break;

    default:
        switch ($GLOBALS["act"]) {
            case "chkname":
                $ctrl_admin->ctrl_chkname();
            break;

            case "chkauth":
                $ctrl_admin->ctrl_chkauth();
            break;

            case "chkmail":
                $ctrl_admin->ctrl_chkmail();
            break;
        }
    break;
}