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

	/*============提交允许类型============
	@str_mimeName 允许类型

	返回多维数组
		num_mimeId ID
		str_alert 提示
	*/
	function mdl_submit($str_mimeName, $str_mimeExt, $str_mimeNote = "") {
		$_arr_mimeInsert = array(
			"mime_name"  => $str_mimeName,
			"mime_ext"   => $str_mimeExt,
			"mime_note"  => $str_mimeNote,
		);

		$_num_mimeId = $this->obj_db->insert(BG_DB_TABLE . "mime", $_arr_mimeInsert);

		if ($_num_mimeId > 0) { //数据库插入是否成功
			$_str_alert = "y080101";
		} else {
			return array(
				"str_alert" => "x080101",
			);
			exit;
		}

		return array(
			"str_alert" => $_str_alert,
			"mime_id" => $_num_mimeId,
		);
	}

	/*============允许类型检查============
	@str_mimeName 允许类型

	返回提示
	*/
	function mdl_read($str_mime, $str_readBy = "mime_id") {
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

		$_arr_mimeRows = $this->obj_db->select_array(BG_DB_TABLE . "mime",  $_arr_mimeSelect, $_str_sqlWhere, 1, 0); //查询数据
		$_arr_mimeRow = $_arr_mimeRows[0];

		if (!$_arr_mimeRow) {
			return array(
				"str_alert" => "x080102", //不存在记录
			);
			exit;
		}

		$_arr_mimeRow["str_alert"] = "y080102";

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

		$_arr_mimeRows = $this->obj_db->select_array(BG_DB_TABLE . "mime",  $_arr_mimeSelect, "mime_id > 0 ORDER BY mime_id DESC", $num_no, $num_except); //查询数据

		return $_arr_mimeRows;
	}

	function mdl_count() {
		$_num_count = $this->obj_db->count(BG_DB_TABLE . "admin"); //查询数据
		return $_num_count;
	}


	/*============删除允许类型============
	@arr_mimeId 允许类型 ID 数组

	返回提示信息
	*/
	function mdl_del($arr_mimeId) {
		$_str_mimeId = implode(",", $arr_mimeId);

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "mime", "mime_id IN (" . $_str_mimeId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y080104";
		} else {
			$_str_alert = "x080104";
		}

		return array(
			"str_alert" => $_str_alert
		);
	}

}
?>