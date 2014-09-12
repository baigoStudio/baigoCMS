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
class MODEL_CATE {

	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	function mdl_create() {
		$_arr_cateCreat = array(
			"cate_id"        => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"cate_name"      => "varchar(300) NOT NULL COMMENT '站点名称'",
			"cate_domain"    => "varchar(3000) NOT NULL COMMENT '绑定域名'",
			"cate_type"      => "varchar(50) NOT NULL COMMENT '类型'",
			"cate_tpl"       => "varchar(1000) NOT NULL COMMENT '模板'",
			"cate_content"   => "text NOT NULL COMMENT '栏目内容'",
			"cate_link"      => "varchar(3000) NOT NULL COMMENT '链接地址'",
			"cate_parent_id" => "int(11) NOT NULL COMMENT '父栏目'",
			"cate_alias"     => "varchar(300) NOT NULL COMMENT '别名'",
			"cate_ftp_host"  => "varchar(3000) NOT NULL COMMENT '站点FTP服务器'",
			"cate_ftp_port"  => "varchar(5) NOT NULL COMMENT 'FTP端口'",
			"cate_ftp_user"  => "varchar(300) NOT NULL COMMENT '站点FTP用户名'",
			"cate_ftp_pass"  => "varchar(300) NOT NULL COMMENT '站点FTP密码'",
			"cate_ftp_path"  => "varchar(3000) NOT NULL COMMENT '站点FTP目录'",
			"cate_status"    => "varchar(20) NOT NULL COMMENT '状态'",
			"cate_order"     => "int(11) NOT NULL COMMENT '排序'",
		);

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "cate", $_arr_cateCreat, "cate_id", "栏目");

		if ($_num_mysql > 0) {
			$_str_alert = "y110105"; //更新成功
		} else {
			$_str_alert = "x110105"; //更新成功
		}

