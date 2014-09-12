<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

function fn_callDisplay($arr_call) {
	$_obj_call     = new CLASS_CALL_DISPLAY();
	$_arr_callRow  = $_obj_call->display_init($arr_call["call_id"]); //读取调用信息

	echo("<ul id=\"call_" . $_arr_callRow["call_id"] . "\" class=\"call " . $_arr_callRow["call_css"] . "\">" . PHP_EOL);

		switch ($_arr_callRow["call_type"]) {
			//栏目列表
			case "cate":
				$_obj_call->display_cate();
			break;

			//TAG 列表
			case "tag":
				$_obj_call->display_tag();
			break;

			//文章列表
			default:
				$_obj_call->display_article();
			break;
		}

	echo("</ul>" . PHP_EOL);
}

class CLASS_CALL_DISPLAY {

	private $mdl_call;
	private $mdl_cate;
	private $mdl_article;
	private $mdl_tag;
	private $mdl_tagBelong;
	private $mdl_attach;
	private $callRow;

	function __construct() { //构造函数
		$this->mdl_call       = new MODEL_CALL();
		$this->mdl_cate       = new MODEL_CATE();
		$this->mdl_articlePub = new MODEL_ARTICLE_PUB();
		$this->mdl_tag        = new MODEL_TAG();
		$this->mdl_tagBelong  = new MODEL_TAG_BELONG();
		$this->mdl_attach     = new MODEL_ATTACH();
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
		foreach ($_arr_cateRows as $_key=>$_value) {
			echo("<li id=\"call_cate_" . $_value["cate_id"] . "\" class=\"call_cate\">" . PHP_EOL);
				echo("<a href=\"" . $_value["urlRow"]["cate_url"] . "\">" . $_value["cate_name"] . "</a>" . PHP_EOL);
			echo("</li>" . PHP_EOL);
		}
	}


	/**
	 * display_tag function.
	 *
	 * @access public
	 * @return void
	 */
	function display_tag() {
		$_arr_tagRows = $this->mdl_tag->mdl_list($this->callRow["call_amount"]["top"], $this->callRow["call_amount"]["except"], "", "show");
		foreach ($_arr_tagRows as $_key=>$_value) {
			echo("<li id=\"call_tag_" . $_value["tag_id"] . "\" class=\"call_tag\">" . PHP_EOL);
				echo("<a href=\"" . $_value["urlRow"]["tag_url"] . "\">" . PHP_EOL);
					echo($_value["tag_name"] . "&nbsp;(" . $_value["tag_article_count"] . ")" . PHP_EOL);
				echo("</a>" . PHP_EOL);
			echo("</li>" . PHP_EOL);
		}
	}


	/**
	 * display_article function.
	 *
	 * @access public
	 * @return void
	 */
	function display_article() {
		$_arr_articleRows = $this->mdl_articlePub->mdl_list($this->callRow["call_amount"]["top"], $this->callRow["call_amount"]["except"], "", "", "", $this->callRow["call_cate_ids"], $this->callRow["call_mark_ids"], 0, $this->callRow["call_attach"], $this->callRow["call_type"]);

		//print_r($_arr_articleRows);

		foreach ($_arr_articleRows as $_key=>$_value) {
			echo("<li id=\"call_article_" . $_value["article_id"] . "\" class=\"call_article\">" . PHP_EOL);

				if ($this->callRow["call_show"]["cate"] == "show") {
					$_arr_cateRow = $this->mdl_cate->mdl_read($_value["belong_cate_id"]);
					echo("<div id=\"call_article_" . $_value["article_id"] . "_cate\" class=\"call_article_cate\"><a href=\"" . $_arr_cateRow["urlRow"]["cate_url"] . "\">" . $_arr_cateRow["cate_name"] . "</a></div>" . PHP_EOL);
				}

				if ($this->callRow["call_show"]["title"] == "show") {
					echo("<div id=\"call_article_" . $_value["article_id"] . "_title\" class=\"call_article_title\">" . PHP_EOL);
						echo("<a href=\"" . $_value["article_url"] . "\" target=\"_blank\">" . $_value["article_title"] . "</a>" . PHP_EOL);
					echo("</div>" . PHP_EOL);
				}

				if ($this->callRow["call_show"]["tag"] == "show") {
					echo("<div id=\"call_article_" . $_value["article_id"] . "_tag\" class=\"call_article_tag\">" . PHP_EOL);
						$_arr_tagBelongRows = $this->mdl_tagBelong->mdl_list($_value["article_id"]);
						//print_r($_arr_tagBelongRows);
						foreach ($_arr_tagBelongRows as $_value_tag) {
							$_arr_tagRow = $this->mdl_tag->mdl_read($_value_tag["belong_tag_id"]);
							if ($_arr_tagRow["tag_status"] == "show") {
								echo("<a href=\"" . $_arr_tagRow["urlRow"]["tag_url"] . "\">" . $_arr_tagRow["tag_name"] . "</a>");
							}
						}
					echo("</div>" . PHP_EOL);
				}

				if ($this->callRow["call_show"]["time"] != "none") {
					echo("<div id=\"call_article_" . $_value["article_id"] . "_time\" class=\"call_article_time\">" . date($this->callRow["call_show"]["time"], $_value["article_time_pub"]) . "</div>" . PHP_EOL);
				}

				if ($this->callRow["call_show"]["excerpt"] == "show") {
					echo("<div id=\"call_article_" . $_value["article_id"] . "_excerpt\" class=\"call_article_excerpt\">" . $_value["article_excerpt"] . "</div>" . PHP_EOL);
				}

				if ($this->callRow["call_show"]["img"] != "none" && $_value["article_attach_id"] > 0) {
					$_arr_attachRow = $this->mdl_attach->mdl_read($_value["article_attach_id"]);
					if ($_arr_attachRow["str_alert"] == "y070102") {
						echo("<div id=\"call_article_" . $_value["article_id"] . "_img\" class=\"call_article_img\">");

							echo("<a href=\"" . $_str_articleUrl . "\" target=\"_blank\"><img src=\"" . BG_UPLOAD_URL . BG_URL_ATTACH . date("Y", $_arr_attachRow["attach_time"]) . "/" . date("m", $_arr_attachRow["attach_time"]) . "/" . $_arr_attachRow["attach_id"] . "_" . $this->callRow["call_show"]["img"] . "." . $_arr_attachRow["attach_ext"] . "\"></a>");

						echo("</div>" . PHP_EOL);
					}
				}

			echo("</li>" . PHP_EOL);
		}
	}
}
?>