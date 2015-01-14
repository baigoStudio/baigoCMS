<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_MODEL . "spec.class.php");

/*-------------文章类-------------*/
class CONTROL_SPEC {

	private $obj_tpl;
	private $search;
	private $mdl_spec;
	private $mdl_tag;
	private $mdl_tagBelong;
	private $mdl_attach;

	function __construct() { //构造函数
		$this->mdl_cate       = new MODEL_CATE(); //设置文章对象
		$this->spec_init();
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_TPL_PUB . $this->config["tpl"]); //初始化视图对象
		$this->mdl_spec       = new MODEL_SPEC();
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
		$_act_get     = fn_getSafe($GLOBALS["act_get"], "txt", "");
		$_num_specId  = fn_getSafe(fn_get("spec_id"), "int", 0);

		if ($_num_specId == 0) {
			return array(
				"str_alert" => "x180204",
			);
			exit;
		}

		$_arr_specRow = $this->mdl_spec->mdl_read($_num_specId);
		if ($_arr_specRow["str_alert"] != "y180102") {
			return $_arr_specRow;
			exit;
		}

		if ($_arr_specRow["spec_status"] != "show") {
			return array(
				"str_alert" => "x180102",
			);
		}

		$this->search["spec_id"] = $_num_specId;

		$_num_articleCount    = $this->mdl_articlePub->mdl_count("", "", "", false, false, $_arr_specRow["spec_id"]);
		$_arr_page            = fn_page($_num_articleCount); //取得分页数据
		$_str_query           = http_build_query($this->search);
		$_arr_articleRows     = $this->mdl_articlePub->mdl_list(BG_SITE_PERPAGE, $_arr_page["except"], "", "", "", false, false, $_arr_specRow["spec_id"]);
		$_arr_attachThumb     = $this->mdl_thumb->mdl_list(100);

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
			"pageRow"        => $_arr_page,
			"search"         => $this->search,
			"specRow"        => $_arr_specRow,
			"articleRows"    => $_arr_articleRows,
			"cateRows"       => $this->cateRows,
		);

		$this->obj_tpl->tplDisplay("spec_show.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y180102",
		);
	}


	/**
	 * ctl_list function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_list() {
		$_num_specCount   = $this->mdl_spec->mdl_count("", "show");
		$_arr_page        = fn_page($_num_specCount); //取得分页数据
		$_str_query       = http_build_query($this->search);
		$_arr_specRows    = $this->mdl_spec->mdl_list(BG_DEFAULT_PERPAGE, $_arr_page["except"], "", "show");

		$_arr_tplData = array(
			"query"      => $_str_query,
			"pageRow"    => $_arr_page,
			"search"     => $this->search,
			"specRows"   => $_arr_specRows,
			"cateRows"   => $this->cateRows,
		);

		$this->obj_tpl->tplDisplay("spec_list.tpl", $_arr_tplData);
	}


	private function url_process() {
		switch (BG_VISIT_TYPE) {
			case "static":
				$_str_specUrl        = BG_URL_ROOT . "spec/";
				$_str_pageAttach    = "page_";
			break;

			case "pstatic":
				$_str_specUrl       = BG_URL_ROOT . "spec/";
				$_str_pageAttach    = "";
			break;

			default:
				$_str_specUrl        = BG_URL_ROOT . "index.php?mod=spec&act_get=list";
				$_str_pageAttach    = "&page=";
			break;
		}

		return array(
			"spec_url"       => $_str_specUrl,
			"page_attach"    => $_str_pageAttach,
		);
	}


	private function spec_init() {
		if(defined("BG_SITE_TPL")) {
			$this->config["tpl"] = BG_SITE_TPL;
		} else {
			$this->config["tpl"] = "default";
		}
		$_act_get = fn_getSafe($GLOBALS["act_get"], "txt", "");

		$_arr_urlRow = $this->url_process();

		$this->search = array(
			"act_get"    => $_act_get,
			"urlRow"     => $_arr_urlRow,
		);

		if (BG_VISIT_TYPE == "static") {
			$this->search["page_ext"] = "." . BG_VISIT_FILE;
		} else {
			$this->search["page_ext"] = "";
		}

		$this->cateRows = $this->mdl_cate->mdl_list(1000);
	}
}
?>