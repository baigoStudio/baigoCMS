<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/


//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

if ($GLOBALS["adminLogged"]["alert"] != "y020102") {
    if ($GLOBALS["view"] == "iframe") {
        $_str_location = "Location: " . BG_URL_ADMIN . "ctl.php?mod=alert&act_get=show&alert=" . $GLOBALS["adminLogged"]["alert"];
    } else {
        if (!fn_isEmpty(fn_server("REQUEST_URI"))) {
            $_str_forwart = fn_forward(fn_server("REQUEST_URI"));
        }
        $_str_location = "Location: " . BG_URL_ADMIN . "ctl.php?mod=logon&forward=" . $_str_forwart;
    }
    header($_str_location . $_url_attach);  //未登录就跳转至登录界面
    exit;
}
