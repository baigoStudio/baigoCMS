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
class MODEL_GROUP {

	public $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $num_groupId
	 * @param mixed $str_groupName
	 * @param mixed $str_groupType
	 * @param string $str_groupNote (default: "")
	 * @param string $str_groupAllow (default: "")
	 * @return void
	 */
	function mdl_submit($num_groupId, $str_groupName, $str_groupType, $str_groupNote = "", $str_groupAllow = "") {

		$_arr_groupData = array(
			"group_name"     => $str_groupName,
			"group_type"     => $str_groupType,
			"group_note"     => $str_groupNote,
			"group_allow"    => $str_groupAllow,
		);

		if ($num_groupId == 0) { //插入
			$_num_groupId = $this->obj_db->insert(BG_DB_TABLE . "group", $_arr_groupData);

			if ($_num_groupId > 0) { //数据库插入是否成功
				$_str_alert = "y040101";
			} else {
				return array(
					"str_alert" => "x040101",
				);
				exit;
			}
		} else {
			$_num_groupId = $num_groupId;
			$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "group", $_arr_groupData, "group_id=" . $_num_groupId);

			if ($_num_mysql > 0) { //数据库更新是否成功
				$_str_alert = "y040103";
			} else {
				return array(
					"str_alert" => "x040103",
				);
				exit;
			}
		}

		return array(
			"group_id"   => $_num_groupId,
			"str_alert"  => $_str_alert,
		);

	}


	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $str_group
	 * @param string $str_readBy (default: "group_id")
	 * @param int $num_notId (default: 0)
	 * @return void
	 */
	function mdl_read($str_group, $str_readBy = "group_id", $num_notId = 0) {

		$_arr_groupSelect = array(
			"group_id",
			"group_name",
			"group_note",
			"group_allow",
			"group_type",
		);

		switch ($str_readBy) {
			case "group_id":
				$_str_sqlWhere = $str_readBy . "=" . $str_group;
			break;
			default:
				$_str_sqlWhere = $str_readBy . "='" . $str_group . "'";
			break;
		}

		if ($num_notId > 0) {
			$_str_sqlWhere .= " AND group_id<>" . $num_notId;
		}

		$_arr_groupRows = $this->obj_db->select_array(BG_DB_TABLE . "group",  $_arr_groupSelect, $_str_sqlWhere, 1, 0); //检查本地表是否存在记录
		$_arr_groupRow = $_arr_groupRows[0];

		if (!$_arr_groupRow) {
			return array(
				"str_alert" => "x040102", //不存在记录
			);
			exit;
		}

		$_arr_groupRow["str_alert"] = "y040102";

		return $_arr_groupRow;
	}


	/**
	 * mdl_list function.
	 *
	 * @access public
	 * @param mixed $num_no
	 * @param int $num_except (default: 0)
	 * @param string $str_key (default: "")
	 * @param string $str_type (default: "")
	 * @return void
	 */
	function mdl_list($num_no, $num_except = 0, $str_key = "", $str_type = "") {

		$_arr_groupSelect = array(
			"group_id",
			"group_name",
			"group_note",
			"group_type",
		);

		$_str_sqlWhere = "group_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND group_name LIKE '%" . $str_key . "%' OR group_note LIKE '%" . $str_key . "%'";
		}

		if ($str_type) {
			$_str_sqlWhere .= " AND group_type='" . $str_type . "'";
		}

		$_arr_groupRows = $this->obj_db->select_array(BG_DB_TABLE . "group",  $_arr_groupSelect, $_str_sqlWhere . " ORDER BY group_id DESC", $num_no, $num_except); //列出本地表是否存在记录

		return $_arr_groupRows;

	}


	/**
	 * mdl_count function.
	 *
	 * @access public
	 * @param string $str_key (default: "")
	 * @param string $str_status (default: "")
	 * @return void
	 */
	function mdl_count($str_key = "", $str_type = "") {
		$_str_sqlWhere = "group_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND group_name LIKE '%" . $str_key . "%' OR group_note LIKE '%" . $str_key . "%'";
		}

		if ($str_type) {
			$_str_sqlWhere .= " AND group_type='" . $str_type . "'";
		}

		$_num_count = $this->obj_db->count(BG_DB_TABLE . "group", $_str_sqlWhere); //查询数据

		return $_num_count;
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @param mixed $arr_groupId
	 * @return void
	 */
	function mdl_del($arr_groupId) {

		$_str_groupId = implode(",", $arr_groupId);

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "group",  "group_id IN (" . $_str_groupId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y040104";
		} else {
			$_str_alert = "x040104";
		}

		return array(
			"str_alert" => $_str_alert,
		);
		exit;

	}
}
?>