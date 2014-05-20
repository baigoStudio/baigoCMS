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
 * fn_userGetBy function.
 *
 * @access public
 * @return void
 */
function fn_userGetBy($str_method = "get") {
	if ($str_method == "post") {
		$_str_getBy = fn_getSafe($_POST["user_by"], "txt", "");
		if ($_str_getBy == "user_id") {
			$_arr_userGet["user_by"]     = "user_id";
			$_arr_userChk                = fn_userIdChk($_POST["user_id"]);
			$_arr_userGet["user_str"]    = $_arr_userChk["user_id"];
		} else {
			$_arr_userGet["user_by"]     = "user_name";
			$_arr_userChk                = fn_userNameChk($_POST["user_name"]);
			$_arr_userGet["user_str"]    = $_arr_userChk["user_name"];
		}
	} else {
		$_str_getBy = fn_getSafe($_GET["user_by"], "txt", "");
		if ($_str_getBy == "user_id") {
			$_arr_userGet["user_by"]     = "user_id";
			$_arr_userChk                = fn_userIdChk($_GET["user_id"]);
			$_arr_userGet["user_str"]    = $_arr_userChk["user_id"];
		} else {
			$_arr_userGet["user_by"]     = "user_name";
			$_arr_userChk                = fn_userNameChk($_GET["user_name"]);
			$_arr_userGet["user_str"]    = $_arr_userChk["user_name"];
		}
	}

	if ($_arr_userChk["str_alert"] != "ok") {
		return $_arr_userChk;
		exit;
	}

	$_arr_userGet["str_alert"] = "ok";

	return $_arr_userGet;
}


/**
 * fn_userIdChk function.
 *
 * @access public
 * @param mixed $num_id
 * @return void
 */
function fn_userIdChk($num_id) {
	$_arr_userId = validateStr($num_id, 1, 0, "str", "int");

	switch ($_arr_userId["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x010217",
			);
			exit;
		break;

		case "format_err":
			return array(
				"str_alert" => "x010218",
			);
			exit;
		break;

		case "ok":
			$_num_userId = $_arr_userId["str"];
		break;
	}

	return array(
		"user_id"     => $_num_userId,
		"str_alert"   => "ok",
	);
}


/**
 * fn_userNameChk function.
 *
 * @access public
 * @param mixed $str_user
 * @return void
 */
function fn_userNameChk($str_name) {
	$_arr_userName = validateStr($str_name, 1, 30, "str", "strDigit");

	switch ($_arr_userName["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x010201",
			);
			exit;
		break;

		case "too_long":
			return array(
				"str_alert" => "x010202",
			);
			exit;
		break;

		case "format_err":
			return array(
				"str_alert" => "x010203",
			);
			exit;
		break;

		case "ok":
			$_str_userName = $_arr_userName["str"];
		break;
	}

	return array(
		"user_name"   => $_str_userName,
		"str_alert"   => "ok",
	);
}


/**
 * fn_userMailChk function.
 *
 * @access public
 * @param mixed $str_mail
 * @param mixed $num_mailMin
 * @return void
 */
function fn_userMailChk($str_mail) {

	if (BG_REG_NEEDMAIL == "on") {
		$_num_mailMin = 1;
	} else {
		$_num_mailMin = 0;
	}

	$_arr_userMail = validateStr($str_mail, $_num_mailMin, 300, "str", "email");

	switch ($_arr_userMail["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x010206",
			);
			exit;
		break;

		case "too_long":
			return array(
				"str_alert" => "x010207",
			);
			exit;
		break;

		case "format_err":
			return array(
				"str_alert" => "x010208",
			);
			exit;
		break;

		case "ok":
			$_str_userMail = $_arr_userMail["str"];
		break;
	}

	return array(
		"user_mail"   => $_str_userMail,
		"str_alert"   => "ok",
	);
}


/**
 * fn_userPassChk function.
 *
 * @access public
 * @param mixed $str_pass
 * @return void
 */
function fn_userPassChk($str_pass) {
	$_arr_userPass = validateStr($str_pass, 1, 0);
	switch ($_arr_userPass["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x010212",
			);
			exit;
		break;

		case "ok":
			$_str_userPass = $_arr_userPass["str"];
		break;
	}

	return array(
		"user_pass"   => $_str_userPass,
		"str_alert"   => "ok",
	);
}


/**
 * fn_userNickChk function.
 *
 * @access public
 * @param mixed $str_nick
 * @return void
 */
function fn_userNickChk($str_nick) {
	$_arr_userNick = validateStr($str_nick, 0, 30);
	switch ($_arr_userNick["status"]) {
		case "too_long":
			return array(
				"str_alert" => "x010214",
			);
			exit;
		break;

		case "ok":
			$_str_userNick = $_arr_userNick["str"];
		break;

	}

	return array(
		"user_nick"   => $_str_userNick,
		"str_alert"   => "ok",
	);
}


