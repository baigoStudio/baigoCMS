<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------文章类-------------*/
class CONTROL_CATE {

	private $cateRow;
	private $cateTrees;
	private $cateIds;
	private $search;
	private $tplData;
	private $obj_tpl;
	private $mdl_cate;
	private $mdl_tag;
	private $mdl_article;
	private $mdl_attach;

	function __construct() { //构造函数
		$this->mdl_cate           = new MODEL_CATE(); //设置文章对象
		$this->mdl_custom         = new MODEL_CUSTOM();
		$this->mdl_articlePub     = new MODEL_ARTICLE_PUB(); //设置文章对象
		$this->cate_init();
		$this->obj_tpl            = new CLASS_TPL(BG_PATH_TPL_PUB . $this->config["tpl"]); //初始化视图对象
		$this->mdl_tag            = new MODEL_TAG();
		$this->mdl_attach         = new MODEL_ATTACH(); //设置文章对象
		$this->mdl_thumb          = new MODEL_THUMB(); //设置上传信息对象
	}


	/**
	 * ctl_list function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_show() {
		if ($this->search["cate_id"] == 0) {
			return array(
				"alert" => "x110217",
			);
			exit;
		}

		if ($this->cateRow["alert"] != "y110102") {
			return $this->cateRow;
			exit;
		}

		if ($this->cateRow["cate_status"] != "show") {
			return array(
				"alert" => "x110102",
			);
			exit;
		}

		if ($this->cateRow["cate_type"] == "link" && $this->cateRow["cate_link"]) {
			return array(
				"alert" => "x110218",
				"cate_link" => $this->cateRow["cate_link"],
			);
			exit;
		}

		if ($this->cateRow["cate_perpage"] <= BG_SITE_PERPAGE) {
			$_num_perpage = BG_SITE_PERPAGE;
		} else {
			$_num_perpage = $this->cateRow["cate_perpage"];
		}

		$_str_customs = urldecode($this->search["customs"]);
		$_str_customs = base64_decode($_str_customs);
		$_str_customs = urldecode($_str_customs);
		$_arr_customs = explode("&", $_str_customs);

		$_arr_customSearch = array();

		if ($_arr_customs) {
			foreach ($_arr_customs as $_key=>$_value) {
				$_arr_customRow = explode("=", $_value);
				if ($_arr_customRow && isset($_arr_customRow[1])) {
					$_arr_customSearch[$_arr_customRow[0]] = $_arr_customRow[1];
				}
			}
		}

		$_num_articleCount    = $this->mdl_articlePub->mdl_count($this->search["key"], "", "", $this->cateRow["cate_ids"], false, 0, false, $_arr_customSearch);
		$_arr_page            = fn_page($_num_articleCount, $_num_perpage); //取得分页数据
		$_str_query           = http_build_query($this->search);
		$_arr_articleRows     = $this->mdl_articlePub->mdl_list($_num_perpage, $_arr_page["except"], $this->search["key"], "", "", $this->cateRow["cate_ids"], false, 0, false, $_arr_customSearch);


		if (!file_exists(BG_PATH_CACHE . "thumb_list.php")) {
			$this->mdl_thumb->mdl_cache();
		}
		$this->mdl_attach->thumbRows = include(BG_PATH_CACHE . "thumb_list.php");

		foreach ($_arr_articleRows as $_key=>$_value) {
			$_arr_articleRows[$_key]["tagRows"] = $this->mdl_tag->mdl_list(10, 0, "", "show", "tag_id", $_value["article_id"]);

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

			$_arr_cateRow                        = include(BG_PATH_CACHE . "cate_" . $_value["article_cate_id"] . ".php");
			$_arr_articleRows[$_key]["cateRow"]  = $_arr_cateRow;

			if ($_arr_cateRow["cate_trees"][0]["cate_domain"]) {
				$_arr_articleRows[$_key]["article_url"]  = $_arr_cateRow["cate_trees"][0]["cate_domain"] . "/" . $_value["article_url"];
			}
		}

		//print_r($_arr_articleRows);

		$_arr_tplData = array(
			"query"          => $_str_query,
			"search"         => $this->search,
			"pageRow"        => $_arr_page,
			"customs"        => $_arr_customSearch,
			"articleRows"    => $_arr_articleRows,
		);

		$_arr_tpl = array_merge($this->tplData, $_arr_tplData);

		switch ($this->cateRow["cate_type"]) {
			case "single":
				$_str_tplFile = "single";
			break;

			default:
				$_str_tplFile = "show";
			break;
		}

		$this->obj_tpl->tplDisplay("cate_" . $_str_tplFile . ".tpl", $_arr_tpl);

		return array(
			"alert" => "y110102",
		);
	}


	/**
	 * cate_init function.
	 *
	 * @access private
	 * @return void
	 */
	private function cate_init() {
		$_num_cateId  = fn_getSafe(fn_get("cate_id"), "int", 0);
		$_str_key     = fn_getSafe(fn_get("key"), "txt", "");
		$_str_customs = fn_getSafe(fn_get("customs"), "txt", "");

		$this->search = array(
			"act_get"    => $GLOBALS["act_get"],
			"cate_id"    => $_num_cateId,
			"key"        => $_str_key,
			"customs"    => $_str_customs,
		);

		if (BG_VISIT_TYPE == "static") {
			$this->search["page_ext"] = "." . BG_VISIT_FILE;
		} else {
			$this->search["page_ext"] = "";
		}

		if(defined("BG_SITE_TPL")) {
			$_str_tpl = BG_SITE_TPL;
		} else {
			$_str_tpl = "default";
		}

		if ($_num_cateId > 0) {
			if (!file_exists(BG_PATH_CACHE . "cate_" . $_num_cateId . ".php")) {
				$this->mdl_cate->mdl_cache(array($_num_cateId));
			}

			$this->cateRow       = include(BG_PATH_CACHE . "cate_" . $_num_cateId . ".php");
			$this->config["tpl"] = $this->cateRow["cate_tplDo"];
		}

		if (!file_exists(BG_PATH_CACHE . "cate_trees.php")) {
			$this->mdl_cate->mdl_cache();
		}
		$_arr_cateRows = include(BG_PATH_CACHE . "cate_trees.php");

		if (!file_exists(BG_PATH_CACHE . "custom_list.php")) {
			$this->mdl_custom->mdl_cache();
		}
		$_arr_customRows = include(BG_PATH_CACHE . "custom_list.php");

		$this->mdl_articlePub->custom_columns = $_arr_customRows["article_custom"];

		$this->tplData = array(
			"customRows" => $_arr_customRows["custom_list"],
			"cateRows"   => $_arr_cateRows,
			"cateRow"    => $this->cateRow,
		);
	}
}
