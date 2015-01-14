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


	function mdl_create() {
		$_arr_belongCreat = array(
			"belong_id"          => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"belong_tag_id"      => "int(11) NOT NULL COMMENT '标签 ID'",
			"belong_article_id"  => "int(11) NOT NULL COMMENT '文章 ID'",
		);

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "tag_belong", $_arr_belongCreat, "belong_id", "标签从属");

		if ($_num_mysql > 0) {
			$_str_alert = "y160105"; //更新成功
		} else {
			$_str_alert = "x160105"; //更新成功
		}

		return array(
			"str_alert" => $_str_alert, //更新成功
		);
	}


	function mdl_column() {
		$_arr_colSelect = array(
			"column_name"
		);

		$_str_sqlWhere = "table_schema='" . BG_DB_NAME . "' AND table_name='" . BG_DB_TABLE . "tag_belong'";

		$_arr_colRows = $this->obj_db->select_array("information_schema`.`columns", $_arr_colSelect, $_str_sqlWhere, 100, 0);

		foreach ($_arr_colRows as $_key=>$_value) {
			$_arr_col[] = $_value["column_name"];
		}

		return $_arr_col;
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
	function mdl_submit($num_articleId, $num_tagId) {

		$_arr_belongData = array(
			"belong_article_id"  => $num_articleId,
			"belong_tag_id"      => $num_tagId,
		);

		$_arr_belongRow = $this->mdl_read($num_articleId, $num_tagId);

		if ($_arr_belongRow["str_alert"] == "x160102" && $num_articleId > 0 && $num_tagId > 0) { //插入
			$_num_belongId = $this->obj_db->insert(BG_DB_TABLE . "tag_belong", $_arr_belongData);

			if ($_num_belongId > 0) { //数据库插入是否成功
				$_str_alert = "y160101";
			} else {
				return array(
					"str_alert" => "x160101",
				);
				exit;
			}
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
	function mdl_read($num_articleId = 0, $num_tagId = 0) {
		$_arr_belongSelect = array(
			"belong_article_id",
			"belong_tag_id",
		);

		$_str_sqlWhere = "belong_id>0";

		if ($num_articleId > 0) {
			$_str_sqlWhere .= " AND belong_article_id=" . $num_articleId;
		}

		if ($num_tagId > 0) {
			$_str_sqlWhere .= " AND belong_tag_id=" . $num_tagId;
		}

		$_arr_belongRows  = $this->obj_db->select_array(BG_DB_TABLE . "tag_belong",  $_arr_belongSelect, $_str_sqlWhere, 1, 0); //检查本地表是否存在记录

		if (isset($_arr_belongRows[0])) {
			$_arr_belongRow   = $_arr_belongRows[0];
		} else {
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
	function mdl_del($num_tagId = 0, $num_articleId = 0, $arr_tagIds = false, $arr_articleIds = false, $arr_notTagIds = false, $arr_notArticleIds = false) {

		$_str_sqlWhere = "belong_id > 0";

		if ($num_tagId > 0) {
			$_str_sqlWhere .= " AND belong_tag_id=" . $num_tagId;
		}

		if ($num_articleId > 0) {
			$_str_sqlWhere .= " AND belong_article_id=" . $num_articleId;
		}

		if ($arr_tagIds) {
			$_str_tagIds     = implode(",", $arr_tagIds);
			$_str_sqlWhere  .= " AND belong_tag_id IN (" . $_str_tagIds . ")";
		}

		if ($arr_articleIds) {
			$_str_articleIds = implode(",", $arr_articleIds);
			$_str_sqlWhere  .= " AND belong_article_id IN (" . $_str_articleIds . ")";
		}

		if ($arr_notTagIds) {
			$_str_notTagIds     = implode(",", $arr_notTagIds);
			$_str_sqlWhere  .= " AND belong_tag_id NOT IN (" . $_str_notTagIds . ")";
		}

		if ($arr_notArticleIds) {
			$_str_notArticleIds = implode(",", $arr_notArticleIds);
			$_str_sqlWhere  .= " AND belong_article_id NOT IN (" . $_str_notArticleIds . ")";
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