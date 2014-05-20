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
 * fn_catePost function.
 *
 * @access public
 * @return void
 */
function fn_catePost() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_catePost["cate_id"] = fn_getSafe($_POST["cate_id"], "int", 0);

	$_arr_cateName = validateStr($_POST["cate_name"], 1, 300);
	switch ($_arr_cateName["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x110201",
			);
			exit;
		break;

		case "too_long":
			return array(
				"str_alert" => "x110202",
			);
			exit;
		break;

		case "ok":
			$_arr_catePost["cate_name"] = $_arr_cateName["str"];
		break;

	}

	$_arr_cateAlias = validateStr($_POST["cate_alias"], 0, 300, "str", "alphabetDigit");
	switch ($_arr_cateAlias["status"]) {
		case "too_long":
			return array(
				"str_alert" => "x110204",
			);
			exit;
		break;

		case "format_err":
			return array(
				"str_alert" => "x110205",
			);
			exit;
		break;

		case "ok":
			$_arr_catePost["cate_alias"] = $_arr_cateAlias["str"];
		break;

	}

	$_arr_cateLink = validateStr($_POST["cate_link"], 0, 3000, "str", "url");
	switch ($_arr_cateLink["status"]) {
		case "too_long":
			return array(
				"str_alert" => "x110211",
			);
			exit;
		break;

		case "format_err":
			return array(
				"str_alert" => "x110212",
			);
			exit;
		break;

		case "ok":
			$_arr_catePost["cate_link"] = $_arr_cateLink["str"];
		break;
	}

	$_arr_cateParentId = validateStr($_POST["cate_parent_id"], 1, 0);
	switch ($_arr_cateParentId["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x110213",
			);
			exit;
		break;

		case "ok":
			$_arr_catePost["cate_parent_id"] = $_arr_cateParentId["str"];
		break;

	}

	$_arr_cateTpl = validateStr($_POST["cate_tpl"], 1, 0);
	switch ($_arr_cateTpl["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x110214",
			);
			exit;
		break;

		case "ok":
			$_arr_catePost["cate_tpl"] = $_arr_cateTpl["str"];
		break;

	}

	$_arr_cateType = validateStr($_POST["cate_type"], 1, 0);
	switch ($_arr_cateType["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x110215",
			);
			exit;
		break;

		case "ok":
			$_arr_catePost["cate_type"] = $_arr_cateType["str"];
		break;

	}

	$_arr_cateStatus = validateStr($_POST["cate_status"], 1, 0);
	switch ($_arr_cateStatus["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x110216",
			);
			exit;
		break;

		case "ok":
			$_arr_catePost["cate_status"] = $_arr_cateStatus["str"];
		break;

	}

	$_arr_cateDomain = validateStr($_POST["cate_domain"], 0, 3000, "str", "url");
	switch ($_arr_cateDomain["status"]) {
		case "too_long":
			return array(
				"str_alert" => "x110207",
			);
			exit;
		break;

		case "format_err":
			return array(
				"str_alert" => "x110208",
			);
			exit;
		break;

		case "ok":
			$_arr_catePost["cate_domain"] = $_arr_cateDomain["str"];
		break;
	}

	$_arr_catePost["cate_content"]     = $_POST["cate_content"];

	$_arr_catePost["cate_ftp_host"]    = fn_getSafe($_POST["cate_ftp_host"], "txt", "");
	$_arr_catePost["cate_ftp_port"]    = fn_getSafe($_POST["cate_ftp_port"], "txt", "");
	$_arr_catePost["cate_ftp_user"]    = fn_getSafe($_POST["cate_ftp_user"], "txt", "");
	$_arr_catePost["cate_ftp_pass"]    = fn_getSafe($_POST["cate_ftp_pass"], "txt", "");
	$_arr_catePost["cate_ftp_path"]    = fn_getSafe($_POST["cate_ftp_path"], "txt", "");

	$_arr_catePost["str_alert"] = "ok";
	return $_arr_catePost;
}


/**
 * fn_cateDo function.
 *
 * @access public
 * @return void
 */
function fn_cateDo() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_cateIds = $_POST["cate_id"];

	if ($_arr_cateIds) {
		foreach ($_arr_cateIds as $_key=>$_value) {
			$_arr_cateIds[$_key] = fn_getSafe($_value, "int", 0);
		}
		$_str_alert = "ok";
	} else {
		$_str_alert = "none";
	}

	$_arr_cateDo = array(
		"str_alert"   => $_str_alert,
		"cate_ids"    => $_arr_cateIds
	);

	return $_arr_cateDo;
}


function fn_cateIds($_arr_cateRows) {
	foreach ($_arr_cateRows as $_value) {
		if ($_value["cate_childs"]) {
			$_arr_cate      = fn_cateIds($_value["cate_childs"]);
			$_arr_cateIds   = array_merge($_arr_cate, $_arr_cateIds);
		}
		if ($_value["cate_id"] > 0) {
			$_arr_cateIds[] = $_value["cate_id"];
		}
	}
	return $_arr_cateIds;
}
?>