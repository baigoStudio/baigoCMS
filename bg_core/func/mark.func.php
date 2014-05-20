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
 * fn_markPost function.
 *
 * @access public
 * @return void
 */
function fn_markPost() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_markPost["mark_id"] = fn_getSafe($_POST["mark_id"], "int", 0);

	$_arr_markName = validateStr($_POST["mark_name"], 1, 30);
	switch ($_arr_markName["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x140201",
			);
			exit;
		break;

		case "too_long":
			return array(
				"str_alert" => "x140202",
			);
			exit;
		break;

		case "ok":
			$_arr_markPost["mark_name"] = $_arr_markName["str"];
		break;

	}

	$_arr_markPost["str_alert"] = "ok";
	return $_arr_markPost;
}


/**
 * fn_markDo function.
 *
 * @access public
 * @return void
 */
function fn_markDo() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_markIds = $_POST["mark_id"];

	if ($_arr_markIds) {
		foreach ($_arr_markIds as $_key=>$_value) {
			$_arr_markIds[$_key] = fn_getSafe($_value, "int", 0);
		}
		$_str_alert = "ok";
	} else {
		$_str_alert = "none";
	}

	$_arr_markDo = array(
		"str_alert"   => $_str_alert,
		"mark_ids"    => $_arr_markIds
	);

	return $_arr_markDo;
}
?>