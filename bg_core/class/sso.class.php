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
	private $arr_result;
	private $arr_decode;

	function __construct() { //构造函数
		$this->arr_data = array(
			"app_id"     => BG_SSO_APPID, //APP ID
			"app_key"    => BG_SSO_APPKEY, //APP KEY
		);
	}


	/** 解码
	 * sso_decode function.
	 *
	 * @access public
	 * @return void
	 */
	function sso_decode() {
		$_arr_sso = array(
			"act_get"    => "decode", //方法
			"code"       => $this->arr_result["code"], //加密串
			"key"        => $this->arr_result["key"], //解码秘钥
		);

		$_arr_ssoData     = array_merge($this->arr_data, $_arr_sso); //合并数组
		$_arr_get         = fn_http(BG_SSO_URL . "?mod=code", $_arr_ssoData, "get"); //提交
		$this->arr_decode = fn_jsonDecode($_arr_get["ret"], "decode"); //将解码得到的JSON解码
	}


	function sso_admin($str_adminName, $str_adminPass) {
		$_arr_sso = array(
			"act_post"   => "add",
			"admin_name"  => $str_adminName,
			"admin_pass"  => md5($str_adminPass),
		);

		$_arr_ssoData     = array_merge($this->arr_data, $_arr_sso); //合并数组
		$_arr_get         = fn_http(BG_SSO_URL . "?mod=admin", $_arr_ssoData, "post"); //提交
		$this->arr_result = json_decode($_arr_get["ret"], true); //将解码得到的JSON解码

		if ($this->arr_result["str_alert"] != "y020101" && $this->arr_result["str_alert"] != "y020103") {
			return $this->arr_result;
			exit;
		}

		$this->sso_decode(); //解码
		$this->arr_decode["str_alert"] = $this->arr_result["str_alert"];

		return $this->arr_decode;
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

		$_arr_ssoData     = array_merge($this->arr_data, $_arr_sso); //合并数组
		$_arr_get         = fn_http(BG_SSO_URL . "?mod=user", $_arr_ssoData, "post"); //提交
		$this->arr_result = json_decode($_arr_get["ret"], true); //将解码得到的JSON解码

		if ($this->arr_result["str_alert"] != "y010101") {
			return $this->arr_result; //返回错误信息
			exit;
		}

		$this->sso_decode(); //解码
		$this->arr_decode["str_alert"] = $this->arr_result["str_alert"];

		return $this->arr_decode;
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

		$_arr_ssoData     = array_merge($this->arr_data, $_arr_sso);
		$_arr_get         = fn_http(BG_SSO_URL . "?mod=user", $_arr_ssoData, "post"); //提交
		$this->arr_result = json_decode($_arr_get["ret"], true);

		if ($this->arr_result["str_alert"] != "y010401") {
			return $this->arr_result; //返回错误信息
			exit;
		}

		$this->sso_decode();
		$this->arr_decode["str_alert"] = $this->arr_result["str_alert"];

		return $this->arr_decode;
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

		$_arr_ssoData     = array_merge($this->arr_data, $_arr_sso);
		$_arr_get         = fn_http(BG_SSO_URL . "?mod=user", $_arr_ssoData, "get"); //提交
		$this->arr_result = json_decode($_arr_get["ret"], true);

		if ($this->arr_result["str_alert"] != "y010102") {
			return $this->arr_result; //返回错误信息
			exit;
		}

		$this->sso_decode();
		$this->arr_decode["str_alert"] = $this->arr_result["str_alert"];

		return $this->arr_decode;
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

		$_arr_ssoData     = array_merge($this->arr_data, $_arr_sso);
		$_arr_get         = fn_http(BG_SSO_URL . "?mod=user", $_arr_ssoData, "post"); //提交

		$this->arr_result = json_decode($_arr_get["ret"], true);

		if ($this->arr_result["str_alert"] != "y010103") {
			return $this->arr_result; //返回错误信息
			exit;
		}

		$this->sso_decode();
		$this->arr_decode["str_alert"] = $this->arr_result["str_alert"];

		return $this->arr_decode;
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

		$_arr_ssoData     = array_merge($this->arr_data, $_arr_sso);
		$_arr_get         = fn_http(BG_SSO_URL . "?mod=user", $_arr_ssoData, "get"); //提交
		$this->arr_result = json_decode($_arr_get["ret"], true);

		if ($this->arr_result["str_alert"] != "y010205") {
			return $this->arr_result; //返回错误信息
			exit;
		}

		$this->sso_decode();
		$this->arr_decode["str_alert"] = $this->arr_result["str_alert"];

		return $this->arr_decode;
	}


	/** 检查Email
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

		$_arr_ssoData     = array_merge($this->arr_data, $_arr_sso);
		$_arr_get         = fn_http(BG_SSO_URL . "?mod=user", $_arr_ssoData, "get"); //提交
		$this->arr_result = json_decode($_arr_get["ret"], true);

		if ($this->arr_result["str_alert"] != "y010211") {
			return $this->arr_result; //返回错误信息
			exit;
		}

		$this->sso_decode();
		$this->arr_decode["str_alert"] = $this->arr_result["str_alert"];

		return $this->arr_decode;
	}
}
?>