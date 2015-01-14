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


	function mdl_create() {
		$_arr_callCreat = array(
			"call_id"        => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"call_show"      => "varchar(300) NOT NULL COMMENT '显示选项'",
			"call_name"      => "varchar(300) NOT NULL COMMENT '调用名'",
			"call_type"      => "varchar(20) NOT NULL COMMENT '调用类型'",
			"call_cate_ids"  => "varchar(300) NOT NULL COMMENT '栏目ID'",
			"call_cate_id"   => "int(11) NOT NULL COMMENT '栏目ID'",
			"call_file"      => "varchar(10) NOT NULL COMMENT '静态文件类型'",
			"call_amount"    => "varchar(300) NOT NULL COMMENT '显示数选项'",
			"call_mark_ids"  => "varchar(300) NOT NULL COMMENT '标记ID'",
			"call_attach"    => "varchar(20) NOT NULL COMMENT '含有附件'",
			"call_hits"      => "varchar(20) NOT NULL COMMENT '排行类型'",
			"call_trim"      => "int(11) NOT NULL COMMENT '标题字数'",
			"call_status"    => "varchar(20) NOT NULL COMMENT '状态'",
			"call_css"       => "varchar(300) NOT NULL COMMENT 'CSS名'",
		);

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "call", $_arr_callCreat, "call_id", "调用");

		if ($_num_mysql > 0) {
			$_str_alert = "y170105"; //更新成功
		} else {
			$_str_alert = "x170105"; //更新成功
		}

		return array(
			"str_alert" => $_str_alert, //更新成功
		);
	}


	function mdl_column() {
		$_arr_colSelect = array(
			"column_name"
		);

		$_str_sqlWhere = "table_schema='" . BG_DB_NAME . "' AND table_name='" . BG_DB_TABLE . "call'";

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
	 * @param mixed $num_callId
	 * @param mixed $str_callName
	 * @param mixed $str_callType
	 * @param string $str_callShow (default: "")
	 * @param string $str_cateIds (default: "")
	 * @return void
	 */
	function mdl_submit() {

		$_arr_callData = array(
			"call_name"      => $this->callSubmit["call_name"],
			"call_type"      => $this->callSubmit["call_type"],
			"call_file"      => $this->callSubmit["call_file"],
			"call_status"    => $this->callSubmit["call_status"],
			"call_amount"    => $this->callSubmit["call_amount"],
			"call_trim"      => $this->callSubmit["call_trim"],
			"call_css"       => $this->callSubmit["call_css"],
			"call_cate_ids"  => $this->callSubmit["call_cate_ids"],
			"call_cate_id"   => $this->callSubmit["call_cate_id"],
			"call_attach"    => $this->callSubmit["call_attach"],
			"call_mark_ids"  => $this->callSubmit["call_mark_ids"],
			"call_show"      => $this->callSubmit["call_show"],
		);

		if ($this->callSubmit["call_id"] == 0) { //插入
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
			$_num_callId = $this->callSubmit["call_id"];
			$_num_mysql  = $this->obj_db->update(BG_DB_TABLE . "call", $_arr_callData, "call_id=" . $_num_callId);

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
			"str_alert"  => $_str_alert,
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
			"call_attach",
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

		if (isset($_arr_callRows[0])) {
			$_arr_callRow = $_arr_callRows[0];
		} else {
			return array(
				"str_alert" => "x170102", //不存在记录
			);
			exit;
		}

		if (isset($_arr_callRow["call_amount"])) {
			$_arr_callRow["call_amount"]      = json_decode($_arr_callRow["call_amount"], true); //json解码
		} else {
			$_arr_callRow["call_amount"]      = array();
		}

		if (isset($_arr_callRow["call_show"])) {
			$_arr_callRow["call_show"]        = json_decode($_arr_callRow["call_show"], true); //json解码
		} else {
			$_arr_callRow["call_show"]        = array();
		}

		if (isset($_arr_callRow["call_cate_ids"])) {
			$_arr_callRow["call_cate_ids"] = json_decode($_arr_callRow["call_cate_ids"], true); //json解码
		} else {
			$_arr_callRow["call_cate_ids"] = array();
		}

		if (isset($_arr_callRow["call_mark_ids"])) {
			$_arr_callRow["call_mark_ids"] = json_decode($_arr_callRow["call_mark_ids"], true); //json解码
		} else {
			$_arr_callRow["call_mark_ids"] = array();
		}

		$_arr_callRow["str_alert"]        = "y170102";

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
			"call_attach",
			"call_mark_ids",
			"call_show",
		);

		$_str_sqlWhere = "call_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND call_name LIKE '%" . $str_key . "%'";
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
			$_str_sqlWhere .= " AND call_name LIKE '%" . $str_key . "%'";
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
	 * @return void
	 */
	function mdl_del() {

		$_str_callId = implode(",", $this->callIds["call_ids"]);

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


	function input_submit() {
		if (!fn_token("chk")) { //令牌
			return array(
				"str_alert" => "x030102",
			);
			exit;
		}

		$this->callSubmit["call_id"] = fn_getSafe(fn_post("call_id"), "int", 0);

		if ($this->callSubmit["call_id"] > 0) {
			$_arr_callRow = $this->mdl_read($this->callSubmit["call_id"]);
			if ($_arr_callRow["str_alert"] != "y170102") {
				return $_arr_callRows;
				exit;
			}
		}

		$_arr_callName = validateStr(fn_post("call_name"), 1, 300);
		switch ($_arr_callName["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x170201",
				);
				exit;
			break;

			case "too_long":
				return array(
					"str_alert" => "x170202",
				);
				exit;
			break;

			case "ok":
				$this->callSubmit["call_name"] = $_arr_callName["str"];
			break;

		}

		$_arr_callType = validateStr(fn_post("call_type"), 1, 0);
		switch ($_arr_callType["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x170204",
				);
				exit;
			break;

			case "ok":
				$this->callSubmit["call_type"] = $_arr_callType["str"];
			break;
		}

		$_arr_callStatus = validateStr(fn_post("call_status"), 1, 0);
		switch ($_arr_callStatus["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x170206",
				);
				exit;
			break;

			case "ok":
				$this->callSubmit["call_status"] = $_arr_callStatus["str"];
			break;
		}

		$_arr_callTrim = validateStr(fn_post("call_trim"), 1, 0);
		switch ($_arr_callTrim["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x170211",
				);
				exit;
			break;

			case "format_err":
				return array(
					"str_alert" => "x170212",
				);
				exit;
			break;

			case "ok":
				$this->callSubmit["call_trim"] = $_arr_callTrim["str"];
			break;
		}

		$_arr_callCss = validateStr(fn_post("call_css"), 0, 300);
		switch ($_arr_callCss["status"]) {
			case "too_long":
				return array(
					"str_alert" => "x170214",
				);
				exit;
			break;

			case "ok":
				$this->callSubmit["call_css"] = $_arr_callCss["str"];
			break;
		}

		$this->callSubmit["call_file"]        = fn_getSafe(fn_post("call_file"), "txt", "");
		$this->callSubmit["call_attach"]      = fn_getSafe(fn_post("call_attach"), "txt", "");
		$this->callSubmit["call_cate_id"]     = fn_getSafe(fn_post("call_cate_id"), "int", 0);

		$this->callSubmit["call_cate_ids"]    = json_encode(fn_post("call_cate_ids"));
		$this->callSubmit["call_mark_ids"]    = json_encode(fn_post("call_mark_ids"));
		$this->callSubmit["call_show"]        = json_encode(fn_post("call_show"));
		$this->callSubmit["call_amount"]      = json_encode(fn_post("call_amount"));

		$this->callSubmit["str_alert"]        = "ok";

		return $this->callSubmit;
	}


	/**
	 * input_ids function.
	 *
	 * @access public
	 * @return void
	 */
	function input_ids() {
		if (!fn_token("chk")) { //令牌
			return array(
				"str_alert" => "x030102",
			);
			exit;
		}

		$_arr_callIds = fn_post("call_id");

		if ($_arr_callIds) {
			foreach ($_arr_callIds as $_key=>$_value) {
				$_arr_callIds[$_key] = fn_getSafe($_value, "int", 0);
			}
			$_str_alert = "ok";
		} else {
			$_str_alert = "none";
		}

		$this->callIds = array(
			"str_alert"  => $_str_alert,
			"call_ids"   => $_arr_callIds
		);

		return $this->callIds;
	}

}
?>