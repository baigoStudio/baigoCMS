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
	private $mdl_tagBelong;
	private $mdl_attach;

	function __construct() { //构造函数
		$this->mdl_cate       = new MODEL_CATE(); //设置文章对象
		$this->mdl_article    = new MODEL_ARTICLE(); //设置文章对象
		$this->article_init();
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_TPL_PUB . $this->config["tpl"]); //初始化视图对象
		$this->mdl_tag        = new MODEL_TAG();
		$this->mdl_tagBelong  = new MODEL_TAG_BELONG();
		$this->mdl_attach     = new MODEL_ATTACH(); //设置文章对象
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

		$_arr_tagBelongRows = $this->mdl_tagBelong->mdl_list($this->articleRow["article_id"]);
		foreach ($_arr_tagBelongRows as $_key_tag=>$_value_tag) {
			$_arr_tagRow = $this->mdl_tag->mdl_read($_value_tag["belong_tag_id"]);
			if ($_arr_tagRow["tag_status"] == "show") {
				$_arr_tagBelongRows[$_key_tag] = $_arr_tagRow;
			}

		}

		if ($this->articleRow["article_attach_id"] > 0) {
			$_arr_attachThumb                = $this->mdl_thumb->mdl_list(100);
			$_arr_attachRow                  = $this->mdl_attach->mdl_read($this->articleRow["article_attach_id"]);
			$this->articleRow["attachRow"]   = $this->mdl_attach->mdl_url($_arr_attachRow["attach_id"], $_arr_attachThumb);
		}

		$_arr_tplData = array(
			"tagRows"    => $_arr_tagBelongRows,
			"attachRow"  => $_arr_attachRow,
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
			$this->articleRow = $this->mdl_articlePub->mdl_read($_num_articleId);
			if ($this->articleRow["str_alert"] == "y120102") {
				$this->cateRow               = $this->mdl_cate->mdl_read($this->articleRow["article_cate_id"]);
				if ($this->cateRow["str_alert"] == "y110102") {
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

		$this->tplData = array(
			"cateRow"    => $this->cateRow,
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
		$_arr_cateRow = $this->mdl_cate->mdl_read($num_cateId);
		$_str_cateTpl = $_arr_cateRow["cate_tpl"];

		if ($_str_cateTpl == "inherit" && $_arr_cateRow["cate_parent_id"] > 0) {
			$_str_cateTpl = $this->tpl_process($_arr_cateRow["cate_parent_id"]);
		}

		return $_str_cateTpl;
	}
}
?>