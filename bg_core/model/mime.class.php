<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------上传类-------------*/
class MODEL_MIME {

	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	function mdl_create_table() {
		$_arr_mimeCreat = array(
			"mime_id"    => "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"mime_name"  => "varchar(300) NOT NULL COMMENT 'MIME'",
			"mime_note"  => "varchar(300) NOT NULL COMMENT '备注'",
			"mime_ext"   => "char(4) NOT NULL COMMENT '扩展名'",
		);

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "mime", $_arr_mimeCreat, "mime_id", "MIME");

		if ($_num_mysql > 0) {
			$_str_alert = "y080105"; //更新成功
		} else {
			$_str_alert = "x080105"; //更新成功
		}

		return array(
			"alert" => $_str_alert, //更新成功
		);
	}


	function mdl_column() {
		$_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "mime");

		foreach ($_arr_colRows as $_key=>$_value) {
			$_arr_col[] = $_value["Field"];
		}

		return $_arr_col;
	}


	/*============提交允许类型============
	@str_mimeName 允许类型

	返回多维数组
		num_mimeId ID
		str_alert 提示
	*/
	function mdl_submit() {
		$_arr_mimeData = array(
			"mime_name"  => $this->mimeSubmit["mime_name"],
			"mime_ext"   => $this->mimeSubmit["mime_ext"],
			"mime_note"  => $this->mimeSubmit["mime_note"],
		);

		if ($this->mimeSubmit["mime_id"] == 0) {
			$_num_mimeId = $this->obj_db->insert(BG_DB_TABLE . "mime", $_arr_mimeData);

			if ($_num_mimeId > 0) { //数据库插入是否成功
				$_str_alert = "y080101";
			} else {
				return array(
					"alert" => "x080101",
				);
				exit;
			}
		} else {
			$_num_mimeId = $this->mimeSubmit["mime_id"];
			$_num_mysql  = $this->obj_db->update(BG_DB_TABLE . "mime", $_arr_mimeData, "mime_id=" . $_num_mimeId);

			if ($_num_mysql > 0) { //数据库插入是否成功
				$_str_alert = "y080103";
			} else {
				return array(
					"alert" => "x080103",
				);
				exit;
			}
		}

		return array(
			"alert" => $_str_alert,
			"mime_id" => $_num_mimeId,
		);
	}

	/*============允许类型检查============
	@str_mimeName 允许类型

	返回提示
	*/
	function mdl_read($str_mime, $str_readBy = "mime_id", $num_notId = 0) {
		$_arr_mimeSelect = array(
			"mime_id",
			"mime_name",
			"mime_ext",
			"mime_note",
		);

		switch ($str_readBy) {
			case "mime_id":
				$_str_sqlWhere = $str_readBy . "=" . $str_mime;
			break;
			default:
				$_str_sqlWhere = $str_readBy . "='" . $str_mime . "'";
			break;
		}

		if ($num_notId > 0) {
			$_str_sqlWhere .= " AND mime_id<>" . $num_notId;
		}

		$_arr_mimeRows = $this->obj_db->select(BG_DB_TABLE . "mime",  $_arr_mimeSelect, $_str_sqlWhere, "", "", 1, 0); //查询数据

		if (isset($_arr_mimeRows[0])) {
			$_arr_mimeRow = $_arr_mimeRows[0];
		} else {
			return array(
				"alert" => "x080102", //不存在记录
			);
			exit;
		}

		$_arr_mimeRow["alert"] = "y080102";

		return $_arr_mimeRow;
	}

	/*============列出允许类型============
	返回多维数组
		mime_id 允许类型 ID
		mime_name 允许类型宽度
	*/
	function mdl_list($num_no, $num_except = 0) {
		$_arr_mimeSelect = array(
			"mime_id",
			"mime_name",
			"mime_ext",
			"mime_note",
		);

		$_arr_mimeRows = $this->obj_db->select(BG_DB_TABLE . "mime",  $_arr_mimeSelect, "", "", "mime_id DESC", $num_no, $num_except); //查询数据

		return $_arr_mimeRows;
	}

	function mdl_count() {
		$_num_count = $this->obj_db->count(BG_DB_TABLE . "mime"); //查询数据
		return $_num_count;
	}


	/*============删除允许类型============
	@arr_mimeId 允许类型 ID 数组

	返回提示信息
	*/
	function mdl_del() {
		$_str_mimeId = implode(",", $this->mimeIds["mime_ids"]);

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "mime", "mime_id IN (" . $_str_mimeId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y080104";
		} else {
			$_str_alert = "x080104";
		}

		return array(
			"alert" => $_str_alert
		);
	}


	function input_submit() {
		if (!fn_token("chk")) { //令牌
			return array(
				"alert" => "x030102",
			);
			exit;
		}

		$this->mimeSubmit["mime_id"] = fn_getSafe(fn_post("mime_id"), "int", 0);

		if ($this->mimeSubmit["mime_id"] > 0) {
			$_arr_mimeRow = $this->mdl_read($this->mimeSubmit["mime_id"]);
			if ($_arr_mimeRow["alert"] != "y080102") {
				return $_arr_mimeRow;
				exit;
			}
		}

		$_arr_mimeName = validateStr(fn_post("mime_name"), 1, 300);
		switch ($_arr_mimeName["status"]) {
			case "too_short":
				return array(
					"alert" => "x080201",
				);
				exit;
			break;

			case "too_long":
				return array(
					"alert" => "x080202",
				);
				exit;
			break;

			case "ok":
				$this->mimeSubmit["mime_name"] = $_arr_mimeName["str"];
			break;
		}

		$_arr_mimeRow = $this->mdl_read($this->mimeSubmit["mime_name"], "mime_name", $this->mimeSubmit["mime_id"]);
		if ($_arr_mimeRow["alert"] == "y080102") {
			return array(
				"alert" => "x080206",
			);
			exit;
		}

		$_arr_mimeExt = validateStr(fn_post("mime_ext"), 1, 10);
		switch ($_arr_mimeExt["status"]) {
			case "too_short":
				return array(
					"alert" => "x080203",
				);
				exit;
			break;

			case "too_long":
				return array(
					"alert" => "x080204",
				);
				exit;
			break;

			case "ok":
				$this->mimeSubmit["mime_ext"] = $_arr_mimeExt["str"];
			break;

		}

		$_arr_mimeNote = validateStr(fn_post("mime_note"), 0, 300);
		switch ($_arr_mimeNote["status"]) {
			case "too_long":
				return array(
					"alert" => "x080205",
				);
				exit;
			break;

			case "ok":
				$this->mimeSubmit["mime_note"] = $_arr_mimeNote["str"];
			break;

		}

		$this->mimeSubmit["alert"] = "ok";
		return $this->mimeSubmit;
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

		$_arr_mimeIds = fn_post("mime_id");

		if ($_arr_mimeIds) {
			foreach ($_arr_mimeIds as $_key=>$_value) {
				$_arr_mimeIds[$_key] = fn_getSafe($_value, "int", 0);
			}
			$_str_alert = "ok";
		} else {
			$_str_alert = "none";
		}

		$this->mimeIds = array(
			"alert"  => $_str_alert,
			"mime_ids"   => $_arr_mimeIds
		);

		return $this->mimeIds;
	}

}
