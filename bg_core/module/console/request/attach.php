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

$ctrl_attach = new CONTROL_CONSOLE_REQUEST_ATTACH();

switch ($GLOBALS["method"]) {
    case "POST":
        switch ($GLOBALS["act"]) {
            case "normal":
            case "recycle":
                $ctrl_attach->ctrl_box();
            break;

            case "gen":
                $ctrl_attach->ctrl_gen();
            break;

            case "empty":
                $ctrl_attach->ctrl_empty();
            break;

            case "clear":
                $ctrl_attach->ctrl_clear();
            break;

            case "submit":
                $ctrl_attach->ctrl_submit();
            break;

            case "del":
                $ctrl_attach->ctrl_del();
            break;
        }
    break;

    default:
        switch ($GLOBALS["act"]) {
            case "article":
                $ctrl_attach->ctrl_article();
            break;

            case "list":
                $ctrl_attach->ctrl_list();
            break;
        }
    break;
}