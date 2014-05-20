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

		echo("<li class=\"call_last\"></li>" . PHP_EOL);
	echo("</ul>" . PHP_EOL);
}

class CLASS_CALL_DISPLAY {

	private $mdl_call;
	private $mdl_cate;
	private $mdl_article;
	private $mdl_tag;
	private $mdl_upfile;
	private $callRow;

	function __construct() { //构造函数
		$this->mdl_call       = new MODEL_CALL();
		$this->mdl_cate       = new MODEL_CATE();
		$this->mdl_article    = new MODEL_ARTICLE_PUB();
		$this->mdl_tag        = new MODEL_TAG_PUB();
		$this->mdl_upfile     = new MODEL_UPFILE();
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
		//栏目ID
		if ($this->callRow["call_cate_ids"] && $this->callRow["call_cate_ids"] != "null") {
			$this->callRow["call_cate_ids"] = json_decode($this->callRow["call_cate_ids"], true);
		} else {
			$this->callRow["call_cate_ids"] = false;
		}
		//标记ID
		if ($this->callRow["call_mark_ids"] && $this->callRow["call_mark_ids"] != "null") {
			$this->callRow["call_mark_ids"] = json_decode($this->callRow["call_mark_ids"], true);
		} else {
			$this->callRow["call_mark_ids"] = false;
		}

		$this->callRow["call_show"]    = json_decode($this->callRow["call_show"], true); //显示情况
		$this->callRow["call_amount"]  = json_decode($this->callRow["call_amount"], true); //数量

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
				echo("<ol id=\"call_cate_" . $_value["cate_id"] . "_detail\" class=\"call_cate_detail\">" . PHP_EOL);
					if ($this->callRow["call_show"]["cateName"] == "show") {
						$_str_cateUrl = $this->cate_urlProcess($_value["cate_id"]);
						echo("<li id=\"call_cate_" . $_value["cate_id"] . "_name\" class=\"call_cate_name\"><a href=\"" . $_str_cateUrl . "\">" . $_value["cate_name"] . "</a></li>" . PHP_EOL);
					}
					//栏目简介
					if ($this->callRow["call_show"]["cateContent"] == "show") {
						echo("<li id=\"call_cate_" . $_value["cate_id"] . "_content\" class=\"call_cate_content\">" . $_value["cate_content"] . "</li>" . PHP_EOL);
					}
					echo("<li class=\"call_cate_last\"></li>" . PHP_EOL);
				echo("</ol>" . PHP_EOL);
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
		$_arr_tagRows = $this->mdl_tag->mdl_list($this->callRow["call_amount"]["top"], $this->callRow["call_amount"]["except"]);
		foreach ($_arr_tagRows as $_key=>$_value) {
			echo("<li id=\"call_tag_" . $_value["tag_id"] . "\" class=\"call_tag\">" . PHP_EOL);
				switch (BG_VISIT_TYPE) {
					case "static":
					case "pstatic":
						$_str_tagUrl = BG_SITE_URL . BG_URL_ROOT . "tag/" . $_value["tag_name"];
					break;

					default:
						$_str_tagUrl = BG_SITE_URL . BG_URL_ROOT . "index.php?mod=tag&act_get=list&tag_name=" . $_value["tag_name"];
					break;
				}
				echo("<a href=\"" . $_str_tagUrl . "\">" . PHP_EOL);
					echo($_value["tag_name"] . "&#160;(" . $_value["tag_article_count"] . ")" . PHP_EOL);
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
		$_arr_articleRows = $this->mdl_article->mdl_list($this->callRow["call_amount"]["top"], $this->callRow["call_amount"]["except"], "", "", "", $this->callRow["call_cate_ids"], $this->callRow["call_mark_ids"], $this->callRow["call_tag_ids"]);

		foreach ($_arr_articleRows as $_key=>$_value) {
			echo("<li id=\"call_article_" . $_value["article_id"] . "\" class=\"call_article\">" . PHP_EOL);
				echo("<ol id=\"call_article_" . $_value["article_id"] . "_detail\" class=\"call_article_detail\">" . PHP_EOL);
					if ($this->callRow["call_show"]["cate"] == "show") {
						$_str_cateUrl = $this->cate_urlProcess($_value["cate_id"]);
						echo("<li id=\"call_article_" . $_value["article_id"] . "_cate\" class=\"call_article_cate\"><a href=\"" . $_str_cateUrl . "\">" . $_value["cate_name"] . "</a></li>" . PHP_EOL);
					}

					if ($this->callRow["call_show"]["title"] == "show") {
						echo("<li id=\"call_article_" . $_value["article_id"] . "_title\" class=\"call_article_title\">" . PHP_EOL);
							if ($_value["article_link"]) {
								$_str_articleUrl = $_value["article_link"];
							} else {
								switch (BG_VISIT_TYPE) {
									case "static":
										$_str_articleUrl = BG_SITE_URL . BG_URL_ROOT . "article/" . date("Y", $_value["article_time_pub"]) . "/" . date("m", $_value["article_time_pub"]) . "/" . $_value["article_id"] . "." . BG_VISIT_FILE;
									break;

									case "pstatic":
										$_str_articleUrl = BG_SITE_URL . BG_URL_ROOT . "article/" . $_value["article_id"];
									break;

									default:
										$_str_articleUrl = BG_SITE_URL . BG_URL_ROOT . "index.php?mod=article&act_get=show&article_id=" . $_value["article_id"];
									break;
								}
							}

							echo("<a href=\"" . $_str_articleUrl . "\" target=\"_blank\">" . $_value["article_title"] . "</a>" . PHP_EOL);
						echo("</li>" . PHP_EOL);
					}

					if ($this->callRow["call_show"]["tag"] == "show") {
						echo("<li id=\"call_article_" . $_value["article_id"] . "_tag\" class=\"call_article_tag\">" . PHP_EOL);
							$_arr_tagRows = $this->mdl_tag->mdl_list(1000, 0, $_value["article_id"]);
							$_num_last = count($_arr_tagRows);
							$_iii = 1;
							foreach ($_arr_tagRows as $_value_tag) {
								switch (BG_VISIT_TYPE) {
									case "static":
									case "pstatic":
										$_str_tagUrl = BG_SITE_URL . BG_URL_ROOT . "tag/" . $_value_tag["tag_name"];
									break;

									default:
										$_str_tagUrl = BG_SITE_URL . BG_URL_ROOT . "index.php?mod=tag&act_get=list&tag_name=" . $_value_tag["tag_name"];
									break;
								}
								echo("<a href=\"" . $_str_tagUrl . "\">" . $_value_tag["tag_name"] . "</a>");
								if ($_iii < $_num_last) {
									echo("," . PHP_EOL);
								}
								$_iii++;
							}
							unset($_num_last, $_iii);
						echo("</li>" . PHP_EOL);
					}

					if ($this->callRow["call_show"]["time"] != "none") {
						echo("<li id=\"call_article_" . $_value["article_id"] . "_time\" class=\"call_article_time\">" . date($this->callRow["call_show"]["time"], $_value["article_time_pub"]) . "</li>" . PHP_EOL);
					}

					if ($this->callRow["call_show"]["excerpt"] == "show") {
						echo("<li id=\"call_article_" . $_value["article_id"] . "_excerpt\" class=\"call_article_excerpt\">" . $_value["article_excerpt"] . "</li>" . PHP_EOL);
					}

					if ($this->callRow["call_show"]["img"] != "none" && $_value["article_upfile_id"] > 0) {
						$_arr_upfileRow = $this->mdl_upfile->mdl_read($_value["article_upfile_id"]);
						if ($_arr_upfileRow["str_alert"] == "y070102") {
							echo("<li id=\"call_article_" . $_value["article_id"] . "_img\" class=\"call_article_img\">");

								echo("<a href=\"" . $_str_articleUrl . "\" target=\"_blank\"><img src=\"" . BG_UPFILE_URL . BG_URL_UPFILE . date("Y", $_arr_upfileRow["upfile_time"]) . "/" . date("m", $_arr_upfileRow["upfile_time"]) . "/" . $_arr_upfileRow["upfile_id"] . "_" . $this->callRow["call_show"]["img"] . "." . $_arr_upfileRow["upfile_ext"] . "\" /></a>");

							echo("</li>" . PHP_EOL);
						}
					}
					echo("<li class=\"call_article_last\"></li>" . PHP_EOL);
				echo("</ol>" . PHP_EOL);
			echo("</li>" . PHP_EOL);
		}
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
}
?>