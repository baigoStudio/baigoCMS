<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}


function fn_callPost() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_callPost["call_id"] = fn_getSafe($_POST["call_id"], "int", 0);

	$_arr_callName = validateStr($_POST["call_name"], 1, 300);
	switch ($_arr_callName["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x170201",
			);
			exit;
		break;

		case "too_long":
			return array(
				"str_alert" => "x170202",
			);
			exit;
		break;

		case "ok":
			$_arr_callPost["call_name"] = $_arr_callName["str"];
		break;

	}

	$_arr_callType = validateStr($_POST["call_type"], 1, 0);
	switch ($_arr_callType["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x170204",
			);
			exit;
		break;

		case "ok":
			$_arr_callPost["call_type"] = $_arr_callType["str"];
		break;
	}

	$_arr_callStatus = validateStr($_POST["call_status"], 1, 0);
	switch ($_arr_callStatus["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x170206",
			);
			exit;
		break;

		case "ok":
			$_arr_callPost["call_status"] = $_arr_callStatus["str"];
		break;
	}

	$_arr_callTrim = validateStr($_POST["call_trim"], 1, 0);
	switch ($_arr_callTrim["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x170211",
			);
			exit;
		break;

		case "format_err":
			return array(
				"str_alert" => "x170212",
			);
			exit;
		break;

		case "ok":
			$_arr_callPost["call_trim"] = $_arr_callTrim["str"];
		break;
	}

	$_arr_callCss = validateStr($_POST["call_css"], 0, 300, "str", "strDigit");
	switch ($_arr_callCss["status"]) {
		case "too_long":
			return array(
				"str_alert" => "x170214",
			);
			exit;
		break;

		case "format_err":
			return array(
				"str_alert" => "x170215",
			);
			exit;
		break;

		case "ok":
			$_arr_callPost["call_css"] = $_arr_callCss["str"];
		break;
	}

	$_arr_callPost["call_file"]        = fn_getSafe($_POST["call_file"], "txt", "");
	$_arr_callPost["call_upfile"]      = fn_getSafe($_POST["call_upfile"], "txt", "");
	$_arr_callPost["call_cate_id"]     = fn_getSafe($_POST["call_cate_id"], "int", 0);

	$_arr_callPost["call_cate_ids"]    = json_encode($_POST["call_cate_ids"]);
	$_arr_callPost["call_mark_ids"]    = json_encode($_POST["call_mark_ids"]);
	$_arr_callPost["call_show"]        = json_encode($_POST["call_show"]);
	$_arr_callPost["call_amount"]      = json_encode($_POST["call_amount"]);

	$_arr_callPost["str_alert"]        = "ok";

	return $_arr_callPost;
}


/**
 * fn_callDo function.
 *
 * @access public
 * @return void
 */
function fn_callDo() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_callIds = $_POST["call_id"];

	if ($_arr_callIds) {
		foreach ($_arr_callIds as $_key=>$_value) {
			$_arr_callIds[$_key] = fn_getSafe($_value, "int", 0);
		}
		$_str_alert = "ok";
	} else {
		$_str_alert = "none";
	}

	$_arr_callDo = array(
		"str_alert"   => $_str_alert,
		"call_ids"   => $_arr_callIds
	);

	return $_arr_callDo;
}
?>