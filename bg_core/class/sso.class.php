<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------单点登录类-------------*/
class CLASS_SSO {

	private $arr_data;

	function __construct() { //构造函数
		$this->arr_data = array(
			"app_id"     => BG_SSO_APPID, //APP ID
			"app_key"    => BG_SSO_APPKEY, //APP KEY
		);
	}


	/** 编码
	 * sso_encode function.
	 *
	 * @access public
	 * @param mixed $_str_json
	 * @return void
	 */
	function sso_encode($arr_data) {
		$_arr_json    = array_merge($this->arr_data, $arr_data); //合并数组
		$_str_json    = fn_jsonEncode($_arr_json, "encode");

		$_arr_sso = array(
			"act_post"   => "encode", //方法
			"data"       => $_str_json,
		);

		$_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
		$_arr_get     = fn_http(BG_SSO_URL . "?mod=code", $_arr_ssoData, "post"); //提交

		return fn_jsonDecode($_arr_get["ret"], "no");
	}


	/** 解码
	 * sso_decode function.
	 *
	 * @access public
	 * @return void
	 */
	function sso_decode($str_code, $str_key) {
		$_arr_sso = array(
			"act_get"    => "decode", //方法
			"code"       => $str_code, //加密串
			"key"        => $str_key, //解码秘钥
		);

		$_arr_ssoData     = array_merge($this->arr_data, $_arr_sso); //合并数组
		$_arr_get         = fn_http(BG_SSO_URL . "?mod=code", $_arr_ssoData, "get"); //提交

		return fn_jsonDecode($_arr_get["ret"], "decode");
	}


	/** 签名
	 * sso_signature function.
	 *
	 * @access public
	 * @param mixed $tm_time
	 * @param mixed $str_rand
	 * @return void
	 */
	function sso_signature($tm_time, $str_rand) {
		$_arr_sso = array(
			"act_get"    => "signature", //方法
			"time"       => $tm_time,
			"random"     => $str_rand,
		);

		$_arr_ssoData     = array_merge($this->arr_data, $_arr_sso); //合并数组
		$_arr_get         = fn_http(BG_SSO_URL . "?mod=signature", $_arr_ssoData, "get"); //提交

		return fn_jsonDecode($_arr_get["ret"], "no");
	}


	/** 验证签名
	 * sso_verify function.
	 *
	 * @access public
	 * @param mixed $tm_time
	 * @param mixed $str_rand
	 * @param mixed $str_sign
	 * @return void
	 */
	function sso_verify($tm_time, $str_rand, $str_sign) {
		$_arr_sso = array(
			"act_get"    => "verify", //方法
			"time"       => $tm_time,
			"random"     => $str_rand,
			"signature"  => $str_sign,
		);

		$_arr_ssoData     = array_merge($this->arr_data, $_arr_sso); //合并数组
		$_arr_get         = fn_http(BG_SSO_URL . "?mod=signature", $_arr_ssoData, "get"); //提交

		return fn_jsonDecode($_arr_get["ret"], "no");
	}


	/** 管理员
	 * sso_admin function.
	 *
	 * @access public
	 * @param mixed $str_adminName
	 * @param mixed $str_adminPass
	 * @return void
	 */
	function sso_admin($str_adminName, $str_adminPass) {
		$_arr_sso = array(
			"act_post"   => "add",
			"admin_name" => $str_adminName,
			"admin_pass" => md5($str_adminPass),
		);

		$_arr_ssoData = array_merge($this->arr_data, $_arr_sso); //合并数组
		$_arr_get     = fn_http(BG_SSO_URL . "?mod=admin", $_arr_ssoData, "post"); //提交
		$_arr_result  = $this->result_process($_arr_get);

		if ($_arr_result["alert"] != "y020101" && $_arr_result["alert"] != "y020103") {
			return $_arr_result;
			exit;
		}

		$_arr_decode          = $this->sso_decode($_arr_result["code"], $_arr_result["key"]); //解码
		$_arr_decode["alert"] = $_arr_result["alert"];

		return $_arr_decode;
	}


