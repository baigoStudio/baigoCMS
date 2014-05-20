<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "cate.func.php"); //载入模板类
include_once(BG_PATH_FUNC . "upfile.func.php"); //载入开放平台类
include_once(BG_PATH_MODEL . "thumb.class.php"); //载入上传模型

/*-------------文章类-------------*/
class CONTROL_CATE {

	private $cateRow;
	private $cateTrees;
	private $cateIds;
	private $searchRow;
	private $tplData;
	private $obj_tpl;
	private $mdl_cate;
	private $mdl_tag;
	private $mdl_article;
	private $mdl_upfile;

	function __construct() { //构造函数
		$this->mdl_cate       = new MODEL_CATE(); //设置文章对象
		$this->cate_init();
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_TPL_PUB . $this->config["tpl"]); //初始化视图对象
		$this->mdl_tag        = new MODEL_TAG_PUB();
		$this->mdl_article    = new MODEL_ARTICLE_PUB(); //设置文章对象
		$this->mdl_upfile     = new MODEL_UPFILE(); //设置文章对象
		$this->mdl_thumb      = new MODEL_THUMB(); //设置上传信息对象
	}


	/**
	 * ctl_list function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_show() {
		if ($this->searchRow["cate_id"] == 0) {
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

		$_num_articleCount            = $this->mdl_article->mdl_count("", "", "", $this->cateIds, false, false);
		$_arr_page                    = fn_page($_num_articleCount, BG_SITE_PERPAGE); //取得分页数据
		$_str_query                   = http_build_query($this->searchRow);
		$_arr_articleRows             = $this->mdl_article->mdl_list(BG_SITE_PERPAGE, $_arr_page["except"], "", "", "", $this->cateIds, false, false);

		foreach ($_arr_articleRows as $_key=>$_value) {
			if ($_value["article_link"]) {
				$_arr_articleRows[$_key]["article_url"] = $_value["article_link"];
			} else {
				switch (BG_VISIT_TYPE) {
					case "static":
						$_arr_articleRows[$_key]["article_url"] = BG_SITE_URL . BG_URL_ROOT . "article/" . date("Y", $_value["article_time_pub"]) . "/" . date("m", $_value["article_time_pub"]) . "/" . $_value["article_id"] . "." . BG_VISIT_FILE;
					break;

					case "pstatic":
						$_arr_articleRows[$_key]["article_url"] = BG_SITE_URL . BG_URL_ROOT . "article/" . $_value["article_id"];
					break;

					default:
						$_arr_articleRows[$_key]["article_url"] = BG_SITE_URL . BG_URL_ROOT . "index.php?mod=article&act_get=show&article_id=" . $_value["article_id"];
					break;
				}
			}

			$_arr_tagRows = $this->mdl_tag->mdl_list(1000, 0, $_value["article_id"]);
			foreach ($_arr_tagRows as $_key_tag=>$_value_tag) {
				switch (BG_VISIT_TYPE) {
					case "static":
					case "pstatic":
						$_arr_tagRows[$_key_tag]["tag_url"] = BG_SITE_URL . BG_URL_ROOT . "tag/" . $_value_tag["tag_name"] . "/";
					break;

					default:
						$_arr_tagRows[$_key_tag]["tag_url"] = BG_SITE_URL . BG_URL_ROOT . "index.php?mod=tag&act_get=list&tag_name=" . $_value_tag["tag_name"];
					break;
				}
			}
			$_arr_articleRows[$_key]["tagRows"] = $_arr_tagRows;

			if ($_value["article_upfile_id"] > 0) {
				$_arr_upfileThumb                       = $this->mdl_thumb->mdl_list(100);
				$_arr_upfileRow                         = $this->mdl_upfile->mdl_read($_value["article_upfile_id"]);
				$_arr_articleRows[$_key]["upfileRow"]   = fn_upfileUrlPub($_arr_upfileRow["upfile_id"], $_arr_upfileRow["upfile_time"], $_arr_upfileRow["upfile_ext"], $_arr_upfileThumb);
			}
		}

		switch (BG_VISIT_TYPE) {
			case "static":
			case "pstatic":
				$_str_cateUrl = BG_SITE_URL . BG_URL_ROOT . "cate/" . $_value_tag["tag_name"];
			break;

			default:
				$_str_cateUrl = BG_SITE_URL . BG_URL_ROOT . "index.php?mod=tag&act_get=list&tag_name=" . $_value_tag["tag_name"];
			break;
		}

		$_arr_tplData = array(
			"query"          => $_str_query,
			"pageRow"        => $_arr_page,
			"search"         => $this->searchRow,
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

		$this->searchRow = array(
			"act_get"    => $_act_get,
			"cate_id"    => $_num_cateId,
		);

		if(defined("BG_SITE_TPL")) {
			$_str_tpl = BG_SITE_TPL;
		} else {
			$_str_tpl = "default";
		}

		if ($_num_cateId > 0) {
			$this->cateRow               = $this->mdl_cate->mdl_read($_num_cateId);
			if ($this->cateRow["str_alert"] == "y110102") {
				$_arr_urlRow                    = $this->cate_urlProcess($_num_cateId);
				$this->cateRow["cate_url"]      = $_arr_urlRow["cate_url"];
				$this->cateRow["page_attach"]   = $_arr_urlRow["page_attach"];

				if (BG_VISIT_TYPE == "static") {
					$this->cateRow["page_ext"] = "." . BG_VISIT_FILE;
				}

				if ($this->cateRow["cate_parent_id"] > 0) {
					$_arr_cateParent               = $this->mdl_cate->mdl_read($this->cateRow["cate_parent_id"]);
					$_arr_urlRow                   = $this->cate_urlProcess($this->cateRow["cate_parent_id"]);
					$_arr_cateParent["cate_url"]   = $_arr_urlRow["cate_url"];
				}

				$_arr_cateBrothers   = $this->mdl_cate->mdl_list(1000, 0, "show", "", $this->cateRow["cate_parent_id"]);
				$_arr_cateChilds     = $this->mdl_cate->mdl_list(1000, 0, "show", "", $_num_cateId);
				$this->cateIds       = fn_cateIds($_arr_cateChilds);
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
			} else {
				$this->cateIds       = false;
				$this->config["tpl"] = $_str_tpl;
			}
		} else {
			$this->cateIds       = false;
			$this->config["tpl"] = $_str_tpl;
		}

		if ($this->cateTreesGlobal) {
			foreach ($this->cateTreesGlobal as $_key=>$_value) {
				$_arr_urlRow                                 = $this->cate_urlProcess($_value["cate_id"]);
				$this->cateTreesGlobal[$_key]["cate_url"]    = $_arr_urlRow["cate_url"];
			}
		}

		if ($_arr_cateBrothers) {
			foreach ($_arr_cateBrothers as $_key=>$_value) {
				$_arr_urlRow                             = $this->cate_urlProcess($_value["cate_id"]);
				$_arr_cateBrothers[$_key]["cate_url"]    = $_arr_urlRow["cate_url"];
			}
		}

		if ($_arr_cateChilds) {
			foreach ($_arr_cateChilds as $_key=>$_value) {
				$_arr_urlRow                         = $this->cate_urlProcess($_value["cate_id"]);
				$_arr_cateChilds[$_key]["cate_url"]  = $_arr_urlRow["cate_url"];
			}
		}

		$this->tplData = array(
			"cateRow"        => $this->cateRow,
			"cateParent"     => $_arr_cateParent,
			"cateTrees"      => $this->cateTreesGlobal,
			"cateBrothers"   => $_arr_cateBrothers,
			"cateChilds"     => $_arr_cateChilds,
		);
	}


	/**
	 * cate_urlProcess function.
	 *
	 * @access private
	 * @param mixed $_num_cateId
	 * @return void
	 */
	private function cate_urlProcess($_num_cateId) {
		$_arr_cateRow = $this->mdl_cate->mdl_read($_num_cateId);

		if ($_arr_cateRow["cate_link"]) {
			$_str_cateUrl = $_arr_cateRow["cate_link"];
		} else {
			switch (BG_VISIT_TYPE) {
				case "static":
					$this->trees_process($_num_cateId);
					foreach ($this->cateTrees as $_tree_value) {
						if ($_tree_value["cate_alias"]) {
							$_str_cateUrlTree .= $_tree_value["cate_alias"] . "/";
						} else {
							$_str_cateUrlTree .= $_tree_value["cate_name"] . "/";
						}
					}

					$_str_cateUrl       = BG_SITE_URL . BG_URL_ROOT . "cate/" . $_str_cateUrlTree;
					$_str_pageAttach    = "page_";
					unset($_str_cateUrlTree);
					unset($this->cateTrees);
				break;

				case "pstatic":
					$this->trees_process($_num_cateId);

					foreach ($this->cateTrees as $_tree_value) {
						if ($_tree_value["cate_alias"]) {
							$_str_cateUrlTree .= $_tree_value["cate_alias"] . "/";
						} else {
							$_str_cateUrlTree .= $_tree_value["cate_name"] . "/";
						}
					}

					$_str_cateUrl       = BG_SITE_URL . BG_URL_ROOT . "cate/" . $_str_cateUrlTree . $_num_cateId . "/";
					unset($_str_cateUrlTree);
					unset($this->cateTrees);
				break;

				default:
					$_str_cateUrl       = BG_SITE_URL . BG_URL_ROOT . "index.php?mod=cate&act_get=show&cate_id=" . $_num_cateId;
					$_str_pageAttach    = "&page=";
				break;
			}
		}

		return array(
			"cate_url"       => $_str_cateUrl,
			"page_attach"    => $_str_pageAttach,
		);
	}


	/**
	 * trees_process function.
	 *
	 * @access private
	 * @param mixed $_num_cateId
	 * @return void
	 */
	private function trees_process($_num_cateId) {
		$_arr_cateRow = $this->mdl_cate->mdl_read($_num_cateId);

		$this->cateTrees[] = array(
			"cate_id"        => $_arr_cateRow["cate_id"],
			"cate_name"      => $_arr_cateRow["cate_name"],
			"cate_link"      => $_arr_cateRow["cate_link"],
			"cate_alias"     => $_arr_cateRow["cate_alias"],
			"cate_domain"    => $_arr_cateRow["cate_domain"],
		);

		if ($_arr_cateRow["cate_parent_id"] > 0) {
			$this->trees_process($_arr_cateRow["cate_parent_id"]);
		}

		krsort($this->cateTrees);
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

		$this->cateTreesGlobal[] = array(
			"cate_id"        => $_arr_cateRow["cate_id"],
			"cate_name"      => $_arr_cateRow["cate_name"],
			"cate_link"      => $_arr_cateRow["cate_link"],
			"cate_alias"     => $_arr_cateRow["cate_alias"],
			"cate_domain"    => $_arr_cateRow["cate_domain"],
		);

		if ($_str_cateTpl == "inherit" && $_arr_cateRow["cate_parent_id"] > 0) {
			$_str_cateTpl = $this->tpl_process($_arr_cateRow["cate_parent_id"]);
		}

		krsort($this->cateTreesGlobal);
		return $_str_cateTpl;
	}
}
?>