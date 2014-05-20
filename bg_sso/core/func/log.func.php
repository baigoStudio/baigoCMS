<?php
/*-----------------------------------------------------------------

！！！！警告！！！！
以下为系统文件，请勿修改

-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}


/**
 * fn_logDo function.
 *
 * @access public
 * @return void
 */
function fn_logDo() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030101",
		);
		exit;
	}

	$_arr_logIds = $_POST["log_id"];

	if ($_arr_logIds) {
		foreach ($_arr_logIds as $_key=>$_value) {
			$_arr_logIds[$_key] = fn_getSafe($_value, "int", 0);
		}
		$_str_alert = "ok";
	} else {
		$_str_alert = "none";
	}

	$_arr_logDo = array(
		"str_alert" => $_str_alert,
		"log_ids" => $_arr_logIds
	);

	return $_arr_logDo;
}
?>