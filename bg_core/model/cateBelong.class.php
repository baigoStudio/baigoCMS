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
class MODEL_CATE_BELONG {

	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	function mdl_create() {
		$_arr_belongCreat = array(
			"belong_id"          => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"belong_cate_id"     => "int(11) NOT NULL COMMENT '栏目 ID'",
			"belong_article_id"  => "int(11) NOT NULL COMMENT '文章 ID'",
		);

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "cate_belong", $_arr_belongCreat, "belong_id", "栏目从属");

		if ($_num_mysql > 0) {
			$_str_alert = "y150105"; //更新成功
		} else {
			$_str_alert = "x150105"; //更新成功
		}

		return array(
			"str_alert" => $_str_alert, //更新成功
		);
	}


	function mdl_column() {
		$_arr_colSelect = array(
			"column_name"
		);

		$_str_sqlWhere = "table_schema='" . BG_DB_NAME . "' AND table_name='" . BG_DB_TABLE . "cate_belong'";

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
	 * @param mixed $num_cateId
	 * @param mixed $num_belongId
	 * @return void
	 */
	function mdl_submit($num_articleId, $num_cateId) {

		$_arr_belongData = array(
			"belong_article_id"  => $num_articleId,
			"belong_cate_id"     => $num_cateId,
		);

		$_arr_belongRow = $this->mdl_read($num_articleId, $num_cateId);

		if ($_arr_belongRow["str_alert"] == "x150102" && $num_articleId > 0 && $num_cateId > 0) { //插入
			$_num_belongId = $this->obj_db->insert(BG_DB_TABLE . "cate_belong", $_arr_belongData);

			if ($_num_belongId > 0) { //数据库插入是否成功
				$_str_alert = "y150101";
			} else {
				return array(
					"str_alert" => "x150101",
				);
				exit;
			}
		} else {
			return array(
				"str_alert" => "x150101",
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
	function mdl_read($num_articleId = 0, $num_cateId = 0) {
		$_arr_belongSelect = array(
			"belong_article_id",
			"belong_cate_id",
		);

		$_str_sqlWhere = "belong_id>0";

		if ($num_articleId > 0) {
			$_str_sqlWhere .= " AND belong_article_id=" . $num_articleId;
		}

		if ($num_cateId > 0) {
			$_str_sqlWhere .= " AND belong_cate_id=" . $num_cateId;
		}

		$_arr_belongRows  = $this->obj_db->select_array(BG_DB_TABLE . "cate_belong",  $_arr_belongSelect, $_str_sqlWhere, 1, 0); //检查本地表是否存在记录

		if (isset($_arr_belongRows[0])) {
			$_arr_belongRow   = $_arr_belongRows[0];
		} else {
			return array(
				"str_alert" => "x150102", //不存在记录
			);
			exit;
		}

		$_arr_belongRow["str_alert"] = "y150102";

		return $_arr_belongRow;
	}


	function mdl_list($num_articleId = 0) {
		$_arr_belongSelect = array(
			"belong_cate_id",
			"belong_article_id",
		);

		$_str_sqlWhere = "belong_id>0";

		if ($num_articleId > 0) {
			$_str_sqlWhere .= " AND belong_article_id=" . $num_articleId;
		}

		$_arr_belongRows = $this->obj_db->select_array(BG_DB_TABLE . "cate_belong", $_arr_belongSelect, $_str_sqlWhere . " ORDER BY belong_id DESC", 1000, 0);

		return $_arr_belongRows;
	}


	/**
	 * mdl_count function.
	 *
	 * @access public
	 * @param int $num_cateId (default: 0)
	 * @param int $num_articleId (default: 0)
	 * @return void
	 */
	function mdl_count($num_cateId = 0, $num_articleId = 0) {

		$_str_sqlWhere = "belong_id > 0";

		if ($num_cateId > 0) {
			$_str_sqlWhere .= " AND belong_cate_id=" . $num_cateId;
		}

		if ($num_articleId > 0) {
			$_str_sqlWhere .= " AND belong_article_id=" . $num_articleId;
		}

		$_num_belongCount = $this->obj_db->count(BG_DB_TABLE . "cate_belong", $_str_sqlWhere); //查询数据

		/*print_r($_arr_userRow);
		exit;*/

		return $_num_belongCount;
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @param int $num_cateId (default: 0)
	 * @param int $num_articleId (default: 0)
	 * @return void
	 */
	function mdl_del($num_cateId = 0, $num_articleId = 0, $arr_cateIds = false, $arr_articleIds = false, $arr_notCateIds = false, $arr_notArticleIds = false) {

		$_str_sqlWhere = "belong_id > 0";

		if ($num_cateId > 0) {
			$_str_sqlWhere .= " AND belong_cate_id=" . $num_cateId;
		}

		if ($num_articleId > 0) {
			$_str_sqlWhere .= " AND belong_article_id=" . $num_articleId;
		}

		if ($arr_cateIds) {
			$_str_cateIds    = implode(",", $arr_cateIds);
			$_str_sqlWhere  .= " AND belong_cate_id IN (" . $_str_cateIds . ")";
		}

		if ($arr_articleIds) {
			$_str_articleIds = implode(",", $arr_articleIds);
			$_str_sqlWhere  .= " AND belong_article_id IN (" . $_str_articleIds . ")";
		}

		if ($arr_notCateIds) {
			$_str_notCateIds    = implode(",", $arr_notCateIds);
			$_str_sqlWhere  .= " AND belong_cate_id NOT IN (" . $_str_notCateIds . ")";
		}

		if ($arr_notArticleIds) {
			$_str_notArticleIds = implode(",", $arr_notArticleIds);
			$_str_sqlWhere  .= " AND belong_article_id NOT IN (" . $_str_notArticleIds . ")";
		}

		//print_r($_str_sqlWhere);

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "cate_belong", $_str_sqlWhere); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y150104";
		} else {
			$_str_alert = "x150104";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}
}
?>