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
    "base"      => true,
    "header"    => "Content-Type: text/html; charset=utf-8",
    "db"        => true,
    "type"      => "ctl",
    "pub"       => true,
);
fn_init($arr_set);

include_once(BG_PATH_CONTROL . "pub/ctl/spec.class.php"); //载入文章类

$ctl_spec = new CONTROL_SPEC();
switch ($GLOBALS["act_get"]) {
    case "show":
        $arr_specRow = $ctl_spec->ctl_show();
        if ($arr_specRow["alert"] != "y180102") {
            header("Location: " . BG_URL_ROOT . "index.php?mod=alert&act_get=show&alert=" . $arr_specRow["alert"]);
            exit;
        }
    break;

    default:
        $arr_specRow = $ctl_spec->ctl_list();
    break;
}
