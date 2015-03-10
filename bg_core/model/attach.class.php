<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

if(!defined("BG_UPLOAD_URL")) {
	define("BG_UPLOAD_URL", "");
}

/*-------------上传类-------------*/
class MODEL_ATTACH {

	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	function mdl_create_table() {
		$_arr_attachCreat = array(
			"attach_id"          => "int NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"attach_ext"         => "char(4) NOT NULL COMMENT '扩展名'",
			"attach_time"        => "int NOT NULL COMMENT '时间'",
			"attach_size"        => "mediumint NOT NULL COMMENT '大小'",
			"attach_name"        => "varchar(1000) NOT NULL COMMENT '原始文件名'",
			"attach_admin_id"    => "smallint NOT NULL COMMENT '上传用户 ID'",
		);

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "attach", $_arr_attachCreat, "attach_id", "附件");

		if ($_num_mysql > 0) {
			$_str_alert = "y070105"; //更新成功
		} else {
			$_str_alert = "x070105"; //更新成功
		}

		return array(
			"str_alert" => $_str_alert, //更新成功
		);
	}


	function mdl_column() {
		$_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "attach");

		foreach ($_arr_colRows as $_key=>$_value) {
			$_arr_col[] = $_value["Field"];
		}

		return $_arr_col;
	}


	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $str_attachName
	 * @param mixed $str_attachExt
	 * @param int $num_attachSize (default: 0)
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_submit($str_attachName, $str_attachExt, $num_attachSize = 0, $num_adminId = 0) {

		$_tm_time = time();

		$_arr_attachInsert = array(
			"attach_name"        => $str_attachName,
			"attach_ext"         => $str_attachExt,
			"attach_time"        => $_tm_time,
			"attach_size"        => $num_attachSize,
			"attach_admin_id"    => $num_adminId,
		);

		$_num_attachId = $this->obj_db->insert(BG_DB_TABLE . "attach", $_arr_attachInsert);

		if ($_num_attachId > 0) { //数据库插入是否成功
			$_str_alert = "y070101";
		} else {
			return array(
				"str_alert" => "x070101",
			);
			exit;
		}

		return array(
			"attach_id"      => $_num_attachId,
			"attach_time"    => $_tm_time,
			"str_alert"      => $_str_alert,
		);
	}


	/**
	 * mdl_listArr function.
	 *
	 * @access public
	 * @param mixed $this->attachIds["attach_ids"]
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_listArr($num_adminId = 0) {
		$_str_attachId = implode(",", $this->attachIds["attach_ids"]);

		$_arr_attachSelect = array(
			"attach_id",
			"attach_time",
			"attach_ext",
		);

		$_str_sqlWhere = "attach_id IN (" . $_str_attachId . ")";

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND attach_admin_id=" . $num_adminId;
		}

		$_arr_attachRows = $this->obj_db->select_array(BG_DB_TABLE . "attach", $_arr_attachSelect, $_str_sqlWhere . " ORDER BY attach_id DESC", 1000, 0);

		return $_arr_attachRows;
	}


	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $num_attachId
	 * @return void
	 */
	function mdl_read($num_attachId) {
		$_arr_attachSelect = array(
			"attach_id",
			"attach_name",
			"attach_time",
			"attach_ext",
			"attach_size",
		);

		$_arr_attachRows  = $this->obj_db->select_array(BG_DB_TABLE . "attach", $_arr_attachSelect, "attach_id=" . $num_attachId, 1, 0); //检查本地表是否存在记录

		if (isset($_arr_attachRows[0])) {
			$_arr_attachRow   = $_arr_attachRows[0];
		} else {
			return array(
				"str_alert" => "x070102", //不存在记录
			);
			exit;
		}

		$_arr_attachRow["str_alert"] = "y070102";

		return $_arr_attachRow;
	}


	/**
	 * mdl_list function.
	 *
	 * @access public
	 * @param mixed $num_no
	 * @param int $num_except (default: 0)
	 * @param string $str_year (default: "")
	 * @param string $str_month (default: "")
	 * @param string $str_ext (default: "")
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_list($num_no, $num_except = 0, $str_year = "", $str_month = "", $str_ext = "", $num_adminId = 0) {
		$_arr_attachSelect = array(
			"attach_id",
			"attach_name",
			"attach_time",
			"attach_ext",
			"attach_size",
			"attach_admin_id",
		);

		$_str_sqlWhere = "1=1";

		if ($str_year) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(attach_time, '%Y')='" . $str_year . "'";
		}

		if ($str_month) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(attach_time, '%m')='" . $str_month . "'";
		}

		if ($str_ext) {
			$_str_sqlWhere .= " AND attach_ext='" . $str_ext . "'";
		}

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND attach_admin_id=" . $num_adminId;
		}

		$_arr_attachRows = $this->obj_db->select_array(BG_DB_TABLE . "attach", $_arr_attachSelect, $_str_sqlWhere . " ORDER BY attach_id DESC", $num_no, $num_except);

		return $_arr_attachRows;
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @param mixed $this->attachIds["attach_ids"]
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_del($num_adminId = 0) {

		$_str_attachId = implode(",", $this->attachIds["attach_ids"]);
		$_str_sqlWhere = "attach_id IN (" . $_str_attachId . ")";

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND attach_admin_id=" . $num_adminId;
		}

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "attach", $_str_sqlWhere); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y070104";
		} else {
			$_str_alert = "x070104";
		}

		return array(
			"str_alert" => $_str_alert
		); //成功
	}


	/**
	 * mdl_count function.
	 *
	 * @access public
	 * @param string $str_year (default: "")
	 * @param string $str_month (default: "")
	 * @param string $str_ext (default: "")
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_count($str_year = "", $str_month = "", $str_ext = "", $num_adminId = 0) {
		$_str_sqlWhere = "1=1";

		if ($str_year) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(attach_time, '%Y')='" . $str_year . "'";
		}

		if ($str_month) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(attach_time, '%m')='" . $str_month . "'";
		}

		if ($str_ext) {
			$_str_sqlWhere .= " AND attach_ext='" . $str_ext . "'";
		}

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND attach_admin_id=" . $num_adminId;
		}

		$_num_mysql = $this->obj_db->count(BG_DB_TABLE . "attach", $_str_sqlWhere);

		return $_num_mysql;
	}


	/**
	 * mdl_ext function.
	 *
	 * @access public
	 * @param mixed $num_no
	 * @return void
	 */
	function mdl_ext() {
		$_arr_attachSelect = array(
			"DISTINCT attach_ext",
		);

		$_str_sqlWhere = "LENGTH(attach_ext) > 0";

		$_arr_attachRows = $this->obj_db->select_array(BG_DB_TABLE . "attach", $_arr_attachSelect, $_str_sqlWhere, 100, 0, false, true);

		return $_arr_attachRows;
	}


	/**
	 * mdl_year function.
	 *
	 * @access public
	 * @param mixed $num_no
	 * @return void
	 */
	function mdl_year() {
		$_arr_attachSelect = array(
			"DISTINCT FROM_UNIXTIME(attach_time, '%Y') AS attach_year",
		);

		$_str_sqlWhere = "attach_time > 0";

		$_arr_yearRows = $this->obj_db->select_array(BG_DB_TABLE . "attach", $_arr_attachSelect, $_str_sqlWhere . " ORDER BY attach_time ASC", 100, 0, false, true);

		return $_arr_yearRows;
	}


	function mdl_url($num_attachId, $arr_thumbRows) {
		$_arr_attachRow = $this->mdl_read($num_attachId);
		if ($_arr_attachRow["str_alert"] != "y070102") {
			return $_arr_attachRow;
			exit;
		}
		$str_attachUrl = BG_UPLOAD_URL . BG_URL_ATTACH . date("Y", $_arr_attachRow["attach_time"]) . "/" . date("m", $_arr_attachRow["attach_time"]) . "/" . $num_attachId . "." . $_arr_attachRow["attach_ext"];

		foreach ($arr_thumbRows as $_key=>$_value) {
			$_arr_attachRow["thumb_" . $_value["thumb_width"] . "_" . $_value["thumb_height"] . "_" . $_value["thumb_type"]] = BG_UPLOAD_URL . BG_URL_ATTACH . date("Y", $_arr_attachRow["attach_time"]) . "/" . date("m", $_arr_attachRow["attach_time"]) . "/" . $num_attachId . "_" . $_value["thumb_width"] . "_" . $_value["thumb_height"] . "_" .$_value["thumb_type"] . "." . $_arr_attachRow["attach_ext"];
		}

		$_arr_attachRow["attach_url"]    = $str_attachUrl;

		return $_arr_attachRow;
	}

	/**
	 * fn_thumbDo function.
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

		$_arr_attachIds = fn_post("attach_id");

		if ($_arr_attachIds) {
			foreach ($_arr_attachIds as $_key=>$_value) {
				$_arr_attachIds[$_key] = fn_getSafe($_value, "int", 0);
			}
			$_str_alert = "ok";
		} else {
			$_str_alert = "none";
		}

		$this->attachIds = array(
			"str_alert"  => $_str_alert,
			"attach_ids" => $_arr_attachIds,
		);

		return $this->attachIds;
	}


	function url_process($num_attachId, $num_attachTime, $num_attachExt, $arr_thumbRows) {
		$str_attachUrl = BG_UPLOAD_URL . BG_URL_ATTACH . date("Y", $num_attachTime) . "/" . date("m", $num_attachTime) . "/" . $num_attachId . "." . $num_attachExt;

		foreach ($arr_thumbRows as $_key=>$_value) {
			$_arr_attach["attach_thumb"][$_key]["thumb_url"] = BG_UPLOAD_URL . BG_URL_ATTACH . date("Y", $num_attachTime) . "/" . date("m", $num_attachTime) . "/" . $num_attachId . "_" . $_value["thumb_width"] . "_" . $_value["thumb_height"] . "_" .$_value["thumb_type"] . "." . $num_attachExt;
			$_arr_attach["attach_thumb"][$_key]["thumb_width"] = $_value["thumb_width"];
			$_arr_attach["attach_thumb"][$_key]["thumb_height"] = $_value["thumb_height"];
			$_arr_attach["attach_thumb"][$_key]["thumb_type"] = $_value["thumb_type"];
		}

		//print_r($_arr_attach);

		$_arr_attach["attach_url"] = $str_attachUrl;

		return $_arr_attach;
	}

}
