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
class MODEL_ARTICLE {

	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $num_articleId
	 * @param mixed $str_articleTitle
	 * @param mixed $str_articleContent
	 * @param string $str_articleExcerpt (default: "")
	 * @param float $num_articleCateId (default: -1)
	 * @param int $num_articleMarkId (default: 0)
	 * @param string $str_articleStatus (default: "")
	 * @param string $str_articleBox (default: "")
	 * @param string $str_articleLink (default: "")
	 * @param string $str_articleTag (default: "")
	 * @param int $tm_articleTimePub (default: 0)
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_submit($num_articleId, $str_articleTitle, $str_articleContent, $str_articleExcerpt = "", $num_articleCateId = -1, $num_articleMarkId = 0, $str_articleStatus = "", $str_articleBox = "", $str_articleLink = "", $str_articleTag = "", $tm_articleTimePub = 0, $num_adminId = 0, $num_upfileId = 0) {

		$_arr_articleData = array(
			"article_title"      => $str_articleTitle,
			"article_excerpt"    => $str_articleExcerpt,
			"article_content"    => $str_articleContent,
			"article_cate_id"    => $num_articleCateId,
			"article_mark_id"    => $num_articleMarkId,
			"article_status"     => $str_articleStatus,
			"article_box"        => $str_articleBox,
			"article_link"       => $str_articleLink,
			"article_tag"        => $str_articleTag,
			"article_time_pub"   => $tm_articleTimePub,
			"article_upfile_id"  => $num_upfileId,
		);

		if ($num_articleId == 0) {

			$_arr_insert = array(
				"article_admin_id"  => $num_adminId,
				"article_time"      => time(),
			);
			$_arr_data = array_merge($_arr_articleData, $_arr_insert);

			$_num_articleId = $this->obj_db->insert(BG_DB_TABLE . "article", $_arr_data); //插入数据

			if ($_num_articleId > 0) {
				$_str_alert = "y120101";
			} else {
				return array(
					"str_alert" => "x120101", //失败
				);
				exit;
			}

		} else {
			$_num_articleId = $num_articleId;
			$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "article", $_arr_articleData, "article_id=" . $_num_articleId); //更新数据

			if ($_num_mysql > 0) {
				$_str_alert = "y120103";
			} else {
				return array(
					"article_id"   => $_num_articleId,
					"str_alert"    => "x120103", //失败
				);
				exit;
			}
		}

		/*print_r($_arr_userRow);
		exit;*/

