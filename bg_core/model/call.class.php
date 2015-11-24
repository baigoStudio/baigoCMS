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


	function mdl_create_table() {
		$_arr_callCreat = array(
			"call_id"            => "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"call_name"          => "varchar(300) NOT NULL COMMENT '调用名'",
			"call_type"          => "enum('article','hits_day','hits_week','hits_month','hits_year','hits_all','spec','cate','tag_list','tag_rank') NOT NULL COMMENT '调用类型'",
			"call_cate_ids"      => "varchar(300) NOT NULL COMMENT '栏目ID'",
			"call_cate_excepts"  => "varchar(300) NOT NULL COMMENT '排除栏目'",
			"call_cate_id"       => "smallint NOT NULL COMMENT '栏目ID'",
			"call_spec_id"       => "mediumint NOT NULL COMMENT '专题ID'",
			"call_mark_ids"      => "varchar(300) NOT NULL COMMENT '标记ID'",
			"call_file"          => "enum('html','js','xml','json') NOT NULL COMMENT '静态文件类型'",
			"call_amount"        => "varchar(300) NOT NULL COMMENT '显示数选项'",
			"call_attach"        => "enum('all','attach','none') NOT NULL COMMENT '含有附件'",
			"call_status"        => "enum('enable','disable') NOT NULL COMMENT '状态'",
		);

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "call", $_arr_callCreat, "call_id", "调用");

		if ($_num_mysql > 0) {
			$_str_alert = "y170105"; //更新成功
		} else {
			$_str_alert = "x170105"; //更新成功
		}

		return array(
			"alert" => $_str_alert, //更新成功
		);
	}


	function mdl_column() {
		$_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "call");

		foreach ($_arr_colRows as $_key=>$_value) {
			$_arr_col[] = $_value["Field"];
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
			"call_name"          => $this->callSubmit["call_name"],
			"call_type"          => $this->callSubmit["call_type"],
			"call_file"          => $this->callSubmit["call_file"],
			"call_status"        => $this->callSubmit["call_status"],
			"call_amount"        => $this->callSubmit["call_amount"],
			"call_cate_ids"      => $this->callSubmit["call_cate_ids"],
			"call_cate_excepts"  => $this->callSubmit["call_cate_excepts"],
			"call_cate_id"       => $this->callSubmit["call_cate_id"],
			"call_mark_ids"      => $this->callSubmit["call_mark_ids"],
			"call_spec_id"       => $this->callSubmit["call_spec_id"],
			"call_attach"        => $this->callSubmit["call_attach"],
		);

		if ($this->callSubmit["call_id"] == 0) { //插入
			$_num_callId = $this->obj_db->insert(BG_DB_TABLE . "call", $_arr_callData);

			if ($_num_callId > 0) { //数据库插入是否成功
				$_str_alert = "y170101";
			} else {
				return array(
					"alert" => "x170101",
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
					"alert" => "x170103",
				);
				exit;
			}
		}

		return array(
			"call_id"    => $_num_callId,
			"alert"  => $_str_alert,
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
			"call_cate_ids",
			"call_cate_excepts",
			"call_cate_id",
			"call_spec_id",
			"call_mark_ids",
			"call_attach",
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

		$_arr_callRows = $this->obj_db->select(BG_DB_TABLE . "call",  $_arr_callSelect, $_str_sqlWhere, "", "", 1, 0); //检查本地表是否存在记录

		if (isset($_arr_callRows[0])) {
			$_arr_callRow = $_arr_callRows[0];
		} else {
			return array(
				"alert" => "x170102", //不存在记录
			);
			exit;
		}

		if (isset($_arr_callRow["call_amount"])) {
			$_arr_callRow["call_amount"]      = fn_jsonDecode($_arr_callRow["call_amount"], "no"); //json解码
		} else {
			$_arr_callRow["call_amount"]      = array();
		}

		if (isset($_arr_callRow["call_cate_ids"])) {
			$_arr_callRow["call_cate_ids"] = fn_jsonDecode($_arr_callRow["call_cate_ids"], "no"); //json解码
		} else {
			$_arr_callRow["call_cate_ids"] = array();
		}

		if (isset($_arr_callRow["call_cate_excepts"])) {
			$_arr_callRow["call_cate_excepts"] = fn_jsonDecode($_arr_callRow["call_cate_excepts"], "no"); //json解码
		} else {
			$_arr_callRow["call_cate_excepts"] = array();
		}

		if (isset($_arr_callRow["call_mark_ids"])) {
			$_arr_callRow["call_mark_ids"] = fn_jsonDecode($_arr_callRow["call_mark_ids"], "no"); //json解码
		} else {
			$_arr_callRow["call_mark_ids"] = array();
		}

		$_arr_callRow["alert"]        = "y170102";

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
			"call_cate_ids",
			"call_cate_excepts",
			"call_cate_id",
			"call_spec_id",
			"call_mark_ids",
			"call_attach",
		);

		$_str_sqlWhere = "1=1";

		if ($str_key) {
			$_str_sqlWhere .= " AND call_name LIKE '%" . $str_key . "%'";
		}

		if ($str_type) {
			$_str_sqlWhere .= " AND call_type='" . $str_type . "'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND call_status='" . $str_status . "'";
		}

		$_arr_callRows = $this->obj_db->select(BG_DB_TABLE . "call",  $_arr_callSelect, $_str_sqlWhere, "", "call_id DESC", $num_no, $num_except); //列出本地表是否存在记录

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
		$_str_sqlWhere = "1=1";

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
	 * mdl_status function.
	 *
	 * @access public
	 * @param mixed $this->callIds["call_ids"]
	 * @param mixed $str_status
	 * @return void
	 */
	function mdl_status($str_status) {
		$_str_callId = implode(",", $this->callIds["call_ids"]);

		$_arr_callData = array(
			"call_status" => $str_status,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "call", $_arr_callData, "call_id IN (" . $_str_callId . ")"); //更新数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y170103";
		} else {
			$_str_alert = "x170103";
		}

		return array(
			"alert" => $_str_alert,
		); //成功
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
			"alert" => $_str_alert,
		);
		exit;
	}

	function mdl_alert_table() {
        $_arr_col   = $this->mdl_column();
        $_arr_alert = array();

		if (in_array("call_upfile", $_arr_col)) {
			$_arr_alert["call_upfile"] = array("CHANGE", "enum('all','attach','none') NOT NULL COMMENT '含有附件'", "call_attach");
		}

		if (in_array("call_attach", $_arr_col)) {
			$_arr_alert["call_attach"] = array("CHANGE", "enum('all','attach','none') NOT NULL COMMENT '含有附件'", "call_attach");
		}

		if (!in_array("call_spec_id", $_arr_col)) {
			$_arr_alert["call_spec_id"] = array("ADD", "mediumint NOT NULL COMMENT '专题ID'");
		}

		if (!in_array("call_cate_excepts", $_arr_col)) {
			$_arr_alert["call_cate_excepts"] = array("ADD", "varchar(300) NOT NULL COMMENT '排除栏目'");
		}

		if (in_array("call_type", $_arr_col)) {
			$_arr_alert["call_type"] = array("CHANGE", "enum('article','hits_day','hits_week','hits_month','hits_year','hits_all','spec','cate','tag_list','tag_rank') NOT NULL COMMENT '调用类型'", "call_type");
		}

		if (in_array("call_cate_id", $_arr_col)) {
			$_arr_alert["call_cate_id"] = array("CHANGE", "smallint NOT NULL COMMENT '栏目ID'", "call_cate_id");
		}

		if (in_array("call_file", $_arr_col)) {
			$_arr_alert["call_file"] = array("CHANGE", "enum('html','js','xml','json') NOT NULL COMMENT '静态文件类型'", "call_file");
		}

		if (in_array("call_status", $_arr_col)) {
			$_arr_alert["call_status"] = array("CHANGE", "enum('enable','disable') NOT NULL COMMENT '状态'", "call_status");
		}

		$_str_alert = "x170106";

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "call", $_arr_alert);

    		if ($_reselt) {
        		$_str_alert = "y170106";
    		}
		}

		return array(
    		"alert" => $_str_alert,
		);
    }


	function input_submit() {
		if (!fn_token("chk")) { //令牌
			return array(
				"alert" => "x030102",
			);
			exit;
		}

		$this->callSubmit["call_id"] = fn_getSafe(fn_post("call_id"), "int", 0);

		if ($this->callSubmit["call_id"] > 0) {
			$_arr_callRow = $this->mdl_read($this->callSubmit["call_id"]);
			if ($_arr_callRow["alert"] != "y170102") {
				return $_arr_callRows;
				exit;
			}
		}

		$_arr_callName = validateStr(fn_post("call_name"), 1, 300);
		switch ($_arr_callName["status"]) {
			case "too_short":
				return array(
					"alert" => "x170201",
				);
				exit;
			break;

			case "too_long":
				return array(
					"alert" => "x170202",
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
					"alert" => "x170204",
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
					"alert" => "x170206",
				);
				exit;
			break;

			case "ok":
				$this->callSubmit["call_status"] = $_arr_callStatus["str"];
			break;
		}

		$this->callSubmit["call_file"]            = fn_getSafe(fn_post("call_file"), "txt", "");
		$this->callSubmit["call_attach"]          = fn_getSafe(fn_post("call_attach"), "txt", "");
		$this->callSubmit["call_cate_id"]         = fn_getSafe(fn_post("call_cate_id"), "int", 0);
		$this->callSubmit["call_spec_id"]         = fn_getSafe(fn_post("call_spec_id"), "int", 0);

		$this->callSubmit["call_cate_ids"]        = fn_jsonEncode(fn_post("call_cate_ids"), "no");
		$this->callSubmit["call_cate_excepts"]    = fn_jsonEncode(fn_post("call_cate_excepts"), "no");
		$this->callSubmit["call_mark_ids"]        = fn_jsonEncode(fn_post("call_mark_ids"), "no");
		$this->callSubmit["call_amount"]          = fn_jsonEncode(fn_post("call_amount"), "no");

		$this->callSubmit["alert"]                = "ok";

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
				"alert" => "x030102",
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
			"alert"  => $_str_alert,
			"call_ids"   => $_arr_callIds
		);

		return $this->callIds;
	}

}
