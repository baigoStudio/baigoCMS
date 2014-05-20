<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}


function fn_groupPost() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_groupPost["group_id"] = fn_getSafe($_POST["group_id"], "int", 0);

	$_arr_groupName = validateStr($_POST["group_name"], 1, 30);
	switch ($_arr_groupName["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x040201",
			);
			exit;
		break;

		case "too_long":
			return array(
				"str_alert" => "x040202",
			);
			exit;
		break;

		case "ok":
			$_arr_groupPost["group_name"] = $_arr_groupName["str"];
		break;

	}

	$_arr_groupNote = validateStr($_POST["group_note"], 0, 30);
	switch ($_arr_groupNote["status"]) {
		case "too_long":
			return array(
				"str_alert" => "x040204",
			);
			exit;
		break;

		case "ok":
			$_arr_groupPost["group_note"] = $_arr_groupNote["str"];
		break;
	}

	$_arr_groupType = validateStr($_POST["group_type"], 1, 0);
	switch ($_arr_groupType["status"]) {
		case "too_long":
			return array(
				"str_alert" => "x040205",
			);
			exit;
		break;

		case "ok":
			$_arr_groupPost["group_type"] = $_arr_groupType["str"];
		break;

	}

	$_arr_groupPost["group_allow"] = json_encode($_POST["group_allow"]);

	$_arr_groupPost["str_alert"] = "ok";
	return $_arr_groupPost;
}


/**
 * fn_groupDo function.
 *
 * @access public
 * @return void
 */
function fn_groupDo() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_groupIds = $_POST["group_id"];

	if ($_arr_groupIds) {
		foreach ($_arr_groupIds as $_key=>$_value) {
			$_arr_groupIds[$_key] = fn_getSafe($_value, "int", 0);
		}
		$_str_alert = "ok";
	} else {
		$_str_alert = "none";
	}

	$_arr_groupDo = array(
		"str_alert"   => $_str_alert,
		"group_ids"   => $_arr_groupIds
	);

	return $_arr_groupDo;
}
?>