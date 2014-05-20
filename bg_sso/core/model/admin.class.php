<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------管理员模型-------------*/
class MODEL_ADMIN {
	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	/**
	 * mdl_loginSubmit function.
	 *
	 * @access public
	 * @param mixed $num_adminId
	 * @param mixed $str_adminPass
	 * @param mixed $str_adminRand
	 * @return void
	 */
	function mdl_loginSubmit($num_adminId, $str_adminPass, $str_adminRand) {
		$_arr_adminData = array(
			"admin_pass"         => $str_adminPass,
			"admin_rand"         => $str_adminRand,
			"admin_time_login"   => time(),
			"admin_ip"           => fn_getIp(true),
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
			"admin_id" => $_num_adminId,
			"str_alert" => $_str_alert, //成功
		);
	}


	/**
	 * mdl_my function.
	 *
	 * @access public
	 * @param mixed $num_adminId
	 * @param string $str_adminPass (default: "")
	 * @param string $str_adminRand (default: "")
	 * @param string $str_adminNote (default: "")
	 * @return void
	 */
	function mdl_my($num_adminId, $str_adminPass = "", $str_adminNote = "") {
		$_arr_adminData = array(
			"admin_note" => $str_adminNote,
		);

		if ($str_adminPass) {
			$_arr_adminData["admin_pass"] = $str_adminPass; //如果密码为空，则不修改
		}
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

		return array(
			"admin_id" => $_num_adminId,
			"str_alert" => $_str_alert, //成功
		);
	}


	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $num_adminId
	 * @param mixed $str_adminName
	 * @param mixed $str_adminPass
	 * @param mixed $str_adminRand (default: fn_rand(6))
	 * @param string $str_adminNote (default: "")
	 * @param string $str_adminStatus (default: "enable")
	 * @param string $str_adminAllow (default: "")
	 * @return void
	 */
	function mdl_submit($num_adminId, $str_adminName, $str_adminPass = "", $str_adminRand = "", $str_adminNote = "", $str_adminStatus = "enable", $str_adminAllow = "") {
		$_arr_adminData = array(
			"admin_name"     => $str_adminName,
			"admin_note"     => $str_adminNote,
			"admin_status"   => $str_adminStatus,
			"admin_allow"    => $str_adminAllow,
		);

		if ($num_adminId == 0) {
			$_arr_insert = array(
				"admin_pass"        => $str_adminPass,
				"admin_rand"        => $str_adminRand,
				"admin_time"        => time(),
				"admin_time_login"  => time(),
				"admin_ip"          => fn_getIp(),
			);
			$_arr_data = array_merge($_arr_adminData, $_arr_insert);

			$_num_adminId = $this->obj_db->insert(BG_DB_TABLE . "admin", $_arr_data); //更新数据
			if ($_num_adminId > 0) {
				$_str_alert = "y020101"; //更新成功
			} else {
				return array(
					"str_alert" => "x020101", //更新失败
				);
				exit;

			}
		} else {
			if ($str_adminPass) {
				$_arr_adminData["admin_pass"] = $str_adminPass; //如果密码为空，则不修改
			}
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
			"admin_id" => $_num_adminId,
			"str_alert" => $_str_alert, //成功
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
	function mdl_status($arr_adminId, $str_status) {
		$_str_adminId = implode(",", $arr_adminId);

		$_arr_adminUpdate = array(
			"admin_status" => $str_status,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "admin", $_arr_adminUpdate, "admin_id IN (" . $_str_adminId . ")"); //删除数据

		//如影响行数大于0则返回成功
		if ($_num_mysql > 0) {
			$_str_alert = "y020103"; //成功
		} else {
			$_str_alert = "x020103"; //失败
		}

		return array(
			"str_alert" => $_str_alert,
		);
	}


	function mdl_loginChk($str_admin, $str_by = "admin_id") {
		$_arr_adminSelect = array(
			"admin_id",
			"admin_name",
			"admin_pass",
			"admin_rand",
			"admin_status",
			"admin_time",
		);

		switch ($str_by) {
			case "admin_id":
				$_str_sqlWhere = "admin_id=" . $str_admin;
			break;
			default:
				$_str_sqlWhere = $str_by . "='" . $str_admin . "'";
			break;
		}

		$_arr_adminRows = $this->obj_db->select_array(BG_DB_TABLE . "admin", $_arr_adminSelect, $_str_sqlWhere, 1, 0); //检查本地表是否存在记录
		$_arr_adminRow = $_arr_adminRows[0];

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
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $str_admin
	 * @param string $str_by (default: "admin_id")
	 * @param int $num_notId (default: 0)
	 * @return void
	 */
	function mdl_read($str_admin, $str_by = "admin_id", $num_notId = 0) {
		$_arr_adminSelect = array(
			"admin_id",
			"admin_name",
			"admin_note",
			"admin_rand",
			"admin_time",
			"admin_time_login",
			"admin_ip",
			"admin_allow",
			"admin_status",
		);

		switch ($str_by) {
			case "admin_id":
				$_str_sqlWhere = "admin_id=" . $str_admin;
			break;
			default:
				$_str_sqlWhere = $str_by . "='" . $str_admin . "'";
			break;
		}

		if ($num_notId > 0) {
			$_str_sqlWhere .= " AND admin_id<>" . $num_notId;
		}

		$_arr_adminRows = $this->obj_db->select_array(BG_DB_TABLE . "admin", $_arr_adminSelect, $_str_sqlWhere, 1, 0); //检查本地表是否存在记录
		$_arr_adminRow = $_arr_adminRows[0];

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
	 * @param mixed $num_adminNo
	 * @param int $num_adminExcept (default: 0)
	 * @param string $str_key (default: "")
	 * @param string $str_status (default: "")
	 * @return void
	 */
	function mdl_list($num_adminNo, $num_adminExcept = 0, $str_key = "", $str_status = "") {
		$_arr_adminSelect = array(
			"admin_id",
			"admin_name",
			"admin_note",
			"admin_status",
			"admin_time",
			"admin_time_login",
			"admin_ip",
		);

		$_str_sqlWhere = "admin_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND (admin_name LIKE '%" . $str_key . "%' OR admin_note LIKE '%" . $str_key . "%')";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND admin_status='" . $str_status . "'";
		}

		$_arr_adminRows = $this->obj_db->select_array(BG_DB_TABLE . "admin", $_arr_adminSelect, $_str_sqlWhere . " ORDER BY admin_id DESC", $num_adminNo, $num_adminExcept); //查询数据

		return $_arr_adminRows;
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
			$_str_alert = "y020104"; //成功
		} else {
			$_str_alert = "x020104"; //失败
		}

		return array(
			"str_alert" => $_str_alert,
		);
	}


	/**
	 * mdl_count function.
	 *
	 * @access public
	 * @param string $str_key (default: "")
	 * @param string $str_status (default: "")
	 * @return void
	 */
	function mdl_count($str_key = "", $str_status = "") {
		$_str_sqlWhere = "admin_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND (admin_name LIKE '%" . $str_key . "%' OR admin_note LIKE '%" . $str_key . "%')";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND admin_status='" . $str_status . "'";
		}

		$_num_adminCount = $this->obj_db->count(BG_DB_TABLE . "admin", $_str_sqlWhere); //查询数据

		return $_num_adminCount;
	}
}
?>