/**
 * fn_userNoteChk function.
 *
 * @access public
 * @param mixed $str_note
 * @return void
 */
function fn_userNoteChk($str_note) {
	$_arr_userNote = validateStr($str_note, 0, 30);
	switch ($_arr_userNote["status"]) {
		case "too_long":
			return array(
				"str_alert" => "x010215",
			);
			exit;
		break;

		case "ok":
			$_str_userNote = $_arr_userNote["str"];
		break;

	}

	return array(
		"user_note"   => $_str_userNote,
		"str_alert"   => "ok",
	);
}


/**
 * fn_userChkName function.
 *
 * @access public
 * @return void
 */
function fn_userChkName() {
	$_num_userId = fn_getSafe($_GET["user_id"], "int", 0);

	$_arr_userName = fn_userNameChk($_GET["user_name"]);
	if ($_arr_userName["str_alert"] != "ok") {
		return $_arr_userName;
		exit;
	}
	if (defined("BG_BAD_NAME") && strlen(BG_BAD_NAME)) {
		if (fn_regChk($_arr_userName["user_name"], BG_BAD_NAME, true)) {
			return array(
				"str_alert" => "x010204",
			);
			exit;
		}
	}

	return array(
		"user_id"     => $_num_userId,
		"user_name"   => $_arr_userName["user_name"],
		"str_alert"   => "ok",
	);
}


/**
 * fn_userChkMail function.
 *
 * @access public
 * @return void
 */
function fn_userChkMail() {
	$_num_userId   = fn_getSafe($_GET["user_id"], "int", 0);

	$_arr_userMail = fn_userMailChk($_GET["user_mail"]);
	if ($_arr_userMail["str_alert"] != "ok") {
		return $_arr_userMail;
		exit;
	}

	if (defined("BG_ACC_MAIL") && strlen(BG_ACC_MAIL)) {
		if (!fn_regChk($_arr_userMail["user_mail"], BG_ACC_MAIL)) {
			return array(
				"str_alert" => "x010209",
			);
			exit;
		}
	} else if (defined("BG_BAD_MAIL") && strlen(BG_BAD_MAIL)) {
		if (fn_regChk($_arr_userMail["user_mail"], BG_BAD_MAIL)) {
			return array(
				"str_alert" => "x010210",
			);
			exit;
		}
	}

	return array(
		"user_id"     => $_num_userId,
		"user_mail"   => $_arr_userMail["user_mail"],
		"str_alert"   => "ok",
	);
}


/**
 * fn_userReg function.
 *
 * @access public
 * @return void
 */
function fn_userReg() {
	$_arr_userName = fn_userNameChk($_POST["user_name"]);
	if ($_arr_userName["str_alert"] != "ok") {
		return $_arr_userName;
		exit;
	}
	$_arr_userReg["user_name"] = $_arr_userName["user_name"];

	if (defined("BG_BAD_NAME") && strlen(BG_BAD_NAME)) {
		if (fn_regChk($_arr_userReg["user_name"], BG_BAD_NAME, true)) {
			return array(
				"str_alert" => "x010204",
			);
			exit;
		}
	}

	$_arr_userMail = fn_userMailChk($_POST["user_mail"]);
	if ($_arr_userMail["str_alert"] != "ok") {
		return $_arr_userMail;
		exit;
	}
	$_arr_userReg["user_mail"] = $_arr_userMail["user_mail"];

	if (defined("BG_ACC_MAIL") && strlen(BG_ACC_MAIL)) {
		if (!fn_regChk($_arr_userReg["user_mail"], BG_ACC_MAIL)) {
			return array(
				"str_alert" => "x010209",
			);
			exit;
		}
	} else if (defined("BG_BAD_MAIL") && strlen(BG_BAD_MAIL)) {
		if (fn_regChk($_arr_userReg["user_mail"], BG_BAD_MAIL)) {
			return array(
				"str_alert" => "x010210",
			);
			exit;
		}
	}

	$_arr_userPass = fn_userPassChk($_POST["user_pass"]);
	if ($_arr_userPass["str_alert"] != "ok") {
		return $_arr_userPass;
		exit;
	}
	$_arr_userReg["user_pass"] = $_arr_userPass["user_pass"];

	$_arr_userNick = fn_userNickChk($_POST["user_nick"]);
	if ($_arr_userNick["str_alert"] != "ok") {
		return $_arr_userNick;
		exit;
	}
	$_arr_userReg["user_nick"] = $_arr_userNick["user_nick"];

	$_arr_userReg["str_alert"] = "ok";
	return $_arr_userReg;
}


/**
 * fn_userLogin function.
 *
 * @access public
 * @return void
 */
