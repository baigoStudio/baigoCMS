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
class MODEL_TAG_BELONG {

	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $num_belongId
	 * @param mixed $num_tagId
	 * @param mixed $num_belongId
	 * @return void
	 */
	function mdl_submit($num_tagId, $num_articleId) {

		$_arr_belongData = array(
			"belong_tag_id"      => $num_tagId,
			"belong_article_id"  => $num_articleId,
		);

		$_num_belongId = $this->obj_db->insert(BG_DB_TABLE . "tag_belong", $_arr_belongData);

		if ($_num_belongId > 0) { //数据库插入是否成功
			$_str_alert = "y160101";
		} else {
			return array(
				"str_alert" => "x160101",
			);
			exit;
		}

		return array(
			"str_alert"  => $_str_alert,
		);
	}


	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $str_belong
	 * @param string $str_readBy (default: "belong_id")
	 * @param int $num_notThisId (default: 0)
	 * @param int $num_parentId (default: 0)
	 * @return void
	 */
	function mdl_read($str_belong, $str_readBy = "belong_tag_id") {
		$_arr_belongSelect = array(
			"belong_tag_id",
			"belong_article_id",
		);

		$_str_sqlWhere = $str_readBy . "=" . $str_belong;

		$_arr_belongRows  = $this->obj_db->select_array(BG_DB_TABLE . "tag_belong",  $_arr_belongSelect, $_str_sqlWhere, 1, 0); //检查本地表是否存在记录
		$_arr_belongRow   = $_arr_belongRows[0];

		if (!$_arr_belongRow) {
			return array(
				"str_alert" => "x160102", //不存在记录
			);
			exit;
		}

		$_arr_belongRow["str_alert"] = "y160102";

		return $_arr_belongRow;
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
	function mdl_list($num_articleId = 0, $str_status = "") {
		$_arr_belongSelect = array(
			"belong_tag_id",
			"belong_article_id",
		);

		$_str_sqlWhere = "belong_id>0";

		if ($num_articleId > 0) {
			$_str_sqlWhere .= " AND belong_article_id=" . $num_articleId;
		}

		$_arr_belongRows = $this->obj_db->select_array(BG_DB_TABLE . "tag_belong",  $_arr_belongSelect, $_str_sqlWhere . " ORDER BY belong_id DESC", 1000, 0);

		return $_arr_belongRows;
	}


	/**
	 * mdl_count function.
	 *
	 * @access public
	 * @param int $num_tagId (default: 0)
	 * @param int $num_articleId (default: 0)
	 * @return void
	 */
	function mdl_count($num_tagId = 0, $num_articleId = 0) {

		$_str_sqlWhere = "belong_id > 0";

		if ($num_tagId > 0) {
			$_str_sqlWhere .= " AND belong_tag_id=" . $num_tagId;
		}

		if ($num_articleId > 0) {
			$_str_sqlWhere .= " AND belong_article_id=" . $num_articleId;
		}

		$_num_belongCount = $this->obj_db->count(BG_DB_TABLE . "tag_belong", $_str_sqlWhere); //查询数据

		return $_num_belongCount;
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @param int $num_tagId (default: 0)
	 * @param int $num_articleId (default: 0)
	 * @return void
	 */
	function mdl_del($num_tagId = 0, $num_articleId = 0, $arr_tagId = false, $arr_articleId = false) {

		$_str_sqlWhere = "belong_tag_id > 0";

		if ($num_tagId > 0) {
			$_str_sqlWhere .= " AND belong_tag_id=" . $num_tagId;
		}

		if ($num_articleId > 0) {
			$_str_sqlWhere .= " AND belong_article_id=" . $num_articleId;
		}

		if ($arr_tagId) {
			$_str_tagId = implode(",", $arr_tagId);
			$_str_sqlWhere .= " AND belong_tag_id IN (" . $_str_tagId . ")";
		}

		if ($arr_articleId) {
			$_str_articleId = implode(",", $arr_articleId);
			$_str_sqlWhere .= " AND belong_article_id IN (" . $_str_articleId . ")";
		}

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "tag_belong", $_str_sqlWhere); //删除数据

		if ($_num_mysql > 0) {
			$_str_alert = "y160104";
		} else {
			$_str_alert = "x160104";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}
}
?>