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


	function mdl_create_cate_view() {
		$_arr_articleCreat = array(
			"article_id"         => BG_DB_TABLE . "article",
			"article_title"      => BG_DB_TABLE . "article",
			"article_excerpt"    => BG_DB_TABLE . "article",
			"article_link"       => BG_DB_TABLE . "article",
			"article_time"       => BG_DB_TABLE . "article",
			"article_time_pub"   => BG_DB_TABLE . "article",
			"article_attach_id"  => BG_DB_TABLE . "article",
			"article_spec_id"    => BG_DB_TABLE . "article",
			"article_status"     => BG_DB_TABLE . "article",
			"article_box"        => BG_DB_TABLE . "article",
			"article_top"        => BG_DB_TABLE . "article",
			"article_cate_id"    => BG_DB_TABLE . "article",
			"article_hits_day"   => BG_DB_TABLE . "article",
			"article_time_day"   => BG_DB_TABLE . "article",
			"article_hits_week"  => BG_DB_TABLE . "article",
			"article_time_week"  => BG_DB_TABLE . "article",
			"article_hits_month" => BG_DB_TABLE . "article",
			"article_time_month" => BG_DB_TABLE . "article",
			"article_hits_year"  => BG_DB_TABLE . "article",
			"article_time_year"  => BG_DB_TABLE . "article",
			"article_hits_all"   => BG_DB_TABLE . "article",
			"belong_cate_id"     => BG_DB_TABLE . "cate_belong",
		);

		$_str_sqlJoin = "LEFT JOIN `" . BG_DB_TABLE . "cate_belong` ON (`" . BG_DB_TABLE . "article`.`article_id`=`" . BG_DB_TABLE . "cate_belong`.`belong_article_id`)";

		$_num_mysql = $this->obj_db->create_view(BG_DB_TABLE . "article_cate_view", $_arr_articleCreat, BG_DB_TABLE . "article", $_str_sqlJoin);

		if ($_num_mysql > 0) {
			$_str_alert = "y120108"; //更新成功
		} else {
			$_str_alert = "x120108"; //更新成功
		}

		return array(
			"str_alert" => $_str_alert, //更新成功
		);
	}


	function mdl_create_tag_view() {
		$_arr_articleCreat = array(
			"article_id"         => BG_DB_TABLE . "article",
			"article_title"      => BG_DB_TABLE . "article",
			"article_excerpt"    => BG_DB_TABLE . "article",
			"article_link"       => BG_DB_TABLE . "article",
			"article_time"       => BG_DB_TABLE . "article",
			"article_time_pub"   => BG_DB_TABLE . "article",
			"article_attach_id"  => BG_DB_TABLE . "article",
			"article_spec_id"    => BG_DB_TABLE . "article",
			"article_status"     => BG_DB_TABLE . "article",
			"article_box"        => BG_DB_TABLE . "article",
			"article_top"        => BG_DB_TABLE . "article",
			"article_cate_id"    => BG_DB_TABLE . "article",
			"article_hits_day"   => BG_DB_TABLE . "article",
			"article_time_day"   => BG_DB_TABLE . "article",
			"article_hits_week"  => BG_DB_TABLE . "article",
			"article_time_week"  => BG_DB_TABLE . "article",
			"article_hits_month" => BG_DB_TABLE . "article",
			"article_time_month" => BG_DB_TABLE . "article",
			"article_hits_year"  => BG_DB_TABLE . "article",
			"article_time_year"  => BG_DB_TABLE . "article",
			"article_hits_all"   => BG_DB_TABLE . "article",
			"belong_tag_id"      => BG_DB_TABLE . "tag_belong",
		);

		$_str_sqlJoin = "LEFT JOIN `" . BG_DB_TABLE . "tag_belong` ON (`" . BG_DB_TABLE . "article`.`article_id`=`" . BG_DB_TABLE . "tag_belong`.`belong_article_id`)";

		$_num_mysql = $this->obj_db->create_view(BG_DB_TABLE . "article_tag_view", $_arr_articleCreat, BG_DB_TABLE . "article", $_str_sqlJoin);

		if ($_num_mysql > 0) {
			$_str_alert = "y120108"; //更新成功
		} else {
			$_str_alert = "x120108"; //更新成功
		}

		return array(
			"str_alert" => $_str_alert, //更新成功
		);
	}


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
			"article_admin_id",
			"article_hits_day",
			"article_time_day",
			"article_hits_week",
			"article_time_week",
			"article_hits_month",
			"article_time_month",
			"article_hits_year",
			"article_time_year",
			"article_hits_all",
			"article_time",
			"article_time_pub",
			"article_top",
			"article_spec_id",
			"article_attach_id",
		);

		$_arr_articleRows = $this->obj_db->select_array(BG_DB_TABLE . "article", $_arr_articleSelect, "article_id=" . $num_articleId, 1, 0); //读取数据

		if (isset($_arr_articleRows[0])) {
			$_arr_articleRow = $_arr_articleRows[0];
		} else {
			return array(
				"str_alert" => "x120102",
			);
		}

		$_arr_articleSelect = array(
			"article_content",
		);

		$_arr_contentRows = $this->obj_db->select_array(BG_DB_TABLE . "article_content", $_arr_articleSelect, "article_id=" . $num_articleId, 1, 0); //读取数据

		if (isset($_arr_contentRows[0])) {
			$_arr_contentRow = $_arr_contentRows[0];
		} else {
			return array(
				"str_alert" => "x120102",
			);
		}

		$_arr_articleRow["article_content"]   = $_arr_contentRow["article_content"];
		$_arr_articleRow["article_url"]       = $this->url_process($_arr_articleRow);
		$_arr_articleRow["str_alert"]         = "y120102";

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
	 * @param string $_str_callAttach (default: "")
	 * @param string $_str_callType (default: "")
	 * @return void
	 */
	function mdl_list($num_no, $num_except = 0, $str_key = "", $str_year = "", $str_month = "", $arr_cateIds = false, $arr_markIds = false, $num_specId = 0, $arr_tagIds = false, $_str_callAttach = "", $_str_callType = "") {
		$_arr_articleSelect = array(
			"article_id",
			"article_title",
			"article_excerpt",
			"article_link",
			"article_time_pub",
			"article_attach_id",
			"article_spec_id",
			"article_cate_id",
			"article_hits_day",
			"article_hits_week",
			"article_hits_month",
			"article_hits_year",
			"article_hits_all",
		);

		$_str_sqlWhere = "article_status='pub' AND article_box='normal' AND article_time_pub<=" . time();

		if ($str_key) {
			$_str_sqlWhere .= " AND article_title LIKE '%" . $str_key . "%'";
		}

		if ($str_year) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(article_time_pub, '%Y')='" . $str_year . "'";
		}

		if ($str_month) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(article_time_pub, '%m')='" . $str_month . "'";
		}

		if ($arr_cateIds) {
			$_str_cateIds = implode(",", $arr_cateIds);
			$_str_sqlWhere .= " AND belong_cate_id IN (" . $_str_cateIds . ")";
		}

		if ($arr_markIds) {
			$_str_markIds = implode(",", $arr_markIds);
			$_str_sqlWhere .= " AND article_mark_id IN (" . $_str_markIds . ")";
		}

		if ($num_specId > 0) {
			$_str_sqlWhere .= " AND article_spec_id=" . $num_specId;
		}

		if ($arr_tagIds) {
			$_str_tagIds     = implode(",", $arr_tagIds);
			$_str_sqlWhere  .= " AND belong_tag_id IN (" . $_str_tagIds . ")";
			$_view_name = "article_tag_view";
		} else {
			$_view_name = "article_cate_view";
		}

		switch ($_str_callAttach) {
			case "attach":
				$_str_sqlWhere .= " AND article_attach_id>0";
			break;

			case "none":
				$_str_sqlWhere .= " AND article_attach_id=0";
			break;

			default:

			break;
		}

		if (!$_str_callType || $_str_callType == "article") {
			$_str_sqlWhere .= " GROUP BY article_top, article_id ORDER BY article_top DESC, article_time_pub DESC";
		} else {
			$_str_sqlWhere .= " GROUP BY article_" . $_str_callType . ", article_id ORDER BY article_" . $_str_callType . " DESC, article_time_pub DESC";
		}

		//print_r($_view_name);

		$_arr_articleRows = $this->obj_db->select_array(BG_DB_TABLE . $_view_name, $_arr_articleSelect, $_str_sqlWhere, $num_no, $num_except, array("article_id"));

		foreach ($_arr_articleRows as $_key=>$_value) {
			$_arr_articleRows[$_key]["article_url"]      = $this->url_process($_value);
			//$_arr_articleRows[$_key]["article_excerpt"]  = htmlentities($_value["article_excerpt"]);
		}

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
	 * @param string $_str_callAttach (default: "")
	 * @param string $_str_callType (default: "")
	 * @return void
	 */
	function mdl_count($str_key = "", $str_year = "", $str_month = "", $arr_cateIds = false, $arr_markIds = false, $num_specId = 0, $arr_tagIds = false, $_str_callAttach = "", $_str_callType = "") {

		$_str_sqlWhere = "article_status='pub' AND article_box='normal' AND article_time_pub<=" . time();

		if ($str_key) {
			$_str_sqlWhere .= " AND article_title LIKE '%" . $str_key . "%'";
		}

		if ($str_year) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(article_time_pub, '%Y')='" . $str_year . "'";
		}

		if ($str_month) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(article_time_pub, '%m')='" . $str_month . "'";
		}

		if ($arr_cateIds) {
			$_str_cateIds = implode(",", $arr_cateIds);
			$_str_sqlWhere .= " AND belong_cate_id IN (" . $_str_cateIds . ")";
		}

		if ($arr_markIds) {
			$_str_markIds = implode(",", $arr_markIds);
			$_str_sqlWhere .= " AND article_mark_id IN (" . $_str_markIds . ")";
		}

		if ($num_specId > 0) {
			$_str_sqlWhere .= " AND article_spec_id=" . $num_specId;
		}

		if ($arr_tagIds) {
			$_str_tagIds     = implode(",", $arr_tagIds);
			$_str_sqlWhere  .= " AND belong_tag_id IN (" . $_str_tagIds . ")";
			$_view_name = "article_tag_view";
		} else {
			$_view_name = "article_cate_view";
		}

		switch ($_str_callAttach) {
			case "attach":
				$_str_sqlWhere .= " AND article_attach_id>0";
			break;

			case "none":
				$_str_sqlWhere .= " AND article_attach_id=0";
			break;

			default:

			break;
		}

		//print_r($_str_sqlWhere);

		$_num_articleCount    = $this->obj_db->count(BG_DB_TABLE . $_view_name, $_str_sqlWhere, array("article_id")); //查询数据

		return $_num_articleCount;
	}


	function mdl_hits($num_articleId) {
		$_arr_articleRow = $this->mdl_read($num_articleId);

		$_arr_update = array(
			"article_hits_all" => $_arr_articleRow["article_hits_all"] + 1,
		);

		if (!isset($_arr_articleRow["article_time_day"]) || date("Y-m-d", $_arr_articleRow["article_time_day"]) != date("Y-m-d")) {
			$_arr_update["article_hits_day"] = 0;
			$_arr_update["article_time_day"] = time();
		} else {
			$_arr_update["article_hits_day"] = $_arr_articleRow["article_hits_day"] + 1;
		}

		if (!isset($_arr_articleRow["article_time_week"]) || date("Y-W", $_arr_articleRow["article_time_week"]) != date("Y-W")) {
			$_arr_update["article_hits_week"] = 0;
			$_arr_update["article_time_week"] = time();
		} else {
			$_arr_update["article_hits_week"] = $_arr_articleRow["article_hits_week"] + 1;
		}

		if (!isset($_arr_articleRow["article_time_month"]) || date("Y-m", $_arr_articleRow["article_time_month"]) != date("Y-m")) {
			$_arr_update["article_hits_month"] = 0;
			$_arr_update["article_time_month"] = time();
		} else {
			$_arr_update["article_hits_month"] = $_arr_articleRow["article_hits_month"] + 1;
		}

		if (!isset($_arr_articleRow["article_time_year"]) || date("Y", $_arr_articleRow["article_time_year"]) != date("Y")) {
			$_arr_update["article_hits_year"] = 0;
			$_arr_update["article_time_year"] = time();
		} else {
			$_arr_update["article_hits_year"] = $_arr_articleRow["article_hits_year"] + 1;
		}

		$_str_sqlWhere    = "article_id=" . $num_articleId;

		//print_r($_arr_update);

		$_arr_articleRows = $this->obj_db->update(BG_DB_TABLE . "article", $_arr_update, $_str_sqlWhere);

		return $_arr_articleRows;
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
