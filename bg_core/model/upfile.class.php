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
class MODEL_UPFILE {

	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $str_upfileName
	 * @param mixed $str_upfileExt
	 * @param int $num_upfileSize (default: 0)
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_submit($str_upfileName, $str_upfileExt, $num_upfileSize = 0, $num_adminId = 0) {

		$_tm_time = time();

		$_arr_upfileInsert = array(
			"upfile_name"        => $str_upfileName,
			"upfile_ext"         => $str_upfileExt,
			"upfile_time"        => $_tm_time,
			"upfile_size"        => $num_upfileSize,
			"upfile_admin_id"    => $num_adminId,
		);

		$_num_upfileId = $this->obj_db->insert(BG_DB_TABLE . "upfile", $_arr_upfileInsert);

		if ($_num_upfileId > 0) { //数据库插入是否成功
			$_str_alert = "y070101";
		} else {
			return array(
				"str_alert" => "x070101",
			);
			exit;
		}

		return array(
			"upfile_id"      => $_num_upfileId,
			"upfile_time"    => $_tm_time,
			"str_alert"      => $_str_alert,
		);
	}


	/**
	 * mdl_listArr function.
	 *
	 * @access public
	 * @param mixed $arr_upfileId
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_listArr($arr_upfileId, $num_adminId = 0) {
		$_str_upfileId = implode(",", $arr_upfileId);

		$_arr_upfileSelect = array(
			"upfile_id",
			"upfile_time",
			"upfile_ext",
		);

		$_str_sqlWhere = "upfile_id IN (" . $_str_upfileId . ")";

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND upfile_admin_id=" . $num_adminId;
		}

		$_arr_upfileRows = $this->obj_db->select_array(BG_DB_TABLE . "upfile", $_arr_upfileSelect, $_str_sqlWhere . " ORDER BY upfile_id DESC", 1000, 0);

		return $_arr_upfileRows;
	}


	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $num_upfileId
	 * @return void
	 */
	function mdl_read($num_upfileId) {
		$_arr_upfileSelect = array(
			"upfile_id",
			"upfile_time",
			"upfile_ext",
		);

		$_arr_upfileRows  = $this->obj_db->select_array(BG_DB_TABLE . "upfile", $_arr_upfileSelect, "upfile_id=" . $num_upfileId, 1, 0); //检查本地表是否存在记录
		$_arr_upfileRow   = $_arr_upfileRows[0];

		if (!$_arr_upfileRow) {
			return array(
				"str_alert" => "x070102", //不存在记录
			);
			exit;
		}

		$_arr_upfileRow["str_alert"] = "y070102";

		return $_arr_upfileRow;
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
		$_arr_upfileSelect = array(
			"upfile_id",
			"upfile_name",
			"upfile_time",
			"upfile_ext",
			"upfile_size",
			"upfile_admin_id",
		);

		$_str_sqlWhere = "upfile_id > 0";

		if ($str_year) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(upfile_time, '%Y')='" . $str_year . "'";
		}

		if ($str_month) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(upfile_time, '%m')='" . $str_month . "'";
		}

		if ($str_ext) {
			$_str_sqlWhere .= " AND upfile_ext='" . $str_ext . "'";
		}

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND upfile_admin_id=" . $num_adminId;
		}

		$_arr_upfileRows = $this->obj_db->select_array(BG_DB_TABLE . "upfile", $_arr_upfileSelect, $_str_sqlWhere . " ORDER BY upfile_id DESC", $num_no, $num_except);

		return $_arr_upfileRows;
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @param mixed $arr_upfileId
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_del($arr_upfileId, $num_adminId = 0) {
		$_str_upfileId = implode(",", $arr_upfileId);

		$_str_sqlWhere = "upfile_id IN (" . $_str_upfileId . ")";

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND upfile_admin_id=" . $num_adminId;
		}

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "upfile", $_str_sqlWhere); //删除数据

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
		$_str_sqlWhere = "upfile_id > 0";

		if ($str_year) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(upfile_time, '%Y')='" . $str_year . "'";
		}

		if ($str_month) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(upfile_time, '%m')='" . $str_month . "'";
		}

		if ($str_ext) {
			$_str_sqlWhere .= " AND upfile_ext='" . $str_ext . "'";
		}

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND upfile_admin_id=" . $num_adminId;
		}

		$_num_mysql = $this->obj_db->count(BG_DB_TABLE . "upfile", $_str_sqlWhere);

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
		$_arr_upfileSelect = array(
			"upfile_ext",
		);

		$_str_sqlWhere = "LENGTH(upfile_ext) > 0";

		$_arr_upfileRows = $this->obj_db->select_array(BG_DB_TABLE . "upfile", $_arr_upfileSelect, $_str_sqlWhere, 100, 0, $_arr_upfileSelect);

		return $_arr_upfileRows;
	}


	/**
	 * mdl_year function.
	 *
	 * @access public
	 * @param mixed $num_no
	 * @return void
	 */
	function mdl_year() {
		$_arr_upfileSelect = array(
			"FROM_UNIXTIME(upfile_time, '%Y') AS upfile_year",
		);

		$_arr_distinct = array(
			"upfile_time",
		);

		$_str_sqlWhere = "upfile_time > 0";

		$_arr_yearRows = $this->obj_db->select_array(BG_DB_TABLE . "upfile", $_arr_upfileSelect, $_str_sqlWhere . " ORDER BY upfile_time ASC", 100, 0, $_arr_distinct, "", true);

		return $_arr_yearRows;
	}
}
?>