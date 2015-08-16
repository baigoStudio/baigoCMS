<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}


/*-------------API 接口类-------------*/
class CLASS_API {

	/** 验证 app
	 * app_chk function.
	 *
	 * @access public
	 * @param mixed $arr_appGet
	 * @param mixed $arr_appRow
	 * @return void
	 */
	function app_chk($arr_appGet, $arr_appRow) {
		if ($arr_appGet["alert"] != "ok") {
			return $arr_appRow;
		}

		if ($arr_appRow["app_status"] != "enable") {
			return array(
				"alert" => "x190402",
			);
			exit;
		}

		$_str_ip = fn_getIp(false);

		if ($arr_appRow["app_ip_allow"]) {
			$_str_ipAllow = str_replace(PHP_EOL, "|", $arr_appRow["app_ip_allow"]);
			if (!fn_regChk($_str_ip, $_str_ipAllow, true)) {
				return array(
					"alert" => "x190212",
				);
				exit;
			}
		} else if ($arr_appRow["app_ip_bad"]) {
			$_str_ipBad = str_replace(PHP_EOL, "|", $arr_appRow["app_ip_bad"]);
			if (fn_regChk($_str_ip, $_str_ipBad)) {
				return array(
					"alert" => "x190213",
				);
				exit;
			}
		}

		if ($arr_appRow["app_key"] != $arr_appGet["app_key"]) {
			return array(
				"alert" => "x190217",
			);
			exit;
		}

		return array(
			"alert" => "ok",
		);
	}


	/** 读取 app 信息
	 * app_get function.
	 *
	 * @access public
	 * @param bool $chk_token (default: false)
	 * @return void
	 */
	function app_get($str_method = "get", $chk_token = false) {
		if ($str_method == "post") {
			$num_appId       = fn_post("app_id");
			$str_appKey      = fn_post("app_key");
		} else {
			$num_appId       = fn_get("app_id");
			$str_appKey      = fn_get("app_key");
		}

		$_arr_appId = validateStr($num_appId, 1, 0, "str", "int");
		switch ($_arr_appId["status"]) {
			case "too_short":
				return array(
					"alert" => "x190203",
				);
				exit;
			break;

			case "format_err":
				return array(
					"alert" => "x190204",
				);
				exit;
			break;

			case "ok":
				$_arr_appGet["app_id"] = $_arr_appId["str"];
			break;

		}

		$_arr_appKey = validateStr($str_appKey, 1, 64, "str", "alphabetDigit");
		switch ($_arr_appKey["status"]) {
			case "too_short":
				return array(
					"alert" => "x190214",
				);
				exit;
			break;

			case "too_long":
				return array(
					"alert" => "x190215",
				);
				exit;
			break;

			case "format_err":
				return array(
					"alert" => "x190216",
				);
				exit;
			break;

			case "ok":
				$_arr_appGet["app_key"] = $_arr_appKey["str"];
			break;

		}

		$_arr_appGet["alert"] = "ok";

		return $_arr_appGet;
	}


	/** 返回结果
	 * halt_re function.
	 *
	 * @access public
	 * @param mixed $arr_re
	 * @return void
	 */
	function halt_re($arr_re, $is_encode = false) {
		if ($is_encode) {
			$_str_return = fn_jsonEncode($arr_re, "encode");
		} else {
			$_str_return = json_encode($arr_re);
		}
		exit($_str_return); //输出错误信息
	}


	function chk_install() {
		if (file_exists(BG_PATH_CONFIG . "is_install.php")) { //验证是否已经安装
			include_once(BG_PATH_CONFIG . "is_install.php");
			if (!defined("BG_INSTALL_PUB") || PRD_CMS_PUB > BG_INSTALL_PUB) {
				$_arr_return = array(
					"alert" => "x030416"
				);
				$this->halt_re($_arr_return);
			}
		} else {
			$_arr_return = array(
				"alert" => "x030415"
			);
			$this->halt_re($_arr_return);
		}
	}
}