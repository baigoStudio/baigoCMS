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
class MODEL_USER {
	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	/**
	 * mdl_loginSubmit function.
	 *
	 * @access public
	 * @param mixed $num_userId
	 * @param mixed $str_userPass
	 * @param mixed $str_userRand
	 * @return void
	 */
	function mdl_loginSubmit($num_userId, $str_userPass, $str_userRand) {
		$_arr_userData = array(
			"user_pass"         => $str_userPass,
			"user_rand"         => $str_userRand,
			"user_time_login"   => time(),
			"user_ip"           => fn_getIp(true),
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "user", $_arr_userData, "user_id=" . $num_userId); //更新数据
		if ($_num_mysql > 0) {
			$_str_alert = "y010103"; //更新成功
		} else {
			return array(
				"str_alert" => "x010103", //更新失败
			);
			exit;

		}

		return array(
			"user_id"    => $_num_userId,
			"str_alert"  => $_str_alert, //成功
		);
	}


	/**
	 * mdl_my function.
	 *
	 * @access public
	 * @param mixed $num_userId
	 * @param string $str_userPass (default: "")
	 * @param string $str_userRand (default: "")
	 * @param string $str_userNick (default: "")
	 * @return void
	 */
	function mdl_my($num_userId, $str_userMail = "", $str_userPass = "", $str_userRand = "", $str_userNick = "") {
		if ($str_userMail) {
			$_arr_userData["user_mail"] = $str_userMail; //如果密码为空，则不修改
		}
		if ($str_userPass) {
			$_arr_userData["user_pass"] = $str_userPass; //如果密码为空，则不修改
		}
		if ($str_userRand) {
			$_arr_userData["user_rand"] = $str_userRand; //如果密码为空，则不修改
		}
		if ($str_userNick) {
			$_arr_userData["user_nick"] = $str_userNick; //如果密码为空，则不修改
		}
		$_num_userId  = $num_userId;
		$_num_mysql   = $this->obj_db->update(BG_DB_TABLE . "user", $_arr_userData, "user_id=" . $_num_userId); //更新数据
		if ($_num_mysql > 0) {
			$_str_alert = "y010103"; //更新成功
		} else {
			return array(
				"str_alert" => "x010103", //更新失败
			);
			exit;

		}

		return array(
			"user_id"    => $_num_userId,
			"str_alert"  => $_str_alert, //成功
		);
	}


	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $num_userId
	 * @param mixed $str_userName
	 * @param mixed $str_userPass
	 * @param mixed $str_userRand (default: fn_rand(6))
	 * @param string $str_userNick (default: "")
	 * @param string $str_userStatus (default: "enable")
	 * @param string $str_userAllow (default: "")
	 * @return void
	 */
	function mdl_submit($num_userId, $str_userName, $str_userMail = "", $str_userPass = "", $str_userRand = "", $str_userNick = "", $str_userNote = "", $str_userStatus = "enable") {
		$_arr_userData = array(
			"user_name"     => $str_userName,
			"user_mail"     => $str_userMail,
			"user_nick"     => $str_userNick,
			"user_note"     => $str_userNote,
			"user_status"   => $str_userStatus,
		);

		if ($num_userId == 0) {
			$_arr_insert = array(
				"user_pass"         => $str_userPass,
				"user_rand"         => $str_userRand,
				"user_time"         => time(),
				"user_time_login"   => time(),
				"user_ip"           => fn_getIp(),
			);
			$_arr_data   = array_merge($_arr_userData, $_arr_insert);
			$_num_userId = $this->obj_db->insert(BG_DB_TABLE . "user", $_arr_data); //更新数据
			if ($_num_userId > 0) {
				$_str_alert = "y010101"; //更新成功
			} else {
				return array(
					"str_alert" => "x010101", //更新失败
				);
				exit;

			}
		} else {
			if ($str_userPass) {
				$_arr_userData["user_pass"] = $str_userPass; //如果密码为空，则不修改
			}
			if ($str_userRand) {
				$_arr_userData["user_rand"] = $str_userRand; //如果密码为空，则不修改
			}
			$_num_userId = $num_userId;
			$_num_mysql  = $this->obj_db->update(BG_DB_TABLE . "user", $_arr_userData, "user_id=" . $_num_userId); //更新数据
			if ($_num_mysql > 0) {
				$_str_alert = "y010103"; //更新成功
			} else {
				return array(
					"str_alert" => "x010103", //更新失败
				);
				exit;

			}
		}

		return array(
			"user_id"    => $_num_userId,
			"str_alert"  => $_str_alert, //成功
		);
	}


