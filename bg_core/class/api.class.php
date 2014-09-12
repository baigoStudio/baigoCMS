<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "http.func.php"); //载入HTTP函数
include_once(BG_PATH_FUNC . "baigocode.func.php"); //载入加密解密函数

/*-------------API 接口类-------------*/
class CLASS_API {

	/**
	 * app_chk function.
	 *
	 * @access public
	 * @param mixed $arr_appGet
	 * @param mixed $arr_appRow
	 * @param bool $chk_token (default: false)
	 * @return void
	 */
	function app_chk($arr_appGet, $arr_appRow, $chk_token = false) {
		if ($arr_appGet["str_alert"] != "ok") {
			return $arr_appRow;
		}

		if ($arr_appRow["app_status"] != "enable") {
			return array(
				"str_alert" => "x050402",
			);
			exit;
		}

		$_str_ip = fn_getIp(false);

		if ($arr_appRow["app_ip_allow"]) {
			$_str_ipAllow = str_replace(PHP_EOL, "|", $arr_appRow["app_ip_allow"]);
			if (!fn_regChk($_str_ip, $_str_ipAllow, true)) {
				return array(
					"str_alert" => "x050212",
				);
				exit;
			}
		} else if ($arr_appRow["app_ip_bad"]) {
			$_str_ipBad = str_replace(PHP_EOL, "|", $arr_appRow["app_ip_bad"]);
			if (fn_regChk($_str_ip, $_str_ipBad)) {
				return array(
					"str_alert" => "x050213",
				);
				exit;
			}
		}

		if ($arr_appRow["app_key"] != $arr_appGet["app_key"]) {
			return array(
				"str_alert" => "x050217",
			);
			exit;
		}

		if ($chk_token) {
			if ($arr_appRow["app_token"] != $arr_appGet["app_token"]) {
				return array(
					"str_alert" => "x050220",
				);
				exit;
			}

			if (($arr_appRow["app_token_time"] + $arr_appRow["app_token_expire"]) < time()) {
				return array(
					"str_alert" => "x050221",
				);
				exit;
			}
		}

		return array(
			"str_alert" => "ok",
		);
	}


	/**
	 * app_get function.
	 *
	 * @access public
	 * @param string $str_method (default: "get")
	 * @param bool $chk_token (default: false)
	 * @return void
	 */
	function app_get($str_method = "get", $chk_token = false) {
		if ($str_method == "act_post") {
			$num_appId       = $_POST["app_id"];
			$str_appKey      = $_POST["app_key"];
			$str_appToken    = $_POST["app_token"];
		} else {
			$num_appId       = $_GET["app_id"];
			$str_appKey      = $_GET["app_key"];
			$str_appToken    = $_GET["app_token"];
		}

		$_arr_appId = validateStr($num_appId, 1, 0, "str", "int");
		switch ($_arr_appId["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x050203",
				);
				exit;
			break;

			case "format_err":
				return array(
					"str_alert" => "x050204",
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
					"str_alert" => "x050214",
				);
				exit;
			break;

			case "too_long":
				return array(
					"str_alert" => "x050215",
				);
				exit;
			break;

			case "format_err":
				return array(
					"str_alert" => "x050216",
				);
				exit;
			break;

			case "ok":
				$_arr_appGet["app_key"] = $_arr_appKey["str"];
			break;

		}

		if ($chk_token) {
			$_arr_appToken = validateStr($str_appToken, 1, 64, "str", "alphabetDigit");
			switch ($_arr_appToken["status"]) {
				case "too_short":
					return array(
						"str_alert" => "x050218",
					);
					exit;
				break;

				case "too_long":
					return array(
						"str_alert" => "x050219",
					);
					exit;
				break;

				case "ok":
					$_arr_appGet["app_token"] = $_arr_appToken["str"];
				break;

			}
		}

		$_arr_appGet["str_alert"] = "ok";

		return $_arr_appGet;
	}


	/**
	 * api_notice function.
	 *
	 * @access public
	 * @param mixed $arr_data
	 * @param mixed $arr_appRows
	 * @return void
	 */
	function api_notice($arr_data, $arr_appRows) {
		foreach ($arr_appRows as $_key=>$_value) {
			$_tm_time    = time();
			$_str_rand   = fn_rand();
			$_str_sign   = fn_baigoSignMk($_tm_time, $_str_rand);

			$_arr_query = array(
				"timestamp" => $_tm_time,
				"random"    => $_str_rand,
				"signature" => $_str_sign,
			);

			$_arr_data = array_merge($arr_data, $_arr_query);

			$_arr_return[$_key] = fn_http($_value["app_notice"], $_arr_data, "act_post");
		}

		return $_arr_return;
	}


	/**
	 * api_encode function.
	 *
	 * @access public
	 * @param mixed $arr_data
	 * @param mixed $str_key
	 * @return void
	 */
	function api_encode($arr_data, $str_key) {
		unset($arr_data["str_alert"]);
		$_str_src     = base64_decode(fn_jsonEncode($arr_data, "encode"));
		$_str_code    = fn_baigoEncode($_str_src, $str_key);
		return $_str_code;
	}


	/**
	 * halt_re function.
	 *
	 * @access public
	 * @param mixed $arr_re
	 * @return void
	 */
	function halt_re($arr_re) {
		exit(base64_decode(fn_jsonEncode($arr_re, "encode"))); //输出错误信息
	}
}
?>