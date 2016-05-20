<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
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

include_once(BG_PATH_CONTROL . "pub/ctl/tag.class.php"); //载入文章类

$ctl_tag = new CONTROL_TAG();

switch ($GLOBALS["act_get"]) {
    default:
        $arr_tagRow = $ctl_tag->ctl_show();
        if ($arr_tagRow["alert"] != "y130102") {
            header("Location: " . BG_URL_ROOT . "index.php?mod=alert&act_get=show&alert=" . $arr_tagRow["alert"]);
            exit;
        }
    break;
}
