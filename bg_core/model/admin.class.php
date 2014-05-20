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
class MODEL_ADMIN {

	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}

	/**
	 * mdl_login function.
	 *
	 * @access public
	 * @param mixed $num_adminId
	 * @param mixed $str_rand
	 * @return void
	 */
	function mdl_login($num_adminId, $str_rand) {

		$_arr_adminUpdate = array(
			"admin_time_login"   => time(),
			"admin_ip"           => fn_getIp(),
			"admin_rand"         => $str_rand,
		);
		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminUpdate, "admin_id=" . $num_adminId); //更新数据
		if ($_num_mysql > 0) {
			$_str_alert = "y020103"; //更新成功
		} else {
			$_str_alert = "x020103"; //更新成功
		}

		return array(
			"str_alert" => $_str_alert, //更新成功
		);

	}


	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $num_adminId
	 * @param mixed $str_adminNote
	 * @param mixed $str_adminRand
	 * @param mixed $str_adminStatus
	 * @param mixed $str_adminAllowCate
	 * @return void
	 */
	function mdl_submit($num_adminId, $str_adminName = "", $str_adminNote = "", $str_adminRand = "", $str_adminStatus = "enable", $str_adminAllowCate = "") {

		$_arr_adminRow = $this->mdl_read($num_adminId);

		$_arr_adminData = array(
			"admin_note"         => $str_adminNote,
			"admin_status"       => $str_adminStatus,
			"admin_allow_cate"   => $str_adminAllowCate,
		);

		if ($_arr_adminRow["str_alert"] == "x020102") {
			$_arr_insert = array(
				"admin_id"      => $num_adminId,
				"admin_rand"    => $str_adminRand,
				"admin_name"    => $str_adminName,
				"admin_time"    => time(),
			);
			$_arr_data = array_merge($_arr_adminData, $_arr_insert);
			$_num_adminId = $this->obj_db->insert(BG_DB_TABLE . "admin", $_arr_data); //插入数据
			if ($_num_adminId >= 0) {
				$_str_alert = "y020101"; //插入成功
			} else {
				return array(
					"str_alert" => "x020101", //更新失败
				);
				exit;
			}
		} else {
			$_num_adminId = $num_adminId;
			$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminData, "admin_id=" . $_num_adminId); //更新数据
			if ($_num_mysql > 0) {
				$_str_alert = "y020103"; //更新成功
			} else {
				return array(
					"str_alert" => "x020103", //更新失败
				);
				exit;
			}
		}

		return array(
			"admin_id"   => $_num_adminId,
			"str_alert"  => $_str_alert, //成功
		);

	}


	/**
	 * mdl_toGroup function.
	 *
	 * @access public
	 * @param mixed $num_adminId
	 * @param mixed $num_groupId
	 * @return void
	 */
	function mdl_toGroup($num_adminId, $num_groupId) {

		$_arr_adminData = array(
			"admin_group_id"  => $num_groupId,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminData, "admin_id=" . $num_adminId); //更新数据
		if ($_num_mysql > 0) {
			$_str_alert = "y020103"; //更新成功
		} else {
			return array(
				"str_alert" => "x020103", //更新失败
			);
			exit;
		}

		return array(
			"admin_id"   => $num_adminId,
			"str_alert"  => $_str_alert, //成功
		);
	}


	/**
	 * mdl_status function.
	 *
	 * @access public
	 * @param mixed $arr_adminId
	 * @param mixed $str_status
	 * @return void
	 */
	function mdl_status($arr_adminId, $str_status = "enable") {

		$_str_adminId = implode(",", $arr_adminId);

		$_arr_adminUpdate = array(
			"admin_status" => $str_status,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminUpdate, "admin_id IN (" . $_str_adminId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y020103";
		} else {
			$_str_alert = "x020103";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功

	}


	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $num_adminId
	 * @return void
	 */
	function mdl_read($num_adminId) {

		$_arr_adminSelect = array(
			"admin_id",
			"admin_name",
			"admin_note",
			"admin_rand",
			"admin_group_id",
			"admin_status",
			"admin_time",
			"admin_ip",
			"admin_allow_cate",
		);

		$_arr_adminRows = $this->obj_db->select_array(BG_DB_TABLE . "admin", $_arr_adminSelect, "admin_id=" . $num_adminId, 1, 0); //检查本地表是否存在记录
		$_arr_adminRow = $_arr_adminRows[0];

		/*print_r($_arr_adminRow);
		exit;*/

		if (!$_arr_adminRow) { //用户名不存在则返回错误
			return array(
				"str_alert" => "x020102", //不存在记录
			);
			exit;
		}

		$_arr_adminRow["str_alert"] = "y020102";

		return $_arr_adminRow;

	}


	/**
	 * mdl_list function.
	 *
	 * @access public
	 * @param mixed $num_no
	 * @param int $num_except (default: 0)
	 * @param string $str_key (default: "")
	 * @param string $str_status (default: "")
	 * @param int $num_groupId (default: 0)
	 * @return void
	 */
	function mdl_list($num_no, $num_except = 0, $str_key = "", $str_status = "", $num_groupId = 0) {

		$_arr_adminSelect = array(
			"admin_id",
			"admin_name",
			"admin_note",
			"admin_group_id",
			"admin_status",
		);

		$_str_sqlWhere = "admin_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND admin_note LIKE '%" . $str_key . "%'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND admin_status='" . $str_status . "'";
		}

		if ($num_groupId != 0) {
			$_str_sqlWhere .= " AND admin_group_id=" . $num_groupId;
		}

		$_arr_adminRows = $this->obj_db->select_array(BG_DB_TABLE . "admin", $_arr_adminSelect, $_str_sqlWhere . " ORDER BY admin_id DESC", $num_no, $num_except); //查询数据

		//print_r($_arr_adminRows);

		return $_arr_adminRows;

	}


	/**
	 * mdl_count function.
	 *
	 * @access public
	 * @param string $str_key (default: "")
	 * @param string $str_status (default: "")
	 * @param int $num_groupId (default: 0)
	 * @return void
	 */
	function mdl_count($str_key = "", $str_status = "", $num_groupId = 0) {
		$_str_sqlWhere = "admin_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND admin_note LIKE '%" . $str_key . "%'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND admin_status='" . $str_status . "'";
		}

		if ($num_groupId != 0) {
			$_str_sqlWhere .= " AND admin_group_id=" . $num_groupId;
		}

		$_num_count = $this->obj_db->count(BG_DB_TABLE . "admin", $_str_sqlWhere); //查询数据

		return $_num_count;
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @param mixed $arr_adminId
	 * @return void
	 */
	function mdl_del($arr_adminId) {

		$_str_adminId = implode(",", $arr_adminId);

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "admin", "admin_id IN (" . $_str_adminId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y020104";
		} else {
			$_str_alert = "x020104";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功

	}
}
?>