	/** 注册
	 * sso_reg function.
	 *
	 * @access public
	 * @param mixed $str_userName 用户名
	 * @param mixed $str_userPass 密码
	 * @param string $str_userMail (default: "") Email
	 * @param string $str_userNick (default: "") 昵称
	 * @return 解码后数组 注册结果
	 */
	function sso_reg($str_userName, $str_userPass, $str_userMail = "", $str_userNick = "") {
		$_arr_sso = array(
			"act_post"   => "reg",
			"user_name"  => $str_userName,
			"user_pass"  => md5($str_userPass),
			"user_mail"  => $str_userMail,
			"user_nick"  => $str_userNick,
		);

		$_arr_ssoData = array_merge($this->arr_data, $_arr_sso); //合并数组
		$_arr_get      = fn_http(BG_SSO_URL . "?mod=user", $_arr_ssoData, "post"); //提交
		$_arr_result  = $this->result_process($_arr_get);

		if ($_arr_result["alert"] != "y010101") {
			return $_arr_result; //返回错误信息
			exit;
		}

		$_arr_decode          = $this->sso_decode($_arr_result["code"], $_arr_result["key"]); //解码
		$_arr_decode["alert"] = $_arr_result["alert"];

		return $_arr_decode;
	}


	/** 登录
	 * sso_login function.
	 *
	 * @access public
	 * @param mixed $str_userName 用户名
	 * @param mixed $str_userPass 密码
	 * @return 解码后数组 登录结果
	 */
	function sso_login($str_userName, $str_userPass) {
		$_arr_sso = array(
			"act_post"   => "login",
			"user_by"    => "user_name",
			"user_name"  => $str_userName,
			"user_pass"  => md5($str_userPass),
		);

		$_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
		$_arr_get     = fn_http(BG_SSO_URL . "?mod=user", $_arr_ssoData, "post"); //提交
		$_arr_result  = $this->result_process($_arr_get);

		if ($_arr_result["alert"] != "y010401") {
			return $_arr_result; //返回错误信息
			exit;
		}

		$_arr_decode          = $this->sso_decode($_arr_result["code"], $_arr_result["key"]); //解码
		$_arr_decode["alert"] = $_arr_result["alert"];

		return $_arr_decode;
	}


	/** 同步登录
	 * sso_sync_login function.
	 *
	 * @access public
	 * @param mixed $num_userId
	 * @return void
	 */
	function sso_sync_login($num_userId) {
		$_str_key             = fn_rand(6);
		$_arr_data["user_id"] = $num_userId;
		$_arr_code            = $this->sso_encode($_arr_data);

		$_tm_time             = time();
		$_str_rand            = fn_rand();
		$_arr_signature       = $this->sso_signature($_tm_time, $_str_rand);

		$_arr_ssoData = array(
			"act_get"    => "login",
			"time"       => $_tm_time,
			"random"     => $_str_rand,
			"signature"  => $_arr_signature["signature"],
			"code"       => $_arr_code["code"],
			"key"        => $_arr_code["key"],
		);

		$_arr_get             = fn_http(BG_SSO_URL . "?mod=sync", $_arr_ssoData, "get"); //提交
		$_arr_result          = $this->result_process($_arr_get);
		$_arr_result["html"]  = base64_decode($_arr_result["html"]);

		return $_arr_result;
	}


	/** 读取用户信息
	 * sso_get function.
	 *
	 * @access public
	 * @param mixed $str_user ID（或用户名）
	 * @param string $str_by (default: "user_id") 用何种方式读取（默认用ID）
	 * @return 解码后数组 用户信息
	 */
	function sso_get($str_user, $str_by = "user_id") {
		$_arr_sso = array(
			"act_get"    => "get",
			"user_by"    => $str_by,
			"user_id"    => $str_user,
			"user_name"  => $str_user,
		);

		$_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
		$_arr_get     = fn_http(BG_SSO_URL . "?mod=user", $_arr_ssoData, "get"); //提交
		$_arr_result  = $this->result_process($_arr_get);

		if ($_arr_result["alert"] != "y010102") {
			return $_arr_result; //返回错误信息
			exit;
		}

		$_arr_decode          = $this->sso_decode($_arr_result["code"], $_arr_result["key"]); //解码
		$_arr_decode["alert"] = $_arr_result["alert"];

		return $_arr_decode;
	}


