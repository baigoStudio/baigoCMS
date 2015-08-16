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

	function mdl_create_table() {
		$_arr_thumbCreat = array(
			"thumb_id"       => "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"thumb_width"    => "smallint NOT NULL COMMENT '宽度'",
			"thumb_height"   => "smallint NOT NULL COMMENT '高度'",
			"thumb_type"     => "enum('ratio','cut') NOT NULL COMMENT '类型'",
		);

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "thumb", $_arr_thumbCreat, "thumb_id", "缩略图");

		if ($_num_mysql > 0) {
			$_str_alert = "y090105"; //更新成功
		} else {
			$_str_alert = "x090105"; //更新成功
		}

		return array(
			"alert" => $_str_alert, //更新成功
		);
	}


	function mdl_column() {
		$_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "thumb");

		foreach ($_arr_colRows as $_key=>$_value) {
			$_arr_col[] = $_value["Field"];
		}

		return $_arr_col;
	}


	/*============提交缩略图============
	@num_thumbWidth 宽度
	@num_thumbHeight 高度
	@str_thumbType 缩略图类型

	返回多维数组
		num_thumbId ID
		str_alert 提示
	*/
	function mdl_submit() {
		$_arr_thumbData = array(
			"thumb_width"    => $this->thumbSubmit["thumb_width"],
			"thumb_height"   => $this->thumbSubmit["thumb_height"],
			"thumb_type"     => $this->thumbSubmit["thumb_type"],
		);

		if ($this->thumbSubmit["thumb_id"] == 0) {
			$_num_thumbId = $this->obj_db->insert(BG_DB_TABLE . "thumb", $_arr_thumbData);

			if ($_num_thumbId > 0) { //数据库插入是否成功
				$_str_alert = "y090101";
			} else {
				return array(
					"alert" => "x090101",
				);
				exit;
			}
		} else {
			$_num_thumbId    = $this->thumbSubmit["thumb_id"];
			$_num_mysql      = $this->obj_db->update(BG_DB_TABLE . "thumb", $_arr_thumbData,"thumb_id=" . $_num_thumbId);

			if ($_num_mysql > 0) { //数据库插入是否成功
				$_str_alert = "y090103";
			} else {
				return array(
					"alert" => "x090103",
				);
				exit;
			}
		}

		return array(
			"thumb_id"   => $_num_thumbId,
			"alert"  => $_str_alert,
		);
	}

	function mdl_read($num_thumbId) {

		$_arr_thumbSelect = array(
			"thumb_id",
			"thumb_width",
			"thumb_height",
			"thumb_type",
		);

		$_str_sqlWhere    = "thumb_id=" . $num_thumbId;

		$_arr_thumbRows   = $this->obj_db->select(BG_DB_TABLE . "thumb",  $_arr_thumbSelect, $_str_sqlWhere, "", "", 1, 0); //查询数据

		if (isset($_arr_thumbRows[0])) { //用户名不存在则返回错误
			$_arr_thumbRow    = $_arr_thumbRows[0];
		} else {
			return array(
				"alert" => "x090102", //不存在记录
			);
			exit;
		}

		$_arr_thumbRow["alert"] = "y090102";

		return $_arr_thumbRow;
	}


	function mdl_check($num_thumbWidth = 0, $num_thumbHeight = 0, $str_thumbType = "", $num_notId = 0) {
		if ($num_thumbWidth == 100 && $num_thumbHeight == 100 && $str_thumbType == "cut") {
			return array(
				"thumb_width"   => 100,
				"thumb_height"  => 100,
				"thumb_type"    => "cut",
				"alert"     => "y090102", //存在记录
			);
			exit;
		}

		$_arr_thumbSelect = array(
			"thumb_id",
			"thumb_width",
			"thumb_height",
			"thumb_type",
		);

		$_str_sqlWhere = "1=1";

		if ($num_thumbWidth > 0) {
			$_str_sqlWhere .= " AND thumb_width=" . $num_thumbWidth;
		}

		if ($num_thumbHeight > 0) {
			$_str_sqlWhere .= " AND thumb_height=" . $num_thumbHeight;
		}

		if ($str_thumbType) {
			$_str_sqlWhere .= " AND thumb_type='" . $str_thumbType . "'";
		}

		if ($num_notId > 0) {
			$_str_sqlWhere .= " AND thumb_id<>" . $num_notId;
		}

		$_arr_thumbRows = $this->obj_db->select(BG_DB_TABLE . "thumb",  $_arr_thumbSelect, $_str_sqlWhere, "", "", 1, 0); //查询数据

		if (isset($_arr_thumbRows[0])) { //用户名不存在则返回错误
			$_arr_thumbRow = $_arr_thumbRows[0];
		} else {
			return array(
				"alert" => "x090102", //不存在记录
			);
			exit;
		}

		$_arr_thumbRow["alert"] = "y090102";

		return $_arr_thumbRow;
	}

	/*============列出缩略图============
	返回多维数组
		thumb_id 缩略图 ID
		thumb_width 缩略图宽度
		thumb_height 缩略图高度
	*/
	function mdl_list($num_no, $num_except = 0) {
		$_arr_thumbSelect = array(
			"thumb_id",
			"thumb_width",
			"thumb_height",
			"thumb_type",
		);

		$_str_sqlWhere    = "1=1";

		$_arr_thumb       = $this->obj_db->select(BG_DB_TABLE . "thumb",  $_arr_thumbSelect, $_str_sqlWhere, "", "thumb_id DESC", $num_no, $num_except); //查询数据
		$_arr_thumbRow[] = array(
			"thumb_id"       => 0,
			"thumb_width"    => 100,
			"thumb_height"   => 100,
			"thumb_type"     => "cut",
		);
		$_arr_thumbRows = array_merge($_arr_thumbRow, $_arr_thumb);

		return $_arr_thumbRows;
	}


	function mdl_count() {
		$_str_sqlWhere = "1=1";

		$_num_count = $this->obj_db->count(BG_DB_TABLE . "thumb", $_str_sqlWhere); //查询数据

		return $_num_count;
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @param mixed $this->thumbIds["thumb_ids"]
	 * @return void
	 */
	function mdl_del() {
		$_str_thumbId = implode(",", $this->thumbIds["thumb_ids"]);

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "thumb", "thumb_id IN (" . $_str_thumbId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y090104";
		} else {
			$_str_alert = "x090104";
		}

		return array(
			"alert" => $_str_alert
		);
	}

	function mdl_cache() {
		$_str_alert = "y090110";

		$_arr_thumbRows = $this->mdl_list(100);

		$_str_outPut = "<?php" . PHP_EOL;
		$_str_outPut .= "return array(" . PHP_EOL;
			foreach ($_arr_thumbRows as $_key=>$_value) {
				$_str_outPut .= $_key . " => array(" . PHP_EOL;
					$_str_outPut .= "\"thumb_id\" => " . $_value["thumb_id"] . "," . PHP_EOL;
					$_str_outPut .= "\"thumb_width\" => " . $_value["thumb_width"] . "," . PHP_EOL;
					$_str_outPut .= "\"thumb_height\" => " . $_value["thumb_height"] . "," . PHP_EOL;
					$_str_outPut .= "\"thumb_type\" => \"" . $_value["thumb_type"] . "\"," . PHP_EOL;
				$_str_outPut .= "),";
			}
		$_str_outPut .= ");";

		$_num_size = file_put_contents(BG_PATH_CACHE . "thumb_list.php", $_str_outPut);

		if (!$_num_size) {
			$_str_alert = "x090110";
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

		$this->thumbSubmit["thumb_id"] = fn_getSafe(fn_post("thumb_id"), "int", 0);

		if ($this->thumbSubmit["thumb_id"] > 0) {
			$_arr_thumbRow = $this->mdl_read($this->thumbSubmit["thumb_id"]);
			if ($_arr_thumbRow["alert"] != "y090102") {
				return $_arr_thumbRow;
				exit;
			}
		}

		$_arr_thumbWidth = validateStr(fn_post("thumb_width"), 1, 0);
		switch ($_arr_thumbWidth["status"]) {
			case "too_short":
				return array(
					"alert" => "x090201",
				);
				exit;
			break;

			case "format_err":
				return array(
					"alert" => "x090202",
				);
				exit;
			break;

			case "ok":
				$this->thumbSubmit["thumb_width"] = $_arr_thumbWidth["str"];
			break;

		}

		$_arr_thumbHeight = validateStr(fn_post("thumb_height"), 1, 0);
		switch ($_arr_thumbHeight["status"]) {
			case "too_short":
				return array(
					"alert" => "x090203",
				);
				exit;
			break;

			case "format_err":
				return array(
					"alert" => "x090204",
				);
				exit;
			break;

			case "ok":
				$this->thumbSubmit["thumb_height"] = $_arr_thumbHeight["str"];
			break;

		}

		$_arr_thumbType = validateStr(fn_post("thumb_type"), 1, 0);
		switch ($_arr_thumbType["status"]) {
			case "too_short":
				return array(
					"alert" => "x090205",
				);
				exit;
			break;

			case "ok":
				$this->thumbSubmit["thumb_type"] = $_arr_thumbType["str"];
			break;

		}

		$_arr_thumbRow = $this->mdl_check($this->thumbSubmit["thumb_width"], $this->thumbSubmit["thumb_height"], $this->thumbSubmit["thumb_type"], $this->thumbSubmit["thumb_id"]);
		if ($_arr_thumbRow["alert"] == "y090102") {
			return array(
				"alert" => "x090206",
			);
			exit;
		}

		$this->thumbSubmit["alert"] = "ok";
		return $this->thumbSubmit;
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

		$_arr_thumbIds = fn_post("thumb_id");

		if ($_arr_thumbIds) {
			foreach ($_arr_thumbIds as $_key=>$_value) {
				$_arr_thumbIds[$_key] = fn_getSafe($_value, "int", 0);
			}
			$_str_alert = "ok";
		} else {
			$_str_alert = "none";
		}

		$this->thumbIds = array(
			"alert"   => $_str_alert,
			"thumb_ids"   => $_arr_thumbIds
		);

		return $this->thumbIds;
	}
}
