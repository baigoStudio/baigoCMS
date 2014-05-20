<?php
$arr_data = array(
	"app_id"       => $_POST["app_id"],
	"app_key"      => $_POST["app_key"],
	"timestamp"    => $_POST["timestamp"],
	"random"       => $_POST["random"],
	"signature"    => $_POST["signature"],
	"echostr"      => $_POST["echostr"],
);
//file_put_contents(BG_PATH_ROOT . "notice.txt", $arr_data);
exit($_POST["echostr"]);
?>