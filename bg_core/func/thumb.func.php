<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}


function fn_thumbPost() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_thumbWidth = validateStr($_POST["thumb_width"], 1, 0);
	switch ($_arr_thumbWidth["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x090201",
			);
			exit;
		break;

		case "format_err":
			return array(
				"str_alert" => "x090202",
			);
			exit;
		break;

		case "ok":
			$_arr_thumbPost["thumb_width"] = $_arr_thumbWidth["str"];
		break;

	}

	$_arr_thumbHeight = validateStr($_POST["thumb_height"], 1, 0);
	switch ($_arr_thumbHeight["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x090203",
			);
			exit;
		break;

		case "format_err":
			return array(
				"str_alert" => "x090204",
			);
			exit;
		break;

		case "ok":
			$_arr_thumbPost["thumb_height"] = $_arr_thumbHeight["str"];
		break;

	}

	$_arr_thumbType = validateStr($_POST["thumb_type"], 1, 0);
	switch ($_arr_thumbType["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x090205",
			);
			exit;
		break;

		case "ok":
			$_arr_thumbPost["thumb_type"] = $_arr_thumbType["str"];
		break;

	}

	$_arr_thumbPost["str_alert"] = "ok";
	return $_arr_thumbPost;
}


/**
 * fn_thumbDo function.
 *
 * @access public
 * @return void
 */
function fn_thumbDo() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_thumbIds = $_POST["thumb_id"];

	if ($_arr_thumbIds) {
		foreach ($_arr_thumbIds as $_key=>$_value) {
			$_arr_thumbIds[$_key] = fn_getSafe($_value, "int", 0);
		}
		$_str_alert = "ok";
	} else {
		$_str_alert = "none";
	}

	$_arr_thumbDo = array(
		"str_alert"   => $_str_alert,
		"thumb_ids"   => $_arr_thumbIds
	);

	return $_arr_thumbDo;
}
?>