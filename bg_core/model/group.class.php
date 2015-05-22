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


	function mdl_create_table() {
		$_arr_groupCreat = array(
			"group_id"       => "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"group_name"     => "varchar(30) NOT NULL COMMENT '组名'",
			"group_note"     => "varchar(30) NOT NULL COMMENT '备注'",
			"group_allow"    => "varchar(1000) NOT NULL COMMENT '权限'",
			"group_type"     => "enum('admin','admin') NOT NULL COMMENT '类型'",
			"group_status"   => "enum('enable','disable') NOT NULL COMMENT '状态'",
		);

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "group", $_arr_groupCreat, "group_id", "群组");

		if ($_num_mysql > 0) {
			$_str_alert = "y040105"; //更新成功
		} else {
			$_str_alert = "x040105"; //更新成功
		}

		return array(
			"str_alert" => $_str_alert, //更新成功
		);
	}


	function mdl_column() {
		$_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "group");

		foreach ($_arr_colRows as $_key=>$_value) {
			$_arr_col[] = $_value["Field"];
		}

		return $_arr_col;
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
	function mdl_submit() {

		$_arr_groupData = array(
			"group_name"     => $this->groupSubmit["group_name"],
			"group_type"     => $this->groupSubmit["group_type"],
			"group_note"     => $this->groupSubmit["group_note"],
			"group_allow"    => $this->groupSubmit["group_allow"],
			"group_status"   => $this->groupSubmit["group_status"],
		);

		if ($this->groupSubmit["group_id"] == 0) { //插入
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
			$_num_groupId    = $this->groupSubmit["group_id"];
			$_num_mysql      = $this->obj_db->update(BG_DB_TABLE . "group", $_arr_groupData, "group_id=" . $_num_groupId);

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
			"group_status",
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

		$_arr_groupRows = $this->obj_db->select(BG_DB_TABLE . "group",  $_arr_groupSelect, $_str_sqlWhere, "", "", 1, 0); //检查本地表是否存在记录

		if (isset($_arr_groupRows[0])) {
			$_arr_groupRow = $_arr_groupRows[0];
		} else {
			return array(
				"str_alert" => "x040102", //不存在记录
			);
			exit;
		}

		if (isset($_arr_groupRow["group_allow"])) {
			$_arr_groupRow["group_allow"] = fn_jsonDecode($_arr_groupRow["group_allow"], "no"); //json解码
		} else {
			$_arr_groupRow["group_allow"] = array();
		}

		$_arr_groupRow["str_alert"]   = "y040102";

		return $_arr_groupRow;
	}


	function mdl_status($str_status) {

		$_str_groupId = implode(",", $this->groupIds["group_ids"]);

		$_arr_groupUpdate = array(
			"group_status" => $str_status,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "group", $_arr_groupUpdate, "group_id IN (" . $_str_groupId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y040103";
		} else {
			$_str_alert = "x040103";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功

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

		$_arr_groupSelect = array(
			"group_id",
			"group_name",
			"group_note",
			"group_type",
			"group_status",
		);

		$_str_sqlWhere = "1=1";

		if ($str_key) {
			$_str_sqlWhere .= " AND group_name LIKE '%" . $str_key . "%' OR group_note LIKE '%" . $str_key . "%'";
		}

		if ($str_type) {
			$_str_sqlWhere .= " AND group_type='" . $str_type . "'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND group_status='" . $str_status . "'";
		}

		$_arr_groupRows = $this->obj_db->select(BG_DB_TABLE . "group",  $_arr_groupSelect, $_str_sqlWhere, "", "group_id DESC", $num_no, $num_except); //列出本地表是否存在记录

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
	function mdl_count($str_key = "", $str_type = "", $str_status = "") {
		$_str_sqlWhere = "1=1";

		if ($str_key) {
			$_str_sqlWhere .= " AND group_name LIKE '%" . $str_key . "%' OR group_note LIKE '%" . $str_key . "%'";
		}

		if ($str_type) {
			$_str_sqlWhere .= " AND group_type='" . $str_type . "'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND group_status='" . $str_status . "'";
		}

		$_num_count = $this->obj_db->count(BG_DB_TABLE . "group", $_str_sqlWhere); //查询数据

		return $_num_count;
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @param mixed $this->groupIds["group_ids"]
	 * @return void
	 */
	function mdl_del() {

		$_str_groupId = implode(",", $this->groupIds["group_ids"]);

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


	function input_submit() {
		if (!fn_token("chk")) { //令牌
			return array(
				"str_alert" => "x030102",
			);
			exit;
		}

		$this->groupSubmit["group_id"] = fn_getSafe(fn_post("group_id"), "int", 0);

		if ($this->groupSubmit["group_id"]) {
			$_arr_groupRow = $this->mdl_read($this->groupSubmit["group_id"]);
			if ($_arr_groupRow["str_alert"] != "y040102") {
				$this->obj_ajax->halt_alert($_arr_groupRow["str_alert"]);
			}
		}

		$_arr_groupName = validateStr(fn_post("group_name"), 1, 30);
		switch ($_arr_groupName["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x040201",
				);
				exit;
			break;

			case "too_long":
				return array(
					"str_alert" => "x040202",
				);
				exit;
			break;

			case "ok":
				$this->groupSubmit["group_name"] = $_arr_groupName["str"];
			break;

		}

		$_arr_groupNote = validateStr(fn_post("group_note"), 0, 30);
		switch ($_arr_groupNote["status"]) {
			case "too_long":
				return array(
					"str_alert" => "x040204",
				);
				exit;
			break;

			case "ok":
				$this->groupSubmit["group_note"] = $_arr_groupNote["str"];
			break;
		}

		$_arr_groupType = validateStr(fn_post("group_type"), 1, 0);
		switch ($_arr_groupType["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x040205",
				);
				exit;
			break;

			case "ok":
				$this->groupSubmit["group_type"] = $_arr_groupType["str"];
			break;
		}

		$_arr_groupStatus = validateStr(fn_post("group_status"), 1, 0);
		switch ($_arr_groupStatus["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x040207",
				);
				exit;
			break;

			case "ok":
				$this->groupSubmit["group_status"] = $_arr_groupStatus["str"];
			break;
		}

		$this->groupSubmit["group_allow"] = fn_jsonEncode(fn_post("group_allow"), "no");
		$this->groupSubmit["str_alert"]   = "ok";

		return $this->groupSubmit;
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

		$_arr_groupIds = fn_post("group_id");

		if ($_arr_groupIds) {
			foreach ($_arr_groupIds as $_key=>$_value) {
				$_arr_groupIds[$_key] = fn_getSafe($_value, "int", 0);
			}
			$_str_alert = "ok";
		} else {
			$_str_alert = "none";
		}

		$this->groupIds = array(
			"str_alert"   => $_str_alert,
			"group_ids"   => $_arr_groupIds
		);

		return $this->groupIds;
	}

}