		return array(
			"str_alert" => $_str_alert, //更新成功
		);
	}


	function mdl_column() {
		$_arr_colSelect = array(
			"column_name"
		);

		$_str_sqlWhere = "table_schema='" . BG_DB_NAME . "' AND table_name='" . BG_DB_TABLE . "cate'";

		$_arr_colRows = $this->obj_db->select_array("information_schema`.`columns", $_arr_colSelect, $_str_sqlWhere, 100, 0);

		foreach ($_arr_colRows as $_key=>$_value) {
			$_arr_col[] = $_value["column_name"];
		}

		return $_arr_col;
	}


	function mdl_submit() {

		$_arr_cateData = array(
			"cate_name"      => $this->cateSubmit["cate_name"],
			"cate_alias"     => $this->cateSubmit["cate_alias"],
			"cate_type"      => $this->cateSubmit["cate_type"],
			"cate_status"    => $this->cateSubmit["cate_status"],
			"cate_tpl"       => $this->cateSubmit["cate_tpl"],
			"cate_content"   => $this->cateSubmit["cate_content"],
			"cate_link"      => $this->cateSubmit["cate_link"],
			"cate_parent_id" => $this->cateSubmit["cate_parent_id"],
			"cate_domain"    => $this->cateSubmit["cate_domain"],
			"cate_ftp_host"  => $this->cateSubmit["cate_ftp_host"],
			"cate_ftp_port"  => $this->cateSubmit["cate_ftp_port"],
			"cate_ftp_user"  => $this->cateSubmit["cate_ftp_user"],
			"cate_ftp_pass"  => $this->cateSubmit["cate_ftp_pass"],
			"cate_ftp_path"  => $this->cateSubmit["cate_ftp_path"],
		);

		if ($this->cateSubmit["cate_id"] == 0) { //插入
			$_num_cateId = $this->obj_db->insert(BG_DB_TABLE . "cate", $_arr_cateData);

			if ($_num_cateId > 0) { //数据库插入是否成功
				$_str_alert = "y110101";
			} else {
				return array(
					"str_alert" => "x110101",
				);
				exit;
			}

		} else {
			$_num_cateId = $this->cateSubmit["cate_id"];
			$_num_mysql  = $this->obj_db->update(BG_DB_TABLE . "cate", $_arr_cateData, "cate_id=" . $_num_cateId);

			if ($_num_mysql > 0) { //数据库更新是否成功
				$_str_alert = "y110103";
			} else {
				return array(
					"str_alert" => "x110103",
				);
				exit;
			}
		}

		return array(
			"cate_id"    => $_num_cateId,
			"str_alert"  => $_str_alert,
		);
	}


	/**
	 * mdl_order function.
	 *
	 * @access public
	 * @param string $str_orderType (default: "")
	 * @param int $num_doId (default: 0)
	 * @param int $num_targetId (default: 0)
	 * @return void
	 */
	function mdl_order($str_orderType = "", $num_doId = 0, $num_targetId = 0, $num_parentId = 0) {

		//处理重复排序号
		$_str_sqlDistinct = "SELECT cate_id FROM " . BG_DB_TABLE . "cate WHERE cate_order IN (SELECT cate_order FROM " . BG_DB_TABLE . "cate GROUP BY cate_order HAVING COUNT(cate_order) > 1) ORDER BY cate_id DESC" ;
		$_obj_reselt      = $this->obj_db->query($_str_sqlDistinct);
		$_arr_row         = $this->obj_db->fetch_assoc($_obj_reselt);

		if ($_arr_row) {
			$_arr_selectData = array(
				"cate_id",
			);

			$_arr_lastRows  = $this->obj_db->select_array(BG_DB_TABLE . "cate", $_arr_selectData, "cate_id > 0 ORDER BY cate_id DESC", 1, 0); //读取倒数第一排序号
			$_arr_lastRow   = $_arr_lastRows[0];

			$_arr_updateData = array(
				"cate_order" => $_arr_row["cate_id"] + 1,
			);

			$_str_sqlWhere = "cate_id=" . $_arr_row["cate_id"];

			$this->obj_db->update(BG_DB_TABLE . "cate", $_arr_updateData, $_str_sqlWhere, true); //所有小于本条大于目标记录的数据排序号加1
		}
		//end

		//
		$_arr_selectData = array(
			"cate_order",
		);

		switch ($str_orderType) {
			case "order_first":
				$_str_sqlWhere = "cate_id > 0";
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;
				}
				$_arr_firstRows = $this->obj_db->select_array(BG_DB_TABLE . "cate", $_arr_selectData, $_str_sqlWhere . " ORDER BY cate_order ASC", 1, 0); //读取第一排序号
				$_arr_firstRow  = $_arr_firstRows[0];

				$_str_sqlWhere  = "cate_id=" . $num_doId;
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;
				}
				$_arr_doRows    = $this->obj_db->select_array(BG_DB_TABLE . "cate", $_arr_selectData, $_str_sqlWhere, 1, 0); //读取本条排序号
				$_arr_doRow     = $_arr_doRows[0];

				$_arr_targetData = array(
					"cate_order" => "cate_order+1",
				);
				$_str_sqlWhere = "cate_order<" . $_arr_doRow["cate_order"];
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;
				}
				$this->obj_db->update(BG_DB_TABLE . "cate", $_arr_targetData, $_str_sqlWhere, true); //所有小于本条的数据排序号加1

				$_arr_doData = array(
					"cate_order" => $_arr_firstRow["cate_order"],
				);
				$_str_sqlWhere = "cate_id=" . $num_doId;
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;
				}
				$this->obj_db->update(BG_DB_TABLE . "cate", $_arr_doData, $_str_sqlWhere); //更新本条排序号为1
			break;

			case "order_last":
				$_str_sqlWhere = "cate_id > 0";
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;
				}
				$_arr_lastRows  = $this->obj_db->select_array(BG_DB_TABLE . "cate", $_arr_selectData, $_str_sqlWhere . " ORDER BY cate_order DESC", 1, 0); //读取倒数第一排序号
				$_arr_lastRow   = $_arr_lastRows[0];

				$_str_sqlWhere  = "cate_id=" . $num_doId;
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;
				}
				$_arr_doRows    = $this->obj_db->select_array(BG_DB_TABLE . "cate", $_arr_selectData, $_str_sqlWhere, 1, 0); //读取本条排序号
				$_arr_doRow     = $_arr_doRows[0];

				$_arr_targetData = array(
					"cate_order" => "cate_order-1",
				);
				$_str_sqlWhere = "cate_order>" . $_arr_doRow["cate_order"];
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;
				}
				$this->obj_db->update(BG_DB_TABLE . "cate", $_arr_targetData, $_str_sqlWhere, true); //所有大于本条的数据排序号减1

				$_arr_doData = array(
					"cate_order" => $_arr_lastRow["cate_order"],
				);
				$_str_sqlWhere = "cate_id=" . $num_doId;
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;
				}
				$this->obj_db->update(BG_DB_TABLE . "cate", $_arr_doData, $_str_sqlWhere); //更新本条排序号为最大
			break;

			case "order_after":
				$_str_sqlWhere = "cate_id=" . $num_targetId;
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;
				}
				$_arr_targetRows    = $this->obj_db->select_array(BG_DB_TABLE . "cate", $_arr_selectData, $_str_sqlWhere, 1, 0); //读取目标记录排序号
				$_arr_targetRow     = $_arr_targetRows[0];

				$_str_sqlWhere      = "cate_id=" . $num_doId;
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;
				}
				$_arr_doRows    = $this->obj_db->select_array(BG_DB_TABLE . "cate", $_arr_selectData, $_str_sqlWhere, 1, 0); //读取本条排序号
				$_arr_doRow     = $_arr_doRows[0];

				if ($_arr_targetRow["hall_order"] > $_arr_doRow["hall_order"]) { //往下移
					$_arr_targetData = array(
						"cate_order" => "cate_order-1",
					);
					$_str_sqlWhere = "cate_order>" . $_arr_doRow["cate_order"] . " AND cate_order<=" . $_arr_targetRow["cate_order"];
					if ($num_parentId > 0) {
						$_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;
					}
					$this->obj_db->update(BG_DB_TABLE . "cate", $_arr_targetData, $_str_sqlWhere, true); //所有大于本条小于目标记录的数据排序号减1

					$_arr_doData = array(
						"cate_order" => $_arr_targetRow["cate_order"],
					);
				} else {
					$_arr_targetData = array(
						"cate_order" => "cate_order+1",
					);
					$_str_sqlWhere = "cate_order<" . $_arr_doRow["cate_order"] . " AND cate_order>" . $_arr_targetRow["cate_order"];
					if ($num_parentId > 0) {
						$_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;
					}
					$this->obj_db->update(BG_DB_TABLE . "cate", $_arr_targetData, $_str_sqlWhere, true); //所有大于本条小于目标记录的数据排序号减1

					$_arr_doData = array(
						"cate_order" => $_arr_targetRow["cate_order"] + 1,
					);
				}

				$_str_sqlWhere = "cate_id=" . $num_doId;
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;
				}
				$this->obj_db->update(BG_DB_TABLE . "cate", $_arr_doData, $_str_sqlWhere); //更新本条排序号为目标记录排序号
			break;
		}

		return array(
			"str_alert" => "y110103",
		);
	}


	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $str_cate
	 * @param string $str_readBy (default: "cate_id")
	 * @param int $num_notThisId (default: 0)
	 * @param int $num_parentId (default: 0)
	 * @return void
	 */
	function mdl_read($str_cate, $str_readBy = "cate_id", $num_notThisId = 0, $num_parentId = 0) {
		$_arr_cateSelect = array(
			"cate_id",
			"cate_name",
			"cate_alias",
			"cate_type",
			"cate_tpl",
			"cate_content",
			"cate_link",
			"cate_parent_id",
			"cate_domain",
			"cate_ftp_host",
			"cate_ftp_port",
			"cate_ftp_user",
			"cate_ftp_pass",
			"cate_ftp_path",
			"cate_status",
		);

		switch ($str_readBy) {
			case "cate_id":
				$_str_sqlWhere = $str_readBy . "=" . $str_cate;
			break;
			default:
				$_str_sqlWhere = $str_readBy . "='" . $str_cate . "'";
			break;
		}

		if ($num_notThisId > 0) {
			$_str_sqlWhere .= " AND cate_id <> " . $num_notThisId;
		}

		if ($num_parentId > 0) {
			$_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;
		}

		$_arr_cateRows    = $this->obj_db->select_array(BG_DB_TABLE . "cate", $_arr_cateSelect, $_str_sqlWhere, 1, 0); //检查本地表是否存在记录
		$_arr_cateRow     = $_arr_cateRows[0];

		if (!$_arr_cateRow) {
			return array(
				"str_alert" => "x110102", //不存在记录
			);
			exit;
		}

		$_arr_cateRow["cate_trees"]   = $this->trees_process($_arr_cateRow["cate_id"]);
		unset($this->cateTrees);
		$_arr_cateRow["urlRow"]       = $this->url_process($_arr_cateRow);
		$_arr_cateRow["str_alert"]    = "y110102";

		return $_arr_cateRow;
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
	function mdl_list($num_no, $num_except = 0, $str_status = "", $str_type = "", $num_parentId = 0, $num_cateLevel = 1) {
		$_arr_updateData = array(
			"cate_order" => "cate_id",
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "cate", $_arr_updateData, "cate_order=0", true); //更新数据

		$_arr_cateSelect = array(
			"cate_id",
			"cate_name",
			"cate_link",
			"cate_alias",
			"cate_content",
			"cate_status",
			"cate_type",
			"cate_parent_id",
		);

		$_str_sqlWhere = "cate_id > 0";

		if ($str_status) {
			$_str_sqlWhere .= " AND cate_status='" . $str_status . "'";
		}

		if ($str_type) {
			$_str_sqlWhere .= " AND cate_type='" . $str_type . "'";
		}

		$_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;

		$_arr_cateRows = $this->obj_db->select_array(BG_DB_TABLE . "cate", $_arr_cateSelect, $_str_sqlWhere . " ORDER BY cate_order ASC, cate_id ASC", $num_no, $num_except);

		foreach ($_arr_cateRows as $_key=>$_value) {
			$_arr_cateRows[$_key]["cate_level"]  = $num_cateLevel;
			$_value["cate_trees"]                = $this->trees_process($_value["cate_id"]);
			unset($this->cateTrees);
			$_arr_cateRows[$_key]["urlRow"]      = $this->url_process($_value);
			$_arr_cateRows[$_key]["cate_childs"] = $this->mdl_list(1000, 0, $str_status, $str_type, $_value["cate_id"], $num_cateLevel + 1);
		}

		return $_arr_cateRows;
	}


	function mdl_cateIds($num_cateId) {
		$this->cateRows = $this->mdl_list(1000, 0, "show", "", $num_cateId);
		$this->cate_ids_process();
		return $this->cateIds;
	}


	/**
	 * mdl_status function.
	 *
	 * @access public
	 * @param mixed $this->cateIds["cate_ids"]
	 * @param mixed $str_status
	 * @return void
	 */
	function mdl_status($str_status) {
		$_str_cateId = implode(",", $this->cateIds["cate_ids"]);

		$_arr_cateData = array(
			"cate_status" => $str_status,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "cate", $_arr_cateData, "cate_id IN (" . $_str_cateId . ")"); //更新数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y110103";
		} else {
			$_str_alert = "x110103";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @return void
	 */
	function mdl_del() {
		$_str_cateId = implode(",", $this->cateIds["cate_ids"]);

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "cate", "cate_id IN (" . $_str_cateId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y110104";

			$_arr_cateData = array(
				"cate_parent_id" => 0
			);
			$this->obj_db->update(BG_DB_TABLE . "cate", $_arr_cateData, "cate_parent_id IN (" . $_str_cateId . ")"); //更新数据

			$_arr_articleData = array(
				"article_cate_id" => -1
			);
			$this->obj_db->update(BG_DB_TABLE . "article", $_arr_articleData, "article_cate_id IN (" . $_str_cateId . ")"); //更新数据

			$this->obj_db->delete(BG_DB_TABLE . "cate_belong", "belong_cate_id IN (" . $_str_cateId . ")"); //更新数据
		} else {
			$_str_alert = "x110104";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	function mdl_count($str_status = "", $str_type = "", $num_parentId = 0) {

		$_str_sqlWhere = "cate_id > 0";

		if ($str_status) {
			$_str_sqlWhere .= " AND cate_status='" . $str_status . "'";
		}

		if ($str_type) {
			$_str_sqlWhere .= " AND cate_type='" . $str_type . "'";
		}

		$_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;

		$_num_cateCount = $this->obj_db->count(BG_DB_TABLE . "cate", $_str_sqlWhere); //查询数据

		/*print_r($_arr_userRow);
		exit;*/

		return $_num_cateCount;
	}


	function input_submit() {
		if (!fn_token("chk")) { //令牌
			return array(
				"str_alert" => "x030102",
			);
			exit;
		}

		$this->cateSubmit["cate_id"] = fn_getSafe($_POST["cate_id"], "int", 0);

		if ($this->cateSubmit["cate_id"] > 0) {
			$_arr_cateRow = $this->mdl_read($this->cateSubmit["cate_id"]);
			if ($_arr_cateRow["str_alert"] != "y110102") {
				return $_arr_cateRow;
				exit;
			}
		}

		$_arr_cateName = validateStr($_POST["cate_name"], 1, 300);
		switch ($_arr_cateName["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x110201",
				);
				exit;
			break;

			case "too_long":
				return array(
					"str_alert" => "x110202",
				);
				exit;
			break;

			case "ok":
				$this->cateSubmit["cate_name"] = $_arr_cateName["str"];
			break;

		}

		$_arr_cateRow = $this->mdl_read($this->cateSubmit["cate_name"], "cate_name", $this->cateSubmit["cate_id"], $this->cateSubmit["cate_parent_id"]);

		if ($_arr_cateRow["str_alert"] == "y110102") {
			return array(
				"str_alert" => "x110203",
			);
			exit;
		}

		$_arr_cateAlias = validateStr($_POST["cate_alias"], 0, 300, "str", "alphabetDigit");
		switch ($_arr_cateAlias["status"]) {
			case "too_long":
				return array(
					"str_alert" => "x110204",
				);
				exit;
			break;

			case "format_err":
				return array(
					"str_alert" => "x110205",
				);
				exit;
			break;

			case "ok":
				$this->cateSubmit["cate_alias"] = $_arr_cateAlias["str"];
			break;
		}

		if ($this->cateSubmit["cate_alias"]) {
			$_arr_cateRow = $this->mdl_read($this->cateSubmit["cate_alias"], "cate_alias", $this->cateSubmit["cate_id"], $this->cateSubmit["cate_parent_id"]);
			if ($_arr_cateRow["str_alert"] == "y110102") {
				return array(
					"str_alert" => "x110206",
				);
				exit;
			}
		}

		$_arr_cateLink = validateStr($_POST["cate_link"], 0, 3000, "str", "url");
		switch ($_arr_cateLink["status"]) {
			case "too_long":
				return array(
					"str_alert" => "x110211",
				);
				exit;
			break;

			case "format_err":
				return array(
					"str_alert" => "x110212",
				);
				exit;
			break;

			case "ok":
				$this->cateSubmit["cate_link"] = $_arr_cateLink["str"];
			break;
		}

		$_arr_cateParentId = validateStr($_POST["cate_parent_id"], 1, 0);
		switch ($_arr_cateParentId["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x110213",
				);
				exit;
			break;

			case "ok":
				$this->cateSubmit["cate_parent_id"] = $_arr_cateParentId["str"];
			break;

		}

		$_arr_cateTpl = validateStr($_POST["cate_tpl"], 1, 0);
		switch ($_arr_cateTpl["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x110214",
				);
				exit;
			break;

			case "ok":
				$this->cateSubmit["cate_tpl"] = $_arr_cateTpl["str"];
			break;

		}

		$_arr_cateType = validateStr($_POST["cate_type"], 1, 0);
		switch ($_arr_cateType["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x110215",
				);
				exit;
			break;

			case "ok":
				$this->cateSubmit["cate_type"] = $_arr_cateType["str"];
			break;

		}

		$_arr_cateStatus = validateStr($_POST["cate_status"], 1, 0);
		switch ($_arr_cateStatus["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x110216",
				);
				exit;
			break;

			case "ok":
				$this->cateSubmit["cate_status"] = $_arr_cateStatus["str"];
			break;

		}

		$_arr_cateDomain = validateStr($_POST["cate_domain"], 0, 3000, "str", "url");
		switch ($_arr_cateDomain["status"]) {
			case "too_long":
				return array(
					"str_alert" => "x110207",
				);
				exit;
			break;

			case "format_err":
				return array(
					"str_alert" => "x110208",
				);
				exit;
			break;

			case "ok":
				$this->cateSubmit["cate_domain"] = $_arr_cateDomain["str"];
			break;
		}

		$this->cateSubmit["cate_content"]     = $_POST["cate_content"];

		$this->cateSubmit["cate_ftp_host"]    = fn_getSafe($_POST["cate_ftp_host"], "txt", "");
		$this->cateSubmit["cate_ftp_port"]    = fn_getSafe($_POST["cate_ftp_port"], "txt", "");
		$this->cateSubmit["cate_ftp_user"]    = fn_getSafe($_POST["cate_ftp_user"], "txt", "");
		$this->cateSubmit["cate_ftp_pass"]    = fn_getSafe($_POST["cate_ftp_pass"], "txt", "");
		$this->cateSubmit["cate_ftp_path"]    = fn_getSafe($_POST["cate_ftp_path"], "txt", "");

		$this->cateSubmit["str_alert"] = "ok";

		return $this->cateSubmit;
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

		$_arr_cateIds = $_POST["cate_id"];

		if ($_arr_cateIds) {
			foreach ($_arr_cateIds as $_key=>$_value) {
				$_arr_cateIds[$_key] = fn_getSafe($_value, "int", 0);
			}
			$_str_alert = "ok";
		} else {
			$_str_alert = "none";
		}

		$this->cateIds = array(
			"str_alert"   => $_str_alert,
			"cate_ids"    => $_arr_cateIds
		);

		return $this->cateIds;
	}


	private function db_read($_num_cateId) {
		$_arr_cateSelect = array(
			"cate_id",
			"cate_name",
			"cate_alias",
			"cate_type",
			"cate_tpl",
			"cate_content",
			"cate_link",
			"cate_parent_id",
			"cate_domain",
			"cate_ftp_host",
			"cate_ftp_port",
			"cate_ftp_user",
			"cate_ftp_pass",
			"cate_ftp_path",
			"cate_status",
		);

		$_str_sqlWhere    = "cate_id=" . $_num_cateId;

		$_arr_cateRows    = $this->obj_db->select_array(BG_DB_TABLE . "cate", $_arr_cateSelect, $_str_sqlWhere, 1, 0); //检查本地表是否存在记录
		$_arr_cateRow     = $_arr_cateRows[0];

		if (!$_arr_cateRow) {
			return array(
				"str_alert" => "x110102", //不存在记录
			);
			exit;
		}

		$_arr_cateRow["str_alert"]    = "y110102";

		return $_arr_cateRow;
	}


	private function cate_ids_process() {
		foreach ($this->cateRows as $_value) {
			if ($_value["cate_childs"]) {
				$_arr_cate      = $this->cate_ids_process($_value["cate_childs"]);
				$this->cateIds  = array_merge($_arr_cate, $this->cateIds);
			}
			if ($_value["cate_id"] > 0) {
				$this->cateIds[] = $_value["cate_id"];
			}
		}
	}


	private function url_process($_arr_cateRow) {
		if ($_arr_cateRow["cate_link"]) {
			$_str_cateUrl = $_arr_cateRow["cate_link"];
		} else {
			/*if ($_arr_cateRow["cate_domain"]) {
				$_str_urlPrefix = $_arr_cateRow["cate_domain"];
			} else {
				$_str_urlPrefix = BG_URL_ROOT;
			}*/
			switch (BG_VISIT_TYPE) {
				case "static":
					foreach ($_arr_cateRow["cate_trees"] as $_tree_value) {
						if ($_tree_value["cate_alias"]) {
							$_str_cateUrlParent .= $_tree_value["cate_alias"] . "/";
						} else {
							$_str_cateUrlParent .= $_tree_value["cate_name"] . "/";
						}
					}

					$_str_cateUrl      = BG_URL_ROOT . "cate/" . $_str_cateUrlParent;
					$_str_pageAttach   = "page_";
				break;

				case "pstatic":
					foreach ($_arr_cateRow["cate_trees"] as $_tree_value) {
						if ($_tree_value["cate_alias"]) {
							$_str_cateUrlParent .= $_tree_value["cate_alias"] . "/";
						} else {
							$_str_cateUrlParent .= $_tree_value["cate_name"] . "/";
						}
					}

					$_str_cateUrl = BG_URL_ROOT . "cate/" . $_str_cateUrlParent . $_arr_cateRow["cate_id"] . "/";
				break;

				default:
					$_str_cateUrl      = BG_URL_ROOT . "index.php?mod=cate&act_get=show&cate_id=" . $_arr_cateRow["cate_id"];
					$_str_pageAttach   = "&page=";
				break;
			}
		}

		return array(
			"cate_url"       => $_str_cateUrl,
			"page_attach"    => $_str_pageAttach,
		);
	}


	private function trees_process($_num_cateId) {
		$_arr_cateRow         = $this->db_read($_num_cateId);
		$this->cateTrees[]    = $_arr_cateRow;

		if ($_arr_cateRow["cate_parent_id"] > 0) {
			$this->trees_process($_arr_cateRow["cate_parent_id"]);
		}

		krsort($this->cateTrees);
		return $this->cateTrees;
	}
}
?>