	/**
	 * mdl_status function.
	 *
	 * @access public
	 * @param mixed $arr_userId
	 * @param mixed $str_status
	 * @return void
	 */
	function mdl_status($arr_userId, $str_status) {
		$_str_userId = implode(",", $arr_userId);

		$_arr_userUpdate = array(
			"user_status" => $str_status,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "user", $_arr_userUpdate, "user_id IN (" . $_str_userId . ")"); //删除数据

		//如影响行数大于0则返回成功
		if ($_num_mysql > 0) {
			$_str_alert = "y010103"; //成功
		} else {
			$_str_alert = "x010103"; //失败
		}

		return array(
			"str_alert" => $_str_alert,
		);
	}


	function mdl_loginChk($str_user, $str_by = "user_id") {
		$_arr_userSelect = array(
			"user_id",
			"user_name",
			"user_pass",
			"user_rand",
			"user_status",
		);

		switch ($str_by) {
			case "user_id":
				$_str_sqlWhere = "user_id=" . $str_user;
			break;
			default:
				$_str_sqlWhere = $str_by . "='" . $str_user . "'";
			break;
		}

		$_arr_userRows    = $this->obj_db->select_array(BG_DB_TABLE . "user", $_arr_userSelect, $_str_sqlWhere, 1, 0); //检查本地表是否存在记录
		$_arr_userRow     = $_arr_userRows[0];

		if (!$_arr_userRow) { //用户名不存在则返回错误
			return array(
				"str_alert" => "x010102", //不存在记录
			);
			exit;
		}

		$_arr_userRow["str_alert"] = "y010102";

		return $_arr_userRow;

	}

	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $str_user
	 * @param string $str_by (default: "user_id")
	 * @param int $num_notId (default: 0)
	 * @return void
	 */
	function mdl_read($str_user, $str_by = "user_id", $num_notId = 0) {
		$_arr_userSelect = array(
			"user_id",
			"user_name",
			"user_mail",
			"user_nick",
			"user_note",
			"user_rand",
			"user_status",
			"user_time",
			"user_time_login",
			"user_ip",
		);

		switch ($str_by) {
			case "user_id":
				$_str_sqlWhere = "user_id=" . $str_user;
			break;
			default:
				$_str_sqlWhere = $str_by . "='" . $str_user . "'";
			break;
		}

		if ($num_notId > 0) {
			$_str_sqlWhere .= " AND user_id<>" . $num_notId;
		}

		$_arr_userRows    = $this->obj_db->select_array(BG_DB_TABLE . "user", $_arr_userSelect, $_str_sqlWhere, 1, 0); //检查本地表是否存在记录
		$_arr_userRow     = $_arr_userRows[0];

		if (!$_arr_userRow) { //用户名不存在则返回错误
			return array(
				"str_alert" => "x010102", //不存在记录
			);
			exit;
		}

		$_arr_userRow["str_alert"] = "y010102";

		return $_arr_userRow;

	}


	/**
	 * mdl_list function.
	 *
	 * @access public
	 * @param mixed $num_userNo
	 * @param int $num_userExcept (default: 0)
	 * @param string $str_key (default: "")
	 * @param string $str_status (default: "")
	 * @return void
	 */
	function mdl_list($num_userNo, $num_userExcept = 0, $str_key = "", $str_status = "") {
		$_arr_userSelect = array(
			"user_id",
			"user_name",
			"user_mail",
			"user_nick",
			"user_note",
			"user_status",
			"user_time",
			"user_time_login",
			"user_ip",
		);

		$_str_sqlWhere = "user_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND (user_name LIKE '%" . $str_key . "%' OR user_nick LIKE '%" . $str_key . "%' OR user_note LIKE '%" . $str_key . "%')";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND user_status='" . $str_status . "'";
		}

		$_arr_userRows = $this->obj_db->select_array(BG_DB_TABLE . "user", $_arr_userSelect, $_str_sqlWhere . " ORDER BY user_id DESC", $num_userNo, $num_userExcept); //查询数据

		return $_arr_userRows;
	}


	/*============删除管理员============
	@arr_userId 管理员 ID 数组

	返回提示信息
	*/
	function mdl_del($arr_userId) {
		$_str_userId = implode(",", $arr_userId);

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "user", "user_id IN (" . $_str_userId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y010104"; //成功
		} else {
			$_str_alert = "x010104"; //失败
		}

		return array(
			"str_alert" => $_str_alert,
		);
	}


	/*============统计管理员============
	返回数量
	*/
	function mdl_count($str_key = "", $str_status = "") {
		$_str_sqlWhere = "user_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND (user_name LIKE '%" . $str_key . "%' OR user_nick LIKE '%" . $str_key . "%' OR user_note LIKE '%" . $str_key . "%')";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND user_status='" . $str_status . "'";
		}

		$_num_userCount = $this->obj_db->count(BG_DB_TABLE . "user", $_str_sqlWhere); //查询数据

		return $_num_userCount;
	}
}
?>