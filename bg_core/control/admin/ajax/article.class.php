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
include_once(BG_PATH_MODEL . "article.class.php"); //载入文章模型类
include_once(BG_PATH_MODEL . "cate.class.php");
include_once(BG_PATH_MODEL . "cateBelong.class.php");
include_once(BG_PATH_MODEL . "tag.class.php");
include_once(BG_PATH_MODEL . "tagBelong.class.php");

/*-------------文章类-------------*/
class AJAX_ARTICLE {

	private $obj_base;
	private $config;
	private $adminLogged;
	private $obj_tpl;
	private $mdl_article;
	private $mdl_cate;
	private $mdl_cateBelong;
	private $allowCateIds;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_ajax       = new CLASS_AJAX();
		$this->mdl_article    = new MODEL_ARTICLE(); //设置文章对象
		$this->mdl_cate       = new MODEL_CATE();
		$this->mdl_cateBelong = new MODEL_CATE_BELONG();
		$this->mdl_tag        = new MODEL_TAG();
		$this->mdl_tagBelong  = new MODEL_TAG_BELONG();

		if (file_exists(BG_PATH_CONFIG . "is_install.php")) { //验证是否已经安装
			include_once(BG_PATH_CONFIG . "is_install.php");
			if (!defined("BG_INSTALL_PUB") || PRD_CMS_PUB > BG_INSTALL_PUB) {
				$this->obj_ajax->halt_alert("x030416");
			}
		} else {
			$this->obj_ajax->halt_alert("x030415");
		}

		if ($this->adminLogged["str_alert"] != "y020102") { //未登录，抛出错误信息
			$this->obj_ajax->halt_alert($this->adminLogged["str_alert"]);
		}

