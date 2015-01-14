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
include_once(BG_PATH_CLASS . "tpl.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "opt.class.php"); //载入管理帐号模型

class CONTROL_UPGRADE {

	private $obj_tpl;
	private $mdl_opt;

	function __construct() { //构造函数
		$this->obj_tpl    = new CLASS_TPL(BG_PATH_SYSTPL_INSTALL);
		$this->obj_dir    = new CLASS_DIR(); //初始化目录对象
	}


	/**
	 * upgrade_2 function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_dbtable() {
		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030404",
			);
			exit;
		}

		$_arr_tplData = array();

		$this->obj_tpl->tplDisplay("upgrade_dbtable.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y030404",
		);
	}


	/**
	 * upgrade_3 function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_base() {
		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030404",
			);
			exit;
		}


		if (!$this->check_db()) {
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
		$_arr_tplData = array(
			"optRows"    => $_arr_optRows,
			"tplRows"    => $_arr_tplRows,
		);

		$this->obj_tpl->tplDisplay("upgrade_base.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y030404",
		);
	}


	/**
	 * upgrade_4 function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_visit() {
		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030404",
			);
			exit;
		}

		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030412",
			);
			exit;
		}

		if(!BG_MODULE_GEN) {
			unset($this->obj_tpl->opt["visit"]["BG_VISIT_TYPE"]["option"]["static"], $this->obj_tpl->opt["visit"]["BG_VISIT_FILE"]);
		}

		foreach ($this->obj_tpl->opt["visit"] as $_key=>$_value) {
			$_arr_optRows[$_key] = $this->mdl_opt->mdl_read($_key);
		}

		$_arr_tplData["optRows"] = $_arr_optRows;

		$this->obj_tpl->tplDisplay("upgrade_visit.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y030404",
		);
	}


	/**
	 * upgrade_5 function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_upload() {
		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030404",
			);
			exit;
		}


		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030412",
			);
			exit;
		}


		if(!BG_MODULE_FTP) {
			unset($this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPHOST"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPPORT"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPUSER"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPPASS"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPPATH"]);
		}

		foreach ($this->obj_tpl->opt["upload"] as $_key=>$_value) {
			$_arr_optRows[$_key] = $this->mdl_opt->mdl_read($_key);
		}

		$_arr_tplData["optRows"] = $_arr_optRows;

		$this->obj_tpl->tplDisplay("upgrade_upload.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y030404",
		);
	}


	/**
	 * upgrade_6 function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_sso() {
		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030404",
			);
			exit;
		}


		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030412",
			);
			exit;
		}

		foreach ($this->obj_tpl->opt["sso"] as $_key=>$_value) {
			$_arr_optRows[$_key] = $this->mdl_opt->mdl_read($_key);
		}

		$_arr_tplData["optRows"] = $_arr_optRows;

		$this->obj_tpl->tplDisplay("upgrade_sso.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y030404",
		);
	}


	function ctl_over() {
		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030404",
			);
			exit;
		}


		if (!$this->check_db()) {
			return array(
				"str_alert" => "x030412",
			);
			exit;
		}

		$_arr_tplData = array();

		$this->obj_tpl->tplDisplay("upgrade_over.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y030404",
		);
	}


	private function check_db() {
		if (strlen(BG_DB_HOST) < 1 || strlen(BG_DB_NAME) < 1 || strlen(BG_DB_USER) < 1 || strlen(BG_DB_PASS) < 1 || strlen(BG_DB_CHARSET) < 1) {
			return false;
		} else {
			$GLOBALS["obj_db"]   = new CLASS_MYSQL(); //设置数据库对象
			$this->mdl_opt       = new MODEL_OPT(); //设置管理员模型
			return true;
		}
	}


	private function check_opt() {
		$_arr_tableSelect = array(
			"table_name",
		);

		$_str_sqlWhere    = "table_schema='" . BG_DB_NAME . "'";
		$_arr_tableRows   = $GLOBALS["obj_db"]->select_array("information_schema`.`tables", $_arr_tableSelect, $_str_sqlWhere, 100, 0);

		foreach ($_arr_tableRows as $_key=>$_value) {
			$_arr_chks[] = $_value["table_name"];
		}

		if (!in_array(BG_DB_TABLE . "opt", $_arr_chks)) {
			return false;
		} else {
			return true;
		}
	}
}
?>