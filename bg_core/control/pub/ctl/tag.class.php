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
	private $mdl_tagPub;
	private $mdl_tagBelong;
	private $mdl_attach;

	function __construct() { //构造函数
		$this->tag_init();
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_TPL_PUB . $this->config["tpl"]); //初始化视图对象
		$this->mdl_tag        = new MODEL_TAG();
		$this->mdl_tagPub     = new MODEL_TAG_PUB();
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
		$_str_tagName = fn_getSafe($_GET["tag_name"], "txt", "");

		if (!$_str_tagName) {
			return array(
				"str_alert" => "x130201",
			);
			exit;
		}

		$_arr_tagRow = $this->mdl_tag->mdl_read($_str_tagName, "tag_name");
		if ($_arr_tagRow["str_alert"] != "y130102") {
			return $_arr_tagRow;
			exit;
		}

		if ($_arr_tagRow["tag_status"] != "show") {
			return array(
				"str_alert" => "x130102",
			);
		}

		$_arr_tagIds = array($_arr_tagRow["tag_id"]);

		$this->search["tag_name"] = $_str_tagName;

		$_num_articleCount    = $this->mdl_tagPub->mdl_count($_arr_tagIds);
		$_arr_page            = fn_page($_num_articleCount); //取得分页数据
		$_str_query           = http_build_query($this->search);
		$_arr_articleRows     = $this->mdl_tagPub->mdl_list(BG_SITE_PERPAGE, $_arr_page["except"], $_arr_tagIds);

		foreach ($_arr_articleRows as $_key=>$_value) {
			$_arr_tagBelongRows = $this->mdl_tagBelong->mdl_list($_value["article_id"]);
			foreach ($_arr_tagBelongRows as $_key_tag=>$_value_tag) {
				$_arr_tagRow = $this->mdl_tag->mdl_read($_value_tag["belong_tag_id"]);
				if ($_arr_tagRow["tag_status"] == "show") {
					$_arr_articleRows[$_key]["tagRows"][$_key_tag] = $_arr_tagRow;
				}
			}

			if ($_value["article_attach_id"] > 0) {
				$_arr_attachThumb                       = $this->mdl_thumb->mdl_list(100);
				$_arr_attachRow                         = $this->mdl_attach->mdl_read($_value["article_attach_id"]);
				$_arr_articleRows[$_key]["attachRow"]   = $this->mdl_attach->mdl_url($_arr_attachRow["attach_id"], $_arr_attachThumb);
			}
		}

		$_arr_tplData = array(
			"query"          => $_str_query,
			"pageRow"        => $_arr_page,
			"search"         => $this->search,
			"tagRow"         => $_arr_tagRow,
			"articleRows"    => $_arr_articleRows,
		);

		$this->obj_tpl->tplDisplay("tag_show.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y130102",
		);
	}


	/**
	 * ctl_list function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_list() {
		$_num_perPage     = 90;
		$_num_tagCount    = $this->mdl_tag->mdl_count("", "show");
		$_arr_page        = fn_page($_num_tagCount, $_num_perPage); //取得分页数据
		$_str_query       = http_build_query($this->search);
		$_arr_tagRows     = $this->mdl_tag->mdl_list($_num_perPage, $_arr_page["except"], "", "show");

		$_arr_tplData = array(
			"query"      => $_str_query,
			"pageRow"    => $_arr_page,
			"search"     => $this->search,
			"tagRows"    => $_arr_tagRows,
		);

		$this->obj_tpl->tplDisplay("tag_list.tpl", $_arr_tplData);
	}


	private function url_process() {
		switch (BG_VISIT_TYPE) {
			case "static":
				$_str_tagUrl        = BG_URL_ROOT . "tag/";
				$_str_pageAttach    = "page_";
			break;

			case "pstatic":
				$_str_tagUrl = BG_URL_ROOT . "tag/";
			break;

			default:
				$_str_tagUrl        = BG_URL_ROOT . "index.php?mod=tag&act_get=list";
				$_str_pageAttach    = "&page=";
			break;
		}

		return array(
			"tag_url"        => $_str_tagUrl,
			"page_attach"    => $_str_pageAttach,
		);
	}


	private function tag_init() {
		if(defined("BG_SITE_TPL")) {
			$this->config["tpl"] = BG_SITE_TPL;
		} else {
			$this->config["tpl"] = "default";
		}
		$_act_get = fn_getSafe($_GET["act_get"], "txt", "");

		$this->search = array(
			"act_get"    => $_act_get,
			"urlRow"     => $_arr_urlRow,
		);

		if (BG_VISIT_TYPE == "static") {
			$this->search["page_ext"] = "." . BG_VISIT_FILE;
		}
	}
}
?>