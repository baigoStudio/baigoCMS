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
class MODEL_ARTICLE_PUB {

	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $num_articleId
	 * @return void
	 */
	function mdl_read($num_articleId) {
		$_arr_articleSelect = array(
			"article_id",
			"article_cate_id",
			"article_mark_id",
			"article_title",
			"article_excerpt",
			"article_status",
			"article_box",
			"article_link",
			"article_tag",
			"article_admin_id",
			"article_hits_all",
			"article_time",
			"article_time_pub",
			"article_content",
		);

		$_arr_articleRows = $this->obj_db->select_array(BG_DB_TABLE . "article", $_arr_articleSelect, "article_id=" . $num_articleId, 1, 0); //读取数据
		$_arr_articleRow = $_arr_articleRows[0];

		if (!$_arr_articleRow) {
			return array(
				"str_alert" => "x120102",
			);
		}

		/*print_r($_arr_userRow);
		exit;*/

		$_arr_articleRow["str_alert"] = "y120102";

		return $_arr_articleRow;
	}


	/**
	 * mdl_list function.
	 *
	 * @access public
	 * @param mixed $num_no
	 * @param int $num_except (default: 0)
	 * @param string $str_key (default: "")
	 * @param string $str_year (default: "")
	 * @param string $str_month (default: "")
	 * @param bool $arr_cateIds (default: false)
	 * @param bool $arr_markIds (default: false)
	 * @param bool $arr_tagIds (default: false)
	 * @param string $_str_callUpfile (default: "")
	 * @param string $_str_callType (default: "")
	 * @return void
	 */
	function mdl_list($num_no, $num_except = 0, $str_key = "", $str_year = "", $str_month = "", $arr_cateIds = false, $arr_markIds = false, $arr_tagIds = false, $_str_callUpfile = "", $_str_callType = "") {
		$_arr_articleSelect = array(
			//"belong_cate_id",
			"cate_id",
			"cate_name",
			"cate_link",
			"article_id",
			"article_title",
			"article_excerpt",
			"article_link",
			"article_time_pub",
			"article_upfile_id",
		);

		$_str_sqlWhere = "LENGTH(article_title) > 0 AND article_status='pub' AND article_box='normal' AND article_time_pub<=" . time();

		if ($str_key) {
			$_str_sqlWhere .= " AND (article_title LIKE '%" . $str_key . "%' OR article_content like '%" . $str_key . "%')";
		}

		if ($str_year) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(article_time, '%Y')='" . $str_year . "'";
		}

		if ($str_month) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(article_time, '%m')='" . $str_month . "'";
		}

		if ($arr_cateIds) {
			$_str_cateIds = implode(",", $arr_cateIds);
			$_str_sqlWhere .= " AND belong_cate_id IN (" . $_str_cateIds . ")";
		}

		if ($arr_markIds) {
			$_str_markIds = implode(",", $arr_markIds);
			$_str_sqlWhere .= " AND article_mark_id IN (" . $_str_markIds . ")";
		}

		if ($arr_tagIds) {
			$_str_tagIds = implode(",", $arr_tagIds);
			$_str_sqlWhere .= " AND belong_tag_id IN (" . $_str_tagIds . ")";
		}

		switch ($_str_callUpfile) {
			case "upfile":
				$_str_sqlWhere .= " AND article_upfile_id>0";
			break;

			case "none":
				$_str_sqlWhere .= " AND article_upfile_id=0";
			break;
		}

		$_str_sqlWhere .= " GROUP BY " . BG_DB_TABLE . "cate_belong.belong_article_id";

		if (!$_str_callType || $_str_callType == "article") {
			$_str_sqlWhere .= " ORDER BY article_top DESC, " . BG_DB_TABLE . "cate_belong.belong_article_id DESC";
		} else {
			$_str_sqlWhere .= " ORDER BY article_" . $_str_callType . " DESC, " . BG_DB_TABLE . "cate_belong.belong_article_id DESC";
		}

		$_str_sqlOn = " ON " . BG_DB_TABLE . "cate_belong.belong_article_id=article_id LEFT JOIN " . BG_DB_TABLE . "tag_belong ON " . BG_DB_TABLE . "cate_belong.belong_article_id=" . BG_DB_TABLE . "tag_belong.belong_article_id LEFT JOIN " . BG_DB_TABLE . "cate ON belong_cate_id=cate_id";

		$_arr_articleRows = $this->obj_db->select_array(BG_DB_TABLE . "cate_belong", $_arr_articleSelect, $_str_sqlWhere, $num_no, $num_except, array(BG_DB_TABLE . "cate_belong`.`belong_article_id"), BG_DB_TABLE . "article" . $_str_sqlOn);

		return $_arr_articleRows;
	}


	/**
	 * mdl_count function.
	 *
	 * @access public
	 * @param string $str_key (default: "")
	 * @param string $str_year (default: "")
	 * @param string $str_month (default: "")
	 * @param bool $arr_cateIds (default: false)
	 * @param bool $arr_markIds (default: false)
	 * @param bool $arr_tagIds (default: false)
	 * @param string $_str_callUpfile (default: "")
	 * @param string $_str_callType (default: "")
	 * @return void
	 */
	function mdl_count($str_key = "", $str_year = "", $str_month = "", $arr_cateIds = false, $arr_markIds = false, $arr_tagIds = false, $_str_callUpfile = "", $_str_callType = "") {
		$_str_sqlWhere = "LENGTH(article_title) > 0 AND article_status='pub' AND article_box='normal' AND article_time_pub<=" . time();

		if ($str_key) {
			$_str_sqlWhere .= " AND (article_title LIKE '%" . $str_key . "%' OR article_content like '%" . $str_key . "%')";
		}

		if ($str_year) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(article_time, '%Y')='" . $str_year . "'";
		}

		if ($str_month) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(article_time, '%m')='" . $str_month . "'";
		}

		if ($arr_cateIds) {
			$_str_cateIds = implode(",", $arr_cateIds);
			$_str_sqlWhere .= " AND belong_cate_id IN (" . $_str_cateIds . ")";
		}

		if ($arr_markIds) {
			$_str_markIds = implode(",", $arr_markIds);
			$_str_sqlWhere .= " AND article_mark_id IN (" . $_str_markIds . ")";
		}

		if ($arr_tagIds) {
			$_str_tagIds = implode(",", $arr_tagIds);
			$_str_sqlWhere .= " AND belong_tag_id IN (" . $_str_tagIds . ")";
		}

		switch ($_str_callUpfile) {
			case "upfile":
				$_str_sqlWhere .= " AND article_upfile_id>0";
			break;

			case "none":
				$_str_sqlWhere .= " AND article_upfile_id=0";
			break;
		}

		$_str_sqlOn = " ON " . BG_DB_TABLE . "cate_belong.belong_article_id=article_id LEFT JOIN " . BG_DB_TABLE . "tag_belong ON " . BG_DB_TABLE . "cate_belong.belong_article_id=" . BG_DB_TABLE . "tag_belong.belong_article_id";

		$_num_articleCount = $this->obj_db->count(BG_DB_TABLE . "cate_belong", $_str_sqlWhere, array(BG_DB_TABLE . "cate_belong`.`belong_article_id"), BG_DB_TABLE . "article" . $_str_sqlOn); //查询数据

		return $_num_articleCount;
	}

}
?>