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

require(BG_PATH_FUNC . "init.func.php"); //验证是否已登录
fn_init($arr_set);

$ctrl_group = new CONTROL_CONSOLE_REQUEST_GROUP();

switch ($GLOBALS["method"]) {
    case "POST":
        switch ($GLOBALS["act"]) {
            case "submit":
                $ctrl_group->ctrl_submit();
            break;

            case "enable":
            case "disable":
                $ctrl_group->ctrl_status();
            break;

            case "del":
                $ctrl_group->ctrl_del();
            break;
        }
    break;

    default:
        switch ($GLOBALS["act"]) {
            case "chkname":
                $ctrl_group->ctrl_chkname();
            break;
        }
    break;
}
