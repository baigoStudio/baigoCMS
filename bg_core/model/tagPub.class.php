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

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	function mdl_read($str_tag) {
		$_arr_tagSelect = array(
			"tag_id",
			"tag_name",
			"tag_status",
		);

		$_str_sqlWhere = "tag_name='" . $str_tag . "'";

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
	function mdl_list($num_no, $num_except = 0, $num_articleId = 0) {
		$_arr_tagSelect = array(
			"tag_id",
			"tag_name",
			"tag_article_count",
		);

		$_str_sqlWhere = "tag_status='show'";

		if ($num_articleId > 0) {
			$_str_sqlWhere .= " AND belong_article_id=" . $num_articleId;
		}

		$_str_sqlWhere .= " GROUP BY belong_tag_id";

		$_str_sqlOn = " ON belong_tag_id=tag_id";

		$_arr_tagRows = $this->obj_db->select_array(BG_DB_TABLE . "tag_belong",  $_arr_tagSelect, $_str_sqlWhere . " ORDER BY tag_id DESC", $num_no, $num_except, array("belong_tag_id"), BG_DB_TABLE . "tag" . $_str_sqlOn);

		return $_arr_tagRows;
	}


	/**
	 * mdl_count function.
	 *
	 * @access public
	 * @param int $num_articleId (default: 0)
	 * @return void
	 */
	function mdl_count($num_articleId = 0) {

		$_str_sqlWhere = "tag_status='show'";

		if ($num_articleId > 0) {
			$_str_sqlWhere .= " AND belong_article_id=" . $num_articleId;
		}

		$_str_sqlOn = " ON belong_tag_id=tag_id";

		$_num_tagCount = $this->obj_db->count(BG_DB_TABLE . "tag_belong", $_str_sqlWhere, array("belong_tag_id"), BG_DB_TABLE . "tag" . $_str_sqlOn); //查询数据

		/*print_r($_arr_userRow);
		exit;*/

		return $_num_tagCount;
	}
}
?>