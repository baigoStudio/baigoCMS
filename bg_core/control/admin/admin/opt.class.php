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

/*-------------管理员控制器-------------*/
class CONTROL_OPT {

	private $adminLogged;
	private $obj_base;
	private $config; //配置
	private $obj_tpl;
	private $mdl_opt;
	private $tplData;

	function __construct() { //构造函数
		$this->obj_base       = $GLOBALS["obj_base"]; //获取界面类型
		$this->config         = $this->obj_base->config;
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_dir        = new CLASS_DIR(); //初始化目录对象
		$this->mdl_opt        = new MODEL_OPT(); //设置管理员模型
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_SYSTPL_ADMIN . $this->config["ui"]);; //初始化视图对象
		$this->tplData = array(
			"adminLogged" => $this->adminLogged
		);
	}


	/**
	 * ctl_upfile function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_upfile() {
		if ($this->adminLogged["admin_allow_sys"]["opt"]["upfile"] != 1) {
			return array(
				"str_alert" => "x060302",
			);
			exit;
		}

		if(!BG_MODULE_FTP) {
			unset($this->obj_tpl->opt["upfile"]["BG_UPFILE_FTPHOST"], $this->obj_tpl->opt["upfile"]["BG_UPFILE_FTPPORT"], $this->obj_tpl->opt["upfile"]["BG_UPFILE_FTPUSER"], $this->obj_tpl->opt["upfile"]["BG_UPFILE_FTPPASS"], $this->obj_tpl->opt["upfile"]["BG_UPFILE_FTPPATH"]);
		}

		foreach ($this->obj_tpl->opt["upfile"] as $_key=>$_value) {
			$_arr_optRows[$_key] = $this->mdl_opt->mdl_read($_key);
		}

		$this->tplData["optRows"] = $_arr_optRows;

		$this->obj_tpl->tplDisplay("opt_upfile.tpl", $this->tplData);

		return array(
			"str_alert" => "y060302",
		);
	}


	/**
	 * ctl_sso function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_sso() {
		if ($this->adminLogged["admin_allow_sys"]["opt"]["sso"] != 1) {
			return array(
				"str_alert" => "x060303",
			);
			exit;
		}

		foreach ($this->obj_tpl->opt["sso"] as $_key=>$_value) {
			$_arr_optRows[$_key] = $this->mdl_opt->mdl_read($_key);
		}

		$this->tplData["optRows"] = $_arr_optRows;

		$this->obj_tpl->tplDisplay("opt_sso.tpl", $this->tplData);

		return array(
			"str_alert" => "y060303",
		);
	}


	/**
	 * ctl_visit function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_visit() {
		if ($this->adminLogged["admin_allow_sys"]["opt"]["visit"] != 1) {
			return array(
				"str_alert" => "x060304",
			);
			exit;
		}

		if(!BG_MODULE_GEN) {
			unset($this->obj_tpl->opt["visit"]["BG_VISIT_TYPE"]["option"]["static"], $this->obj_tpl->opt["visit"]["BG_VISIT_FILE"]);
		}

		foreach ($this->obj_tpl->opt["visit"] as $_key=>$_value) {
			$_arr_optRows[$_key] = $this->mdl_opt->mdl_read($_key);
		}

		$this->tplData["optRows"] = $_arr_optRows;

		$this->obj_tpl->tplDisplay("opt_visit.tpl", $this->tplData);

		return array(
			"str_alert" => "y060304",
		);
	}


	/**
	 * ctl_db function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_db() {
		if ($this->adminLogged["admin_allow_sys"]["opt"]["db"] != 1) {
			return array(
				"str_alert" => "x060306",
			);
			exit;
		}

		$this->obj_tpl->tplDisplay("opt_db.tpl", $this->tplData);

		return array(
			"str_alert" => "y060306",
		);
	}


	/**
	 * ctl_base function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_base() {
		if ($this->adminLogged["admin_allow_sys"]["opt"]["base"] != 1) {
			return array(
				"str_alert" => "x060301",
			);
			exit;
		}

		foreach ($this->obj_tpl->opt["base"] as $_key=>$_value) {
			$_arr_optRows[$_key] = $this->mdl_opt->mdl_read($_key);
		}

		$_arr_optRows["BG_SITE_TPL"]  = $this->mdl_opt->mdl_read("BG_SITE_TPL");
		$_arr_tplRows                 = $this->obj_dir->list_dir(BG_PATH_TPL_PUB);

		$this->tplData["optRows"]     = $_arr_optRows;
		$this->tplData["tplRows"]     = $_arr_tplRows;

		$this->obj_tpl->tplDisplay("opt_base.tpl", $this->tplData);

		return array(
			"str_alert" => "y060301",
		);
	}
}
?>