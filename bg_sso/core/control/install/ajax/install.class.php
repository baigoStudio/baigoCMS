<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "admin.func.php"); //载入开放平台类
include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "opt.class.php"); //载入管理帐号模型
include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型

class AJAX_INSTALL {

	private $obj_ajax;
	private $obj_db;

	function __construct() { //构造函数
		$this->obj_ajax       = new CLASS_AJAX(); //初始化 AJAX 基对象
		if (file_exists(BG_PATH_CONFIG . "is_install.php")) {
			$this->obj_ajax->halt_alert("x030403");
		}
	}


	/**
	 * install_1_do function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_dbconfig() {
		$_str_dbHost      = fn_getSafe($_POST["db_host"], "txt", "localhost");
		$_str_dbName      = fn_getSafe($_POST["db_name"], "txt", "sso");
		$_str_dbUser      = fn_getSafe($_POST["db_user"], "txt", "sso");
		$_str_dbPass      = fn_getSafe($_POST["db_pass"], "txt", "");
		$_str_dbCharset   = fn_getSafe($_POST["db_charset"], "txt", "utf8");
		$_str_dbTable     = fn_getSafe($_POST["db_table"], "txt", "sso_");

		$_str_content = "<?php" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_HOST\", \"" . $_str_dbHost . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_NAME\", \"" . $_str_dbName . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_USER\", \"" . $_str_dbUser . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_PASS\", \"" . $_str_dbPass . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_CHARSET\", \"" . $_str_dbCharset . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_TABLE\", \"" . $_str_dbTable . "\");" . PHP_EOL;
		$_str_content .= "?>";

		file_put_contents(BG_PATH_CONFIG . "config_db.inc.php", $_str_content);

		$this->obj_ajax->halt_alert("y030404");
	}


	function ajax_dbtable() {
		if (strlen(BG_DB_HOST) < 1 || strlen(BG_DB_NAME) < 1 || strlen(BG_DB_USER) < 1 || strlen(BG_DB_PASS) < 1 || strlen(BG_DB_CHARSET) < 1) {
			$this->obj_ajax->halt_alert("x030404");
		}

		$this->obj_db = new CLASS_MYSQL(); //初始化基类

		$_str_sql = "CREATE TABLE IF NOT EXISTS `" . BG_DB_TABLE . "admin` (
			`admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`admin_name` varchar(30) NOT NULL COMMENT '用户名',
			`admin_pass` varchar(32) NOT NULL COMMENT '密码',
			`admin_rand` varchar(6) NOT NULL COMMENT '随机串',
			`admin_note` varchar(30) NOT NULL COMMENT '备注',
			`admin_status` varchar(20) NOT NULL COMMENT '状态',
			`admin_allow` varchar(3000) NOT NULL COMMENT '权限',
			`admin_time` int(11) NOT NULL COMMENT '创建时间',
			`admin_time_login` int(11) NOT NULL COMMENT '登录时间',
			`admin_ip` varchar(15) NOT NULL COMMENT '最后IP地址',
			PRIMARY KEY (`admin_id`),
			UNIQUE KEY `admin_name` (`admin_name`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理员' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030103");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `" . BG_DB_TABLE . "user` (
			`user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`user_name` varchar(30) NOT NULL COMMENT '用户名',
			`user_mail` varchar(300) NOT NULL COMMENT 'E-mail',
			`user_pass` varchar(32) NOT NULL COMMENT '密码',
			`user_rand` varchar(6) NOT NULL COMMENT '随机串',
			`user_nick` varchar(30) NOT NULL COMMENT '备注',
			`user_status` varchar(20) NOT NULL COMMENT '状态',
			`user_note` varchar(30) NOT NULL COMMENT '备注',
			`user_time` int(11) NOT NULL COMMENT '创建时间',
			`user_time_login` int(11) NOT NULL COMMENT '登录时间',
			`user_ip` varchar(15) NOT NULL COMMENT '最后IP地址',
			PRIMARY KEY (`user_id`),
			UNIQUE KEY `user_name` (`user_name`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030104");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `" . BG_DB_TABLE . "app` (
			`app_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`app_name` varchar(30) NOT NULL COMMENT '应用名',
			`app_key` varchar(64) NOT NULL COMMENT '校验码',
			`app_notice` varchar(3000) NOT NULL COMMENT '通知接口URL',
			`app_token` varchar(64) NOT NULL COMMENT '访问口令',
			`app_token_expire` int(11) NOT NULL COMMENT '口令存活期',
			`app_token_time` int(11) NOT NULL COMMENT '上次授权时间',
			`app_status` varchar(20) NOT NULL COMMENT '状态',
			`app_note` varchar(30) NOT NULL COMMENT '备注',
			`app_time` int(11) NOT NULL COMMENT '创建时间',
			`app_ip_allow` varchar(1000) NOT NULL COMMENT '允许调用IP地址',
			`app_ip_bad` varchar(1000) NOT NULL COMMENT '禁止IP',
			`app_sync` varchar(30) NOT NULL COMMENT '是否同步',
			`app_allow` varchar(3000) NOT NULL COMMENT '权限',
			PRIMARY KEY (`app_id`),
			UNIQUE KEY `app_name` (`app_name`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='应用' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030105");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `" . BG_DB_TABLE . "log` (
			`log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`log_time` int(11) NOT NULL COMMENT '时间',
			`log_operator_id` int(11) NOT NULL COMMENT '操作者 ID',
			`log_targets` text NOT NULL COMMENT '目标 JSON',
			`log_target_type` varchar(20) NOT NULL COMMENT '目标类型',
			`log_title` varchar(1000) NOT NULL COMMENT '操作标题',
			`log_result` varchar(1000) NOT NULL COMMENT '操作结果',
			`log_type` varchar(30) NOT NULL COMMENT '日志类型',
			`log_status` varchar(20) NOT NULL COMMENT '状态',
			`log_level` varchar(30) NOT NULL COMMENT '日志级别',
			PRIMARY KEY (`log_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='日志' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030106");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `" . BG_DB_TABLE . "opt` (
			`opt_key` varchar(100) NOT NULL COMMENT '设置键名',
			`opt_value` varchar(1000) NOT NULL COMMENT '设置键值',
			PRIMARY KEY (`opt_key`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='选项'";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030107");
		}


		$this->obj_ajax->halt_alert("y030103");
	}


	/**
	 * install_2_do function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_base() {
		$_arr_optPost = $this->opt_post("base");

		$this->obj_ajax->halt_alert("y030405");
	}


	/**
	 * install_3_do function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_reg() {
		$_arr_optPost = $this->opt_post("reg");

		$this->obj_ajax->halt_alert("y030406");
	}


	function ajax_admin() {
		if (strlen(BG_DB_HOST) < 1 || strlen(BG_DB_NAME) < 1 || strlen(BG_DB_USER) < 1 || strlen(BG_DB_PASS) < 1 || strlen(BG_DB_CHARSET) < 1) {
			$this->obj_ajax->halt_alert("x030404");
		}

		$GLOBALS["obj_db"]    = new CLASS_MYSQL(); //初始化基类
		$this->mdl_admin      = new MODEL_ADMIN(); //设置管理组模型

		$_arr_adminPost       = fn_adminPost();

		if ($_arr_adminPost["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminPost["str_alert"]);
		}

		$_arr_adminRow = $this->mdl_admin->mdl_read($_arr_adminPost["admin_name"], "admin_name", $_arr_adminPost["admin_id"]);
		if ($_arr_adminRow["str_alert"] == "y020102") {
			$this->obj_ajax->halt_alert("x020204");
		}

		$_arr_adminPass = validateStr($_POST["admin_pass"], 1, 0);
		switch ($_arr_adminPass["status"]) {
			case "too_short":
				$this->obj_ajax->halt_alert("x020205");
			break;

			case "ok":
				$_str_adminPass = $_arr_adminPass["str"];
			break;
		}

		$_arr_adminPassConfirm = validateStr($_POST["admin_pass_confirm"], 1, 0);
		switch ($_arr_adminPassConfirm["status"]) {
			case "too_short":
				$this->obj_ajax->halt_alert("x020211");
			break;

			case "ok":
				$_str_adminPassConfirm = $_arr_adminPassConfirm["str"];
			break;
		}

		if ($_str_adminPass != $_str_adminPassConfirm) {
			$this->obj_ajax->halt_alert("x020206");
		}

		$_str_adminRand      = fn_rand(6);
		$_str_adminPassDo    = fn_baigoEncrypt($_str_adminPass, $_str_adminRand);

		$_arr_adminRow = $this->mdl_admin->mdl_submit(0, $_arr_adminPost["admin_name"], $_str_adminPassDo, $_str_adminRand, $_arr_adminPost["admin_note"], "enable", $_arr_adminPost["admin_allow"]);

		$_str_content = "<?php" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_VER\", " . PRD_SSO_VER . ");" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_PUB\", " . PRD_SSO_PUB . ");" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_TIME\", " . time() . ");" . PHP_EOL;
		$_str_content .= "?>";

		file_put_contents(BG_PATH_CONFIG . "is_install.php", $_str_content);

		$this->obj_ajax->halt_alert("y030407");
	}

	/**
	 * opt_post function.
	 *
	 * @access private
	 * @param mixed $str_type
	 * @return void
	 */
	private function opt_post($str_type) {
		if (strlen(BG_DB_HOST) < 1 || strlen(BG_DB_NAME) < 1 || strlen(BG_DB_USER) < 1 || strlen(BG_DB_PASS) < 1 || strlen(BG_DB_CHARSET) < 1) {
			$this->obj_ajax->halt_alert("x030404");
		}

		$GLOBALS["obj_db"]    = new CLASS_MYSQL(); //初始化基类
		$this->mdl_opt        = new MODEL_OPT(); //设置管理组模型

		$_arr_opt = $_POST["opt"];

		$_str_content = "<?php" . PHP_EOL;
		foreach ($_arr_opt as $_key=>$_value) {
			$_arr_optChk = validateStr($_value, 1, 900);
			$_str_optValue = $_arr_optChk["str"];
			if (is_numeric($_value)) {
				$_str_content .= "define(\"" . $_key . "\", " . $_str_optValue . ");" . PHP_EOL;
			} else {
				$_str_content .= "define(\"" . $_key . "\", \"" . str_replace(PHP_EOL, "|", $_str_optValue) . "\");" . PHP_EOL;
			}
			$_arr_optRow = $this->mdl_opt->mdl_submit($_key, $_str_optValue);
		}

		if ($str_type == "base") {
			$_str_content .= "define(\"BG_SITE_SSIN\", \"" . fn_rand(6) . "\");" . PHP_EOL;
		}

		$_str_content .= "?>";

		$_str_content = str_replace("||", "", $_str_content);

		file_put_contents(BG_PATH_CONFIG . "opt_" . $str_type . ".inc.php", $_str_content);
	}
}
?>