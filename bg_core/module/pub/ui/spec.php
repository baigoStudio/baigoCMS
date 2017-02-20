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
require(BG_PATH_FUNC . "init.func.php");
$arr_set = array(
    "base"      => true,
    "db"        => true,
    "pub"       => true,
);
fn_init($arr_set);

$ctrl_spec = new CONTROL_PUB_UI_SPEC();

switch ($GLOBALS["act"]) {
    case "show":
        $ctrl_spec->ctrl_show();
    break;

    default:
        $ctrl_spec->ctrl_list();
    break;
}
