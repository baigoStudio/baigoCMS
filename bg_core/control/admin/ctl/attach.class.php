<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "tpl_admin.class.php");
include_once(BG_PATH_MODEL . "article.class.php");
include_once(BG_PATH_MODEL . "attach.class.php");
include_once(BG_PATH_MODEL . "thumb.class.php");
include_once(BG_PATH_MODEL . "mime.class.php");
include_once(BG_PATH_MODEL . "cate.class.php");
include_once(BG_PATH_MODEL . "mark.class.php");

/*-------------用户类-------------*/
class CONTROL_ATTACH {

	private $obj_base;
	private $config;
	private $adminLogged;
	private $obj_tpl;
	private $mdl_attach;
	private $mimeRows;
	private $mdl_admin;

	function __construct() { //构造函数
		$this->obj_base           = $GLOBALS["obj_base"];
		$this->config             = $this->obj_base->config;
		$this->adminLogged        = $GLOBALS["adminLogged"];
		$this->obj_tpl            = new CLASS_TPL(BG_PATH_SYSTPL_ADMIN . $this->config["ui"]); //初始化视图对象
		$this->mdl_attach         = new MODEL_ATTACH(); //设置上传信息对象
		$this->mdl_thumb          = new MODEL_THUMB();
		$this->mdl_mime           = new MODEL_MIME();
		$this->mdl_admin          = new MODEL_ADMIN();
		$this->mdl_article        = new MODEL_ARTICLE(); //设置文章对象
		$this->mdl_cate           = new MODEL_CATE(); //设置栏目对象
		$this->mdl_mark           = new MODEL_MARK(); //设置标记对象
		$this->setUpload();
		$this->tplData = array(
			"adminLogged"    => $this->adminLogged,
			"uploadSize"     => BG_UPLOAD_SIZE * $this->sizeUnit,
			"mimeRows"       => $this->mimeRows
		);
	}


	function ctl_article() {
		$_num_articleId = fn_getSafe(fn_get("article_id"), "int", 0);
		if ($_num_articleId == 0) {
			return array(
				"alert" => "x120212"
			);
			exit;
		}

		$_arr_articleRow = $this->mdl_article->mdl_read($_num_articleId); //读取文章
		if ($_arr_articleRow["alert"] != "y120102") {
			return $_arr_articleRow;
			exit;
		}

		if ((!isset($this->adminLogged["groupRow"]["group_allow"]["article"]["edit"]) && !isset($this->adminLogged["admin_allow_cate"][$_arr_articleRow["article_cate_id"]]["edit"]) && $_arr_articleRow["article_admin_id"] != $this->adminLogged["admin_id"]) || !isset($this->adminLogged["groupRow"]["group_allow"]["attach"]["browse"])) { //判断权限
			return array(
				"alert" => "x120303"
			);
			exit;
		}

		$_arr_cateRow     = $this->mdl_cate->mdl_read($_arr_articleRow["article_cate_id"]);
		$_arr_markRow     = $this->mdl_mark->mdl_read($_arr_articleRow["article_mark_id"]);
		$_arr_attachIds   = fn_getAttach($_arr_articleRow["article_content"]);
		$_arr_attachRows  = array();
		$_arr_page        = fn_page(0);

		if ($_arr_attachIds) {
			$_num_attachCount = $this->mdl_attach->mdl_count("", "", "", "", 0, "normal", $_arr_attachIds);
			$_arr_page        = fn_page($_num_attachCount);
			$_arr_attachRows  = $this->mdl_attach->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], "", "", "", "", 0, "normal", $_arr_attachIds);

