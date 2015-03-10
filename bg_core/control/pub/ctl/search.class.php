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
class CONTROL_SEARCH {

	private $obj_tpl;
	private $search;
	private $mdl_tag;
	private $mdl_article;
	private $mdl_attach;

	function __construct() { //构造函数
		$this->mdl_cate       = new MODEL_CATE(); //设置文章对象
		$this->search_init();
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_TPL_PUB . $this->config["tpl"]); //初始化视图对象
		$this->mdl_tag        = new MODEL_TAG();
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
		$_str_query       = "";
		$_arr_page        = array();
		$_arr_articleRows = array();

		if ($this->search["key"]) {
			$_num_articleCount    = $this->mdl_articlePub->mdl_count($this->search["key"]);
			$_arr_page            = fn_page($_num_articleCount, BG_SITE_PERPAGE); //取得分页数据
			$_str_query           = http_build_query($this->search);
			$_arr_articleRows     = $this->mdl_articlePub->mdl_list(BG_SITE_PERPAGE, $_arr_page["except"], $this->search["key"]);
			$_arr_attachThumb     = $this->mdl_thumb->mdl_list(100);

			foreach ($_arr_articleRows as $_key=>$_value) {
				$_arr_articleRows[$_key]["tagRows"] = $this->mdl_tag->mdl_list(10, 0, "", "show", "tag_id", $_value["article_id"]);

				if ($_value["article_attach_id"] > 0) {
					$_arr_articleRows[$_key]["attachRow"]   = $this->mdl_attach->mdl_url($_value["article_attach_id"], $_arr_attachThumb);
				}
			}
		}

		$_arr_cateRows = $this->mdl_cate->mdl_list(1000);

		$_arr_tplData = array(
			"query"          => $_str_query,
			"pageRow"        => $_arr_page,
			"search"         => $this->search,
			"articleRows"    => $_arr_articleRows,
			"cateRows"       => $_arr_cateRows,
		);

		$this->obj_tpl->tplDisplay("search_show.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y130102",
		);
	}


	private function url_process() {
		switch (BG_VISIT_TYPE) {
			case "pstatic":
				$_str_searchUrl     = BG_URL_ROOT . "search/";
				$_str_pageAttach    = "";
			break;

			default:
				$_str_searchUrl     = BG_URL_ROOT . "index.php?mod=search&act_get=list";
				$_str_pageAttach    = "&page=";
			break;
		}

		return array(
			"search_url"     => $_str_searchUrl,
			"page_attach"    => $_str_pageAttach,
		);
	}


	private function search_init() {
		if(defined("BG_SITE_TPL")) {
			$this->config["tpl"] = BG_SITE_TPL;
		} else {
			$this->config["tpl"] = "default";
		}
		$_act_get = fn_getSafe($GLOBALS["act_get"], "txt", "");
		$_str_key = fn_getSafe(fn_get("key"), "txt", "");

		$this->search = array(
			"act_get"    => $_act_get,
			"urlRow"     => $this->url_process(),
			"key"        => $_str_key,
		);

	}
}
