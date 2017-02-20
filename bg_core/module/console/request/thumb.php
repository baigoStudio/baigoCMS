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

$ctrl_thumb = new CONTROL_CONSOLE_REQUEST_THUMB();

switch ($GLOBALS["method"]) {
    case "POST":
        switch ($GLOBALS["act"]) {
            case "submit":
                $ctrl_thumb->ctrl_submit();
            break;

            case "cache":
                $ctrl_thumb->ctrl_cache();
            break;

            case "del":
                $ctrl_thumb->ctrl_del();
            break;
        }
    break;
}
