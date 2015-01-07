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
	private $mdl_tagBelong;
	private $mdl_article;
	private $mdl_attach;

	function __construct() { //构造函数
		$this->mdl_cate       = new MODEL_CATE(); //设置文章对象
		$this->cate_init();
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_TPL_PUB . $this->config["tpl"]); //初始化视图对象
		$this->mdl_tag        = new MODEL_TAG();
		$this->mdl_tagBelong  = new MODEL_TAG_BELONG();
		$this->mdl_articlePub = new MODEL_ARTICLE_PUB(); //设置文章对象
		$this->mdl_attach     = new MODEL_ATTACH(); //设置文章对象
		$this->mdl_thumb      = new MODEL_THUMB(); //设置上传信息对象
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
				"str_alert" => "x110217",
			);
			exit;
		}
		if ($this->cateRow["str_alert"] != "y110102") {
			return $this->cateRow;
			exit;
		}

		if ($this->cateRow["cate_link"]) {
			return array(
				"str_alert" => "x110218",
				"cate_link" => $this->cateRow["cate_link"],
			);
			exit;
		}

		$_num_articleCount            = $this->mdl_articlePub->mdl_count("", "", "", $this->cateIds);
		$_arr_page                    = fn_page($_num_articleCount); //取得分页数据
		$_str_query                   = http_build_query($this->search);
		$_arr_articleRows             = $this->mdl_articlePub->mdl_list(BG_SITE_PERPAGE, $_arr_page["except"], "", "", "", $this->cateIds);
		$_arr_attachThumb             = $this->mdl_thumb->mdl_list(100);

		foreach ($_arr_articleRows as $_key=>$_value) {
			$_arr_tagBelongRows = $this->mdl_tagBelong->mdl_list($_value["article_id"]);

			foreach ($_arr_tagBelongRows as $_key_tag=>$_value_tag) {
				$_arr_tagRow = $this->mdl_tag->mdl_read($_value_tag["belong_tag_id"]);
				if ($_arr_tagRow["tag_status"] == "show") {
					$_arr_articleRows[$_key]["tagRows"][$_key_tag] = $_arr_tagRow;
				}
			}

			$_arr_articleRows[$_key]["attachRow"]   = $this->mdl_attach->mdl_url($_value["article_attach_id"], $_arr_attachThumb);
		}

		$_arr_tplData = array(
			"query"          => $_str_query,
			"search"         => $this->search,
			"pageRow"        => $_arr_page,
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
			"str_alert" => "y110102",
		);
	}


	/**
	 * cate_init function.
	 *
	 * @access private
	 * @return void
	 */
	private function cate_init() {
		$_act_get     = fn_getSafe($_GET["act_get"], "txt", "");
		$_num_cateId  = fn_getSafe($_GET["cate_id"], "int", 0);

		$this->search = array(
			"act_get"    => $_act_get,
			"cate_id"    => $_num_cateId,
		);

		if (BG_VISIT_TYPE == "static") {
			$this->search["page_ext"] = "." . BG_VISIT_FILE;
		}

		if(defined("BG_SITE_TPL")) {
			$_str_tpl = BG_SITE_TPL;
		} else {
			$_str_tpl = "default";
		}

		if ($_num_cateId > 0) {
			$this->cateRow = $this->mdl_cate->mdl_read($_num_cateId);
			if ($this->cateRow["str_alert"] == "y110102") {
				$this->cateIds       = $this->mdl_cate->mdl_cateIds($_num_cateId);
				$this->cateIds[]     = $_num_cateId;
				$_str_cateTpl        = $this->tpl_process($_num_cateId);
				if ($_str_cateTpl == "inherit") {
					$this->config["tpl"] = $_str_tpl;
				} else {
					$this->config["tpl"] = $_str_cateTpl;
				}
				if (!$this->config["tpl"]) {
					$this->config["tpl"] = "default";
				}

				if (is_array($this->cateRow["cate_trees"])) {
					foreach ($this->cateRow["cate_trees"] as $_key=>$_value) {
						$_arr_cateRow = $this->mdl_cate->mdl_read($_value["cate_id"]);
						$this->cateRow["cate_trees"][$_key]["urlRow"] = $_arr_cateRow["urlRow"];
					}
				}
			} else {
				$this->cateIds       = false;
				$this->config["tpl"] = $_str_tpl;
			}
		} else {
			$this->cateIds       = false;
			$this->config["tpl"] = $_str_tpl;
		}

		$_arr_cateRows = $this->mdl_cate->mdl_list(1000);

		$this->tplData = array(
			"cateRows"   => $_arr_cateRows,
			"cateRow"    => $this->cateRow,
		);
	}


	/**
	 * tpl_process function.
	 *
	 * @access private
	 * @param mixed $num_cateId
	 * @return void
	 */
	private function tpl_process($num_cateId) {
		$_arr_cateRow = $this->mdl_cate->mdl_read($num_cateId);
		$_str_cateTpl = $_arr_cateRow["cate_tpl"];

		if ($_str_cateTpl == "inherit" && $_arr_cateRow["cate_parent_id"] > 0) {
			$_str_cateTpl = $this->tpl_process($_arr_cateRow["cate_parent_id"]);
		}

		return $_str_cateTpl;
	}
}
?>