function fn_userLogin() {
	$_arr_userGet = fn_userGetBy("post");

	if ($_arr_userGet["str_alert"] != "ok") {
		return $_arr_userGet;
		exit;
	}

	$_arr_userLogin = $_arr_userGet;

	$_arr_userPass = fn_userPassChk($_POST["user_pass"]);
	if ($_arr_userPass["str_alert"] != "ok") {
		return $_arr_userPass;
		exit;
	}
	$_arr_userLogin["user_pass"]   = $_arr_userPass["user_pass"];

	$_arr_userLogin["str_alert"]   = "ok";
	return $_arr_userLogin;
}


/**
 * fn_userEdit function.
 *
 * @access public
 * @return void
 */
function fn_userEdit() {
	$_arr_userGet = fn_userGetBy("post");

	if ($_arr_userGet["str_alert"] != "ok") {
		return $_arr_userGet;
		exit;
	}

	$_arr_userEdit = $_arr_userGet;

	if ($_POST["user_mail"]) {
		$_arr_userMail = fn_userMailChk($_POST["user_mail"]);
		if ($_arr_userMail["str_alert"] != "ok") {
			return $_arr_userMail;
			exit;
		}
		$_arr_userEdit["user_mail"] = $_arr_userMail["user_mail"];

		if (defined("BG_ACC_MAIL") && strlen(BG_ACC_MAIL)) {
			if (!fn_regChk($_arr_userEdit["user_mail"], BG_ACC_MAIL)) {
				return array(
					"str_alert" => "x010209",
				);
				exit;
			}
		} else if (defined("BG_BAD_MAIL") && strlen(BG_BAD_MAIL)) {
			if (fn_regChk($_arr_userEdit["user_mail"], BG_BAD_MAIL)) {
				return array(
					"str_alert" => "x010210",
				);
				exit;
			}
		}
	}

	$_arr_userEdit["user_check_pass"] = fn_getSafe($_POST["user_check_pass"], "txt", "");

	if ($_arr_userEdit["user_check_pass"] == true) {
		$_arr_userPass = fn_userPassChk($_POST["user_pass"]);
		if ($_arr_userPass["str_alert"] != "ok") {
			return $_arr_userPass;
			exit;
		}
		$_arr_userEdit["user_pass"] = $_arr_userPass["user_pass"];
	}

	if ($_POST["user_pass_new"]) {
		$_arr_userEdit["user_pass_new"] = $_POST["user_pass_new"];
	}

	$_arr_userNick = fn_userNickChk($_POST["user_nick"]);
	if ($_arr_userNick["str_alert"] != "ok") {
		return $_arr_userNick;
		exit;
	}
	$_arr_userEdit["user_nick"] = $_arr_userNick["user_nick"];

	$_arr_userEdit["str_alert"] = "ok";
	return $_arr_userEdit;
}


/**
 * fn_userPost function.
 *
 * @access public
 * @return void
 */
function fn_userPost() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030101",
		);
		exit;
	}

	$_arr_userPost["user_id"] = fn_getSafe($_POST["user_id"], "int", 0);

	$_arr_userName = fn_userNameChk($_POST["user_name"]);
	if ($_arr_userName["str_alert"] != "ok") {
		return $_arr_userName;
		exit;
	}
	$_arr_userPost["user_name"] = $_arr_userName["user_name"];

	$_arr_userMail = fn_userMailChk($_POST["user_mail"]);
	if ($_arr_userMail["str_alert"] != "ok") {
		return $_arr_userMail;
		exit;
	}
	$_arr_userPost["user_mail"] = $_arr_userMail["user_mail"];

	$_arr_userNick = fn_userNickChk($_POST["user_nick"]);
	if ($_arr_userNick["str_alert"] != "ok") {
		return $_arr_userNick;
		exit;
	}
	$_arr_userPost["user_nick"] = $_arr_userNick["user_nick"];

	$_arr_userNote = fn_userNoteChk($_POST["user_note"]);
	if ($_arr_userNote["str_alert"] != "ok") {
		return $_arr_userNote;
		exit;
	}
	$_arr_userPost["user_note"] = $_arr_userNote["user_note"];

	$_arr_userPost["str_alert"] = "ok";
	return $_arr_userPost;
}


/**
 * fn_userDo function.
 *
 * @access public
 * @return void
 */
function fn_userDo() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030101",
		);
		exit;
	}

	$_arr_userIds = $_POST["user_id"];

	if ($_arr_userIds) {
		foreach ($_arr_userIds as $_key=>$_value) {
			$_arr_userIds[$_key] = fn_getSafe($_value, "int", 0);
		}
		$_str_alert = "ok";
	} else {
		$_str_alert = "none";
	}

	$_arr_userDo = array(
		"str_alert"   => $_str_alert,
		"user_ids"    => $_arr_userIds
	);

	return $_arr_userDo;
}
?>