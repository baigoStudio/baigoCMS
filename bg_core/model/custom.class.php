<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------自定义表单-------------*/
class MODEL_CUSTOM {

	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	/**
	 * mdl_create_table function.
	 *
	 * @access public
	 * @return void
	 */
	function mdl_create_table() {
		$_arr_customCreat = array(
			"custom_id"      => "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"custom_name"    => "varchar(90) NOT NULL COMMENT '名称'",
			"custom_type"    => "enum('article','cate') NOT NULL COMMENT '类型'",
			"custom_status"  => "enum('enable','disable') NOT NULL COMMENT '状态'",
		);

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "custom", $_arr_customCreat, "custom_id", "自定义表单");

		if ($_num_mysql > 0) {
			$_str_alert = "y200105"; //更新成功
		} else {
			$_str_alert = "x200105"; //更新成功
		}

		return array(
			"str_alert" => $_str_alert, //更新成功
		);
	}


	/**
	 * mdl_column function.
	 *
	 * @access public
	 * @return void
	 */
	function mdl_column() {
		$_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "custom");

		foreach ($_arr_colRows as $_key=>$_value) {
			$_arr_col[] = $_value["Field"];
		}

		return $_arr_col;
	}


	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $num_customId
	 * @param mixed $str_customName
	 * @param mixed $str_customType
	 * @param mixed $str_customStatus
	 * @return void
	 */
	function mdl_submit() {

		$_arr_customData = array(
			"custom_name"    => $this->customSubmit["custom_name"],
			"custom_type"    => $this->customSubmit["custom_type"],
			"custom_status"  => $this->customSubmit["custom_status"],
		);

		if ($this->customSubmit["custom_id"] == 0) {

			$_num_customId = $this->obj_db->insert(BG_DB_TABLE . "custom", $_arr_customData);

			if ($_num_customId > 0) { //数据库插入是否成功
				$_str_alert = "y200101";
			} else {
				return array(
					"str_alert" => "x200101",
				);
				exit;
			}

		} else {
			$_num_customId = $this->customSubmit["custom_id"];
			$_num_mysql  = $this->obj_db->update(BG_DB_TABLE . "custom", $_arr_customData, "custom_id=" . $_num_customId);

			if ($_num_mysql > 0) {
				$_str_alert = "y200103";
			} else {
				return array(
					"str_alert" => "x200103",
				);
				exit;
			}
		}

		return array(
			"custom_id"    => $_num_customId,
			"str_alert"  => $_str_alert,
		);
	}


	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $str_custom
	 * @param string $str_readBy (default: "custom_id")
	 * @param int $num_notThisId (default: 0)
	 * @param int $num_parentId (default: 0)
	 * @return void
	 */
	function mdl_read($str_custom, $str_readBy = "custom_id", $num_notId = 0, $str_type = "") {
		$_arr_customSelect = array(
			"custom_id",
			"custom_name",
			"custom_type",
			"custom_status",
		);

		switch ($str_readBy) {
			case "custom_id":
				$_str_sqlWhere = $str_readBy . "=" . $str_custom;
			break;
			default:
				$_str_sqlWhere = $str_readBy . "='" . $str_custom . "'";
			break;
		}

		if ($num_notId > 0) {
			$_str_sqlWhere .= " AND custom_id<>" . $num_notId;
		}

		if ($str_type) {
			$_str_sqlWhere .= " AND custom_type='" . $str_type . "'";
		}

		$_arr_customRows = $this->obj_db->select(BG_DB_TABLE . "custom",  $_arr_customSelect, $_str_sqlWhere, "", "", 1, 0); //检查本地表是否存在记录

		if (isset($_arr_customRows[0])) {
			$_arr_customRow = $_arr_customRows[0];
		} else {
			return array(
				"str_alert" => "x200102", //不存在记录
			);
			exit;
		}

		$_arr_customRow["str_alert"] = "y200102";

		return $_arr_customRow;
	}


	/**
	 * mdl_list function.
	 *
	 * @access public
	 * @param string $str_status (default: "")
	 * @param string $str_type (default: "")
	 * @param int $num_parentId (default: 0)
	 * @return void
	 */
	function mdl_list($num_no, $num_except = 0, $str_key = "", $str_type = "", $str_status = "") {
		$_arr_customSelect = array(
			"custom_id",
			"custom_name",
			"custom_type",
			"custom_status",
		);

		$_str_sqlWhere = "1=1";

		if ($str_key) {
			$_str_sqlWhere .= " AND custom_name LIKE '%" . $str_key . "%'";
		}

		if ($str_type) {
			$_str_sqlWhere .= " AND custom_type='" . $str_type . "'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND custom_status='" . $str_status . "'";
		}

		$_arr_customRows = $this->obj_db->select(BG_DB_TABLE . "custom",  $_arr_customSelect, $_str_sqlWhere, "", "custom_id DESC", $num_no, $num_except);

		return $_arr_customRows;
	}


	/**
	 * mdl_count function.
	 *
	 * @access public
	 * @param string $str_key (default: "")
	 * @param string $str_type (default: "")
	 * @return void
	 */
	function mdl_count($str_key = "", $str_type = "", $str_status = "") {

		$_str_sqlWhere = "1=1";

		if ($str_key) {
			$_str_sqlWhere .= " AND custom_name LIKE '%" . $str_key . "%'";
		}

		if ($str_type) {
			$_str_sqlWhere .= " AND custom_type='" . $str_type . "'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND custom_status='" . $str_status . "'";
		}

		$_num_customCount = $this->obj_db->count(BG_DB_TABLE . "custom", $_str_sqlWhere); //查询数据

		/*print_r($_arr_userRow);
		exit;*/

		return $_num_customCount;
	}



	function mdl_status($str_status) {
		$_str_customId = implode(",", $this->customIds["custom_ids"]);

		$_arr_customData = array(
			"custom_status" => $str_status,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "custom", $_arr_customData, "custom_id IN (" . $_str_customId . ")"); //更新数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y200103";
		} else {
			$_str_alert = "x200103";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @param mixed $this->customIds["custom_ids"]
	 * @return void
	 */
	function mdl_del() {
		$_str_customIds = implode(",", $this->customIds["custom_ids"]);

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "custom",  "custom_id IN (" . $_str_customIds . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y200104";
		} else {
			$_str_alert = "x200104";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	function input_submit() {
		if (!fn_token("chk")) { //令牌
			return array(
				"str_alert" => "x030102",
			);
			exit;
		}

		$this->customSubmit["custom_id"] = fn_getSafe(fn_post("custom_id"), "int", 0);

		if ($this->customSubmit["custom_id"] > 0) {
			$_arr_customRow = $this->mdl_read($this->customSubmit["custom_id"]);
			if ($_arr_customRow["str_alert"] != "y200102") {
				return $_arr_customRow;
				exit;
			}
		}

		$_arr_customName = validateStr(fn_post("custom_name"), 1, 30);
		switch ($_arr_customName["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x200201",
				);
				exit;
			break;

			case "too_long":
				return array(
					"str_alert" => "x200202",
				);
				exit;
			break;

			case "ok":
				$this->customSubmit["custom_name"] = $_arr_customName["str"];
			break;
		}

		$_arr_customType = validateStr(fn_post("custom_type"), 1, 0);
		switch ($_arr_customType["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x200205",
				);
				exit;
			break;

			case "ok":
				$this->customSubmit["custom_type"] = $_arr_customType["str"];
			break;
		}

		$_arr_customRow = $this->mdl_read($this->customSubmit["custom_name"], "custom_name", $this->customSubmit["custom_id"], $this->customSubmit["custom_type"]);
		if ($_arr_customRow["str_alert"] == "y200102") {
			return array(
				"str_alert" => "x200203",
			);
			exit;
		}

		$_arr_customStatus = validateStr(fn_post("custom_status"), 1, 0);
		switch ($_arr_customStatus["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x200206",
				);
				exit;
			break;

			case "ok":
				$this->customSubmit["custom_status"] = $_arr_customStatus["str"];
			break;
		}

		$this->customSubmit["str_alert"] = "ok";

		return $this->customSubmit;
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

		$_arr_customIds = fn_post("custom_id");

		if ($_arr_customIds) {
			foreach ($_arr_customIds as $_key=>$_value) {
				$_arr_customIds[$_key] = fn_getSafe($_value, "int", 0);
			}
			$_str_alert = "ok";
		} else {
			$_str_alert = "none";
		}

		$this->customIds = array(
			"str_alert"  => $_str_alert,
			"custom_ids" => $_arr_customIds,
		);

		return $this->customIds;
	}
}
