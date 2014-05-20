<?php
/*-----------------------------------------------------------------

！！！！警告！！！！
以下为系统文件，请勿修改

-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

if (!file_exists(BG_PATH_CONFIG . "is_install.php")) {
	header("Location: " . BG_URL_INSTALL . "install.php");
	exit;
}
?>