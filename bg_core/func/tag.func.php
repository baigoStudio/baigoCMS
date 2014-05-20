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
 * fn_tagPost function.
 *
 * @access public
 * @return void
 */
function fn_tagPost() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_tagPost["tag_id"] = fn_getSafe($_POST["tag_id"], "int", 0);

	$_arr_tagName = validateStr($_POST["tag_name"], 1, 30);
	switch ($_arr_tagName["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x130201",
			);
			exit;
		break;

		case "too_long":
			return array(
				"str_alert" => "x130202",
			);
			exit;
		break;

		case "ok":
			$_arr_tagPost["tag_name"] = $_arr_tagName["str"];
		break;
	}

	$_arr_tagStatus = validateStr($_POST["tag_status"], 1, 0);
	switch ($_arr_tagStatus["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x130204",
			);
			exit;
		break;

		case "ok":
			$_arr_tagPost["tag_status"] = $_arr_tagStatus["str"];
		break;
	}

	$_arr_tagPost["str_alert"] = "ok";
	return $_arr_tagPost;
}


/**
 * fn_tagDo function.
 *
 * @access public
 * @return void
 */
function fn_tagDo() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_tagIds = $_POST["tag_id"];

	if ($_arr_tagIds) {
		foreach ($_arr_tagIds as $_key=>$_value) {
			$_arr_tagIds[$_key] = fn_getSafe($_value, "int", 0);
		}
		$_str_alert = "ok";
	} else {
		$_str_alert = "none";
	}

	$_arr_tagDo = array(
		"str_alert"   => $_str_alert,
		"tag_ids"   => $_arr_tagIds
	);

	return $_arr_tagDo;
}
?>