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
class MODEL_THUMB {

	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}

	/*============提交缩略图============
	@num_thumbWidth 宽度
	@num_thumbHeight 高度
	@str_thumbType 缩略图类型

	返回多维数组
		num_thumbId ID
		str_alert 提示
	*/
	function mdl_submit($num_thumbWidth, $num_thumbHeight, $str_thumbType) {
		$_arr_thumbData = array(
			"thumb_width"    => $num_thumbWidth,
			"thumb_height"   => $num_thumbHeight,
			"thumb_type"     => $str_thumbType,
		);

		$_num_thumbId = $this->obj_db->insert(BG_DB_TABLE . "thumb", $_arr_thumbData);

		if ($_num_thumbId > 0) { //数据库插入是否成功
			$_str_alert = "y090101";
		} else {
			return array(
				"str_alert" => "x090101",
			);
			exit;
		}

		return array(
			"thumb_id" => $_num_thumbId,
			"str_alert" => $_str_alert,
		);
	}

	/*============缩略图检查============
	@num_thumbWidth 宽度
	@num_thumbHeight 高度

	返回提示
	*/
	function mdl_read($num_thumbWidth = 0, $num_thumbHeight = 0, $str_thumbType = "") {
		if ($num_thumbWidth == 100 && $num_thumbHeight == 100 && $str_thumbType == "cut") {
			return array(
				"thumb_width"   => 100,
				"thumb_height"  => 100,
				"thumb_type"    => "cut",
				"str_alert"     => "y090102", //不存在记录
			);
			exit;
		}

		$_arr_thumbSelect = array(
			"thumb_id",
			"thumb_width",
			"thumb_height",
			"thumb_type",
		);

		$_str_sqlWhere = "thumb_id > 0";

		if ($num_thumbWidth > 0) {
			$_str_sqlWhere .= " AND thumb_width=" . $num_thumbWidth;
		}

		if ($num_thumbHeight > 0) {
			$_str_sqlWhere .= " AND thumb_height=" . $num_thumbHeight;
		}

		if ($str_thumbType) {
			$_str_sqlWhere .= " AND thumb_type='" . $str_thumbType . "'";
		}

		$_arr_thumbRows = $this->obj_db->select_array(BG_DB_TABLE . "thumb",  $_arr_thumbSelect, $_str_sqlWhere, 1, 0); //查询数据
		$_arr_thumbRow = $_arr_thumbRows[0];

		if (!$_arr_thumbRow) { //用户名不存在则返回错误
			return array(
				"str_alert" => "x090102", //不存在记录
			);
			exit;
		}

		$_arr_thumbRow["str_alert"] = "y090102";

		return $_arr_thumbRow;
	}

	/*============列出缩略图============
	返回多维数组
		thumb_id 缩略图 ID
		thumb_width 缩略图宽度
		thumb_height 缩略图高度
	*/
	function mdl_list($num_no, $num_except = 0, $str_type = "") {
		$_arr_thumbSelect = array(
			"thumb_id",
			"thumb_width",
			"thumb_height",
			"thumb_type",
		);

		$_str_sqlWhere = "thumb_id > 0";

		if ($str_type) {
			$_str_sqlWhere .= " AND thumb_type='" . $str_type . "'";
		}

		$_arr_thumb = $this->obj_db->select_array(BG_DB_TABLE . "thumb",  $_arr_thumbSelect, $_str_sqlWhere . " ORDER BY thumb_id DESC", $num_no, $num_except); //查询数据
		$_arr_thumbRow[] = array(
			"thumb_id"       => 0,
			"thumb_width"    => 100,
			"thumb_height"   => 100,
			"thumb_type"     => "cut",
		);
		$_arr_thumbRows = array_merge($_arr_thumbRow, $_arr_thumb);

		return $_arr_thumbRows;
	}


	function mdl_count($str_type = "") {
		$_str_sqlWhere = "thumb_id > 0";

		if ($str_type) {
			$_str_sqlWhere .= " AND thumb_type='" . $str_type . "'";
		}

		$_num_count = $this->obj_db->count(BG_DB_TABLE . "thumb", $_str_sqlWhere); //查询数据

		return $_num_count;
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @param mixed $arr_thumbId
	 * @return void
	 */
	function mdl_del($arr_thumbId) {
		$_str_thumbId = implode(",", $arr_thumbId);

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "thumb", "thumb_id IN (" . $_str_thumbId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y090104";
		} else {
			$_str_alert = "x090104";
		}

		return array(
			"str_alert" => $_str_alert
		);
	}

}
?>