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
class MODEL_APP {
	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	/**
	 * mdl_token function.
	 *
	 * @access public
	 * @param mixed $num_appId
	 * @return void
	 */
	function mdl_token($num_appId) {
		$_arr_appData = array(
			"app_token"      => fn_rand(64),
			"app_token_time" => time(),
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "app", $_arr_appData, "app_id=" . $num_appId); //更新数据

		return $_arr_appData;
	}


	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $num_appId
	 * @param mixed $str_appName
	 * @param mixed $str_appNotice
	 * @param string $str_appNote (default: "")
	 * @param string $str_appStatus (default: "enable")
	 * @param string $str_appIpAllow (default: "")
	 * @return void
	 */
	function mdl_submit($num_appId, $str_appName, $str_appNotice, $str_appNote = "", $str_appStatus = "enable", $str_appIpAllow = "", $str_appIpBad = "", $str_appSync = "off", $str_appAllow = "") {
		$_arr_appData = array(
			"app_name"       => $str_appName,
			"app_notice"     => $str_appNotice,
			"app_note"       => $str_appNote,
			"app_status"     => $str_appStatus,
			"app_ip_allow"   => $str_appIpAllow,
			"app_ip_bad"     => $str_appIpBad,
			"app_sync"       => $str_appSync,
			"app_allow"      => $str_appAllow,
		);

		if ($num_appId == 0) {
			$_arr_insert = array(
				"app_key"           => fn_rand(64),
				"app_time"          => time(),
				"app_token"         => fn_rand(64),
				"app_token_time"    => time(),
				"app_token_expire"  => BG_DEFAULT_TOKEN,
			);
			$_arr_data = array_merge($_arr_appData, $_arr_insert);

			$_num_appId = $this->obj_db->insert(BG_DB_TABLE . "app", $_arr_data); //更新数据
			if ($_num_appId > 0) {
				$_str_alert = "y050101"; //更新成功
			} else {
				return array(
					"str_alert" => "x050101", //更新失败
				);
				exit;

			}
		} else {
			$_num_appId = $num_appId;
			$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "app", $_arr_appData, "app_id=" . $_num_appId); //更新数据
			if ($_num_mysql > 0) {
				$_str_alert = "y050103"; //更新成功
			} else {
				return array(
					"str_alert" => "x050103", //更新失败
				);
				exit;

			}
		}

		return array(
			"app_id" => $_num_appId,
			"str_alert" => $_str_alert, //成功
		);
	}


	/**
	 * mdl_status function.
	 *
	 * @access public
	 * @param mixed $arr_appId
	 * @param mixed $str_status
	 * @return void
	 */
	function mdl_status($arr_appId, $str_status) {
		$_str_appId = implode(",", $arr_appId);

		$_arr_appUpdate = array(
			"app_status" => $str_status,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "app", $_arr_appUpdate, "app_id IN (" . $_str_appId . ")"); //删除数据

		//如影响行数大于0则返回成功
		if ($_num_mysql > 0) {
			$_str_alert = "y050103"; //成功
		} else {
			$_str_alert = "x050103"; //失败
		}

		return array(
			"str_alert" => $_str_alert,
		);
	}


	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $str_app
	 * @param string $str_by (default: "app_id")
	 * @param int $num_notId (default: 0)
	 * @return void
	 */
	function mdl_read($str_app, $str_by = "app_id", $num_notId = 0) {
		$_arr_appSelect = array(
			"app_id",
			"app_name",
			"app_notice",
			"app_key",
			"app_note",
			"app_token",
			"app_token_expire",
			"app_token_time",
			"app_status",
			"app_time",
			"app_ip_allow",
			"app_ip_bad",
			"app_sync",
			"app_allow",
		);

		switch ($str_by) {
			case "app_id":
				$_str_sqlWhere = "app_id=" . $str_app;
			break;
			default:
				$_str_sqlWhere = $str_by . "='" . $str_app . "'";
			break;
		}

		if ($num_notId > 0) {
			$_str_sqlWhere .= " AND app_id<>" . $num_notId;
		}

		$_arr_appRows = $this->obj_db->select_array(BG_DB_TABLE . "app", $_arr_appSelect, $_str_sqlWhere, 1, 0); //检查本地表是否存在记录
		$_arr_appRow = $_arr_appRows[0];

		if (!$_arr_appRow) { //用户名不存在则返回错误
			return array(
				"str_alert" => "x050102", //不存在记录
			);
			exit;
		}

		$_arr_appRow["str_alert"] = "y050102";

		return $_arr_appRow;
	}


	/**
	 * mdl_list function.
	 *
	 * @access public
	 * @param mixed $num_appNo
	 * @param int $num_appExcept (default: 0)
	 * @param string $str_key (default: "")
	 * @param string $str_status (default: "")
	 * @return void
	 */
	function mdl_list($num_appNo, $num_appExcept = 0, $str_key = "", $str_status = "", $str_sync = "", $str_notice = false) {
		$_arr_appSelect = array(
			"app_id",
			"app_name",
			"app_notice",
			"app_note",
			"app_status",
			"app_time",
		);

		$_str_sqlWhere = "app_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND (app_name LIKE '%" . $str_key . "%' OR app_note LIKE '%" . $str_key . "%')";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND app_status='" . $str_status . "'";
		}

		if ($str_sync) {
			$_str_sqlWhere .= " AND app_sync='" . $str_sync . "'";
		}

		if ($str_notice) {
			$_str_sqlWhere .= " AND LENGTH(app_notice)>0";
		}

		$_arr_appRows = $this->obj_db->select_array(BG_DB_TABLE . "app", $_arr_appSelect, $_str_sqlWhere . " ORDER BY app_id DESC", $num_appNo, $num_appExcept); //查询数据

		return $_arr_appRows;
	}


	/*============删除管理员============
	@arr_appId 管理员 ID 数组

	返回提示信息
	*/
	function mdl_del($arr_appId) {
		$_str_appId = implode(",", $arr_appId);

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "app", "app_id IN (" . $_str_appId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y050104"; //成功
		} else {
			$_str_alert = "x050104"; //失败
		}

		return array(
			"str_alert" => $_str_alert,
		);
	}


	/*============统计管理员============
	返回数量
	*/
	function mdl_count($str_key = "", $str_status = "", $str_sync = "", $str_notice = false) {
		$_str_sqlWhere = "app_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND (app_name LIKE '%" . $str_key . "%' OR app_note LIKE '%" . $str_key . "%')";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND app_status='" . $str_status . "'";
		}

		if ($str_sync) {
			$_str_sqlWhere .= " AND app_sync='" . $str_sync . "'";
		}

		if ($str_notice) {
			$_str_sqlWhere .= " AND LENGTH(app_notice)>0";
		}

		$_num_appCount = $this->obj_db->count(BG_DB_TABLE . "app", $_str_sqlWhere); //查询数据

		return $_num_appCount;
	}
}
?>