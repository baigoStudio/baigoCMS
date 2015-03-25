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
	private $mdl_articlePub;
	private $mdl_tag;
	private $mdl_attach;

	function __construct() { //构造函数
		$this->mdl_cate       = new MODEL_CATE(); //设置文章对象
		$this->mdl_articlePub = new MODEL_ARTICLE_PUB(); //设置文章对象
		$this->mdl_tag        = new MODEL_TAG();
		$this->article_init();
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_TPL_PUB . $this->config["tpl"]); //初始化视图对象
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
		if ($this->search["article_id"] == 0) {
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

		if ($this->cateRow["cate_type"] == "link" && $this->cateRow["cate_link"]) {
			return array(
				"str_alert" => "x110218",
				"cate_link" => $this->cateRow["cate_link"],
			);
			exit;
		}

		if ($this->articleRow["article_attach_id"] > 0) {
			$_arr_attachThumb                = $this->mdl_thumb->mdl_list(100);
			$this->articleRow["attachRow"]   = $this->mdl_attach->mdl_url($this->articleRow["article_attach_id"], $_arr_attachThumb);
		}

		//print_r(date("W", strtotime("2014-12-01")));

		$this->mdl_articlePub->mdl_hits($this->articleRow["article_id"]);

		//$_arr_tpl = array_merge($this->tplData, $_arr_tplData);

		$this->obj_tpl->tplDisplay("article_show.tpl", $this->tplData);

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
		$_act_get         = fn_getSafe($GLOBALS["act_get"], "txt", "");
		$_num_articleId   = fn_getSafe(fn_get("article_id"), "int", 0);

		$this->search = array(
			"act_get"    => $_act_get,
			"article_id" => $_num_articleId,
		);

		if(defined("BG_SITE_TPL")) {
			$_str_tpl = BG_SITE_TPL;
		} else {
			$_str_tpl = "default";
		}

		if ($_num_articleId > 0) {
			$this->articleRow = $this->mdl_articlePub->mdl_read($_num_articleId);
			if ($this->articleRow["str_alert"] == "y120102") {
				$this->cateRow               = $this->mdl_cate->mdl_readPub($this->articleRow["article_cate_id"]);
				if ($this->cateRow["str_alert"] == "y110102" && $this->cateRow["cate_status"] == "show") {
					$_str_cateTpl        = $this->tpl_process($this->articleRow["article_cate_id"]);
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
							$_arr_cateRow = $this->mdl_cate->mdl_readPub($_value["cate_id"]);
							if ($_arr_cateRow["str_alert"] == "y110102" && $_arr_cateRow["cate_status"] == "show") {
								$this->cateRow["cate_trees"][$_key]["urlRow"] = $_arr_cateRow["urlRow"];
							}
						}
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

		$this->articleRow["cateRow"] = $this->cateRow;

		$this->articleRow["tagRows"] = $this->mdl_tag->mdl_list(10, 0, "", "show", "tag_id", $this->articleRow["article_id"]);

		$_arr_cateRows = $this->mdl_cate->mdl_list(1000, 0, "show");

		$this->tplData = array(
			"cateRows"   => $_arr_cateRows,
			"articleRow" => $this->articleRow,
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
		$_arr_cateRow = $this->mdl_cate->mdl_readPub($num_cateId);
		if ($_arr_cateRow["str_alert"] == "y110102" && $_arr_cateRow["cate_status"] == "show") {
			$_str_cateTpl = $_arr_cateRow["cate_tpl"];

			if ($_str_cateTpl == "inherit" && $_arr_cateRow["cate_parent_id"] > 0) {
				$_str_cateTpl = $this->tpl_process($_arr_cateRow["cate_parent_id"]);
			}
		} else {
			$_str_cateTpl = BG_SITE_TPL;
		}

		return $_str_cateTpl;
	}
}
