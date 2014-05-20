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
	private $searchRow;
	private $mdl_tag;
	private $mdl_article;
	private $mdl_upfile;

	function __construct() { //构造函数
		$this->search_init();
		$this->obj_tpl        = new CLASS_TPL(BG_PATH_TPL_PUB . $this->config["tpl"]); //初始化视图对象
		$this->mdl_tag        = new MODEL_TAG_PUB();
		$this->mdl_article    = new MODEL_ARTICLE_PUB(); //设置文章对象
		$this->mdl_upfile     = new MODEL_UPFILE(); //设置文章对象
	}


	/**
	 * ctl_list function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_show() {
		if ($this->searchRow["key"]) {
			$_num_articleCount    = $this->mdl_article->mdl_count($this->searchRow["key"], "", "", false, false, false);
			$_arr_page            = fn_page($_num_articleCount, BG_SITE_PERPAGE); //取得分页数据
			$_str_query           = http_build_query($this->searchRow);
			$_arr_articleRows     = $this->mdl_article->mdl_list(BG_SITE_PERPAGE, $_arr_page["except"], $this->searchRow["key"], "", "", false, false, false);

			foreach ($_arr_articleRows as $_key=>$_value) {
				if ($_value["article_link"]) {
					$_arr_articleRows[$_key]["article_url"] = $_value["article_link"];
				} else {
					switch (BG_VISIT_TYPE) {
						case "static":
							$_arr_articleRows[$_key]["article_url"] = BG_SITE_URL . BG_URL_ROOT . "article/" . date("Y", $_value["article_time_pub"]) . "/" . date("m", $_value["article_time_pub"]) . "/" . $_value["article_id"] . ".shtml";
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
			}
		}

		$_arr_tplData = array(
			"query"          => $_str_query,
			"pageRow"        => $_arr_page,
			"search"         => $this->searchRow,
			"articleRows"    => $_arr_articleRows,
		);

		$this->obj_tpl->tplDisplay("search_show.tpl", $_arr_tplData);

		return array(
			"str_alert" => "y130102",
		);
	}


	private function search_init() {
		if(defined("BG_SITE_TPL")) {
			$this->config["tpl"] = BG_SITE_TPL;
		} else {
			$this->config["tpl"] = "default";
		}
		$_act_get = fn_getSafe($_GET["act_get"], "txt", "");
		$_str_key = fn_getSafe($_GET["key"], "txt", "");

		$this->searchRow = array(
			"act_get"    => $_act_get,
			"key"        => $_str_key,
		);

	}
}
?>