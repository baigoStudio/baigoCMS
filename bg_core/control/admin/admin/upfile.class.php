<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "upfile.func.php"); //载入开放平台类
include_once(BG_PATH_CLASS . "tpl.class.php"); //载入文件操作类
include_once(BG_PATH_MODEL . "upfile.class.php"); //载入上传模型
include_once(BG_PATH_MODEL . "thumb.class.php"); //载入上传模型
include_once(BG_PATH_MODEL . "mime.class.php"); //载入上传模型
include_once(BG_PATH_MODEL . "admin.class.php"); //载入文章模型类

/*-------------用户类-------------*/
class CONTROL_UPFILE {

	private $obj_base;
	private $config;
	private $adminLogged;
	private $obj_tpl;
	private $mdl_upfile;
	private $upfileMime;
	private $mdl_admin;

	function __construct() { //构造函数
		$this->obj_base           = $GLOBALS["obj_base"]; //获取界面类型
		$this->config             = $this->obj_base->config;
		$this->config["img_ext"]  = $GLOBALS["img_ext"];
		$this->adminLogged        = $GLOBALS["adminLogged"];
		$this->mdl_upfile         = new MODEL_UPFILE(); //设置上传信息对象
		$this->mdl_thumb          = new MODEL_THUMB(); //设置上传信息对象
		$this->mdl_mime           = new MODEL_MIME(); //设置上传信息对象
		$this->mdl_admin          = new MODEL_ADMIN(); //设置栏目对象
		$this->obj_tpl            = new CLASS_TPL(BG_PATH_SYSTPL_ADMIN . $this->config["ui"]);; //初始化视图对象
		$this->setUpload();
		$this->tplData = array(
			"adminLogged" => $this->adminLogged
		);
	}

	/*============编辑上传============
	返回数组
		upfile_id 上传 ID
		str_alert 提示信息
	*/
	function ctl_form() {
		if ($this->adminLogged["admin_allow_sys"]["upfile"]["upload"] != 1) {
			return array(
				"str_alert" => "x070302",
			);
			exit;
		}

		if (!is_array($this->upfileMime)) {
			return array(
				"str_alert" => "x070405",
			);
			exit;
		}

		$_str_target  = fn_getSafe($_GET["target"], "txt", "");
		$_arr_search = array(
			"target"     => $_str_target,
		); //搜索设置

		$_arr_tpl = array(
			"search"     => $_arr_search,
			"upfileMime" => "*." . implode("; *.", $this->upfileMime), //允许上传信息
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("upfile_form.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y070302",
		);
	}

	/*============列出上传信息============
	返回提示
	*/
	function ctl_list() {
		if ($this->adminLogged["admin_allow_sys"]["upfile"]["browse"] != 1) {
			return array(
				"str_alert" => "x070301",
			);
			exit;
		}

		if (!is_array($this->upfileMime)) {
			return array(
				"str_alert" => "x070405",
			);
			exit;
		}

		$_num_page    = fn_getSafe($_GET["page"], "int", 1);
		$_act_get     = fn_getSafe($_GET["act_get"], "txt", "");
		$_str_year    = fn_getSafe($_GET["year"], "txt", "");
		$_str_month   = fn_getSafe($_GET["month"], "txt", "");
		$_str_ext     = fn_getSafe($_GET["ext"], "txt", "");
		$_num_adminId = fn_getSafe($_GET["admin_id"], "int", 0);
		$_str_tpl     = fn_getSafe($_GET["tpl"], "txt", "");
		$_str_target  = fn_getSafe($_GET["target"], "txt", "");

		$_arr_search = array(
			"page"       => $_num_page,
			"act_get"    => $_act_get,
			"key"        => $_str_key,
			"year"       => $_str_year,
			"month"      => $_str_month,
			"ext"        => $_str_ext,
			"admin_id"   => $_num_adminId,
			"tpl"        => $_str_tpl,
			"target"     => $_str_target,
			"view"       => $GLOBALS["view"],
		); //搜索设置

		if ($_str_tpl) {
			$_str_tpl        = $_str_tpl;
			$_num_perPage    = 10;
		} else {
			$_str_tpl        = "list";
			$_num_perPage    = BG_DEFAULT_PERPAGE;
		}

		$_num_upfileCount = $this->mdl_upfile->mdl_count($_str_key, $_str_year, $_str_month, $_str_ext, $_num_adminId);
		$_arr_page        = fn_page($_num_upfileCount, $_num_perPage);
		$_str_query       = http_build_query($_arr_search);
		$_arr_pathRows    = $this->mdl_upfile->mdl_year(100);
		$_arr_extRows     = $this->mdl_upfile->mdl_ext(100);
		$_arr_upfileRows  = $this->mdl_upfile->mdl_list($_num_perPage, $_arr_page["except"], $_str_year, $_str_month, $_str_ext, $_num_adminId);

		foreach ($_arr_upfileRows as $_key=>$_value) {
			if (in_array($_value["upfile_ext"], $this->config["img_ext"])) {
				$_arr_upfileRows[$_key]["upfile_type"] = "image";
			} else {
				$_arr_upfileRows[$_key]["upfile_type"] = "file";
			}
			$_arr_upfileRows[$_key]["upfile_row"]        = fn_upfileUrl($_value["upfile_id"], $_value["upfile_time"], $_value["upfile_ext"], $this->upfileThumb);
			$_arr_adminRow                               = $this->mdl_admin->mdl_read($_value["upfile_admin_id"]);
			$_arr_upfileRows[$_key]["upfile_admin_name"] = $_arr_adminRow["admin_name"];
			$_arr_upfileRows[$_key]["upfile_admin_note"] = $_arr_adminRow["admin_note"];
		}

		$_arr_tpl = array(
			"query"      => $_str_query,
			"pageRow"    => $_arr_page,
			"search"     => $_arr_search,
			"upfileRows" => $_arr_upfileRows, //上传信息
			"pathRows"   => $_arr_pathRows, //目录列表
			"extRows"    => $_arr_extRows, //扩展名列表
			"upfileMime" => "*." . implode("; *.", $this->upfileMime), //允许上传信息
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("upfile_" . $_str_tpl . ".tpl", $_arr_tplData);

		return array(
			"str_alert" => "y070301",
		);
	}

	/*============设置上传参数============
	无返回
	*/
	private function setUpload() {
		$this->upfileThumb = $this->mdl_thumb->mdl_list(100);

		$_arr_mimeRows = $this->mdl_mime->mdl_list(100);
		foreach ($_arr_mimeRows as $_value) {
			$this->upfileMime[] = $_value["mime_ext"];
		}
	}
}
?>