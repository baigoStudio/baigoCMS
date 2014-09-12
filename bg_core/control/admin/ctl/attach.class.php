<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "tpl.class.php"); //载入文件操作类
include_once(BG_PATH_MODEL . "attach.class.php"); //载入上传模型
include_once(BG_PATH_MODEL . "thumb.class.php"); //载入上传模型
include_once(BG_PATH_MODEL . "mime.class.php"); //载入上传模型

/*-------------用户类-------------*/
class CONTROL_ATTACH {

	private $obj_base;
	private $config;
	private $adminLogged;
	private $obj_tpl;
	private $mdl_attach;
	private $mimeRow;
	private $mdl_admin;

	function __construct() { //构造函数
		$this->obj_base           = $GLOBALS["obj_base"]; //获取界面类型
		$this->config             = $this->obj_base->config;
		$this->config["img_ext"]  = $GLOBALS["img_ext"];
		$this->adminLogged        = $GLOBALS["adminLogged"];
		$this->mdl_attach         = new MODEL_ATTACH(); //设置上传信息对象
		$this->mdl_thumb          = new MODEL_THUMB(); //设置上传信息对象
		$this->mdl_mime           = new MODEL_MIME(); //设置上传信息对象
		$this->mdl_admin          = new MODEL_ADMIN(); //设置栏目对象
		$this->obj_tpl            = new CLASS_TPL(BG_PATH_SYSTPL_ADMIN . $this->config["ui"]);; //初始化视图对象
		$this->setUpload();
		$this->tplData = array(
			"adminLogged"    => $this->adminLogged,
			"uploadSize"     => BG_UPLOAD_SIZE * $this->sizeUnit,
		);
	}

	/*============编辑上传============
	返回数组
		attach_id 上传 ID
		str_alert 提示信息
	*/
	function ctl_form() {
		if ($this->adminLogged["groupRow"]["group_allow"]["attach"]["upload"] != 1) {
			return array(
				"str_alert" => "x070302",
			);
			exit;
		}


		if (!is_array($this->mimeRow)) {
			return array(
				"str_alert" => "x070405",
			);
			exit;
		}

		$_arr_yearRows    = $this->mdl_attach->mdl_year(100);
		$_arr_extRows     = $this->mdl_attach->mdl_ext(100);

		$_arr_tpl = array(
			"search"     => $_arr_search,
			"yearRows"   => $_arr_yearRows,
			"extRows"    => $_arr_extRows,
			"mimeRow"    => $this->mimeRow
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("attach_form.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y070302",
		);
	}

	/*============列出上传信息============
	返回提示
	*/
	function ctl_list() {
		if ($this->adminLogged["groupRow"]["group_allow"]["attach"]["browse"] != 1) {
			return array(
				"str_alert" => "x070301",
			);
			exit;
		}

		if (!is_array($this->mimeRow)) {
			return array(
				"str_alert" => "x070405",
			);
			exit;
		}

		$_act_get     = fn_getSafe($_GET["act_get"], "txt", "");
		$_str_year    = fn_getSafe($_GET["year"], "txt", "");
		$_str_month   = fn_getSafe($_GET["month"], "txt", "");
		$_str_ext     = fn_getSafe($_GET["ext"], "txt", "");
		$_num_adminId = fn_getSafe($_GET["admin_id"], "int", 0);

		$_arr_search = array(
			"act_get"    => $_act_get,
			"year"       => $_str_year,
			"month"      => $_str_month,
			"ext"        => $_str_ext,
			"admin_id"   => $_num_adminId,
		); //搜索设置

		$_num_attachCount = $this->mdl_attach->mdl_count($_str_year, $_str_month, $_str_ext, $_num_adminId);
		$_arr_page        = fn_page($_num_attachCount);
		$_str_query       = http_build_query($_arr_search);
		$_arr_pathRows    = $this->mdl_attach->mdl_year(100);
		$_arr_extRows     = $this->mdl_attach->mdl_ext(100);
		$_arr_attachRows  = $this->mdl_attach->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_str_year, $_str_month, $_str_ext, $_num_adminId);

		foreach ($_arr_attachRows as $_key=>$_value) {
			if (in_array($_value["attach_ext"], $this->config["img_ext"])) {
				$_arr_attachRows[$_key]["attach_type"]  = "image";
				$_arr_thumb = $this->mdl_attach->url_process($_value["attach_id"], $_value["attach_time"], $_value["attach_ext"], $this->attachThumb);
				//print_r($_arr_thumb);
				$_arr_attachRows[$_key]["attach_url"]   = $_arr_thumb["attach_url"];
				$_arr_attachRows[$_key]["attach_thumb"] = $_arr_thumb["attach_thumb"];
			} else {
				$_arr_attachRows[$_key]["attach_type"] = "file";
			}
			$_arr_attachRows[$_key]["adminRow"] = $this->mdl_admin->mdl_read($_value["attach_admin_id"]);
		}

		$_arr_tpl = array(
			"query"      => $_str_query,
			"pageRow"    => $_arr_page,
			"search"     => $_arr_search,
			"attachRows" => $_arr_attachRows, //上传信息
			"pathRows"   => $_arr_pathRows, //目录列表
			"extRows"    => $_arr_extRows, //扩展名列表
			"mimeRow"    => $this->mimeRow
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("attach_list.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y070301",
		);
	}

	/*============设置上传参数============
	无返回
	*/
	private function setUpload() {
		$this->attachThumb = $this->mdl_thumb->mdl_list(100);

		$_arr_mimeRows = $this->mdl_mime->mdl_list(100);
		foreach ($_arr_mimeRows as $_value) {
			$this->mimeRow[] = $_value["mime_name"];
		}

		switch (BG_UPLOAD_UNIT) { //初始化单位
			case "B":
				$this->sizeUnit = 1;
			break;

			case "KB":
				$this->sizeUnit = 1024;
			break;

			case "MB":
				$this->sizeUnit = 1024 * 1024;
			break;

			case "GB":
				$this->sizeUnit = 1024 * 1024 * 1024;
			break;
		}
	}
}
?>