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
class MODEL_LOG {
	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $num_logId
	 * @param mixed $str_targetNote
	 * @param mixed $str_logTitle
	 * @param string $str_logResult (default: "")
	 * @param string $str_logStatus (default: "enable")
	 * @param string $str_logType (default: "")
	 * @return void
	 */
	function mdl_submit($str_targets, $str_targetType, $str_logTitle, $str_logResult, $str_logType, $num_operatorId = 0, $str_logStatus = "wait", $str_logLevel = "normal") {
		$_arr_logData = array(
			"log_operator_id"    => $num_operatorId,
			"log_targets"        => $str_targets,
			"log_target_type"    => $str_targetType,
			"log_title"          => $str_logTitle,
			"log_result"         => $str_logResult,
			"log_type"           => $str_logType,
			"log_status"         => $str_logStatus,
			"log_level"          => $str_logLevel,
			"log_time"           => time(),
		);

		$_num_logId = $this->obj_db->insert(BG_DB_TABLE . "log", $_arr_logData); //更新数据
		if ($_num_logId > 0) {
			$_str_alert = "y060101"; //更新成功
		} else {
			return array(
				"str_alert" => "x060101", //更新失败
			);
			exit;

		}

		return array(
			"log_id" => $_num_logId,
			"str_alert" => $_str_alert, //成功
		);
	}


	/**
	 * mdl_status function.
	 *
	 * @access public
	 * @param mixed $arr_logId
	 * @param mixed $str_status
	 * @return void
	 */
	function mdl_status($arr_logId, $str_status) {
		$_str_logId = implode(",", $arr_logId);

		$_arr_logUpdate = array(
			"log_status" => $str_status,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "log", $_arr_logUpdate, "log_id IN (" . $_str_logId . ")"); //删除数据

		//如影响行数大于0则返回成功
		if ($_num_mysql > 0) {
			$_str_alert = "y060103"; //成功
		} else {
			$_str_alert = "x060103"; //失败
		}

		return array(
			"str_alert" => $_str_alert,
		);
	}


	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $str_log
	 * @param string $str_by (default: "log_id")
	 * @param int $num_notId (default: 0)
	 * @return void
	 */
	function mdl_read($num_logId) {
		$_arr_logSelect = array(
			"log_id",
			"log_time",
			"log_operator_id",
			"log_targets",
			"log_target_type",
			"log_title",
			"log_result",
			"log_type",
			"log_status",
			"log_level",
		);

		$_str_sqlWhere = "log_id=" . $num_logId;

		$_arr_logRows = $this->obj_db->select_array(BG_DB_TABLE . "log", $_arr_logSelect, $_str_sqlWhere, 1, 0); //检查本地表是否存在记录
		$_arr_logRow = $_arr_logRows[0];

		if (!$_arr_logRow) { //用户名不存在则返回错误
			return array(
				"str_alert" => "x060102", //不存在记录
			);
			exit;
		}

		$_arr_logRow["str_alert"] = "y060102";

		return $_arr_logRow;
	}


	/**
	 * mdl_list function.
	 *
	 * @access public
	 * @param mixed $num_no
	 * @param int $num_except (default: 0)
	 * @param string $str_key (default: "")
	 * @param string $str_status (default: "")
	 * @return void
	 */
	function mdl_list($num_no, $num_except = 0, $str_key = "", $str_type = "", $str_status = "", $str_level = "", $num_operatorId = 0) {
		$_arr_logSelect = array(
			"log_id",
			"log_time",
			"log_target_type",
			"log_title",
			"log_type",
			"log_status",
			"log_operator_id",
		);

		$_str_sqlWhere = "log_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND (log_title LIKE '%" . $str_key . "%')";
		}

		if ($str_type) {
			$_str_sqlWhere .= " AND log_type='" . $str_type . "'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND log_status='" . $str_status . "'";
		}

		if ($str_level) {
			$_str_sqlWhere .= " AND log_level='" . $str_level . "'";
		}

		if ($num_operatorId > 0) {
			$_str_sqlWhere .= " AND log_operator_id=" . $num_operatorId;
		}

		$_arr_logRows = $this->obj_db->select_array(BG_DB_TABLE . "log", $_arr_logSelect, $_str_sqlWhere . " ORDER BY log_id DESC", $num_no, $num_except); //查询数据

		return $_arr_logRows;
	}


	/*============删除管理员============
	@arr_logId 管理员 ID 数组

	返回提示信息
	*/
	function mdl_del($arr_logId) {
		$_str_logId = implode(",", $arr_logId);

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "log", "log_id IN (" . $_str_logId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y060104"; //成功
		} else {
			$_str_alert = "x060104"; //失败
		}

		return array(
			"str_alert" => $_str_alert,
		);
	}


	/*============统计管理员============
	返回数量
	*/
	function mdl_count($str_key = "", $str_type = "", $str_status = "", $str_level = "", $num_operatorId = 0) {
		$_str_sqlWhere = "log_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND (log_target_type LIKE '%" . $str_key . "%' OR log_result LIKE '%" . $str_key . "%')";
		}

		if ($str_type) {
			$_str_sqlWhere .= " AND log_type='" . $str_type . "'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND log_status='" . $str_status . "'";
		}

		if ($str_level) {
			$_str_sqlWhere .= " AND log_level='" . $str_level . "'";
		}

		if ($num_operatorId > 0) {
			$_str_sqlWhere .= " AND log_operator_id=" . $num_operatorId;
		}

		$_num_logCount = $this->obj_db->count(BG_DB_TABLE . "log", $_str_sqlWhere); //查询数据

		return $_num_logCount;
	}
}
?>