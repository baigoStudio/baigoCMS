<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------用户类-------------*/
class MODEL_TAG_PUB {

	private $obj_db;

	function mdl_create() {
		$_arr_tagCreat = array(
			"article_id"         => BG_DB_TABLE . "article",
			"article_title"      => BG_DB_TABLE . "article",
			"article_excerpt"    => BG_DB_TABLE . "article",
			"article_link"       => BG_DB_TABLE . "article",
			"article_time_pub"   => BG_DB_TABLE . "article",
			"article_attach_id"  => BG_DB_TABLE . "article",
			"article_status"     => BG_DB_TABLE . "article",
			"article_box"        => BG_DB_TABLE . "article",
			"article_top"        => BG_DB_TABLE . "article",
			"belong_tag_id"      => BG_DB_TABLE . "tag_belong",
		);

		$_str_sqlJoin = "LEFT JOIN `" . BG_DB_TABLE . "article` ON (`" . BG_DB_TABLE . "tag_belong`.`belong_article_id`=`" . BG_DB_TABLE . "article`.`article_id`)";

		$_num_mysql = $this->obj_db->create_view(BG_DB_TABLE . "tag_view", $_arr_tagCreat, BG_DB_TABLE . "tag_belong", $_str_sqlJoin);

		if ($_num_mysql > 0) {
			$_str_alert = "y130108"; //更新成功
		} else {
			$_str_alert = "x130108"; //更新成功
		}

		return array(
			"str_alert" => $_str_alert, //更新成功
		);
	}


	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	function mdl_read($str_tag, $str_readBy = "tag_id") {
		$_arr_tagSelect = array(
			"tag_id",
			"tag_name",
			"tag_status",
		);

		switch ($str_readBy) {
			case "tag_id":
				$_str_sqlWhere = $str_readBy . "=" . $str_tag;
			break;
			default:
				$_str_sqlWhere = $str_readBy . "='" . $str_tag . "'";
			break;
		}

		$_arr_tagRows = $this->obj_db->select_array(BG_DB_TABLE . "tag",  $_arr_tagSelect, $_str_sqlWhere, 1, 0); //检查本地表是否存在记录
		$_arr_tagRow  = $_arr_tagRows[0];

		if (!$_arr_tagRow) {
			return array(
				"str_alert" => "x130102", //不存在记录
			);
			exit;
		}

		$_arr_tagRow["str_alert"] = "y130102";

		return $_arr_tagRow;
	}

	/**
	 * mdl_list function.
	 *
	 * @access public
	 * @param string $str_status (default: "")
	 * @param string $str_type (default: "")
	 * @param int $num_parentId (default: 0)
	 * @return void
	 */
	function mdl_list($num_no, $num_except = 0, $arr_tagIds = false) {
		$_arr_tagSelect = array(
			"belong_tag_id",
			"article_id",
			"article_title",
			"article_excerpt",
			"article_link",
			"article_time_pub",
			"article_attach_id",
		);

		$_str_sqlWhere = "LENGTH(article_title) > 0 AND article_status='pub' AND article_box='normal' AND article_time_pub<=" . time();

		if ($arr_tagIds) {
			$_str_tagIds = implode(",", $arr_tagIds);
			$_str_sqlWhere .= " AND belong_tag_id IN (" . $_str_tagIds . ")";
		}

		$_arr_tagRows = $this->obj_db->select_array(BG_DB_TABLE . "tag_view",  $_arr_tagSelect, $_str_sqlWhere . " ORDER BY article_id DESC", $num_no, $num_except);

		foreach ($_arr_tagRows as $_key=>$_value) {
			$_arr_tagRows[$_key]["article_url"] = $this->url_process($_value);
		}

		return $_arr_tagRows;
	}


	/**
	 * mdl_count function.
	 *
	 * @access public
	 * @param int $num_articleId (default: 0)
	 * @return void
	 */
	function mdl_count($arr_tagIds = false) {

		$_str_sqlWhere = "LENGTH(article_title) > 0 AND article_status='pub' AND article_box='normal' AND article_time_pub<=" . time();

		if ($arr_tagIds) {
			$_str_tagIds = implode(",", $arr_tagIds);
			$_str_sqlWhere .= " AND belong_tag_id IN (" . $_str_tagIds . ")";
		}

		$_num_tagCount = $this->obj_db->count(BG_DB_TABLE . "tag_view", $_str_sqlWhere); //查询数据

		return $_num_tagCount;
	}

	private function url_process($_arr_articleRow) {

		if ($_arr_articleRow["article_link"]) {
			$_str_articleUrl = $_arr_articleRow["article_link"];
		} else {
			switch (BG_VISIT_TYPE) {
				case "static":
					$_str_articleUrl = BG_URL_ROOT . "article/" . date("Y", $_arr_articleRow["article_time"]) . "/" . date("m", $_arr_articleRow["article_time"]) . "/" . $_arr_articleRow["article_id"] . "." . BG_VISIT_FILE;
				break;

				case "pstatic":
					$_str_articleUrl = BG_URL_ROOT . "article/" . $_arr_articleRow["article_id"];
				break;

				default:
					$_str_articleUrl = BG_URL_ROOT . "index.php?mod=article&act_get=show&article_id=" . $_arr_articleRow["article_id"];
				break;
			}
		}

		return $_str_articleUrl;
	}
}
?>