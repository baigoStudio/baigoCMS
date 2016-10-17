<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_FUNC . "init.func.php"); //验证是否已登录
$arr_set = array(
    "base"          => true,
    "ssin"          => true,
    "header"        => "Content-Type: text/html; charset=utf-8",
    "db"            => true,
    "type"          => "ctl",
    "ssin_begin"    => true,
    "pub"           => true,
);
fn_init($arr_set);

include_once(BG_PATH_CONTROL . "admin/gen/call.class.php"); //载入登录控制器

$gen_call = new GEN_CALL();

switch ($GLOBALS["act_get"]) {
    case "1by1":
        $arr_callRow = $gen_call->gen_1by1();
        if ($arr_callRow["alert"] != "y170402") {
            header("Location: " . BG_URL_ADMIN . "gen.php?mod=alert&act_get=show&alert=" . $arr_callRow["alert"]);
            exit;
        }
    break;

    case "single":
        $arr_callRow = $gen_call->gen_single();
        if ($arr_callRow["alert"] != "y170402") {
            header("Location: " . BG_URL_ADMIN . "gen.php?mod=alert&act_get=show&alert=" . $arr_callRow["alert"]);
            exit;
        }
    break;
}
