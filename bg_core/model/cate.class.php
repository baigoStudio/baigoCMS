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


	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $num_cateId
	 * @param mixed $str_cateName
	 * @param mixed $str_cateType
	 * @param mixed $str_cateStatus
	 * @param mixed $str_tpl
	 * @param string $str_cateAlias (default: "")
	 * @param string $str_cateContent (default: "")
	 * @param string $str_cateLink (default: "")
	 * @param int $num_parentId (default: 0)
	 * @param string $str_cateDomain (default: "")
	 * @param string $str_cateFtpHost (default: "")
	 * @param string $str_cateFtpPort (default: "")
	 * @param string $str_cateFtpUser (default: "")
	 * @param string $str_cateFtpPass (default: "")
	 * @param string $str_cateFtpPath (default: "")
	 * @return void
	 */
	function mdl_submit($num_cateId, $str_cateName, $str_cateType, $str_cateStatus, $str_tpl, $str_cateAlias = "", $str_cateContent = "", $str_cateLink = "", $num_parentId = 0, $str_cateDomain = "", $str_cateFtpHost = "", $str_cateFtpPort = "", $str_cateFtpUser = "", $str_cateFtpPass = "", $str_cateFtpPath = "") {

		$_arr_cateData = array(
			"cate_name"      => $str_cateName,
			"cate_alias"     => $str_cateAlias,
			"cate_type"      => $str_cateType,
			"cate_status"    => $str_cateStatus,
			"cate_tpl"       => $str_tpl,
			"cate_content"   => $str_cateContent,
			"cate_link"      => $str_cateLink,
			"cate_parent_id" => $num_parentId,
			"cate_domain"    => $str_cateDomain,
			"cate_ftp_host"  => $str_cateFtpHost,
			"cate_ftp_port"  => $str_cateFtpPort,
			"cate_ftp_user"  => $str_cateFtpUser,
			"cate_ftp_pass"  => $str_cateFtpPass,
			"cate_ftp_path"  => $str_cateFtpPath,
		);

		if ($num_cateId == 0) { //插入
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
			$_num_cateId = $num_cateId;

			$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "cate", $_arr_cateData, "cate_id=" . $_num_cateId);

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

			case "order_before":
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

				$_arr_targetData = array(
					"cate_order" => "cate_order+1",
				);
				$_str_sqlWhere = "cate_order<" . $_arr_doRow["cate_order"] . " AND cate_order>=" . $_arr_targetRow["cate_order"];
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;
				}
				$this->obj_db->update(BG_DB_TABLE . "cate", $_arr_targetData, $_str_sqlWhere, true); //所有小于本条大于目标记录的数据排序号加1

				$_arr_doData = array(
					"cate_order" => $_arr_targetRow["cate_order"],
				);
				$_str_sqlWhere = "cate_id=" . $num_doId;
				if ($num_parentId > 0) {
					$_str_sqlWhere .= " AND cate_parent_id=" . $num_parentId;
				}
				$this->obj_db->update(BG_DB_TABLE . "cate", $_arr_doData, $_str_sqlWhere); //更新本条排序号为目标记录排序号
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

		$_arr_cateRows = $this->obj_db->select_array(BG_DB_TABLE . "cate", $_arr_cateSelect, $_str_sqlWhere, 1, 0); //检查本地表是否存在记录
		$_arr_cateRow = $_arr_cateRows[0];

		if (!$_arr_cateRow) {
			return array(
				"str_alert" => "x110102", //不存在记录
			);
			exit;
		}

		$_arr_cateRow["str_alert"] = "y110102";

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
	function mdl_list($num_no, $num_except = 0, $str_status = "", $str_type = "", $num_parentId = 0, $num_cateLevel = 0) {
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
			$_arr_cateRows[$_key]["cate_level"] = $num_cateLevel;
			$_arr_cateRows[$_key]["cate_childs"] = $this->mdl_list(1000, 0, $str_status, $str_type, $_value["cate_id"], $num_cateLevel + 1);
		}

		return $_arr_cateRows;
	}


	/**
	 * mdl_status function.
	 *
	 * @access public
	 * @param mixed $arr_cateIds
	 * @param mixed $str_status
	 * @return void
	 */
	function mdl_status($arr_cateIds, $str_status) {
		$_str_cateId = implode(",", $arr_cateIds);

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
	 * @param mixed $arr_cateIds
	 * @return void
	 */
	function mdl_del($arr_cateIds) {
		$_str_cateId = implode(",", $arr_cateIds);

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
}
?>