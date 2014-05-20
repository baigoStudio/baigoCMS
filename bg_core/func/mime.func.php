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
 * fn_mimePost function.
 *
 * @access public
 * @return void
 */
function fn_mimePost() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_mimeName = validateStr($_POST["mime_name"], 1, 300);
	switch ($_arr_mimeName["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x080201",
			);
			exit;
		break;

		case "too_long":
			return array(
				"str_alert" => "x080202",
			);
			exit;
		break;

		case "ok":
			$_arr_mimePost["mime_name"] = $_arr_mimeName["str"];
		break;

	}

	$_arr_mimeExt = validateStr($_POST["mime_ext"], 1, 10);
	switch ($_arr_mimeExt["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x080203",
			);
			exit;
		break;

		case "too_long":
			return array(
				"str_alert" => "x080204",
			);
			exit;
		break;

		case "ok":
			$_arr_mimePost["mime_ext"] = $_arr_mimeExt["str"];
		break;

	}

	$_arr_mimeNote = validateStr($_POST["mime_note"], 0, 300);
	switch ($_arr_mimeNote["status"]) {
		case "too_long":
			return array(
				"str_alert" => "x080205",
			);
			exit;
		break;

		case "ok":
			$_arr_mimePost["mime_note"] = $_arr_mimeNote["str"];
		break;

	}

	$_arr_mimePost["str_alert"] = "ok";
	return $_arr_mimePost;
}


/**
 * fn_mimeDo function.
 *
 * @access public
 * @return void
 */
function fn_mimeDo() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_mimeIds = $_POST["mime_id"];

	if ($_arr_mimeIds) {
		foreach ($_arr_mimeIds as $_key=>$_value) {
			$_arr_mimeIds[$_key] = fn_getSafe($_value, "int", 0);
		}
		$_str_alert = "ok";
	} else {
		$_str_alert = "none";
	}

	$_arr_mimeDo = array(
		"str_alert"   => $_str_alert,
		"mime_ids"   => $_arr_mimeIds
	);

	return $_arr_mimeDo;
}
?>