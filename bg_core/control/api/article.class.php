<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "api.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "app.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "cate.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "articlePub.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "tag.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "thumb.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "attach.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "articleCustom.class.php"); //载入后台用户类

/*-------------文章类-------------*/
class API_ARTICLE {

	private $obj_api;
	private $mdl_app;
	private $mdl_cate;
	private $mdl_articlePub;
	private $mdl_tag;
	private $mdl_attach;
	private $mdl_thumb;

	function __construct() { //构造函数
		$this->obj_api            = new CLASS_API();
		$this->obj_api->chk_install();
		$this->mdl_app            = new MODEL_APP(); //设置管理组模型
		$this->mdl_cate           = new MODEL_CATE(); //设置文章对象
		$this->mdl_articlePub     = new MODEL_ARTICLE_PUB(); //设置文章对象
		$this->mdl_tag            = new MODEL_TAG();
		$this->mdl_thumb          = new MODEL_THUMB(); //设置上传信息对象
		$this->mdl_attach         = new MODEL_ATTACH(); //设置文章对象
	}


	/**
	 * api_list function.
	 *
	 * @access public
	 * @return void
	 */
	function api_get() {
		$this->app_check("get");

		$_num_articleId   = fn_getSafe(fn_get("article_id"), "int", 0);

		if ($_num_articleId == 0) {
			$_arr_return = array(
				"alert" => "x120212",
			);
			$this->obj_api->halt_re($_arr_return);
		}

		$_arr_articleRow = $this->mdl_articlePub->mdl_read($_num_articleId);

		if ($_arr_articleRow["alert"] != "y120102") {
			$this->obj_api->halt_re($_arr_articleRow);
		}

		unset($_arr_articleRow["article_url"]);

		if (!file_exists(BG_PATH_CACHE . "cate_" . $_arr_articleRow["article_cate_id"] . ".php")) {
			$this->mdl_cate->mdl_cache(array($_arr_articleRow["article_cate_id"]));
		}

		$_arr_cateRow = include(BG_PATH_CACHE . "cate_" . $_arr_articleRow["article_cate_id"] . ".php");

		if ($_arr_cateRow["alert"] != "y110102") {
			$this->obj_api->halt_re($_arr_cateRow);
		}

		if ($_arr_cateRow["cate_status"] != "show") {
			$_arr_return = array(
				"alert" => "x110102",
			);
			$this->obj_api->halt_re($_arr_return);
		}

		unset($_arr_cateRow["urlRow"]);

		if ($_arr_cateRow["cate_type"] == "link" && $_arr_cateRow["cate_link"]) {
			$_arr_return = array(
				"alert" => "x110218",
				"cate_link" => $_arr_cateRow["cate_link"],
			);
			$this->obj_api->halt_re($_arr_return);
		}

		$_arr_articleRow["cateRow"] = $_arr_cateRow;

		if (strlen($_arr_articleRow["article_title"]) < 1 || $_arr_articleRow["article_status"] != "pub" || $_arr_articleRow["article_box"] != "normal" || $_arr_articleRow["article_time_pub"] > time()) {
			$_arr_return = array(
				"alert" => "x120102",
			);
			$this->obj_api->halt_re($_arr_return);
		}

		if ($_arr_articleRow["article_link"]) {
			$_arr_return = array(
				"alert"         => "x120213",
				"article_link"  => $_arr_articleRow["article_link"],
			);
			$this->obj_api->halt_re($_arr_return);
		}

		$_arr_articleRow["tagRows"] = $this->mdl_tag->mdl_list(10, 0, "", "show", "tag_id", $_arr_articleRow["article_id"]);

		if ($_arr_articleRow["article_attach_id"] > 0) {
			$_arr_attachRow = $this->mdl_attach->mdl_url($_arr_articleRow["article_attach_id"]);

			if ($_arr_attachRow["alert"] == "y070102") {
				if ($_arr_attachRow["attach_box"] != "normal") {
					$_arr_attachRow = array(
						"alert" => "x070102",
					);
				}
			}

			$_arr_articleRow["attachRow"]    = $_arr_attachRow;
		}

		$this->obj_api->halt_re($_arr_articleRow, true);
	}



