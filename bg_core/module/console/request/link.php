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

$ctrl_link = new CONTROL_CONSOLE_REQUEST_LINK();

switch ($GLOBALS["method"]) {
    case "POST":
        switch ($GLOBALS["act"]) {
            case "order":
                $ctrl_link->ctrl_order();
            break;

            case "cache":
                $ctrl_link->ctrl_cache();
            break;

            case "submit":
                $ctrl_link->ctrl_submit();
            break;

            case "enable":
            case "disable":
                $ctrl_link->ctrl_status();
            break;

            case "del":
                $ctrl_link->ctrl_del();
            break;
        }
    break;
}
