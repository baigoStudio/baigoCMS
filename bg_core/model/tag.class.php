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
class MODEL_TAG {

	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $num_tagId
	 * @param mixed $str_tagName
	 * @param mixed $str_tagType
	 * @param mixed $str_tagStatus
	 * @return void
	 */
	function mdl_submit($num_tagId, $str_tagName, $str_tagStatus = "show") {
		$_arr_tagData = array(
			"tag_name"   => $str_tagName,
			"tag_status" => $str_tagStatus,
		);

		if ($num_tagId == 0) {
			$_num_tagId = $this->obj_db->insert(BG_DB_TABLE . "tag", $_arr_tagData);

			if ($_num_tagId > 0) { //数据库插入是否成功
				$_str_alert = "y130101";
			} else {
				return array(
					"str_alert" => "x130101",
				);
				exit;
			}
		} else {
			$_num_tagId = $num_tagId;
			$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "tag", $_arr_tagData, "tag_id=" . $_num_tagId);

			if ($_num_mysql > 0) {
				$_str_alert = "y130103";
			} else {
				return array(
					"str_alert" => "x130103",
				);
				exit;
			}
		}

		return array(
			"tag_id"     => $_num_tagId,
			"str_alert"  => $_str_alert,
		);
	}


	/**
	 * mdl_countDo function.
	 *
	 * @access public
	 * @param mixed $num_tagId
	 * @param int $num_articleCount (default: 0)
	 * @return void
	 */
	function mdl_countDo($num_tagId, $num_articleCount = 0) {
		$_arr_tagData = array(
			"tag_article_count" => $num_articleCount,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "tag", $_arr_tagData, "tag_id=" . $num_tagId);

		if ($_num_mysql > 0) {
			$_str_alert = "y130103";
		} else {
			return array(
				"str_alert" => "x130103",
			);
			exit;
		}

		return array(
			"tag_id"     => $_num_tagId,
			"str_alert"  => $_str_alert,
		);
	}


	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $str_tag
	 * @param string $str_readBy (default: "tag_id")
	 * @param int $num_notThisId (default: 0)
	 * @param int $num_parentId (default: 0)
	 * @return void
	 */
	function mdl_read($str_tag, $str_readBy = "tag_id", $num_notId = 0) {
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

		if ($num_notId > 0) {
			$_str_sqlWhere .= " AND tag_id<>" . $num_notId;
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
	function mdl_list($num_no, $num_except = 0, $str_key = "", $str_status = "") {
		$_arr_tagSelect = array(
			"tag_id",
			"tag_name",
			"tag_article_count",
			"tag_status",
		);

		$_str_sqlWhere = "tag_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND tag_name LIKE '%" . $str_key . "%'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND tag_status='" . $str_status . "'";
		}

		$_arr_tagRows = $this->obj_db->select_array(BG_DB_TABLE . "tag",  $_arr_tagSelect, $_str_sqlWhere . " ORDER BY tag_id DESC", $num_no, $num_except);

		return $_arr_tagRows;
	}


	/**
	 * mdl_status function.
	 *
	 * @access public
	 * @param mixed $arr_tagId
	 * @param mixed $str_status
	 * @return void
	 */
	function mdl_status($arr_tagId, $str_status) {
		$_str_tagId = implode(",", $arr_tagId);

		$_arr_tagData = array(
			"tag_status" => $str_status,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "tag",  $_arr_tagData, "tag_id IN (" . $_str_tagId . ")"); //更新数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y130103";
		} else {
			$_str_alert = "x130103";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @param mixed $arr_tagId
	 * @return void
	 */
	function mdl_del($arr_tagId) {
		$_str_tagId = implode(",", $arr_tagId);

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "tag",  "tag_id IN (" . $_str_tagId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y130104";
			$this->obj_db->delete(BG_DB_TABLE . "tag_belong", "belong_tag_id IN (" . $_str_tagId . ")"); //更新数据
		} else {
			$_str_alert = "x130104";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	function mdl_count($str_key = "", $str_status = "") {

		$_str_sqlWhere = "tag_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND tag_name LIKE '%" . $str_key . "%'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND tag_status='" . $str_status . "'";
		}

		$_num_tagCount = $this->obj_db->count(BG_DB_TABLE . "tag", $_str_sqlWhere); //查询数据

		/*print_r($_arr_userRow);
		exit;*/

		return $_num_tagCount;
	}
}
?>