	function api_list() {
		$this->app_check("get");

		$_str_key     = fn_getSafe(fn_get("key"), "txt", "");
		$_str_year    = fn_getSafe(fn_get("year"), "txt", "");
		$_str_month   = fn_getSafe(fn_get("month"), "txt", "");
		$_str_markIds = fn_getSafe(fn_get("mark_ids"), "txt", "");
		$_str_tagIds  = fn_getSafe(fn_get("tag_ids"), "txt", "");
		$_num_cateId  = fn_getSafe(fn_get("cate_id"), "int", 0);
		$_num_specId  = fn_getSafe(fn_get("spec_id"), "int", 0);
		$_str_customs = fn_getSafe(fn_get("customs"), "txt", "");
		$_num_perPage = fn_getSafe(fn_get("per_page"), "int", BG_SITE_PERPAGE);

		$_arr_markIds = array();
		$_arr_tagIds  = array();
		$_arr_customs = array();

		if ($_str_markIds) {
			$_arr_markIds = explode("|", $_str_markIds);
		}
		if ($_str_markIds) {
			$_arr_tagIds  = explode("|", $_str_tagIds);
		}
		if ($_str_markIds) {
			$_arr_customs = explode("|", $_str_customs);
		}

		$_arr_customSearch = array();
		if ($_arr_customs) {
			foreach ($_arr_customs as $_key=>$_value) {
				$_arr_customRow = explode(":", $_value);
				$_arr_customSearch[$_arr_customRow[0]] = $_arr_customRow[1];
			}
		}

		if ($_num_cateId > 0) {
			if (!file_exists(BG_PATH_CACHE . "cate_" . $_num_cateId . ".php")) {
				$this->mdl_cate->mdl_cache(array($_num_cateId));
			}

			$_arr_cateRow = include(BG_PATH_CACHE . "cate_" . $_num_cateId . ".php");
			if ($_arr_cateRow["alert"] == "y110102" && $_arr_cateRow["cate_status"] == "show") {
				$_arr_cateIds   = $_arr_cateRow["cate_ids"];
			}
		} else {
			$_arr_cateIds = false;
		}

		$_num_articleCount    = $this->mdl_articlePub->mdl_count($_str_key, $_str_year, $_str_month, $_arr_cateIds, $_arr_markIds, $_num_specId, $_arr_tagIds, $_arr_customSearch);
		$_arr_page            = fn_page($_num_articleCount, $_num_perPage); //取得分页数据
		$_arr_articleRows     = $this->mdl_articlePub->mdl_list($_num_perPage, $_arr_page["except"], $_str_key, $_str_year, $_str_month, $_arr_cateIds, $_arr_markIds, $_num_specId, $_arr_tagIds, $_arr_customSearch);

		foreach ($_arr_articleRows as $_key=>$_value) {
			unset($_arr_articleRows[$_key]["article_url"]);

			$_arr_articleRows[$_key]["tagRows"][$_key] = $this->mdl_tag->mdl_list(10, 0, "", "show", "tag_id", $_value["article_id"]);

			if ($_value["article_attach_id"] > 0) {
				$_arr_attachRow = $this->mdl_attach->mdl_url($_value["article_attach_id"]);
				if ($_arr_attachRow["alert"] == "y070102") {
					if ($_arr_attachRow["attach_box"] != "normal") {
						$_arr_attachRow = array(
							"alert" => "x070102",
						);
					}
				}
				$_arr_articleRows[$_key]["attachRow"]    = $_arr_attachRow;
			}
			if (!file_exists(BG_PATH_CACHE . "cate_" . $_value["article_cate_id"] . ".php")) {
				$this->mdl_cate->mdl_cache(array($_value["article_cate_id"]));
			}

			$_arr_cateRow = include(BG_PATH_CACHE . "cate_" . $_value["article_cate_id"] . ".php");
			if ($_arr_cateRow["alert"] == "y110102" && $_arr_cateRow["cate_status"] == "show") {
				unset($_arr_cateRow["urlRow"]);
				$_arr_articleRows[$_key]["cateRow"] = $_arr_cateRow;
			}
		}

		$_arr_return = array(
			"pageRow"        => $_arr_page,
			"articleRows"    => $_arr_articleRows,
		);

		//print_r($_arr_return);

		$this->obj_api->halt_re($_arr_return, true);
	}


	/**
	 * app_check function.
	 *
	 * @access private
	 * @param mixed $num_appId
	 * @param string $str_method (default: "get")
	 * @return void
	 */
	private function app_check($str_method = "get") {
		$this->appGet = $this->obj_api->app_get($str_method);

		if ($this->appGet["alert"] != "ok") {
			$this->obj_api->halt_re($this->appGet);
		}

		$_arr_appRow = $this->mdl_app->mdl_read($this->appGet["app_id"]);
		if ($_arr_appRow["alert"] != "y190102") {
			$this->obj_api->halt_re($_arr_appRow);
		}
		$this->appAllow = $_arr_appRow["app_allow"];

		$_arr_appChk = $this->obj_api->app_chk($this->appGet, $_arr_appRow);
		if ($_arr_appChk["alert"] != "ok") {
			$this->obj_api->halt_re($_arr_appChk);
		}

		if (!file_exists(BG_PATH_CACHE . "thumb_list.php")) {
			$this->mdl_thumb->mdl_cache();
		}
		$this->mdl_attach->thumbRows = include(BG_PATH_CACHE . "thumb_list.php");
	}
}