	/** 编辑用户
	 * sso_edit function.
	 *
	 * @access public
	 * @param mixed $str_userName 用户名
	 * @param string $str_userPass (default: "") 密码
	 * @param string $str_userPassNew (default: "") 新密码
	 * @param string $str_userMail (default: "") Email
	 * @param string $str_userNick (default: "") 昵称
	 * @param string $str_userBy (default: "user_name") 用何种方式编辑（默认用用户名）
	 * @param string $str_checkPass (default: "off") 是否验证密码（默认不验证）
	 * @return 解码后数组 编辑结果
	 */
	function sso_edit($str_userName, $str_userPass = "", $str_userPassNew = "", $str_userMail = "", $str_userNick = "", $str_userBy = "user_name", $str_checkPass = false) {
		if ($str_userPassNew) {
			$_str_userPassNew = md5($str_userPassNew);
		} else {
			$_str_userPassNew = "";
		}

		$_arr_sso = array(
			"act_post"           => "edit",
			"user_by"            => $str_userBy,
			$str_userBy          => $str_userName,
			"user_check_pass"    => $str_checkPass,
			"user_pass"          => md5($str_userPass),
			"user_pass_new"      => $_str_userPassNew,
			"user_mail"          => $str_userMail,
			"user_nick"          => $str_userNick,
		);

		$_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
		$_arr_get     = fn_http(BG_SSO_URL . "?mod=user", $_arr_ssoData, "post"); //提交
		$_arr_result  = $this->result_process($_arr_get);

		if ($_arr_result["alert"] != "y010103") {
			return $_arr_result; //返回错误信息
			exit;
		}

		$_arr_decode          = $this->sso_decode($_arr_result["code"], $_arr_result["key"]); //解码
		$_arr_decode["alert"] = $_arr_result["alert"];

		return $_arr_decode;
	}


	/** 检查用户名
	 * sso_chkname function.
	 *
	 * @access public
	 * @param mixed $str_userName 用户名
	 * @return 解码后数组 检查结果
	 */
	function sso_chkname($str_userName) {
		$_arr_sso = array(
			"act_get"    => "check_name",
			"user_name"  => $str_userName,
		);

		$_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
		$_arr_get     = fn_http(BG_SSO_URL . "?mod=user", $_arr_ssoData, "get"); //提交
		$_arr_result  = $this->result_process($_arr_get);

		if ($_arr_result["alert"] != "y010205") {
			return $_arr_result; //返回错误信息
			exit;
		}

		//$this->sso_decode();
		$_arr_decode["alert"] = $_arr_result["alert"];

		return $_arr_decode;
	}


	/** 检查 Email
	 * sso_chkmail function.
	 *
	 * @access public
	 * @param mixed $str_userMail Email
	 * @param int $num_userId (default: 0) 当前用户ID（默认为0，忽略）
	 * @return 解码后数组 检查结果
	 */
	function sso_chkmail($str_userMail, $num_userId = 0) {
		$_arr_sso = array(
			"act_get"    => "check_mail",
			"user_mail"  => $str_userMail,
			"user_id"    => $num_userId,
		);

		$_arr_ssoData = array_merge($this->arr_data, $_arr_sso);
		$_arr_get     = fn_http(BG_SSO_URL . "?mod=user", $_arr_ssoData, "get"); //提交
		$_arr_result  = $this->result_process($_arr_get);

		if ($_arr_result["alert"] != "y010211") {
			return $_arr_result; //返回错误信息
			exit;
		}

		//$this->sso_decode();
		$_arr_decode["alert"] = $_arr_result["alert"];

		return $_arr_decode;
	}


	/**
	 * result_process function.
	 *
	 * @access private
	 * @return void
	 */
	private function result_process($arr_get) {
		if (!isset($arr_get["ret"])) {
			$_arr_result = array(
				"alert" => "x030110"
			);
			return $_arr_result;
			exit;
		}

		$_arr_result = json_decode($arr_get["ret"], true);
		if (!isset($_arr_result["alert"])) {
			$_arr_result = array(
				"alert" => "x030110"
			);
			return $_arr_result;
			exit;
		}

		if (!isset($_arr_result["prd_sso_pub"]) || $_arr_result["prd_sso_pub"] < 20150713) {
			$_arr_result = array(
				"alert" => "x030114"
			);
			return $_arr_result;
			exit;
		}

		$_arr_result["alert"]   = str_replace("x030410", "x030413", $_arr_result["alert"]);
		$_arr_result["alert"]   = str_replace("x030411", "x030414", $_arr_result["alert"]);

		return $_arr_result;
	}
}