		return array(
			"article_id" => $_num_articleId,
			"str_alert"  => $_str_alert,
		);
	}


	/**
	 * mdl_list function.
	 *
	 * @access public
	 * @param mixed $num_no
	 * @param int $num_except (default: 0)
	 * @param string $str_key (default: "")
	 * @param bool $arr_tagIds (default: false)
	 * @param string $str_year (default: "")
	 * @param string $str_month (default: "")
	 * @param string $str_status (default: "")
	 * @param string $str_box (default: "")
	 * @param bool $arr_cateIds (default: false)
	 * @param bool $arr_markIds (default: false)
	 * @param string $_str_callUpfile (default: "")
	 * @param int $num_adminId (default: 0)
	 * @param bool $is_pub (default: false)
	 * @param string $_str_callType (default: "")
	 * @return void
	 */
	function mdl_list($num_no, $num_except = 0, $str_key = "", $str_year = "", $str_month = "", $str_status = "", $str_box = "", $arr_cateIds = false, $arr_markIds = false, $arr_tagIds = false, $num_adminId = 0, $is_pub = false) {
		$_arr_articleSelect = array(
			"article_id",
			"article_cate_id",
			"article_title",
			"article_excerpt",
			"article_status",
			"article_box",
			"article_link",
			"article_tag",
			"article_admin_id",
			"article_hits_day",
			"article_hits_week",
			"article_hits_month",
			"article_hits_year",
			"article_hits_all",
			"article_time",
			"article_time_pub",
		);

		$_str_sqlWhere = "article_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND (article_title LIKE '%" . $str_key . "%' OR article_content like '%" . $str_key . "%')";
		}

		if ($str_year) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(article_time, '%Y')='" . $str_year . "'";
		}

		if ($str_month) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(article_time, '%m')='" . $str_month . "'";
		}

		if ($is_pub) {
			$_str_sqlWhere .= " AND LENGTH(article_title) > 0 AND article_status='pub' AND article_box='normal' AND article_time_pub<=" . time();
		} else {
			if ($str_status) {
				$_str_sqlWhere .= " AND article_status='" . $str_status . "'";
			}

			if ($str_box) {
				$_str_sqlWhere .= " AND article_box='" . $str_box . "'";
			} else {
				$_str_sqlWhere .= " AND article_box='normal'";
			}
		}

		if ($arr_cateIds) {
			$_str_cateIds = implode(",", $arr_cateIds);
			$_str_sqlWhere .= " AND  article_cate_id IN (" . $_str_cateIds . ")";
		}

		if ($arr_markIds) {
			$_str_markIds = implode(",", $arr_markIds);
			$_str_sqlWhere .= " AND article_mark_id IN (" . $_str_markIds . ")";
		}

		if ($arr_tagIds) {
			$_str_tagIds = implode(",", $arr_tagIds);
			$_str_sqlWhere .= " AND article_tag_id IN (" . $_str_tagIds . ")";
		}

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND article_admin_id=" . $num_adminId;
		}

		$_arr_articleRows = $this->obj_db->select_array(BG_DB_TABLE . "article", $_arr_articleSelect, $_str_sqlWhere . " ORDER BY article_top DESC, article_id DESC", $num_no, $num_except);

		return $_arr_articleRows;
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
	 * mdl_top function.
	 *
	 * @access public
	 * @param mixed $arr_articleId
	 * @param mixed $num_top
	 * @param bool $arr_cateIds (default: false)
	 * @return void
	 */
	function mdl_top($arr_articleId, $num_top, $arr_cateIds = false) {

		$_str_articleId = implode(",", $arr_articleId);

		$_arr_articleUpdate = array(
			"article_top" => $num_top,
		);

		if ($arr_cateIds) {
			$_str_cateIds     = implode(",", $arr_cateIds);
			$_str_sqlWhere   = " AND article_cate_id IN (" . $_str_cateIds . ")";
		}

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "article", $_arr_articleUpdate, "article_id IN (" . $_str_articleId . ")" . $_str_sqlWhere); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y120103";
		} else {
			$_str_alert = "x120103";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	/**
	 * mdl_status function.
	 *
	 * @access public
	 * @param mixed $arr_articleId
	 * @param mixed $str_status
	 * @param bool $arr_cateIds (default: false)
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_status($arr_articleId, $str_status, $arr_cateIds = false, $num_adminId = 0) {

		$_str_articleId = implode(",", $arr_articleId);

		$_arr_articleUpdate = array(
			"article_status" => $str_status,
		);

		if ($arr_cateIds) {
			$_str_cateIds    = implode(",", $arr_cateIds);
			$_str_sqlWhere   = " AND article_cate_id IN (" . $_str_cateIds . ")";
		}

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND article_admin_id=" . $num_adminId;
		}

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "article", $_arr_articleUpdate, "article_id IN (" . $_str_articleId . ")" . $_str_sqlWhere); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y120103";
		} else {
			$_str_alert = "x120103";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	/**
	 * mdl_box function.
	 *
	 * @access public
	 * @param mixed $arr_articleId
	 * @param mixed $str_box
	 * @param bool $arr_cateIds (default: false)
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_box($arr_articleId, $str_box, $arr_cateIds = false, $num_adminId = 0) {

		$_str_articleId = implode(",", $arr_articleId);

		$_arr_articleUpdate = array(
			"article_box"        => $str_box,
		);

		if ($arr_cateIds) {
			$_str_cateIds     = implode(",", $arr_cateIds);
			$_str_sqlWhere   = " AND article_cate_id IN (" . $_str_cateIds . ")";
		}

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND article_admin_id=" . $num_adminId;
		}

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "article", $_arr_articleUpdate, "article_id IN (" . $_str_articleId . ")" . $_str_sqlWhere); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y120103";
		} else {
			$_str_alert = "x120103";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @param mixed $arr_articleId
	 * @param bool $arr_cateIds (default: false)
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_del($arr_articleId, $arr_cateIds = false, $num_adminId = 0) {

		$_str_articleId = implode(",", $arr_articleId);

		if ($arr_cateIds) {
			$_str_cateIds     = implode(",", $arr_cateIds);
			$_str_sqlWhere   = " AND article_cate_id IN (" . $_str_cateIds . ")";
		}

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND article_admin_id=" . $num_adminId;
		}

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "article", "article_id IN (" . $_str_articleId . ")" . $_str_sqlWhere); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y120103";
		} else {
			$_str_alert = "x120103";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	/**
	 * mdl_empty function.
	 *
	 * @access public
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_empty($num_adminId = 0) {
		$_str_sqlWhere = "article_status='recycle'";

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND article_admin_id=" . $num_adminId;
		}

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "article", $_str_sqlWhere); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y120104";
		} else {
			$_str_alert = "x120104";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	/**
	 * mdl_unknowCate function.
	 *
	 * @access public
	 * @param mixed $arr_articleId
	 * @return void
	 */
	function mdl_unknowCate($arr_articleId) {
		$_str_articleId = implode(",", $arr_articleId);

		$_arr_articleData = array(
			"article_cate_id" => -1,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "article",  $_arr_articleData, "article_id IN (" . $_str_articleId . ")"); //更新数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y120103";
		} else {
			$_str_alert = "x120103";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	/**
	 * mdl_count function.
	 *
	 * @access public
	 * @param string $str_key (default: "")
	 * @param string $str_tag (default: "")
	 * @param string $str_year (default: "")
	 * @param string $str_month (default: "")
	 * @param string $str_status (default: "")
	 * @param string $str_box (default: "")
	 * @param bool $arr_cateIds (default: false)
	 * @param int $arr_markIds (default: 0)
	 * @param int $num_adminId (default: 0)
	 * @param bool $is_pub (default: false)
	 * @return void
	 */
	function mdl_count($str_key = "", $str_year = "", $str_month = "", $str_status = "", $str_box = "", $arr_cateIds = false, $arr_markIds = false, $arr_tagIds = false, $num_adminId = 0, $is_pub = false) {
		$_str_sqlWhere = "article_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND (article_title LIKE '%" . $str_key . "%' OR article_content like '%" . $str_key . "%')";
		}

		if ($str_year) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(article_time, '%Y')='" . $str_year . "'";
		}

		if ($str_month) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(article_time, '%m')='" . $str_month . "'";
		}

		if ($is_pub) {
			$_str_sqlWhere .= " AND LENGTH(article_title) > 0 AND article_status='pub' AND article_box='normal' AND article_time_pub<=" . time();
		} else {
			if ($str_status) {
				$_str_sqlWhere .= " AND article_status='" . $str_status . "'";
			}

			if ($str_box) {
				$_str_sqlWhere .= " AND article_box='" . $str_box . "'";
			} else {
				$_str_sqlWhere .= " AND article_box='normal'";
			}
		}

		if ($arr_cateIds) {
			$_str_cateIds = implode(",", $arr_cateIds);
			$_str_sqlWhere .= " AND  article_cate_id IN (" . $_str_cateIds . ")";
		}

		if ($arr_markIds) {
			$_str_markIds = implode(",", $arr_markIds);
			$_str_sqlWhere .= " AND article_mark_id IN (" . $_str_markIds . ")";
		}

		if ($arr_tagIds) {
			$_str_tagIds = implode(",", $arr_tagIds);
			$_str_sqlWhere .= " AND article_tag_id IN (" . $_str_tagIds . ")";
		}

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND article_admin_id=" . $num_adminId;
		}

		$_num_articleCount = $this->obj_db->count(BG_DB_TABLE . "article", $_str_sqlWhere); //查询数据

		return $_num_articleCount;
	}


	/**
	 * mdl_year function.
	 *
	 * @access public
	 * @return void
	 */
	function mdl_year() {
		$_arr_articleSelect = array(
			"FROM_UNIXTIME(article_time, '%Y') AS article_year",
		);

		$_arr_distinct = array(
			"article_time",
		);

		$_str_sqlWhere = "article_time > 0";

		$_arr_articleRows = $this->obj_db->select_array(BG_DB_TABLE . "article", $_arr_articleSelect, $_str_sqlWhere . " ORDER BY article_time ASC", 100, 0, $_arr_distinct, "", true);

		return $_arr_articleRows;
	}
}
?>