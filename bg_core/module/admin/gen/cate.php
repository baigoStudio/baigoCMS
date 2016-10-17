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

include_once(BG_PATH_CONTROL . "admin/gen/cate.class.php"); //载入登录控制器

$gen_cate = new GEN_CATE();

switch ($GLOBALS["act_get"]) {
    case "1by1":
        $arr_cateRow = $gen_cate->gen_1by1();
        if ($arr_cateRow["alert"] != "y110402") {
            header("Location: " . BG_URL_ADMIN . "gen.php?mod=alert&act_get=show&alert=" . $arr_cateRow["alert"]);
            exit;
        }
    break;

    case "single":
        $arr_cateRow = $gen_cate->gen_single();
        if ($arr_cateRow["alert"] != "y110402") {
            header("Location: " . BG_URL_ADMIN . "gen.php?mod=alert&act_get=show&alert=" . $arr_cateRow["alert"]);
            exit;
        }
    break;
}
