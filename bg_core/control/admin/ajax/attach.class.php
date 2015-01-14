<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_CLASS . "dir.class.php"); //载入文件操作类
if (BG_MODULE_FTP == true) {
	include_once(BG_PATH_CLASS . "ftp.class.php"); //载入 FTP 类
}
include_once(BG_PATH_CLASS . "upload.class.php"); //载入上传类
include_once(BG_PATH_MODEL . "attach.class.php");
include_once(BG_PATH_MODEL . "thumb.class.php");
include_once(BG_PATH_MODEL . "mime.class.php");

/*-------------用户类-------------*/
class AJAX_ATTACH {

	private $adminLogged;
	private $obj_ajax;
	private $mdl_attach;
	private $attachThumb;
	private $attachMime;

	function __construct() { //构造函数
		$this->adminLogged        = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_ajax           = new CLASS_AJAX();
		$this->obj_upload         = new CLASS_UPLOAD();
		$this->mdl_attach         = new MODEL_ATTACH();
		$this->mdl_thumb          = new MODEL_THUMB();
		$this->mdl_mime           = new MODEL_MIME();
		$this->mdl_admin          = new MODEL_ADMIN();
		$this->setUpload();
	}


	/**
	 * ajax_submit function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_submit() {
		if ($this->adminLogged["str_alert"] != "y020102") { //未登录，抛出错误信息
			$this->show_err($this->adminLogged["str_alert"]);
		}

		if ($this->adminLogged["groupRow"]["group_allow"]["attach"]["upload"] != 1) {
			$this->show_err("x070302");
		}

		if (!fn_token("chk")) { //令牌
			$this->show_err("x030102");
		}

		if (!is_array($this->attachMime)) {
			$this->show_err("x070405");
		}

		$_arr_uploadRow = $this->obj_upload->upload_pre();

		if ($_arr_uploadRow["str_alert"] != "y100201") {
			$this->show_err($_arr_uploadRow["str_alert"]);
		}

		$_arr_attachRow = $this->mdl_attach->mdl_submit($_arr_uploadRow["attach_name"], $_arr_uploadRow["attach_ext"], $_arr_uploadRow["attach_size"], $this->adminLogged["admin_id"]);

		if ($_arr_attachRow["str_alert"] != "y070101") {
			$this->show_err($_arr_attachRow["str_alert"]);
		}

		$_arr_uploadRowSubmit = $this->obj_upload->upload_submit($_arr_attachRow["attach_time"], $_arr_attachRow["attach_id"]);
		if ($_arr_uploadRowSubmit["str_alert"] != "y070401") {
			$this->show_err($_arr_uploadRowSubmit["str_alert"]);
		}
		$_arr_uploadRowSubmit["attach_id"]    = $_arr_attachRow["attach_id"];
		$_arr_uploadRowSubmit["attach_ext"]   = $_arr_uploadRow["attach_ext"];
		$_arr_uploadRowSubmit["attach_name"]  = $_arr_uploadRow["attach_name"];

		if (in_array($_arr_uploadRow["attach_ext"], $this->obj_upload->config["img_ext"])) {
			$_arr_uploadRowSubmit["attach_type"] = "image";
		} else {
			$_arr_uploadRowSubmit["attach_type"] = "file";
		}

		exit(json_encode($_arr_uploadRowSubmit));
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if ($this->adminLogged["str_alert"] != "y020102") { //未登录，抛出错误信息
			$this->show_err($this->adminLogged["str_alert"]);
		}

		if ($this->adminLogged["groupRow"]["group_allow"]["attach"]["del"] == 1) {
			$_num_adminId = 0;
		} else {
			$_num_adminId = $this->adminLogged["admin_id"];
		}

		$_arr_attachIds = $this->mdl_attach->input_ids();
		if ($_arr_attachIds["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_attachIds["str_alert"]);
		}

		$_arr_attachRow = $this->mdl_attach->mdl_listArr($_num_adminId);
		$this->obj_upload->upload_del($_arr_attachRow);

		$_arr_attachDel = $this->mdl_attach->mdl_del($_num_adminId);

		$this->obj_ajax->halt_alert($_arr_attachDel["str_alert"]);
	}


	/**
	 * ajax_list function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_list() {
		if ($this->adminLogged["str_alert"] != "y020102") { //未登录，抛出错误信息
			$this->obj_ajax->halt_alert($this->adminLogged["str_alert"]);
		}

		if ($this->adminLogged["groupRow"]["group_allow"]["attach"]["browse"] != 1) {
			$this->obj_ajax->halt_alert("x070301");
		}

		$_act_get         = fn_getSafe($GLOBALS["act_get"], "txt", "");
		$_str_year        = fn_getSafe(fn_get("year"), "txt", "");
		$_str_month       = fn_getSafe(fn_get("month"), "txt", "");
		$_str_ext         = fn_getSafe(fn_get("ext"), "txt", "");
		$_num_adminId     = fn_getSafe(fn_get("admin_id"), "int", 0);

		$_num_perPage     = 8;
		$_num_attachCount = $this->mdl_attach->mdl_count($_str_year, $_str_month, $_str_ext, $_num_adminId);
		$_arr_page        = fn_page($_num_attachCount, $_num_perPage);
		$_arr_attachRows  = $this->mdl_attach->mdl_list($_num_perPage, $_arr_page["except"], $_str_year, $_str_month, $_str_ext, $_num_adminId);

		foreach ($_arr_attachRows as $_key=>$_value) {
			if (in_array($_value["attach_ext"], $this->obj_upload->config["img_ext"])) {
				$_arr_attachRows[$_key]["attach_type"]  = "image";
				$_arr_thumb                             = $this->mdl_attach->url_process($_value["attach_id"], $_value["attach_time"], $_value["attach_ext"], $this->attachThumb);
				$_arr_attachRows[$_key]["attach_url"]   = $_arr_thumb["attach_url"];
				$_arr_attachRows[$_key]["attach_thumb"] = $_arr_thumb["attach_thumb"];
			} else {
				$_arr_attachRows[$_key]["attach_type"] = "file";
			}
			$_arr_adminRow                                = $this->mdl_admin->mdl_read($_value["attach_admin_id"]);
			$_arr_attachRows[$_key]["attach_admin_name"]  = $_arr_adminRow["admin_name"];
			$_arr_attachRows[$_key]["attach_admin_note"]  = $_arr_adminRow["admin_note"];
		}

		//print_r($_arr_page);

		$_arr_tpl = array(
			"pageRow"    => $_arr_page,
			"attachRows" => $_arr_attachRows, //上传信息
		);

		exit(json_encode($_arr_tpl));
	}


	/**
	 * show_err function.
	 *
	 * @access private
	 * @param mixed $str_alert
	 * @return void
	 */
	private function show_err($str_alert) {
		$_arr_re = array(
			"str_alert"  => $str_alert,
			"msg"        => $this->obj_ajax->halt_alert[$str_alert],
		);
		if ($str_alert == "x070203") {
			$_arr_re["msg"] = $this->obj_ajax->halt_alert[$str_alert] . " " . BG_UPLOAD_SIZE . " " . BG_UPLOAD_UNIT;
		}
		exit(json_encode($_arr_re));
	}


	/**
	 * setUpload function.
	 *
	 * @access private
	 * @return void
	 */
	private function setUpload() {
		$this->attachThumb    = $this->mdl_thumb->mdl_list(100);
		$_arr_mimeRows        = $this->mdl_mime->mdl_list(100);
		foreach ($_arr_mimeRows as $_value) {
			$this->attachMime[] = $_value["mime_ext"];
		}

		$_arr_status = $this->obj_upload->upload_init($this->attachMime, $this->attachThumb);
		if ($_arr_status["str_alert"] != "y070403") {
			$this->show_err($_arr_status["str_alert"]);
		}
	}
}
?>