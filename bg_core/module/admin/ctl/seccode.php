<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_FUNC . "init.func.php");
$arr_set = array(
    "ssin"          => true,
    "header"        => "Content-Type: image/png",
    "db"            => true,
    "type"          => "ajax",
);
fn_init($arr_set);

include_once(BG_PATH_CONTROL . "admin/ctl/seccode.class.php"); //载入登录控制器

$ctl_seccode = new CONTROL_SECCODE();

switch ($GLOBALS["act_get"]) {
    case "make":
        $ctl_seccode->ctl_make();
    break;
}
