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
    "base"          => true,
    "header"        => "Content-type: application/json; charset=utf-8",
    "db"            => true,
    "type"          => "ajax",
);
fn_init($arr_set);

include_once(BG_PATH_CONTROL . "api/api/call.class.php"); //载入商家控制器

$api_call = new API_CALL();

switch ($GLOBALS["act_get"]) {
    default:
        $api_call->api_read();
    break;
}
