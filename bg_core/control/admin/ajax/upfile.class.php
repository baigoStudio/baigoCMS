<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "upfile.func.php"); //载入 http
include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_CLASS . "dir.class.php"); //载入文件操作类
if (BG_MODULE_FTP == true) {
	include_once(BG_PATH_CLASS . "ftp.class.php"); //载入 FTP 类
}
include_once(BG_PATH_CLASS . "upload.class.php"); //载入上传类
include_once(BG_PATH_MODEL . "upfile.class.php"); //载入上传模型
include_once(BG_PATH_MODEL . "thumb.class.php"); //载入上传模型
include_once(BG_PATH_MODEL . "mime.class.php"); //载入上传模型

/*-------------用户类-------------*/
class AJAX_UPFILE {

	private $adminLogged;
	private $obj_ajax;
	private $mdl_upfile;
	private $arr_thumb;
	private $arr_mime;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_ajax       = new CLASS_AJAX(); //获取界面类型
		$this->obj_upload     = new CLASS_UPLOAD(); //获取界面类型
		$this->mdl_upfile     = new MODEL_UPFILE(); //设置管理员对象
		$this->mdl_thumb      = new MODEL_THUMB(); //设置上传信息对象
		$this->mdl_mime       = new MODEL_MIME(); //设置上传信息对象
		$this->setUpload();
	}

	/*============添加允许类型============
	返回数组
		upfile_id 上传 ID
		str_alert 提示信息
	*/
	function ajax_submit() {
		if ($this->adminLogged["str_alert"] != "y020102") { //未登录，抛出错误信息
			$this->show_err($this->adminLogged["str_alert"]);
		}

		if ($this->adminLogged["admin_allow_sys"]["upfile"]["upload"] != 1) {
			$this->show_err("x070302");
		}

		if (!fn_token("chk", "post", "post")) { //令牌
			$this->show_err("x030102");
		}

		if (!is_array($this->arr_mime)) {
			$this->show_err("x070405");
		}

		$_arr_uploadRow = $this->obj_upload->upload_pre();

		if ($_arr_uploadRow["str_alert"] != "y100201") {
			$this->show_err($_arr_uploadRow["str_alert"]);
		}

		$_arr_upfileRow = $this->mdl_upfile->mdl_submit($_arr_uploadRow["upfile_name"], $_arr_uploadRow["upfile_ext"], $_arr_uploadRow["upfile_size"], $this->adminLogged["admin_id"]);

		if ($_arr_upfileRow["str_alert"] != "y070101") {
			$this->show_err($_arr_upfileRow["str_alert"]);
		}

		$_arr_uploadRowSubmit = $this->obj_upload->upload_submit($_arr_upfileRow["upfile_time"], $_arr_upfileRow["upfile_id"]);
		if ($_arr_uploadRowSubmit["str_alert"] != "y070401") {
			$this->show_err($_arr_uploadRowSubmit["str_alert"]);
		}
		$_arr_uploadRowSubmit["upfile_id"]    = $_arr_upfileRow["upfile_id"];
		$_arr_uploadRowSubmit["upfile_ext"]   = $_arr_uploadRow["upfile_ext"];

		if (in_array($_arr_uploadRow["upfile_ext"], $this->obj_upload->config["img_ext"])) {
			$_arr_uploadRowSubmit["upfile_type"] = "image";
		} else {
			$_arr_uploadRowSubmit["upfile_type"] = "file";
		}

		exit(json_encode($_arr_uploadRowSubmit));
	}


	/*============删除允许类型============
	返回提示信息
	*/
	function ajax_del() {
		if ($this->adminLogged["str_alert"] != "y020102") { //未登录，抛出错误信息
			$this->show_err($this->adminLogged["str_alert"]);
		}

		if ($this->adminLogged["admin_allow_sys"]["upfile"]["del"] == 1) {
			$_num_adminId = 0;
		} else {
			$_num_adminId = $this->adminLogged["admin_id"];
		}

		$_arr_upfileDo = fn_upfileDo();
		if ($_arr_upfileDo["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_upfileDo["str_alert"]);
		}

		$_arr_upfileRow = $this->mdl_upfile->mdl_listArr($_arr_upfileDo["upfile_ids"], $_num_adminId);
		$this->obj_upload->upload_del($_arr_upfileRow);

		$_arr_upfileDel = $this->mdl_upfile->mdl_del($_arr_upfileDo["upfile_ids"], $_num_adminId);

		$this->obj_ajax->halt_alert($_arr_upfileDel["str_alert"]);
	}


	private function show_err($str_alert) {
		$_arr_re = array(
			"str_alert"  => $str_alert,
			"msg"        => $this->obj_ajax->halt_alert[$str_alert],
		);
		if ($str_alert == "x070203") {
			$_arr_re["msg"] = $this->obj_ajax->halt_alert[$str_alert] . " " . BG_UPFILE_SIZE . " " . BG_UPFILE_UNIT;
		}
		exit(json_encode($_arr_re));
	}

	private function setUpload() {
		$this->arr_thumb  = $this->mdl_thumb->mdl_list(100);
		$_arr_mimeRows    = $this->mdl_mime->mdl_list(100);
		foreach ($_arr_mimeRows as $_value) {
			$this->arr_mime[] = $_value["mime_ext"];
		}

		$_arr_status = $this->obj_upload->upload_init($this->arr_mime, $this->arr_thumb);
		if ($_arr_status["str_alert"] != "y070403") {
			$this->show_err($_arr_status["str_alert"]);
		}
	}
}
?>