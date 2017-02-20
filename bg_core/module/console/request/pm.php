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

require(BG_PATH_FUNC . "init.func.php");
fn_init($arr_set);

$ctrl_pm = new CONTROL_CONSOLE_REQUEST_PM();

switch ($GLOBALS["method"]) {
    case "POST":
        switch ($GLOBALS["act"]) {
            case "revoke":
                $ctrl_pm->ctrl_revoke();
            break;

            case "send":
                $ctrl_pm->ctrl_send();
            break;

            case "read":
            case "wait":
                $ctrl_pm->ctrl_status();
            break;

            case "del":
                $ctrl_pm->ctrl_del();
            break;
        }
    break;
}