		if (is_array($this->adminLogged["admin_allow_cate"])) {
			foreach ($this->adminLogged["admin_allow_cate"] as $_key=>$_value) {
				if (isset($_value["add"])) {
					$this->allowCateIds["add"][] = $_key;
				}
				if (isset($_value["edit"])) {
					$this->allowCateIds["edit"][] = $_key;
				}
				if (isset($_value["del"])) {
					$this->allowCateIds["del"][] = $_key;
				}
				if (isset($_value["approve"])) {
					$this->allowCateIds["approve"][] = $_key;
				}
			}
		} else {
			$this->allowCateIds["add"]       = array();
			$this->allowCateIds["edit"]      = array();
			$this->allowCateIds["del"]       = array();
			$this->allowCateIds["approve"]   = array();
		}
	}


	/**
	 * ajax_submit function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_submit() {
		//从表单获取数据
		$_arr_articleSubmit = $this->mdl_article->input_submit();
		if ($_arr_articleSubmit["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_articleSubmit["str_alert"]);
		}

		foreach ($_arr_articleSubmit["cate_ids"] as $_value) {
			$_arr_cateRow = $this->mdl_cate->mdl_read($_value);
			if ($_arr_cateRow["str_alert"] != "y110102") {
				$this->obj_ajax->halt_alert($_arr_cateRow["str_alert"]);
			}
			if ($_arr_cateRow["cate_type"] != "normal") {
				$this->obj_ajax->halt_alert("x110222");
			}
		}

		if ($_arr_articleSubmit["article_id"] > 0) {
			//判断权限
			if (!isset($this->adminLogged["groupRow"]["group_allow"]["article"]["edit"]) && isset($this->adminLogged["admin_allow_cate"][$_arr_articleSubmit["article_cate_id"]]["edit"])) {
				$this->obj_ajax->halt_alert("x120303");
			}
			foreach ($_arr_articleSubmit["cate_ids"] as $_value) {
				if (($this->allowCateIds["edit"] && in_array($_value, $this->allowCateIds["edit"])) || isset($this->adminLogged["groupRow"]["group_allow"]["article"]["edit"])) {
					$_arr_cateIds[] = $_value;
				}
			}
		} else {
			if (!isset($this->adminLogged["groupRow"]["group_allow"]["article"]["add"]) && isset($this->adminLogged["admin_allow_cate"][$_arr_articleSubmit["article_cate_id"]]["add"])) {
				$this->obj_ajax->halt_alert("x120302");
			}
			foreach ($_arr_articleSubmit["cate_ids"] as $_value) {
				if (($this->allowCateIds["add"] && in_array($_value, $this->allowCateIds["add"])) || isset($this->adminLogged["groupRow"]["group_allow"]["article"]["add"])) {
					$_arr_cateIds[] = $_value;
				}
			}
		}

		if (isset($this->adminLogged["groupRow"]["group_allow"]["article"]["approve"]) || isset($this->adminLogged["admin_allow_cate"][$_arr_articleSubmit["article_cate_id"]]["approve"])) {
			$_str_status = $_arr_articleSubmit["article_status"];
		} else {
			$_str_status = "wait";
		}

		//print_r($_arr_articleSubmit);

		$_arr_articleRow = $this->mdl_article->mdl_submit($this->adminLogged["admin_id"], $_str_status);

		$_arr_tags    = explode(",", $_arr_articleSubmit["article_tags"]);
		$_arr_tagIds  = array();

		foreach ($_arr_tags as $_value) {
			$_value = trim($_value);
			if ($_value) {
				$_arr_tagRow = $this->mdl_tag->mdl_read($_value, "tag_name");
				if ($_arr_tagRow["str_alert"] == "y130102") {
					$_arr_tagIds[]      = $_arr_tagRow["tag_id"];
					//统计 tag 文章数
					$_num_articleCount  = $this->mdl_tagBelong->mdl_count($_arr_tagRow["tag_id"]);
					$this->mdl_tag->mdl_countDo($_arr_tagRow["tag_id"], $_num_articleCount); //更新
				} else {
					$_arr_tagRow    = $this->mdl_tag->mdl_submit($_value, "show");
					$_arr_tagIds[]  = $_arr_tagRow["tag_id"];
				}
			}
		}

		//print_r($_arr_tagIds);

		if ($_arr_articleSubmit["article_id"] > 0) {
			$_arr_cateBelongDel    = $this->mdl_cateBelong->mdl_del(0, $_arr_articleRow["article_id"], false, false, $_arr_cateIds);
			if ($_arr_tagIds) {
				$_arr_tagBelongDel = $this->mdl_tagBelong->mdl_del(0, $_arr_articleRow["article_id"], false, false, $_arr_tagIds);
			} else {
				$_arr_tagBelongDel = $this->mdl_tagBelong->mdl_del(0, $_arr_articleRow["article_id"]);
			}
			$_belong               = $this->belong_submit($_arr_articleSubmit["article_id"], $_arr_cateIds, $_arr_tagIds);
		} else {
			$_belong               = $this->belong_submit($_arr_articleRow["article_id"], $_arr_cateIds, $_arr_tagIds);
		}

		if ($_arr_articleRow["str_alert"] == "x120103") {
			if (isset($_belong) || (isset($_arr_cateBelongDel["str_alert"]) && $_arr_cateBelongDel["str_alert"] == "y150104") || (isset($_arr_tagBelongDel["str_alert"]) && $_arr_tagBelongDel["str_alert"] == "y160104")) {
				$_arr_articleRow["str_alert"] = "y120103";
			}
		}

		$this->obj_ajax->halt_alert($_arr_articleRow["str_alert"]);
	}


	/**
	 * ajax_top function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_top() {
		$_arr_articleIds = $this->mdl_article->input_ids();
		if ($_arr_articleIds["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_articleIds["str_alert"]);
		}

		$_str_articleStatus = fn_getSafe($GLOBALS["act_post"], "txt", "");
		if (!$_str_articleStatus) {
			$this->obj_ajax->halt_alert("x120208");
		}

		switch ($_str_articleStatus) {
			case "top":
				$_num_articleTop = 1;
			break;

			default:
				$_num_articleTop = 0;
			break;
		}

		if (isset($this->adminLogged["groupRow"]["group_allow"]["article"]["approve"])) {
			$_arr_cateId = false;
		} else {
			foreach ($this->adminLogged["admin_allow_cate"] as $_key=>$_value) {
				if (isset($_value["approve"])) {
					$_arr_cateId[] = $_key;
				}
			}
		}

		$_arr_articleRow = $this->mdl_article->mdl_top($_num_articleTop, $_arr_cateId);

		$this->obj_ajax->halt_alert($_arr_articleRow["str_alert"]);
	}


	/**
	 * ajax_status function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_status() {
		$_arr_articleIds = $this->mdl_article->input_ids();
		if ($_arr_articleIds["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_articleIds["str_alert"]);
		}

		$_str_articleStatus = fn_getSafe($GLOBALS["act_post"], "txt", "");
		if (!$_str_articleStatus) {
			$this->obj_ajax->halt_alert("x120208");
		}

		if (isset($this->adminLogged["groupRow"]["group_allow"]["article"]["approve"])) {
			$_arr_cateId     = false;
			$_num_adminId    = 0;
		} else {
			foreach ($this->adminLogged["admin_allow_cate"] as $_key=>$_value) {
				if (isset($_value["approve"])) {
					$_arr_cateId[] = $_key;
				}
			}
			$_num_adminId = $this->adminLogged["admin_id"];
		}

		$_arr_articleRow = $this->mdl_article->mdl_status($_str_articleStatus, $_arr_cateId, $_num_adminId);

		$this->obj_ajax->halt_alert($_arr_articleRow["str_alert"]);
	}


	/**
	 * ajax_box function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_box() {
		$_arr_articleIds = $this->mdl_article->input_ids();
		if ($_arr_articleIds["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_articleIds["str_alert"]);
		}

		$_str_articleBox = fn_getSafe($GLOBALS["act_post"], "txt", "");
		if (!$_str_articleBox) {
			$this->obj_ajax->halt_alert("x120208");
		}

		if (isset($this->adminLogged["groupRow"]["group_allow"]["article"]["edit"])) {
			$_arr_cateId     = false;
			$_num_adminId    = 0;
		} else {
			foreach ($this->adminLogged["admin_allow_cate"] as $_key=>$_value) {
				if (isset($_value["edit"])) {
					$_arr_cateId[] = $_key;
				}
			}
			$_num_adminId = $this->adminLogged["admin_id"];
		}

		$_arr_articleRow = $this->mdl_article->mdl_box($_str_articleBox, $_arr_cateId, $_num_adminId);

		$this->obj_ajax->halt_alert($_arr_articleRow["str_alert"]);
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		$_arr_articleIds = $this->mdl_article->input_ids();
		if ($_arr_articleIds["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_articleIds["str_alert"]);
		}

		if (isset($this->adminLogged["groupRow"]["group_allow"]["article"]["del"])) {
			$_arr_cateId     = false;
			$_num_adminId    = 0;
		} else {
			foreach ($this->adminLogged["admin_allow_cate"] as $_key=>$_value) {
				if (isset($_value["del"])) {
					$_arr_cateId[] = $_key;
				}
			}
			$_num_adminId = $this->adminLogged["admin_id"];
		}

		$_arr_articleRow = $this->mdl_article->mdl_del($_arr_cateId, $_num_adminId);

		$this->mdl_cateBelong->mdl_del(0, 0, 0, $_arr_articleIds["article_ids"]);
		$this->mdl_tagBelong->mdl_del(0, 0, 0, $_arr_articleIds["article_ids"]);

		$this->obj_ajax->halt_alert($_arr_articleRow["str_alert"]);
	}


	/**
	 * ajax_empty function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_empty() {
		$_arr_articleRow = $this->mdl_article->mdl_empty($this->adminLogged["admin_id"]);

		$this->obj_ajax->halt_alert($_arr_articleRow["str_alert"]);
	}


	/**
	 * belong_submit function.
	 *
	 * @access private
	 * @param mixed $_num_articleId
	 * @param mixed $_arr_cateIds
	 * @param mixed $_arr_tagIds
	 * @return void
	 */
	private function belong_submit($_num_articleId, $_arr_cateIds, $_arr_tagIds) {
		$_is_submit = false;
		if (is_array($_arr_cateIds)) {
			foreach ($_arr_cateIds as $_value) {
				if ($_value) {
					$_arr_cateBelongRow = $this->mdl_cateBelong->mdl_submit($_num_articleId, $_value);
					if (!$_is_submit && $_arr_cateBelongRow["str_alert"] == "y150101") {
						$_is_submit = true;
					}
				}
			}
		}

		if (is_array($_arr_tagIds)) {
			foreach ($_arr_tagIds as $_value) {
				if ($_value) {
					$_arr_tagBelongRow = $this->mdl_tagBelong->mdl_submit($_num_articleId, $_value);
					if (!$_is_submit && $_arr_tagBelongRow["str_alert"] == "y160101") {
						$_is_submit = true;
					}
				}
			}
		}

		return $_is_submit;
	}
}
