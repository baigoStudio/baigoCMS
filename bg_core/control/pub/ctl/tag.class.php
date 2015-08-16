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
class CONTROL_TAG {

	private $obj_tpl;
	private $search;
	private $mdl_tag;
	private $mdl_articlePub;
	private $mdl_attach;

	function __construct() { //构造函数
		$this->mdl_cate           = new MODEL_CATE(); //设置文章对象
		$this->mdl_custom         = new MODEL_CUSTOM();
		$this->tag_init();
		$this->obj_tpl            = new CLASS_TPL(BG_PATH_TPL_PUB . $this->config["tpl"]); //初始化视图对象
		$this->mdl_tag            = new MODEL_TAG();
		$this->mdl_articlePub     = new MODEL_ARTICLE_PUB();
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
		$_str_tagName = fn_getSafe(fn_get("tag_name"), "txt", "");

		if (!$_str_tagName) {
			return array(
				"alert" => "x130201",
			);
			exit;
		}

		$_arr_tagRow = $this->mdl_tag->mdl_read($_str_tagName, "tag_name");

		if ($_arr_tagRow["alert"] != "y130102") {
			return $_arr_tagRow;
			exit;
		}

		if ($_arr_tagRow["tag_status"] != "show") {
			return array(
				"alert" => "x130102",
			);
		}

		$_arr_tagIds = array($_arr_tagRow["tag_id"]);

		$this->search["tag_name"] = $_str_tagName;

		$_num_articleCount    = $this->mdl_articlePub->mdl_count("", "", "", false, false, false, $_arr_tagIds);
		$_arr_page            = fn_page($_num_articleCount, BG_SITE_PERPAGE); //取得分页数据
		$_str_query           = http_build_query($this->search);
		$_arr_articleRows     = $this->mdl_articlePub->mdl_list(BG_SITE_PERPAGE, $_arr_page["except"], "", "", "", false, false, false, $_arr_tagIds);
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
				$_arr_articleRows[$_key]["attachRow"]   = $_arr_attachRow;
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

		//统计 tag 文章数
		$this->mdl_tag->mdl_countDo($_arr_tagRow["tag_id"], $_num_articleCount); //更新

		$_arr_tplData = array(
			"query"          => $_str_query,
			"pageRow"        => $_arr_page,
			"search"         => $this->search,
			"tagRow"         => $_arr_tagRow,
			"articleRows"    => $_arr_articleRows,
			"cateRows"       => $this->cateRows,
			"customRows"     => $this->customRows["custom_list"],
		);

		$this->obj_tpl->tplDisplay("tag_show.tpl", $_arr_tplData);

		return array(
			"alert" => "y130102",
		);
	}


	private function tag_init() {
		if(defined("BG_SITE_TPL")) {
			$this->config["tpl"] = BG_SITE_TPL;
		} else {
			$this->config["tpl"] = "default";
		}

		$this->search = array(
			"act_get"    => $GLOBALS["act_get"],
		);

		if (BG_VISIT_TYPE == "static") {
			$this->search["page_ext"] = "." . BG_VISIT_FILE;
		} else {
			$this->search["page_ext"] = "";
		}

		if (!file_exists(BG_PATH_CACHE . "cate_trees.php")) {
			$this->mdl_cate->mdl_cache();
		}
		$this->cateRows = include(BG_PATH_CACHE . "cate_trees.php");

		if (!file_exists(BG_PATH_CACHE . "custom_list.php")) {
			$this->mdl_custom->mdl_cache();
		}
		$this->customRows = include(BG_PATH_CACHE . "custom_list.php");
	}
}
