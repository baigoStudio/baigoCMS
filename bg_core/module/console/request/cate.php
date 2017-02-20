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

$ctrl_cate = new CONTROL_CONSOLE_REQUEST_CATE();

switch ($GLOBALS["method"]) {
    case "POST":
        switch ($GLOBALS["act"]) {
            case "order":
                $ctrl_cate->ctrl_order();
            break;

            case "submit":
                $ctrl_cate->ctrl_submit();
            break;

            case "cache":
                $ctrl_cate->ctrl_cache();
            break;

            case "del":
                $ctrl_cate->ctrl_del();
            break;

            case "hide":
            case "show":
                $ctrl_cate->ctrl_status();
            break;
        }
    break;

    default:
        switch ($GLOBALS["act"]) {
            case "chkname":
                $ctrl_cate->ctrl_chkname();
            break;
            case "chkalias":
                $ctrl_cate->ctrl_chkalias();
            break;
        }
    break;
}
