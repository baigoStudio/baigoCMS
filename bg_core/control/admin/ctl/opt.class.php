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
include_once(BG_PATH_CLASS . "tpl_admin.class.php");

/*-------------管理员控制器-------------*/
class CONTROL_OPT {

	private $adminLogged;
	private $obj_base;
	private $config; //配置
	private $obj_tpl;
	private $tplData;

	function __construct() { //构造函数
		$this->obj_base       = $GLOBALS["obj_base"];
		$this->config         = $this->obj_base->config;
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_dir        = new CLASS_DIR(); //初始化目录对象
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_SYSTPL_ADMIN . $this->config["ui"]); //初始化视图对象
		$this->tplData = array(
			"adminLogged" => $this->adminLogged
		);
	}


	/**
	 * ctl_upload function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_upload() {
		if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["upload"])) {
			return array(
				"alert" => "x060302",
			);
			exit;
		}

		if(BG_MODULE_FTP == false) {
			unset($this->obj_tpl->opt["upload"]["BG_UPLOAD_URL"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPHOST"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPPORT"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPUSER"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPPASS"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPPATH"], $this->obj_tpl->opt["upload"]["BG_UPLOAD_FTPPASV"]);
		}

		$this->obj_tpl->tplDisplay("opt_upload.tpl", $this->tplData);

		return array(
			"alert" => "y060302",
		);
	}


	/**
	 * ctl_sso function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_sso() {
		if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["sso"])) {
			return array(
				"alert" => "x060303",
			);
			exit;
		}

		$this->obj_tpl->tplDisplay("opt_sso.tpl", $this->tplData);

		return array(
			"alert" => "y060303",
		);
	}


	/**
	 * ctl_visit function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_visit() {
		if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["visit"])) {
			return array(
				"alert" => "x060304",
			);
			exit;
		}

		if(BG_MODULE_GEN == false) {
			unset($this->obj_tpl->opt["visit"]["BG_VISIT_TYPE"]["option"]["static"], $this->obj_tpl->opt["visit"]["BG_VISIT_FILE"]);
		}

		$this->obj_tpl->tplDisplay("opt_visit.tpl", $this->tplData);

		return array(
			"alert" => "y060304",
		);
	}


	/**
	 * ctl_db function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_db() {
		if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["db"])) {
			return array(
				"alert" => "x060306",
			);
			exit;
		}

		$this->obj_tpl->tplDisplay("opt_db.tpl", $this->tplData);

		return array(
			"alert" => "y060306",
		);
	}


	/**
	 * ctl_base function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_base() {
		if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["base"])) {
			return array(
				"alert" => "x060301",
			);
			exit;
		}

		$_arr_tplRows                 = $this->obj_dir->list_dir(BG_PATH_TPL_PUB);
		$_arr_excerptType             = $this->obj_tpl->type["excerpt"];

		$this->tplData["tplRows"]     = $_arr_tplRows;
		$this->tplData["excerptType"] = $_arr_excerptType;

		$this->obj_tpl->tplDisplay("opt_base.tpl", $this->tplData);

		return array(
			"alert" => "y060301",
		);
	}
}
