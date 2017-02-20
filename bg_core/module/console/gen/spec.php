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
    "pub"           => true,
);
fn_chkPHP($arr_set);

require(BG_PATH_FUNC . "init.func.php"); //验证是否已登录
fn_init($arr_set);

$ctrl_spec = new CONTROL_CONSOLE_GEN_SPEC();

switch ($GLOBALS["act"]) {
    case "list":
        $ctrl_spec->ctrl_list();
    break;

    case "1by1":
        $ctrl_spec->ctrl_1by1();
    break;

    case "single":
        $ctrl_spec->ctrl_single();
    break;
}
