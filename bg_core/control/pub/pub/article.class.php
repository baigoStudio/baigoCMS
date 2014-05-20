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
class CONTROL_ARTICLE {

	private $cateRow;
	private $articleRow;
	private $tplData;
	private $obj_tpl;
	private $mdl_cate;
	private $mdl_article;
	private $mdl_tag;
	private $mdl_upfile;

	function __construct() { //构造函数
		$this->mdl_cate       = new MODEL_CATE(); //设置文章对象
		$this->mdl_article    = new MODEL_ARTICLE_PUB(); //设置文章对象
		$this->article_init();
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_TPL_PUB . $this->config["tpl"]); //初始化视图对象
		$this->mdl_tag        = new MODEL_TAG_PUB();
		$this->mdl_upfile     = new MODEL_UPFILE(); //设置文章对象
	}


	/**
	 * ctl_list function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_show() {
		if ($this->searchRow["article_id"] == 0) {
			return array(
				"str_alert" => "x120212",
			);
			exit;
		}

		if ($this->articleRow["str_alert"] != "y120102") {
			return $this->articleRow;
			exit;
		}

		if (strlen($this->articleRow["article_title"]) < 1 || $this->articleRow["article_status"] != "pub" || $this->articleRow["article_box"] != "normal" || $this->articleRow["article_time_pub"] > time()) {
			return array(
				"str_alert" => "x120102",
			);
			exit;
		}

		if ($this->articleRow["article_link"]) {
			return array(
				"str_alert" => "x120213",
				"article_link" => $this->articleRow["article_link"],
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

		$_arr_tagRows = $this->mdl_tag->mdl_list(1000, 0, $this->articleRow["article_id"]);
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

		if ($this->articleRow["article_upfile_id"] > 0) {
			$_arr_upfileThumb                = $this->mdl_thumb->mdl_list(100);
			$_arr_upfileRow                  = $this->mdl_upfile->mdl_read($this->articleRow["article_upfile_id"]);
			$this->articleRow["upfileRow"]   = fn_upfileUrlPub($_arr_upfileRow["upfile_id"], $_arr_upfileRow["upfile_time"], $_arr_upfileRow["upfile_ext"], $_arr_upfileThumb);
		}

		$_arr_tplData = array(
			"tagRows"    => $_arr_tagRows,
			"upfileRow"  => $_arr_upfileRow,
		);

		$_arr_tpl = array_merge($this->tplData, $_arr_tplData);

		$this->obj_tpl->tplDisplay("article_show.tpl", $_arr_tpl);

		return array(
			"str_alert" => "y120102",
		);
	}


	/**
	 * article_init function.
	 *
	 * @access private
	 * @return void
	 */
	private function article_init() {
		$_act_get         = fn_getSafe($_GET["act_get"], "txt", "");
		$_num_articleId   = fn_getSafe($_GET["article_id"], "int", 0);

		$this->searchRow = array(
			"act_get"    => $_act_get,
			"article_id" => $_num_articleId,
		);

		if(defined("BG_SITE_TPL")) {
			$_str_tpl = BG_SITE_TPL;
		} else {
			$_str_tpl = "default";
		}

		if ($_num_articleId > 0) {
			$this->articleRow = $this->mdl_article->mdl_read($_num_articleId);
			if ($this->articleRow["str_alert"] == "y120102") {
				switch (BG_VISIT_TYPE) {
					case "static":
						$this->articleRow["article_url"] = BG_SITE_URL . BG_URL_ROOT . "article/" . date("Y", $this->articleRow["article_time_pub"]) . "/" . date("m", $this->articleRow["article_time_pub"]) . "/" . $this->articleRow["article_id"] . "." . BG_VISIT_FILE;
					break;

					case "pstatic":
						$this->articleRow["article_url"] = BG_SITE_URL . BG_URL_ROOT . "article/" . $this->articleRow["article_id"];
					break;

					default:
						$this->articleRow["article_url"] = BG_SITE_URL . BG_URL_ROOT . "index.php?mod=article&act_get=show&article_id=" . $this->articleRow["article_id"];
					break;
				}

				$this->cateRow               = $this->mdl_cate->mdl_read($this->articleRow["article_cate_id"]);
				if ($this->cateRow["str_alert"] == "y110102") {
					$this->cateRow["cate_url"]   = $this->cate_urlProcess($this->articleRow["article_cate_id"]);

					$_str_cateTpl        = $this->tpl_process($this->articleRow["article_cate_id"]);
					if ($_str_cateTpl == "inherit") {
						$this->config["tpl"] = $_str_tpl;
					} else {
						$this->config["tpl"] = $_str_cateTpl;
					}
					if (!$this->config["tpl"]) {
						$this->config["tpl"] = "default";
					}
				} else {
					$this->config["tpl"] = $_str_tpl;
				}
			} else {
				$this->config["tpl"] = $_str_tpl;
			}
		} else {
			$this->config["tpl"] = $_str_tpl;
		}

		if ($this->cateTreesGlobal) {
			foreach ($this->cateTreesGlobal as $_key=>$_value) {
				$this->cateTreesGlobal[$_key]["cate_url"] = $this->cate_urlProcess($_value["cate_id"]);
			}
		}

		$this->tplData = array(
			"cateRow"    => $this->cateRow,
			"cateTrees"  => $this->cateTreesGlobal,
			"articleRow" => $this->articleRow,
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
							$_str_cateUrlParent .= $_tree_value["cate_alias"] . "/";
						} else {
							$_str_cateUrlParent .= $_tree_value["cate_name"] . "/";
						}
					}

					$_str_cateUrl = BG_SITE_URL . BG_URL_ROOT . "cate/" . $_str_cateUrlParent;
					unset($_str_cateUrlParent);
					unset($this->cateTrees);
				break;

				case "pstatic":
					$this->trees_process($_num_cateId);

					foreach ($this->cateTrees as $_tree_value) {
						if ($_tree_value["cate_alias"]) {
							$_str_cateUrlParent .= $_tree_value["cate_alias"] . "/";
						} else {
							$_str_cateUrlParent .= $_tree_value["cate_name"] . "/";
						}
					}

					$_str_cateUrl = BG_SITE_URL . BG_URL_ROOT . "cate/" . $_str_cateUrlParent . $_num_cateId . "/";
					unset($_str_cateUrlParent);
					unset($this->cateTrees);
				break;

				default:
					$_str_cateUrl = BG_SITE_URL . BG_URL_ROOT . "index.php?mod=cate&act_get=show&cate_id=" . $_num_cateId;
				break;
			}
		}
		return $_str_cateUrl;
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