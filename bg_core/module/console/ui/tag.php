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

$ctrl_tag = new CONTROL_CONSOLE_UI_TAG(); //初始化设置对象

switch ($GLOBALS["act"]) {
    case "form":
        $ctrl_tag->ctrl_form();
    break;

    default:
        $ctrl_tag->ctrl_list();
    break;
}
