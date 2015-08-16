<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------自定义字段值类-------------*/
class MODEL_ARTICLE_CUSTOM {

	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	function mdl_create_table($arr_customRows) {
		$_str_alert = "x210105";

		$_arr_articleCreat = array(
			"article_id" => "int NOT NULL AUTO_INCREMENT COMMENT 'ID'",
		);

		foreach ($arr_customRows as $_key=>$_value) {
			$_str_create = $_value["custom_type"];

			if ($_value["custom_type"] != "text") {
				$_str_create .= "(" . $_value["custom_opt"] . ")";
			}

			$_str_create .= " NOT NULL COMMENT '自定义字段" . $_value["custom_id"] . "'";

			$_arr_articleCreat["custom_" . $_value["custom_id"]] = $_str_create;
		}

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "article_custom", $_arr_articleCreat, "article_id", "自定义字段");

		if ($_num_mysql > 1) {
			$_str_alert = "y210105";
		}

		$_arr_col     = $this->mdl_column(true);
		$_arr_alert   = array();

		foreach ($arr_customRows as $_key=>$_value) {
			$_str_create = $_value["custom_type"];

			if ($_value["custom_type"] != "text") {
				$_str_create .= "(" . $_value["custom_opt"] . ")";
			}

			$_str_create .= " NOT NULL COMMENT '自定义字段" . $_value["custom_id"] . "'";

			if (array_key_exists("custom_" . $_value["custom_id"], $_arr_col)) {
				$_type = $_arr_col["custom_" . $_value["custom_id"]];
				if ($_type != $_value["custom_type"] . "(" . $_value["custom_opt"] . ")") {
					$_arr_alert["custom_" . $_value["custom_id"]] = array("CHANGE", $_str_create, "custom_" . $_value["custom_id"]);
				}
			} else {
				$_arr_alert["custom_" . $_value["custom_id"]] = array("ADD", $_str_create);
			}
			$_arr_custom[] = "custom_" . $_value["custom_id"];
		}

		foreach ($_arr_col as $_key=>$_value) {
			if (!in_array($_key, $_arr_custom) && $_key != "article_id") {
				$_arr_alert[$_key] = array("DROP");
			}
		}

		$_arr_alert["article_id"] = array("ADD", "int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'ID'");

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "article_custom", $_arr_alert);
			if ($_reselt) {
				$_str_alert = "y210105";
			}
		}


		return array(
			"alert" => $_str_alert, //更新成功
		);
	}


	function mdl_column($is_type = false) {
		$_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "article_custom");

		$_arr_col = array();

		if ($_arr_colRows) {
			foreach ($_arr_colRows as $_key=>$_value) {
				if ($is_type) {
					$_arr_col[$_value["Field"]] = $_value["Type"];
				} else {
					$_arr_col[] = $_value["Field"];
				}
			}
		}

		return $_arr_col;
	}


	function mdl_cache() {
		$_str_alert   = "y210110";

		$_arr_column  = $this->mdl_column();
		$_str_outPut  = "<?php" . PHP_EOL;
		$_str_outPut .= "return array(" . PHP_EOL;
		foreach ($_arr_column as $_key=>$_value) {
			$_str_outPut .= "\"" . $_value . "\",";
		}
		$_str_outPut .= ");";

		$_num_size    = file_put_contents(BG_PATH_CACHE . "article_custom.php", $_str_outPut);

		if (!$_num_size) {
			$_str_alert = "x210110";
		}

		return array(
			"alert" => $_str_alert,
		);
	}
}
