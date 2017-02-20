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

$ctrl_spec = new CONTROL_CONSOLE_REQUEST_SPEC();

switch ($GLOBALS["method"]) {
    case "POST":
        switch ($GLOBALS["act"]) {
            case "show":
            case "hide":
                $ctrl_spec->ctrl_status();
            break;

            case "submit":
                $ctrl_spec->ctrl_submit();
            break;

            case "del":
                $ctrl_spec->ctrl_del();
            break;

            case "belongDel":
                $ctrl_spec->ctrl_belongDel();
            break;

            case "belongAdd":
                $ctrl_spec->ctrl_belongAdd();
            break;
        }
    break;

    default:
        switch ($GLOBALS["act"]) {
            case "list":
                $ctrl_spec->ctrl_list();
            break;
        }
    break;
}
