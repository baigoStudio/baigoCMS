<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "dir.class.php"); //载入模板类
include_once(BG_PATH_CLASS . "tpl_admin.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "opt.class.php"); //载入管理帐号模型

class CONTROL_INSTALL {

	private $obj_tpl;
	private $mdl_opt;

	function __construct() { //构造函数
		$this->obj_base   = $GLOBALS["obj_base"];
		$this->config     = $this->obj_base->config;
		$this->obj_tpl    = new CLASS_TPL(BG_PATH_SYSTPL_INSTALL . $this->config["ui"]);
		$this->obj_dir    = new CLASS_DIR(); //初始化目录对象
		$this->install_init();
	}


	function ctl_ext() {
		$this->obj_tpl->tplDisplay("install_ext.tpl", $this->tplData);

		return array(
			"str_alert" => "y030403",
		);
	}

	/**
	 * install_1 function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_dbconfig() {
		if ($this->errCount > 0) {
			return array(
				"str_alert" => "x030417",
			);
			exit;
		}

		$this->obj_tpl->tplDisplay("install_dbconfig.tpl", $this->tplData);

		return array(
			"str_alert" => "y030403",
		);
	}


	/**
	 * install_2 function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_dbtable() {
		if ($this->errCount > 0) {
			return array(
				"str_alert" => "x030417",
			);
			exit;
		}

		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030404",
			);
			exit;
		}

		$this->obj_tpl->tplDisplay("install_dbtable.tpl", $this->tplData);

		return array(
			"str_alert" => "y030404",
		);
	}


	/**
	 * install_3 function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_base() {
		if ($this->errCount > 0) {
			return array(
				"str_alert" => "x030417",
			);
			exit;
		}

		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030404",
			);
			exit;
		}

		if (!$this->check_opt()) {
			return array(
				"str_alert" => "x030412",
			);
			exit;
		}

		foreach ($this->obj_tpl->opt["base"] as $_key=>$_value) {
			$_arr_optRows[$_key] = $this->mdl_opt->mdl_read($_key);
		}

		$_arr_optRows["BG_SITE_TPL"]  = $this->mdl_opt->mdl_read("BG_SITE_TPL");
		$_arr_tplRows                 = $this->obj_dir->list_dir(BG_PATH_TPL_PUB);

		$_arr_tpl = array(
			"optRows"    => $_arr_optRows,
			"tplRows"    => $_arr_tplRows,
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("install_base.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y030404",
		);
	}


	/**
	 * install_4 function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_visit() {
		if ($this->errCount > 0) {
			return array(
				"str_alert" => "x030417",
			);
			exit;
		}

		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030404",
			);
			exit;
		}


		if (!$this->check_opt()) {
			return array(
				"str_alert" => "x030412",
			);
			exit;
		}


		if(BG_MODULE_GEN == false) {
			unset($this->obj_tpl->opt["visit"]["BG_VISIT_TYPE"]["option"]["static"], $this->obj_tpl->opt["visit"]["BG_VISIT_FILE"]);
		}

		foreach ($this->obj_tpl->opt["visit"] as $_key=>$_value) {
			$_arr_optRows[$_key] = $this->mdl_opt->mdl_read($_key);
		}

		$this->tplData["optRows"] = $_arr_optRows;

		$this->obj_tpl->tplDisplay("install_visit.tpl", $this->tplData);

		return array(
			"str_alert" => "y030404",
		);
	}


	/**
	 * install_5 function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_upload() {
		if ($this->errCount > 0) {
			return array(
				"str_alert" => "x030417",
			);
			exit;
		}

		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030404",
			);
			exit;
		}


		if (!$this->check_opt()) {
			return array(
				"str_alert" => "x030412",
			);
			exit;
		}


		if(BG_MODULE_FTP == false) {
			unset($this->obj_tpl->opt["upload"]["BG_UPLOAD_URL"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPHOST"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPPORT"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPUSER"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPPASS"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPPATH"]);
		}

		foreach ($this->obj_tpl->opt["upload"] as $_key=>$_value) {
			$_arr_optRows[$_key] = $this->mdl_opt->mdl_read($_key);
		}

		$this->tplData["optRows"] = $_arr_optRows;

		$this->obj_tpl->tplDisplay("install_upload.tpl", $this->tplData);

		return array(
			"str_alert" => "y030404",
		);
	}


	/**
	 * install_6 function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_sso() {
		if ($this->errCount > 0) {
			return array(
				"str_alert" => "x030417",
			);
			exit;
		}

		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030404",
			);
			exit;
		}


		if (!$this->check_opt()) {
			return array(
				"str_alert" => "x030412",
			);
			exit;
		}

		foreach ($this->obj_tpl->opt["sso"] as $_key=>$_value) {
			$_arr_optRows[$_key] = $this->mdl_opt->mdl_read($_key);
		}

		$this->tplData["optRows"] = $_arr_optRows;

		$this->obj_tpl->tplDisplay("install_sso.tpl", $this->tplData);

		return array(
			"str_alert" => "y030404",
		);
	}


	/**
	 * install_7 function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_ssoAuto() {
		if ($this->errCount > 0) {
			return array(
				"str_alert" => "x030417",
			);
			exit;
		}

		if (file_exists(BG_PATH_SSO . "config/is_install.php")) {
			return array(
				"str_alert" => "x030408",
			);
			exit;
		}


		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030412",
			);
			exit;
		}


		if (!$this->check_opt()) {
			return array(
				"str_alert" => "x030412",
			);
			exit;
		}

		$_arr_tpl = array(
			"url"    => base64_encode(BG_URL_INSTALL),
			"path"   => base64_encode(BG_PATH_CONFIG),
			"target" => "cms",
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("install_ssoAuto.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y030404",
		);
	}


	function ctl_ssoAdmin() {
		if ($this->errCount > 0) {
			return array(
				"str_alert" => "x030417",
			);
			exit;
		}

		if (file_exists(BG_PATH_SSO . "config/is_install.php")) {
			return array(
				"str_alert" => "x030408",
			);
			exit;
		}


		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030412",
			);
			exit;
		}


		if (!$this->check_opt()) {
			return array(
				"str_alert" => "x030412",
			);
			exit;
		}

		$this->obj_tpl->tplDisplay("install_ssoAdmin.tpl", $this->tplData);

		return array(
			"str_alert" => "y030404",
		);
	}


	/**
	 * install_8 function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_admin() {
		if ($this->errCount > 0) {
			return array(
				"str_alert" => "x030417",
			);
			exit;
		}

		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030404",
			);
			exit;
		}

		if (!$this->check_opt()) {
			return array(
				"str_alert" => "x030412",
			);
			exit;
		}

		$this->obj_tpl->tplDisplay("install_admin.tpl", $this->tplData);

		return array(
			"str_alert" => "y030404",
		);
	}


	function ctl_auth() {
		if ($this->errCount > 0) {
			return array(
				"str_alert" => "x030417",
			);
			exit;
		}

		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030404",
			);
			exit;
		}

		if (!$this->check_opt()) {
			return array(
				"str_alert" => "x030412",
			);
			exit;
		}

		$this->obj_tpl->tplDisplay("install_auth.tpl", $this->tplData);

		return array(
			"str_alert" => "y030404",
		);
	}


	function ctl_over() {
		if ($this->errCount > 0) {
			return array(
				"str_alert" => "x030417",
			);
			exit;
		}

		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030404",
			);
			exit;
		}

		if (!$this->check_opt()) {
			return array(
				"str_alert" => "x030412",
			);
			exit;
		}

		$this->obj_tpl->tplDisplay("install_over.tpl", $this->tplData);

		return array(
			"str_alert" => "y030404",
		);
	}


	private function check_db() {
		if (strlen(BG_DB_HOST) < 1 || strlen(BG_DB_NAME) < 1 || strlen(BG_DB_USER) < 1 || strlen(BG_DB_PASS) < 1 || strlen(BG_DB_CHARSET) < 1) {
			return false;
			exit;
		} else {
			if (!defined("BG_DB_PORT")) {
				define("BG_DB_PORT", "3306");
			}

			$_cfg_host = array(
				"host"      => BG_DB_HOST,
				"name"      => BG_DB_NAME,
				"user"      => BG_DB_USER,
				"pass"      => BG_DB_PASS,
				"charset"   => BG_DB_CHARSET,
				"debug"     => BG_DB_DEBUG,
				"port"      => BG_DB_PORT,
			);

			$GLOBALS["obj_db"]   = new CLASS_MYSQLI($_cfg_host); //设置数据库对象
			$this->obj_db        = $GLOBALS["obj_db"];

			if (!$this->obj_db->connect()) {
				return false;
				exit;
			}

			if (!$this->obj_db->select_db()) {
				return false;
				exit;
			}

			$this->mdl_opt       = new MODEL_OPT(); //设置管理员模型
			return true;
		}
	}


	private function check_opt() {
		$_arr_tableRows = $this->obj_db->show_tables();

		foreach ($_arr_tableRows as $_key=>$_value) {
			$_arr_tables[] = $_value["Tables_in_" . BG_DB_NAME];
		}

		if (!in_array(BG_DB_TABLE . "opt", $_arr_tables)) {
			return false;
		} else {
			return true;
		}
	}


	private function install_init() {
		$_arr_extRow      = get_loaded_extensions();
		$this->errCount   = 0;

		foreach ($this->obj_tpl->type["ext"] as $_key=>$_value) {
			if (!in_array($_key, $_arr_extRow)) {
				$this->errCount++;
			}
		}

		$this->tplData = array(
			"errCount"   => $this->errCount,
			"extRow"     => $_arr_extRow,
		);
	}
}
