<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

if ($GLOBALS["adminLogged"]["str_alert"] != "y020102") {
	if ($GLOBALS["view"] == "iframe") {
		$_str_url = BG_URL_ADMIN . "ctl.php?mod=alert&act_get=display&alert=" . $GLOBALS["adminLogged"]["str_alert"];
	} else {
		if (fn_server("REQUEST_URI")) {
			$_str_attach = base64_encode(fn_server("REQUEST_URI"));
		}
		$_str_url = BG_URL_ADMIN . "ctl.php?mod=logon&forward=" . $_str_attach;
	}
	header("Location: " . $_str_url . $_url_attach);
	exit;
}
