<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

function fn_callDisplay($arr_call, $template) {
	$_obj_call     = new CLASS_CALL_DISPLAY();
	$_arr_callRow  = $_obj_call->display_init($arr_call["call_id"]); //读取调用信息

	$_arr_return   = array();

	if ($_arr_callRow["str_alert"] == "y170102" && $_arr_callRow["call_status"] == "enable") {

		switch ($_arr_callRow["call_type"]) {
			case "spec":
				$_arr_return = $_obj_call->display_spec();
			break;

			//栏目列表
			case "cate":
				$_arr_return = $_obj_call->display_cate();
			break;

			//TAG 列表
			case "tag_list":
			case "tag_rank":
				$_arr_return = $_obj_call->display_tag();
			break;

			//文章列表
			default:
				$_arr_return = $_obj_call->display_article();
			break;
		}

	}

	//print_r($_arr_return);
	$callRows[$arr_call["call_id"]] = $_arr_return;
	$template->assign("callRows", $callRows);
}

class CLASS_CALL_DISPLAY {

	private $mdl_call;
	private $mdl_cate;
	private $mdl_article;
	private $mdl_tag;
	private $mdl_attach;
	private $callRow;

	function __construct() { //构造函数
		$this->mdl_call       = new MODEL_CALL();
		$this->mdl_spec       = new MODEL_SPEC();
		$this->mdl_cate       = new MODEL_CATE();
		$this->mdl_articlePub = new MODEL_ARTICLE_PUB();
		$this->mdl_tag        = new MODEL_TAG();
		$this->mdl_attach     = new MODEL_ATTACH();
		$this->mdl_thumb      = new MODEL_THUMB(); //设置上传信息对象
	}


	/**
	 * display_init function.
	 *
	 * @access public
	 * @param mixed $_num_callId
	 * @return void
	 */
	function display_init($_num_callId) {
		$this->callRow = $this->mdl_call->mdl_read($_num_callId);
		return $this->callRow;
	}


	/**
	 * display_cate function.
	 *
	 * @access public
	 * @return void
	 */
	function display_cate() {
		$_arr_cateRows = $this->mdl_cate->mdl_list($this->callRow["call_amount"]["top"], $this->callRow["call_amount"]["except"], "show", "", $this->callRow["call_cate_id"]);

		return $_arr_cateRows;
	}


	/**
	 * display_spec function.
	 *
	 * @access public
	 * @return void
	 */
	function display_spec() {
		$_arr_specRows = $this->mdl_spec->mdl_list($this->callRow["call_amount"]["top"], $this->callRow["call_amount"]["except"], "", "show");

		return $_arr_specRows;
	}


	/**
	 * display_tag function.
	 *
	 * @access public
	 * @return void
	 */
	function display_tag() {
		$_arr_tagRows = $this->mdl_tag->mdl_list($this->callRow["call_amount"]["top"], $this->callRow["call_amount"]["except"], "", "show", $this->callRow["call_type"]);

		return $_arr_tagRows;
	}


	/**
	 * display_article function.
	 *
	 * @access public
	 * @return void
	 */
	function display_article() {
		$_arr_articleRows = $this->mdl_articlePub->mdl_list($this->callRow["call_amount"]["top"], $this->callRow["call_amount"]["except"], "", "", "", $this->callRow["call_cate_ids"], $this->callRow["call_mark_ids"], $this->callRow["call_spec_id"], false, $this->callRow["call_attach"], $this->callRow["call_type"]);

		//print_r($_arr_articleRows);
		if (!file_exists(BG_PATH_CACHE . "thumb_list.php")) {
			$this->mdl_thumb->mdl_cache();
		}
		$_arr_thumbRows = include(BG_PATH_CACHE . "thumb_list.php");

		foreach ($_arr_articleRows as $_key=>$_value) {
			$_arr_articleRows[$_key]["tagRows"] = $this->mdl_tag->mdl_list(10, 0, "", "show", "tag_id", $_value["article_id"]);

			if ($_value["article_attach_id"] > 0) {
				$_arr_articleRows[$_key]["attachRow"]     = $this->mdl_attach->mdl_url($_value["article_attach_id"], $_arr_thumbRows);
			}

			/*if (isset($_value["belong_cate_id"]) && $_value["belong_cate_id"] > 0) {
				$_num_cateId = $_value["belong_cate_id"];
			} else {
				$_num_cateId = $_value["article_cate_id"];
			}*/

			if (!file_exists(BG_PATH_CACHE . "cate_" . $_value["article_cate_id"] . ".php")) {
				$this->mdl_cate->mdl_cache(array($_value["article_cate_id"]));
			}

			$_arr_articleRows[$_key]["cateRow"] = include(BG_PATH_CACHE . "cate_" . $_value["article_cate_id"] . ".php");
		}

		return $_arr_articleRows;
	}
}