			foreach ($_arr_attachRows as $_key=>$_value) {
				if ($_value["attach_type"] == "image") {
					$_arr_attachRows[$_key]["attach_thumb"] = $this->mdl_attach->thumb_process($_value["attach_id"], $_value["attach_time"], $_value["attach_ext"]);
				}
				$_arr_attachRows[$_key]["adminRow"] = $this->mdl_admin->mdl_read($_value["attach_admin_id"]);
			}
		}

		$_arr_tpl = array(
			"attach_ids" => implode("|", $_arr_attachIds),
			"pageRow"    => $_arr_page,
			"markRow"    => $_arr_markRow,
			"cateRow"    => $_arr_cateRow,
			"attachRows" => $_arr_attachRows,
			"articleRow" => $_arr_articleRow,
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("attach_article.tpl", $_arr_tplData);

		return array(
			"alert" => "y120102"
		);
	}


	/**
	 * ctl_form function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_form() {
		if (!isset($this->adminLogged["groupRow"]["group_allow"]["attach"]["upload"])) {
			return array(
				"alert" => "x070302",
			);
			exit;
		}

		if (!is_array($this->mimeRows)) {
			return array(
				"alert" => "x070405",
			);
			exit;
		}

		$_num_articleId   = fn_getSafe(fn_get("article_id"), "int", 0);
		$_arr_yearRows    = $this->mdl_attach->mdl_year(100);
		$_arr_extRows     = $this->mdl_attach->mdl_ext();

		$_arr_tpl = array(
			"article_id" => $_num_articleId,
			"yearRows"   => $_arr_yearRows,
			"extRows"    => $_arr_extRows,
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("attach_form.tpl", $_arr_tplData);

		return array(
			"alert" => "y070302",
		);
	}


	/**
	 * ctl_list function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_list() {
		if (!isset($this->adminLogged["groupRow"]["group_allow"]["attach"]["browse"])) {
			return array(
				"alert" => "x070301",
			);
			exit;
		}

		if (!is_array($this->mimeRows)) {
			return array(
				"alert" => "x070405",
			);
			exit;
		}

		$_str_box         = fn_getSafe(fn_get("box"), "txt", "normal");
		$_str_key         = fn_getSafe(fn_get("key"), "txt", "");
		$_str_year        = fn_getSafe(fn_get("year"), "txt", "");
		$_str_month       = fn_getSafe(fn_get("month"), "txt", "");
		$_str_ext         = fn_getSafe(fn_get("ext"), "txt", "");
		$_num_adminId     = fn_getSafe(fn_get("admin_id"), "int", 0);
		$_str_attachIds   = fn_getSafe(fn_get("attach_ids"), "txt", "");

		$_arr_search = array(
			"act_get"    => $GLOBALS["act_get"],
			"box"        => $_str_box,
			"key"        => $_str_key,
			"year"       => $_str_year,
			"month"      => $_str_month,
			"ext"        => $_str_ext,
			"admin_id"   => $_num_adminId,
			"attach_ids" => $_str_attachIds,
		); //搜索设置

		if ($_str_attachIds) {
			$_arr_attachIds = explode("|", $_str_attachIds);
		} else {
			$_arr_attachIds = false;
		}

		$_num_attachCount = $this->mdl_attach->mdl_count($_str_key, $_str_year, $_str_month, $_str_ext, $_num_adminId, $_str_box, $_arr_attachIds);
		$_arr_page        = fn_page($_num_attachCount);
		$_str_query       = http_build_query($_arr_search);
		$_arr_pathRows    = $this->mdl_attach->mdl_year(100);
		$_arr_extRows     = $this->mdl_attach->mdl_ext();
		$_arr_attachRows  = $this->mdl_attach->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], $_str_key, $_str_year, $_str_month, $_str_ext, $_num_adminId, $_str_box, $_arr_attachIds);

		foreach ($_arr_attachRows as $_key=>$_value) {
			if ($_value["attach_type"] == "image") {
				//print_r($_arr_url);
				$_arr_attachRows[$_key]["attach_thumb"] = $this->mdl_attach->thumb_process($_value["attach_id"], $_value["attach_time"], $_value["attach_ext"]);
			}
			$_arr_attachRows[$_key]["adminRow"] = $this->mdl_admin->mdl_read($_value["attach_admin_id"]);
		}

		//print_r($_arr_attachRows);

		$_arr_attachCount["all"]     = $this->mdl_attach->mdl_count("", "", "", "", 0, "normal");
		$_arr_attachCount["recycle"] = $this->mdl_attach->mdl_count("", "", "", "", 0, "recycle");

		$_arr_tpl = array(
			"query"          => $_str_query,
			"pageRow"        => $_arr_page,
			"search"         => $_arr_search,
			"attachCount"    => $_arr_attachCount,
			"attachRows"     => $_arr_attachRows, //上传信息
			"pathRows"       => $_arr_pathRows, //目录列表
			"extRows"        => $_arr_extRows, //扩展名列表
		);

		$_arr_tplData = array_merge($this->tplData, $_arr_tpl);

		$this->obj_tpl->tplDisplay("attach_list.tpl", $_arr_tplData);

		return array(
			"alert" => "y070301",
		);
	}


	/**
	 * setUpload function.
	 *
	 * @access private
	 * @return void
	 */
	private function setUpload() {
		$this->mdl_attach->thumbRows  = $this->mdl_thumb->mdl_list(100);

		$_arr_mimeRows = $this->mdl_mime->mdl_list(100);
		foreach ($_arr_mimeRows as $_key=>$_value) {
			$this->mimeRows[] = $_value["mime_name"];
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
