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
class MODEL_SPEC {

	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}



	function mdl_create_table() {
		$_arr_specCreat = array(
			"spec_id"        => "mediumint NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"spec_name"      => "varchar(300) NOT NULL COMMENT '专题名称'",
			"spec_status"    => "enum('show','hide') NOT NULL COMMENT '状态'",
			"spec_content"   => "varchar(3000) NOT NULL COMMENT '专题内容'",
		);

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "spec", $_arr_specCreat, "spec_id", "专题");

		if ($_num_mysql > 0) {
			$_str_alert = "y180105"; //更新成功
		} else {
			$_str_alert = "x180105"; //更新成功
		}

		return array(
			"str_alert" => $_str_alert, //更新成功
		);
	}


	function mdl_column() {
		$_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "spec");

		foreach ($_arr_colRows as $_key=>$_value) {
			$_arr_col[] = $_value["Field"];
		}

		return $_arr_col;
	}


	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $num_specId
	 * @param mixed $str_specName
	 * @param mixed $str_specType
	 * @param mixed $str_specStatus
	 * @return void
	 */
	function mdl_submit() {

		$_arr_specData = array(
			"spec_name"      => $this->specSubmit["spec_name"],
			"spec_status"    => $this->specSubmit["spec_status"],
			"spec_content"   => $this->specSubmit["spec_content"],
		);

		if ($this->specSubmit["spec_id"] == 0) {

			$_num_specId = $this->obj_db->insert(BG_DB_TABLE . "spec", $_arr_specData);

			if ($_num_specId > 0) { //数据库插入是否成功
				$_str_alert = "y180101";
			} else {
				return array(
					"str_alert" => "x180101",
				);
				exit;
			}

		} else {
			$_num_specId = $this->specSubmit["spec_id"];
			$_num_mysql  = $this->obj_db->update(BG_DB_TABLE . "spec", $_arr_specData, "spec_id=" . $_num_specId);

			if ($_num_mysql > 0) {
				$_str_alert = "y180103";
			} else {
				return array(
					"str_alert" => "x180103",
				);
				exit;
			}
		}

		return array(
			"spec_id"    => $_num_specId,
			"str_alert"  => $_str_alert,
		);
	}


	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $str_spec
	 * @param string $str_readBy (default: "spec_id")
	 * @param int $num_notThisId (default: 0)
	 * @param int $num_parentId (default: 0)
	 * @return void
	 */
	function mdl_read($str_spec, $str_readBy = "spec_id", $num_notId = 0) {
		$_arr_specSelect = array(
			"spec_id",
			"spec_name",
			"spec_status",
			"spec_content",
		);

		switch ($str_readBy) {
			case "spec_id":
				$_str_sqlWhere = $str_readBy . "=" . $str_spec;
			break;
			default:
				$_str_sqlWhere = $str_readBy . "='" . $str_spec . "'";
			break;
		}

		if ($num_notId > 0) {
			$_str_sqlWhere .= " AND spec_id<>" . $num_notId;
		}

		$_arr_specRows = $this->obj_db->select_array(BG_DB_TABLE . "spec",  $_arr_specSelect, $_str_sqlWhere, 1, 0); //检查本地表是否存在记录

		if (isset($_arr_specRows[0])) {
			$_arr_specRow = $_arr_specRows[0];
		} else {
			return array(
				"str_alert" => "x180102", //不存在记录
			);
			exit;
		}

		$_arr_specRow["urlRow"]       = $this->url_process($_arr_specRow);
		$_arr_specRow["str_alert"]    = "y180102";

		return $_arr_specRow;
	}


	function mdl_status($str_status) {

		$_str_specId = implode(",", $this->specIds["spec_ids"]);

		$_arr_specUpdate = array(
			"spec_status" => $str_status,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "spec", $_arr_specUpdate, "spec_id IN (" . $_str_specId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y180103";
		} else {
			$_str_alert = "x180103";
		}

		return array(
			"str_alert" => $_str_alert,
		);
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
	function mdl_list($num_no, $num_except = 0, $str_key = "", $str_status = "") {
		$_arr_specSelect = array(
			"spec_id",
			"spec_name",
			"spec_status",
		);

		$_str_sqlWhere = "1=1";

		if ($str_key) {
			$_str_sqlWhere .= " AND spec_name LIKE '%" . $str_key . "%'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND spec_status='" . $str_status . "'";
		}

		$_arr_specRows = $this->obj_db->select_array(BG_DB_TABLE . "spec",  $_arr_specSelect, $_str_sqlWhere . " ORDER BY spec_id DESC", $num_no, $num_except);

		foreach ($_arr_specRows as $_key=>$_value) {
			$_arr_specRows[$_key]["urlRow"] = $this->url_process($_value);
		}

		return $_arr_specRows;
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @param mixed $this->specIds["spec_ids"]
	 * @return void
	 */
	function mdl_del() {
		$_str_specIds = implode(",", $this->specIds["spec_ids"]);

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "spec",  "spec_id IN (" . $_str_specIds . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y180104";
		} else {
			$_str_alert = "x180104";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	function mdl_count($str_key = "", $str_status = "") {

		$_str_sqlWhere = "1=1";

		if ($str_key) {
			$_str_sqlWhere .= " AND spec_name LIKE '%" . $str_key . "%'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND spec_status='" . $str_status . "'";
		}

		$_num_specCount = $this->obj_db->count(BG_DB_TABLE . "spec", $_str_sqlWhere); //查询数据

		/*print_r($_arr_userRow);
		exit;*/

		return $_num_specCount;
	}


	function input_submit() {
		if (!fn_token("chk")) { //令牌
			return array(
				"str_alert" => "x030102",
			);
			exit;
		}

		$this->specSubmit["spec_id"] = fn_getSafe(fn_post("spec_id"), "int", 0);

		if ($this->specSubmit["spec_id"] > 0) {
			$_arr_specRow = $this->mdl_read($this->specSubmit["spec_id"]);
			if ($_arr_specRow["str_alert"] != "y180102") {
				return $_arr_specRow;
				exit;
			}
		}

		$_arr_specName = validateStr(fn_post("spec_name"), 1, 300);
		switch ($_arr_specName["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x180201",
				);
				exit;
			break;

			case "too_long":
				return array(
					"str_alert" => "x180202",
				);
				exit;
			break;

			case "ok":
				$this->specSubmit["spec_name"] = $_arr_specName["str"];
			break;
		}

		$_arr_specStatus = validateStr(fn_post("spec_status"), 1, 0);
		switch ($_arr_specStatus["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x180201",
				);
				exit;
			break;

			case "ok":
				$this->specSubmit["spec_status"] = $_arr_specStatus["str"];
			break;
		}

		$_arr_specContent = validateStr(fn_post("spec_content"), 0, 3000);
		switch ($_arr_specContent["status"]) {
			case "too_long":
				return array(
					"str_alert" => "x180202",
				);
				exit;
			break;

			case "ok":
				$this->specSubmit["spec_content"] = $_arr_specContent["str"];
			break;
		}

		$this->specSubmit["str_alert"] = "ok";

		return $this->specSubmit;
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

		$_arr_specIds = fn_post("spec_id");

		if ($_arr_specIds) {
			foreach ($_arr_specIds as $_key=>$_value) {
				$_arr_specIds[$_key] = fn_getSafe($_value, "int", 0);
			}
			$_str_alert = "ok";
		} else {
			$_str_alert = "none";
		}

		$this->specIds = array(
			"str_alert"   => $_str_alert,
			"spec_ids"    => $_arr_specIds
		);

		return $this->specIds;
	}


	private function url_process($_arr_specRow) {
		switch (BG_VISIT_TYPE) {
			case "static":
				$_str_specUrl       = BG_URL_ROOT . "spec/" . $_arr_specRow["spec_id"] . "/";
				$_str_pageAttach    = "page_";
			break;

			case "pstatic":
				$_str_specUrl       = BG_URL_ROOT . "spec/" . $_arr_specRow["spec_id"] . "/";
				$_str_pageAttach    = "";
			break;

			default:
				$_str_specUrl       = BG_URL_ROOT . "index.php?mod=spec&act_get=list&spec_id=" . $_arr_specRow["spec_id"];
				$_str_pageAttach    = "&page=";
			break;
		}

		return array(
			"spec_url"       => $_str_specUrl,
			"page_attach"    => $_str_pageAttach,
		);
	}
}
