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
 * fn_articlePost function.
 *
 * @access public
 * @return void
 */
function fn_articlePost() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_articlePost["article_id"] = fn_getSafe($_POST["article_id"], "int", 0);

	$_arr_articleTitle = validateStr($_POST["article_title"], 1, 300);
	switch ($_arr_articleTitle["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x120201",
			);
			exit;
		break;

		case "too_long":
			return array(
				"str_alert" => "x120202",
			);
			exit;
		break;

		case "ok":
			$_arr_articlePost["article_title"] = $_arr_articleTitle["str"];
		break;

	}

	$_arr_articleTag = validateStr($_POST["article_tag"], 0, 300);
	switch ($_arr_articleTag["status"]) {
		case "too_long":
			return array(
				"str_alert" => "x120203",
			);
			exit;
		break;

		case "ok":
			$_arr_articlePost["article_tag"] = $_arr_articleTag["str"];
		break;

	}

	$_arr_articleLink = validateStr($_POST["article_link"], 0, 900, "str", "url");
	switch ($_arr_articleLink["status"]) {
		case "too_long":
			return array(
				"str_alert" => "x120204",
			);
			exit;
		break;

		case "format_err":
			return array(
				"str_alert" => "x120204",
			);
			exit;
		break;

		case "ok":
			$_arr_articlePost["article_link"] = $_arr_articleLink["str"];
		break;
	}

	$_arr_articleExcerpt = validateStr($_POST["article_excerpt"], 0, 900);
	switch ($_arr_articleExcerpt["status"]) {
		case "too_long":
			return array(
				"str_alert" => "x120205",
			);
			exit;
		break;

		case "ok":
			$_arr_articlePost["article_excerpt"] = $_arr_articleExcerpt["str"];
		break;
	}

	$_arr_articleStatus = validateStr($_POST["article_status"], 1, 0);
	switch ($_arr_articleStatus["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x120208",
			);
			exit;
		break;

		case "ok":
			$_arr_articlePost["article_status"] = $_arr_articleStatus["str"];
		break;

	}

	$_arr_articleBox = validateStr($_POST["article_box"], 1, 0);
	switch ($_arr_articleBox["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x120209",
			);
			exit;
		break;

		case "ok":
			$_arr_articlePost["article_box"] = $_arr_articleBox["str"];
		break;

	}


	$_arr_articleTimePub = validateStr($_POST["article_time_pub"], 1, 0, "str", "datetime");
	switch ($_arr_articleTimePub["status"]) {
		case "too_short":
			return array(
				"str_alert" => "x120210",
			);
			exit;
		break;

		case "format_err":
			return array(
				"str_alert" => "x120211",
			);
			exit;
		break;

		case "ok":
			$_arr_articlePost["article_time_pub"] = strtotime($_arr_articleTimePub["str"]);
		break;
	}

	$_arr_cateIds = $_POST["cate_ids"];
	if (!$_arr_cateIds) {
		return array(
			"str_alert" => "x120207",
		);
		exit;
	}

	foreach ($_arr_cateIds as $_value) {
		$_arr_articlePost["cate_ids"][] = fn_getSafe($_value, "int", 0);
	}

	$_arr_articlePost["article_cate_id"]   = $_arr_articlePost["cate_ids"][0];
	$_arr_articlePost["article_content"]   = $_POST["article_content"];

	if (!$_arr_articlePost["article_excerpt"] || $_arr_articlePost["article_excerpt"] == "<br />") {
		$_arr_articlePost["article_excerpt"] = substr($_arr_articlePost["article_content"], 0, 900);
	}

	$_arr_articlePost["article_upfile_id"] = fn_getUpfile($_arr_articlePost["article_content"]);
	$_arr_articlePost["article_mark_id"]   = fn_getSafe($_POST["article_mark_id"], "int", 0);
	$_arr_articlePost["str_alert"]         = "ok";

	return $_arr_articlePost;
}


/**
 * fn_articleDo function.
 *
 * @access public
 * @return void
 */
function fn_articleDo() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_articleIds = $_POST["article_id"];

	if ($_arr_articleIds) {
		foreach ($_arr_articleIds as $_key=>$_value) {
			$_arr_articleIds[$_key] = fn_getSafe($_value, "int", 0);
		}
		$_str_alert = "ok";
	} else {
		$_str_alert = "none";
	}

	$_arr_articleDo = array(
		"str_alert"   => $_str_alert,
		"article_ids"    => $_arr_articleIds
	);

	return $_arr_articleDo;
}
?>