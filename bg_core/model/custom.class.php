<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------自定义字段-------------*/
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
			"custom_id"          => "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"custom_name"        => "varchar(90) NOT NULL COMMENT '名称'",
			"custom_target"      => "enum('article','cate') NOT NULL COMMENT '目标'",
			"custom_type"        => "enum('int','decimal','varchar','text','enum') NOT NULL COMMENT '类型'",
			"custom_opt"         => "varchar(90) NOT NULL COMMENT '选项'",
			"custom_status"      => "enum('enable','disable') NOT NULL COMMENT '状态'",
			"custom_order"       => "smallint NOT NULL COMMENT '排序'",
			"custom_parent_id"   => "smallint NOT NULL COMMENT '父字段'",
		);

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "custom", $_arr_customCreat, "custom_id", "自定义字段");

		if ($_num_mysql > 0) {
			$_str_alert = "y200105"; //更新成功
		} else {
			$_str_alert = "x200105"; //更新成功
		}

		return array(
			"alert" => $_str_alert, //更新成功
		);
	}


	function mdl_create_index() {
		$_str_alert = "y200109";
		$_arr_indexRow    = $this->obj_db->show_index(BG_DB_TABLE . "custom");

		$is_exists        = false;
		foreach ($_arr_indexRow as $_key=>$_value) {
			if (in_array("order", $_value)) {
				$is_exists = true;
				break;
			}
		}

		$_arr_customIndex = array(
			"custom_order",
			"custom_id",
		);

		$_num_mysql = $this->obj_db->create_index("order", BG_DB_TABLE . "custom", $_arr_customIndex, "BTREE", $is_exists);

		if ($_num_mysql <= 0) {
			$_str_alert = "x200109";
		}

		return array(
			"alert" => $_str_alert, //更新成功
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


	function mdl_column_custom() {
		$_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "article_custom");

		$_arr_col = array();

		if ($_arr_colRows) {
			foreach ($_arr_colRows as $_key=>$_value) {
				$_arr_col[] = $_value["Field"];
			}
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
			"custom_name"        => $this->customSubmit["custom_name"],
			"custom_target"      => $this->customSubmit["custom_target"],
			"custom_type"        => $this->customSubmit["custom_type"],
			"custom_opt"         => $this->customSubmit["custom_opt"],
			"custom_status"      => $this->customSubmit["custom_status"],
			"custom_parent_id"   => $this->customSubmit["custom_parent_id"],
		);

		if ($this->customSubmit["custom_id"] == 0) {

			$_num_customId = $this->obj_db->insert(BG_DB_TABLE . "custom", $_arr_customData);

			if ($_num_customId > 0) { //数据库插入是否成功
				$_str_alert = "y200101";
			} else {
				return array(
					"alert" => "x200101",
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
					"alert" => "x200103",
				);
				exit;
			}
		}

		return array(
			"custom_id"    => $_num_customId,
			"alert"  => $_str_alert,
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
	function mdl_read($str_custom, $str_readBy = "custom_id", $num_notId = 0, $str_target = "") {
		$_arr_customSelect = array(
			"custom_id",
			"custom_name",
			"custom_target",
			"custom_type",
			"custom_opt",
			"custom_status",
			"custom_parent_id",
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
			$_str_sqlWhere .= " AND custom_target='" . $str_target . "'";
		}

		$_arr_customRows = $this->obj_db->select(BG_DB_TABLE . "custom",  $_arr_customSelect, $_str_sqlWhere, "", "", 1, 0); //检查本地表是否存在记录

		if (isset($_arr_customRows[0])) {
			$_arr_customRow = $_arr_customRows[0];
		} else {
			return array(
				"alert" => "x200102", //不存在记录
			);
			exit;
		}

		$_arr_customRow["alert"] = "y200102";

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
	function mdl_list($num_no, $num_except = 0, $str_key = "", $str_target = "", $str_status = "", $num_parentId = 0, $num_level = 1, $is_tree = true) {
		$_arr_updateData = array(
			"custom_order" => "custom_id",
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "custom", $_arr_updateData, "custom_order=0", true); //更新数据

		$_arr_customSelect = array(
			"custom_id",
			"custom_name",
			"custom_target",
			"custom_type",
			"custom_opt",
			"custom_status",
			"custom_parent_id",
		);

		$_str_sqlWhere = "1=1";

		if ($str_key) {
			$_str_sqlWhere .= " AND custom_name LIKE '%" . $str_key . "%'";
		}

		if ($str_target) {
			$_str_sqlWhere .= " AND custom_target='" . $str_target . "'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND custom_status='" . $str_status . "'";
		}

		if ($is_tree) {
			$_str_sqlWhere .= " AND custom_parent_id=" . $num_parentId;
		}

		$_arr_customRows = $this->obj_db->select(BG_DB_TABLE . "custom",  $_arr_customSelect, $_str_sqlWhere, "", "custom_order ASC, custom_id ASC", $num_no, $num_except);

		if ($is_tree) {
			foreach ($_arr_customRows as $_key=>$_value) {
				$_arr_customRows[$_key]["custom_level"]  = $num_level;
				$_arr_customRows[$_key]["custom_childs"] = $this->mdl_list(1000, 0, $str_key, $str_target, $str_status, $_value["custom_id"], $num_level + 1);
			}
		}

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
	function mdl_count($str_key = "", $str_target = "", $str_status = "", $num_parentId = 0) {

		$_str_sqlWhere = "1=1";

		if ($str_key) {
			$_str_sqlWhere .= " AND custom_name LIKE '%" . $str_key . "%'";
		}

		if ($str_target) {
			$_str_sqlWhere .= " AND custom_target='" . $str_target . "'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND custom_status='" . $str_status . "'";
		}

		$_str_sqlWhere .= " AND custom_parent_id=" . $num_parentId;

		$_num_customCount = $this->obj_db->count(BG_DB_TABLE . "custom", $_str_sqlWhere); //查询数据

		/*print_r($_arr_userRow);
		exit;*/

		return $_num_customCount;
	}


	function mdl_order($str_orderType = "", $num_doId = 0, $num_targetId = 0, $num_parentId = 0) {

		//处理重复排序号
		$_str_sqlDistinct = "SELECT custom_id FROM " . BG_DB_TABLE . "custom WHERE custom_order IN (SELECT custom_order FROM " . BG_DB_TABLE . "custom GROUP BY custom_order HAVING COUNT(custom_order) > 1) ORDER BY custom_id DESC" ;
		$_obj_reselt      = $this->obj_db->query($_str_sqlDistinct);
		$_arr_row         = $this->obj_db->fetch_assoc($_obj_reselt);

		if ($_arr_row) {
			$_arr_selectData = array(
				"custom_id",
			);

			$_arr_lastRows  = $this->obj_db->select(BG_DB_TABLE . "custom", $_arr_selectData, "", "", "custom_id DESC", 1, 0); //读取倒数第一排序号
			if (isset($_arr_lastRows[0])) {
				$_arr_lastRow   = $_arr_lastRows[0];

				$_arr_updateData = array(
					"custom_order" => $_arr_row["custom_id"] + 1,
				);

				$_str_sqlWhere = "custom_id=" . $_arr_row["custom_id"];

				$this->obj_db->update(BG_DB_TABLE . "custom", $_arr_updateData, $_str_sqlWhere, true); //所有小于本条大于目标记录的数据排序号加1
			}
		}
		//end

		//
		$_arr_selectData = array(
			"custom_order",
		);

		switch ($str_orderType) {
			case "order_first":
				$_str_sqlWhere = "1=1";
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND custom_parent_id=" . $num_parentId;
				}
				$_arr_firstRows = $this->obj_db->select(BG_DB_TABLE . "custom", $_arr_selectData, $_str_sqlWhere, "", "custom_order ASC", 1, 0); //读取第一排序号
				if (isset($_arr_firstRows[0])) {
					$_arr_firstRow  = $_arr_firstRows[0];
				}

				$_str_sqlWhere  = "custom_id=" . $num_doId;
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND custom_parent_id=" . $num_parentId;
				}
				$_arr_doRows    = $this->obj_db->select(BG_DB_TABLE . "custom", $_arr_selectData, $_str_sqlWhere, "", "", 1, 0); //读取本条排序号
				if (isset($_arr_doRows[0])) {
					$_arr_doRow     = $_arr_doRows[0];
				} else {
					return array(
						"alert" => "x110217",
					);
					exit;
				}

				$_arr_targetData = array(
					"custom_order" => "custom_order+1",
				);
				$_str_sqlWhere = "custom_order<" . $_arr_doRow["custom_order"];
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND custom_parent_id=" . $num_parentId;
				}
				$this->obj_db->update(BG_DB_TABLE . "custom", $_arr_targetData, $_str_sqlWhere, true); //所有小于本条的数据排序号加1

				$_arr_doData = array(
					"custom_order" => $_arr_firstRow["custom_order"],
				);
				$_str_sqlWhere = "custom_id=" . $num_doId;
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND custom_parent_id=" . $num_parentId;
				}
				$this->obj_db->update(BG_DB_TABLE . "custom", $_arr_doData, $_str_sqlWhere); //更新本条排序号为1
			break;

			case "order_last":
				$_str_sqlWhere = "1=1";
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND custom_parent_id=" . $num_parentId;
				}
				$_arr_lastRows  = $this->obj_db->select(BG_DB_TABLE . "custom", $_arr_selectData, $_str_sqlWhere, "", "custom_order DESC", 1, 0); //读取倒数第一排序号
				if (isset($_arr_lastRows[0])) {
					$_arr_lastRow   = $_arr_lastRows[0];
				}

				$_str_sqlWhere  = "custom_id=" . $num_doId;
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND custom_parent_id=" . $num_parentId;
				}
				$_arr_doRows    = $this->obj_db->select(BG_DB_TABLE . "custom", $_arr_selectData, $_str_sqlWhere, "", "", 1, 0); //读取本条排序号
				if (isset($_arr_doRows[0])) {
					$_arr_doRow     = $_arr_doRows[0];
				} else {
					return array(
						"alert" => "x110217",
					);
					exit;
				}

				$_arr_targetData = array(
					"custom_order" => "custom_order-1",
				);
				$_str_sqlWhere = "custom_order>" . $_arr_doRow["custom_order"];
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND custom_parent_id=" . $num_parentId;
				}
				$this->obj_db->update(BG_DB_TABLE . "custom", $_arr_targetData, $_str_sqlWhere, true); //所有大于本条的数据排序号减1

				$_arr_doData = array(
					"custom_order" => $_arr_lastRow["custom_order"],
				);
				$_str_sqlWhere = "custom_id=" . $num_doId;
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND custom_parent_id=" . $num_parentId;
				}
				$this->obj_db->update(BG_DB_TABLE . "custom", $_arr_doData, $_str_sqlWhere); //更新本条排序号为最大
			break;

			case "order_after":
				$_str_sqlWhere = "custom_id=" . $num_targetId;
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND custom_parent_id=" . $num_parentId;
				}
				$_arr_targetRows    = $this->obj_db->select(BG_DB_TABLE . "custom", $_arr_selectData, $_str_sqlWhere, "", "", 1, 0); //读取目标记录排序号
				if (isset($_arr_targetRows[0])) {
					$_arr_targetRow     = $_arr_targetRows[0];
				} else {
					return array(
						"alert" => "x110220",
					);
					exit;
				}

				$_str_sqlWhere      = "custom_id=" . $num_doId;
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND custom_parent_id=" . $num_parentId;
				}
				$_arr_doRows    = $this->obj_db->select(BG_DB_TABLE . "custom", $_arr_selectData, $_str_sqlWhere, "", "", 1, 0); //读取本条排序号
				if (isset($_arr_doRows[0])) {
					$_arr_doRow     = $_arr_doRows[0];
				} else {
					return array(
						"alert" => "x110217",
					);
					exit;
				}

				//print_r($_arr_doRow);

				if ($_arr_targetRow["custom_order"] > $_arr_doRow["custom_order"]) { //往下移
					$_arr_targetData = array(
						"custom_order" => "custom_order-1",
					);
					$_str_sqlWhere = "custom_order>" . $_arr_doRow["custom_order"] . " AND custom_order<=" . $_arr_targetRow["custom_order"];
					if ($num_parentId > 0) {
						$_str_sqlWhere .= " AND custom_parent_id=" . $num_parentId;
					}
					$this->obj_db->update(BG_DB_TABLE . "custom", $_arr_targetData, $_str_sqlWhere, true); //所有大于本条小于目标记录的数据排序号减1

					$_arr_doData = array(
						"custom_order" => $_arr_targetRow["custom_order"],
					);
				} else {
					$_arr_targetData = array(
						"custom_order" => "custom_order+1",
					);
					$_str_sqlWhere = "custom_order<" . $_arr_doRow["custom_order"] . " AND custom_order>" . $_arr_targetRow["custom_order"];
					if ($num_parentId > 0) {
						$_str_sqlWhere .= " AND custom_parent_id=" . $num_parentId;
					}
					$this->obj_db->update(BG_DB_TABLE . "custom", $_arr_targetData, $_str_sqlWhere, true); //所有大于本条小于目标记录的数据排序号减1

					$_arr_doData = array(
						"custom_order" => $_arr_targetRow["custom_order"] + 1,
					);
				}

				$_str_sqlWhere = "custom_id=" . $num_doId;
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND custom_parent_id=" . $num_parentId;
				}
				$this->obj_db->update(BG_DB_TABLE . "custom", $_arr_doData, $_str_sqlWhere); //更新本条排序号为目标记录排序号
			break;
		}

		return array(
			"alert" => "y110103",
		);
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
			"alert" => $_str_alert,
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
			"alert" => $_str_alert,
		); //成功
	}


	function mdl_cache() {
		$_str_alert = "y200110";


		$_arr_column_custom  = $this->mdl_column_custom();

		$_arr_customRows  = $this->mdl_list(1000, 0, "", "", "enable");

		$_str_outPut      = "<?php" . PHP_EOL;
		$_str_outPut     .= "return array(" . PHP_EOL;
			$_str_outPut     .= "\"article_custom\" => array(" . PHP_EOL;

			foreach ($_arr_column_custom as $_key=>$_value) {
				$_str_outPut .= "\"" . $_value . "\",";
			}

			$_str_outPut     .= "),";
			$_str_outPut     .= "\"custom_list\" => array(" . PHP_EOL;
				$_str_outPut     .= $this->cache_process($_arr_customRows);
			$_str_outPut     .= "),";
		$_str_outPut     .= ");";

		$_num_size        = file_put_contents(BG_PATH_CACHE . "custom_list.php", $_str_outPut);

		if (!$_num_size) {
			$_str_alert = "x200110";
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

		$this->customSubmit["custom_id"] = fn_getSafe(fn_post("custom_id"), "int", 0);

		if ($this->customSubmit["custom_id"] > 0) {
			$_arr_customRow = $this->mdl_read($this->customSubmit["custom_id"]);
			if ($_arr_customRow["alert"] != "y200102") {
				return $_arr_customRow;
				exit;
			}
		}

		$_arr_customName = validateStr(fn_post("custom_name"), 1, 90);
		switch ($_arr_customName["status"]) {
			case "too_short":
				return array(
					"alert" => "x200201",
				);
				exit;
			break;

			case "too_long":
				return array(
					"alert" => "x200202",
				);
				exit;
			break;

			case "ok":
				$this->customSubmit["custom_name"] = $_arr_customName["str"];
			break;
		}

		$_arr_customParentId = validateStr(fn_post("custom_parent_id"), 1, 0);
		switch ($_arr_customParentId["status"]) {
			case "too_short":
				return array(
					"alert" => "x200207",
				);
				exit;
			break;

			case "ok":
				$this->customSubmit["custom_parent_id"] = $_arr_customParentId["str"];
			break;
		}

		if ($this->customSubmit["custom_parent_id"] > 0 && $this->customSubmit["custom_parent_id"] == $this->customSubmit["custom_id"]) {
			return array(
				"alert" => "x200208",
			);
			exit;
		}

		$_arr_customTarget = validateStr(fn_post("custom_target"), 1, 0);
		switch ($_arr_customTarget["status"]) {
			case "too_short":
				return array(
					"alert" => "x200205",
				);
				exit;
			break;

			case "ok":
				$this->customSubmit["custom_target"] = $_arr_customTarget["str"];
			break;
		}


		$_arr_customRow = $this->mdl_read($this->customSubmit["custom_name"], "custom_name", $this->customSubmit["custom_id"], $this->customSubmit["custom_target"]);
		if ($_arr_customRow["alert"] == "y200102") {
			return array(
				"alert" => "x200203",
			);
			exit;
		}

		$_arr_customType = validateStr(fn_post("custom_type"), 1, 0);
		switch ($_arr_customType["status"]) {
			case "too_short":
				return array(
					"alert" => "x200211",
				);
				exit;
			break;

			case "ok":
				$this->customSubmit["custom_type"] = $_arr_customType["str"];
			break;
		}

		$_arr_customOpt = validateStr(fn_post("custom_opt"), 0, 900);
		switch ($_arr_customOpt["status"]) {
			case "too_long":
				return array(
					"alert" => "x200212",
				);
				exit;
			break;

			case "ok":
				$this->customSubmit["custom_opt"] = $_arr_customOpt["str"];
			break;
		}

		$_arr_customStatus = validateStr(fn_post("custom_status"), 1, 0);
		switch ($_arr_customStatus["status"]) {
			case "too_short":
				return array(
					"alert" => "x200206",
				);
				exit;
			break;

			case "ok":
				$this->customSubmit["custom_status"] = $_arr_customStatus["str"];
			break;
		}

		$this->customSubmit["alert"] = "ok";

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
				"alert" => "x030102",
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
			"alert"      => $_str_alert,
			"custom_ids" => $_arr_customIds,
		);

		return $this->customIds;
	}


	private function cache_process($_arr_customRows) {
		$_str_outPut = "";

		foreach ($_arr_customRows as $_key=>$_value) {
			$_str_outPut .= $_key . " => array(" . PHP_EOL;
				$_str_outPut .= "\"custom_id\" => " . $_value["custom_id"] . "," . PHP_EOL;
				$_str_outPut .= "\"custom_name\" => \"" . $_value["custom_name"] . "\"," . PHP_EOL;
				$_str_outPut .= "\"custom_parent_id\" => " . $_value["custom_parent_id"] . "," . PHP_EOL;

				if ($_value["custom_childs"]) {
					$_str_childs = $this->cache_process($_value["custom_childs"]);
					$_str_outPut .= "\"custom_childs\" => array(" . PHP_EOL;
					$_str_outPut .= $_str_childs . PHP_EOL;
					$_str_outPut .= ")," . PHP_EOL;
				}

			$_str_outPut .= ")," . PHP_EOL;
		}

		return $_str_outPut;
	}
}
