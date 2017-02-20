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

$ctrl_profile = new CONTROL_CONSOLE_REQUEST_PROFILE();

switch ($GLOBALS["method"]) {
    case "POST":
        switch ($GLOBALS["act"]) {
            case "mailbox":
                $ctrl_profile->ctrl_mailbox();
            break;

            case "qa":
                $ctrl_profile->ctrl_qa();
            break;

            case "pass":
                $ctrl_profile->ctrl_pass();
            break;

            case "info":
                $ctrl_profile->ctrl_info();
            break;

            case "prefer":
                $ctrl_profile->ctrl_prefer();
            break;
        }
    break;
}
