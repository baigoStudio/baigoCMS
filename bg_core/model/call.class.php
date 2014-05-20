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
class MODEL_CALL {

	public $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $num_callId
	 * @param mixed $str_callName
	 * @param mixed $str_callType
	 * @param string $str_callShow (default: "")
	 * @param string $str_cateIds (default: "")
	 * @return void
	 */
	function mdl_submit($num_callId, $str_callName, $str_callType, $str_callFile, $str_callStatus, $str_callAmount, $num_callTrim, $str_callCss, $str_cateIds = "", $num_cateId = 0, $str_callUpfile = "", $str_markIds = "", $str_callShow = "") {

		$_arr_callData = array(
			"call_name"      => $str_callName,
			"call_type"      => $str_callType,
			"call_file"      => $str_callFile,
			"call_status"    => $str_callStatus,
			"call_amount"    => $str_callAmount,
			"call_trim"      => $num_callTrim,
			"call_css"       => $str_callCss,
			"call_cate_ids"  => $str_cateIds,
			"call_cate_id"   => $num_cateId,
			"call_upfile"    => $str_callUpfile,
			"call_mark_ids"  => $str_markIds,
			"call_show"      => $str_callShow,
		);

		if ($num_callId == 0) { //插入
			$_num_callId = $this->obj_db->insert(BG_DB_TABLE . "call", $_arr_callData);

			if ($_num_callId > 0) { //数据库插入是否成功
				$_str_alert = "y170101";
			} else {
				return array(
					"str_alert" => "x170101",
				);
				exit;
			}
		} else {
			$_num_callId = $num_callId;
			$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "call", $_arr_callData, "call_id=" . $_num_callId);

			if ($_num_mysql > 0) { //数据库更新是否成功
				$_str_alert = "y170103";
			} else {
				return array(
					"str_alert" => "x170103",
				);
				exit;
			}
		}

		return array(
			"call_id"    => $_num_callId,
			"str_alert"      => $_str_alert,
		);

	}


	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $str_call
	 * @param string $str_readBy (default: "call_id")
	 * @param int $num_notId (default: 0)
	 * @return void
	 */
	function mdl_read($str_call, $str_readBy = "call_id", $num_notId = 0) {

		$_arr_callSelect = array(
			"call_id",
			"call_name",
			"call_type",
			"call_file",
			"call_status",
			"call_amount",
			"call_trim",
			"call_css",
			"call_cate_ids",
			"call_cate_id",
			"call_upfile",
			"call_mark_ids",
			"call_show",
		);

		switch ($str_readBy) {
			case "call_id":
				$_str_sqlWhere = $str_readBy . "=" . $str_call;
			break;
			default:
				$_str_sqlWhere = $str_readBy . "='" . $str_call . "'";
			break;
		}

		if ($num_notId > 0) {
			$_str_sqlWhere .= " AND call_id<>" . $num_notId;
		}

		$_arr_callRows = $this->obj_db->select_array(BG_DB_TABLE . "call",  $_arr_callSelect, $_str_sqlWhere, 1, 0); //检查本地表是否存在记录
		$_arr_callRow = $_arr_callRows[0];

		if (!$_arr_callRow) {
			return array(
				"str_alert" => "x170102", //不存在记录
			);
			exit;
		}

		$_arr_callRow["str_alert"] = "y170102";

		return $_arr_callRow;
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
	function mdl_list($num_no, $num_except = 0, $str_key = "", $str_type = "", $str_status = "") {

		$_arr_callSelect = array(
			"call_id",
			"call_name",
			"call_type",
			"call_file",
			"call_status",
			"call_amount",
			"call_trim",
			"call_css",
			"call_cate_ids",
			"call_cate_id",
			"call_upfile",
			"call_mark_ids",
			"call_show",
		);

		$_str_sqlWhere = "call_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND call_name LIKE '%" . $str_key . "%' OR call_show LIKE '%" . $str_key . "%'";
		}

		if ($str_type) {
			$_str_sqlWhere .= " AND call_type='" . $str_type . "'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND call_status='" . $str_status . "'";
		}

		$_arr_callRows = $this->obj_db->select_array(BG_DB_TABLE . "call",  $_arr_callSelect, $_str_sqlWhere . " ORDER BY call_id DESC", $num_no, $num_except); //列出本地表是否存在记录

		return $_arr_callRows;

	}


	/**
	 * mdl_count function.
	 *
	 * @access public
	 * @param string $str_key (default: "")
	 * @param string $str_status (default: "")
	 * @return void
	 */
	function mdl_count($str_key = "", $str_type = "", $str_status = "") {
		$_str_sqlWhere = "call_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND call_name LIKE '%" . $str_key . "%' OR call_show LIKE '%" . $str_key . "%'";
		}

		if ($str_type) {
			$_str_sqlWhere .= " AND call_type='" . $str_type . "'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND call_status='" . $str_status . "'";
		}

		$_num_count = $this->obj_db->count(BG_DB_TABLE . "call", $_str_sqlWhere); //查询数据

		return $_num_count;
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @param mixed $arr_callId
	 * @return void
	 */
	function mdl_del($arr_callId) {

		$_str_callId = implode(",", $arr_callId);

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "call",  "call_id IN (" . $_str_callId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y170104";
		} else {
			$_str_alert = "x170104";
		}

		return array(
			"str_alert" => $_str_alert,
		);
		exit;
	}
}
?>