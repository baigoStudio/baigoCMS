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
 * fn_adminMy function.
 *
 * @access public
 * @return void
 */
function fn_adminMy() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_adminPass = validateStr($_POST["admin_pass"], 1, 0);
	switch ($_arr_adminPass["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x020210",
			);
			exit;
		break;

		case "ok":
			$_arr_adminMy["admin_pass"] = $_arr_adminPass["str"];
		break;

	}

	$_str_adminPassNew     = $_POST["admin_pass_new"];
	$_str_adminPassConfirm = $_POST["admin_pass_confirm"];

	if ($_str_adminPassNew != $_str_adminPassConfirm) {
		return array(
			"str_alert" => "x020211",
		);
		exit;
	}

	$_arr_adminMy["admin_pass_new"]    = $_str_adminPassNew;

	$_arr_adminMail = validateStr($_POST["admin_mail"], 0, 900, "str", "email");
	switch ($_arr_adminMail["status"]) {
		case "too_long":
			return array(
				"str_alert" => "x020208",
			);
			exit;
		break;

		case "format_err":
			return array(
				"str_alert" => "x020209",
			);
			exit;
		break;

		case "ok":
			$_arr_adminMy["admin_mail"] = $_arr_adminMail["str"];
		break;

	}

	$_arr_adminMy["str_alert"]         = "ok";

	return $_arr_adminMy;
}


/**
 * fn_adminLogin function.
 *
 * @access public
 * @return void
 */
function fn_adminLogin() {
	$_arr_adminLogin["forward"] = fn_getSafe($_POST["forward"], "txt", "");
	if (!$_arr_adminLogin["forward"]) {
		$_arr_adminLogin["forward"] = base64_encode(BG_URL_ADMIN . "admin.php");
	}

	if (!fn_seccode()) { //验证码
		return array(
			"forward"    => $_arr_adminLogin["forward"],
			"str_alert"  => "x030101",
		);
		exit;
	}

	if (!fn_token("chk")) { //令牌
		return array(
			"forward"    => $_arr_adminLogin["forward"],
			"str_alert"  => "x030102",
		);
		exit;
	}

	$_arr_adminName = validateStr($_POST["admin_name"], 1, 30, "str", "strDigit");
	switch ($_arr_adminName["status"]) {
		case "too_short":
			return array(
				"forward"   => $_arr_adminLogin["forward"],
				"str_alert" => "x020201",
			);
			exit;
		break;

		case "too_long":
			return array(
				"forward"   => $_arr_adminLogin["forward"],
				"str_alert" => "x020202",
			);
			exit;
		break;

		case "format_err":
			return array(
				"forward"   => $_arr_adminLogin["forward"],
				"str_alert" => "x020203",
			);
			exit;
		break;

		case "ok":
			$_arr_adminLogin["admin_name"] = $_arr_adminName["str"];
		break;

	}

	$_arr_adminPass = validateStr($_POST["admin_pass"], 1, 0);
	switch ($_arr_adminPass["status"]) {
		case "too_short":
			return array(
				"forward"   => $_arr_adminLogin["forward"],
				"str_alert" => "x020208",
			);
			exit;
		break;

		case "ok":
			$_arr_adminLogin["admin_pass"] = $_arr_adminPass["str"];
		break;

	}

	$_arr_adminLogin["str_alert"]  = "ok";
	$_arr_adminLogin["view"] = fn_getSafe($_POST["view"], "txt", "");

	return $_arr_adminLogin;
}


/**
 * fn_adminPost function.
 *
 * @access public
 * @return void
 */
function fn_adminPost() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_adminPost["admin_id"] = fn_getSafe($_POST["admin_id"], "int", 0);

	$_arr_adminName = validateStr($_POST["admin_name"], 1, 30, "str", "strDigit");
	switch ($_arr_adminName["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x020201",
			);
			exit;
		break;

		case "too_long":
			return array(
				"str_alert" => "x020202",
			);
			exit;
		break;

		case "format_err":
			return array(
				"str_alert" => "x020203",
			);
			exit;
		break;

		case "ok":
			$_arr_adminPost["admin_name"] = $_arr_adminName["str"];
		break;

	}

	$_arr_adminMail = validateStr($_POST["admin_mail"], 0, 900, "str", "email");
	switch ($_arr_adminMail["status"]) {
		case "too_long":
			return array(
				"str_alert" => "x020208",
			);
			exit;
		break;

		case "format_err":
			return array(
				"str_alert" => "x020209",
			);
			exit;
		break;

		case "ok":
			$_arr_adminPost["admin_mail"] = $_arr_adminMail["str"];
		break;

	}

	$_arr_adminNote = validateStr($_POST["admin_note"], 0, 30);
	switch ($_arr_adminNote["status"]) {
		case "too_long":
			return array(
				"str_alert" => "x020212",
			);
			exit;
		break;

		case "ok":
			$_arr_adminPost["admin_note"] = $_arr_adminNote["str"];
		break;
	}

	$_arr_adminStatus = validateStr($_POST["admin_status"], 1, 0);
	switch ($_arr_adminStatus["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x020213",
			);
			exit;
		break;

		case "ok":
			$_arr_adminPost["admin_status"] = $_arr_adminStatus["str"];
		break;

	}

	$_arr_adminPost["admin_allow_cate"] = json_encode($_POST["admin_allow_cate"]);

	$_arr_adminPost["str_alert"] = "ok";
	return $_arr_adminPost;
}


/**
 * fn_adminDo function.
 *
 * @access public
 * @return void
 */
function fn_adminDo() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_adminIds = $_POST["admin_id"];

	if ($_arr_adminIds) {
		foreach ($_arr_adminIds as $_key=>$_value) {
			$_arr_adminIds[$_key] = fn_getSafe($_value, "int", 0);
		}
		$_str_alert = "ok";
	} else {
		$_str_alert = "none";
	}

	$_arr_adminDo = array(
		"str_alert"   => $_str_alert,
		"admin_ids"   => $_arr_adminIds
	);

	return $_arr_adminDo;
}


/**
 * fn_adminEnd function.
 *
 * @access public
 * @return void
 */
function fn_adminEnd() {
	unset($_SESSION["admin_id_" . BG_SITE_SSIN]);
	unset($_SESSION["admin_ssintime_" . BG_SITE_SSIN]);
	unset($_SESSION["admin_hash_" . BG_SITE_SSIN]);
}
?>