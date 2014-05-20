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
 * fn_appPost function.
 *
 * @access public
 * @return void
 */
function fn_appPost() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030101",
		);
		exit;
	}

	$_arr_appPost["app_id"] = fn_getSafe($_POST["app_id"], "int", 0);

	$_arr_appName = validateStr($_POST["app_name"], 1, 30);
	switch ($_arr_appName["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x050201",
			);
			exit;
		break;

		case "too_long":
			return array(
				"str_alert" => "x050202",
			);
			exit;
		break;

		case "ok":
			$_arr_appPost["app_name"] = $_arr_appName["str"];
		break;

	}

	$_arr_appNotice = validateStr($_POST["app_notice"], 1, 3000);
	switch ($_arr_appNotice["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x050207",
			);
			exit;
		break;

		case "too_long":
			return array(
				"str_alert" => "x050208",
			);
			exit;
		break;

		case "format_err":
			return array(
				"str_alert" => "x050209",
			);
			exit;
		break;

		case "ok":
			$_arr_appPost["app_notice"] = $_arr_appNotice["str"];
		break;
	}

	$_arr_appNote = validateStr($_POST["app_note"], 0, 30);
	switch ($_arr_appNote["status"]) {
		case "too_long":
			return array(
				"str_alert" => "x050205",
			);
			exit;
		break;

		case "ok":
			$_arr_appPost["app_note"] = $_arr_appNote["str"];
		break;

	}

	$_arr_appStatus = validateStr($_POST["app_status"], 1, 0);
	switch ($_arr_appStatus["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x050206",
			);
			exit;
		break;

		case "ok":
			$_arr_appPost["app_status"] = $_arr_appStatus["str"];
		break;
	}

	$_arr_appIpAllow = validateStr($_POST["app_ip_allow"], 0, 3000);
	switch ($_arr_appIpAllow["status"]) {
		case "too_long":
			return array(
				"str_alert" => "x050210",
			);
			exit;
		break;

		case "ok":
			$_arr_appPost["app_ip_allow"] = $_arr_appIpAllow["str"];
		break;
	}

	$_arr_appIpBad = validateStr($_POST["app_ip_bad"], 0, 3000);
	switch ($_arr_appIpBad["status"]) {
		case "too_long":
			return array(
				"str_alert" => "x050211",
			);
			exit;
		break;

		case "ok":
			$_arr_appPost["app_ip_bad"] = $_arr_appIpBad["str"];
		break;
	}

	$_arr_appSync = validateStr($_POST["app_sync"], 1, 0);
	switch ($_arr_appSync["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x050218",
			);
			exit;
		break;

		case "ok":
			$_arr_appPost["app_sync"] = $_arr_appSync["str"];
		break;
	}

	$_arr_appPost["app_allow"] = json_encode($_POST["app_allow"]);

	$_arr_appPost["str_alert"] = "ok";

	return $_arr_appPost;
}


/**
 * fn_appDo function.
 *
 * @access public
 * @return void
 */
function fn_appDo() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030101",
		);
		exit;
	}

	$_arr_appIds = $_POST["app_id"];

	if ($_arr_appIds) {
		foreach ($_arr_appIds as $_key=>$_value) {
			$_arr_appIds[$_key] = fn_getSafe($_value, "int", 0);
		}
		$_str_alert = "ok";
	} else {
		$_str_alert = "none";
	}

	$_arr_appDo = array(
		"str_alert" => $_str_alert,
		"app_ids" => $_arr_appIds
	);

	return $_arr_appDo;
}
?>