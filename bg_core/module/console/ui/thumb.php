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

$ctrl_thumb = new CONTROL_CONSOLE_UI_THUMB(); //初始化设置对象

switch ($GLOBALS["act"]) {
    case "show":
        $ctrl_thumb->ctrl_show();
    break;

    case "form":
        $ctrl_thumb->ctrl_form();
    break;

    default:
        $ctrl_thumb->ctrl_list();
    break;
}
