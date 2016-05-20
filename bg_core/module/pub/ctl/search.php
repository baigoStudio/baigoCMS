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

include_once(BG_PATH_CONTROL . "pub/ctl/search.class.php"); //载入文章类

$ctl_search = new CONTROL_SEARCH();

switch ($GLOBALS["act_get"]) {
    /*case "custom":
        $arr_searchRow = $ctl_search->ctl_custom();
    break;*/

    default:
        $arr_searchRow = $ctl_search->ctl_show();
    break;
}
