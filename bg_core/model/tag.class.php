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
class MODEL_TAG {

	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}


	function mdl_create() {
		$_arr_tagCreat = array(
			"tag_id"             => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"tag_name"           => "varchar(30) NOT NULL COMMENT '标题'",
			"tag_status"         => "varchar(20) NOT NULL COMMENT '状态'",
			"tag_article_count"  => "int(11) NOT NULL COMMENT '标签统计'",
		);

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "tag", $_arr_tagCreat, "tag_id", "标签");

		if ($_num_mysql > 0) {
			$_str_alert = "y130105"; //更新成功
		} else {
			$_str_alert = "x130105"; //更新成功
		}

		return array(
			"str_alert" => $_str_alert, //更新成功
		);
	}


	function mdl_column() {
		$_arr_colSelect = array(
			"column_name"
		);

		$_str_sqlWhere = "table_schema='" . BG_DB_NAME . "' AND table_name='" . BG_DB_TABLE . "tag'";

		$_arr_colRows = $this->obj_db->select_array("information_schema`.`columns", $_arr_colSelect, $_str_sqlWhere, 100, 0);

		foreach ($_arr_colRows as $_key=>$_value) {
			$_arr_col[] = $_value["column_name"];
		}

		return $_arr_col;
	}


	/**
	 * mdl_submit function.
	 *
	 * @access public
	 * @param mixed $num_tagId
	 * @param mixed $str_tagName
	 * @param mixed $str_tagType
	 * @param mixed $str_tagStatus
	 * @return void
	 */
	function mdl_submit($_str_tagName, $_str_tagStatus) {
		$_arr_tagData = array(
			"tag_name"   => $_str_tagName,
			"tag_status" => $_str_tagStatus,
		);

		if ($this->tagSubmit["tag_id"] == 0) {
			$_num_tagId = $this->obj_db->insert(BG_DB_TABLE . "tag", $_arr_tagData);

			if ($_num_tagId > 0) { //数据库插入是否成功
				$_str_alert = "y130101";
			} else {
				return array(
					"str_alert" => "x130101",
				);
				exit;
			}
		} else {
			$_num_tagId = $this->tagSubmit["tag_id"];
			$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "tag", $_arr_tagData, "tag_id=" . $_num_tagId);

			if ($_num_mysql > 0) {
				$_str_alert = "y130103";
			} else {
				return array(
					"str_alert" => "x130103",
				);
				exit;
			}
		}

		return array(
			"tag_id"     => $_num_tagId,
			"str_alert"  => $_str_alert,
		);
	}


	/**
	 * mdl_countDo function.
	 *
	 * @access public
	 * @param mixed $num_tagId
	 * @param int $num_articleCount (default: 0)
	 * @return void
	 */
	function mdl_countDo($num_tagId, $num_articleCount = 0) {
		$_arr_tagData = array(
			"tag_article_count" => $num_articleCount,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "tag", $_arr_tagData, "tag_id=" . $num_tagId);

		if ($_num_mysql > 0) {
			$_str_alert = "y130103";
		} else {
			return array(
				"str_alert" => "x130103",
			);
			exit;
		}

		return array(
			"tag_id"     => $_num_tagId,
			"str_alert"  => $_str_alert,
		);
	}


	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $str_tag
	 * @param string $str_readBy (default: "tag_id")
	 * @param int $num_notThisId (default: 0)
	 * @param int $num_parentId (default: 0)
	 * @return void
	 */
	function mdl_read($str_tag, $str_readBy = "tag_id", $num_notId = 0) {
		$_arr_tagSelect = array(
			"tag_id",
			"tag_name",
			"tag_status",
		);

		switch ($str_readBy) {
			case "tag_id":
				$_str_sqlWhere = $str_readBy . "=" . $str_tag;
			break;
			default:
				$_str_sqlWhere = $str_readBy . "='" . $str_tag . "'";
			break;
		}

		if ($num_notId > 0) {
			$_str_sqlWhere .= " AND tag_id<>" . $num_notId;
		}

		$_arr_tagRows = $this->obj_db->select_array(BG_DB_TABLE . "tag",  $_arr_tagSelect, $_str_sqlWhere, 1, 0); //检查本地表是否存在记录
		$_arr_tagRow  = $_arr_tagRows[0];

		if (!$_arr_tagRow) {
			return array(
				"str_alert" => "x130102", //不存在记录
			);
			exit;
		}

		$_arr_tagRow["urlRow"]    = $this->url_process($_arr_tagRow);
		$_arr_tagRow["str_alert"] = "y130102";

		return $_arr_tagRow;
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
		$_arr_tagSelect = array(
			"tag_id",
			"tag_name",
			"tag_article_count",
			"tag_status",
		);

		$_str_sqlWhere = "tag_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND tag_name LIKE '%" . $str_key . "%'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND tag_status='" . $str_status . "'";
		}

		$_arr_tagRows = $this->obj_db->select_array(BG_DB_TABLE . "tag",  $_arr_tagSelect, $_str_sqlWhere . " ORDER BY tag_id DESC", $num_no, $num_except);

		foreach ($_arr_tagRows as $_key=>$_value) {
			$_arr_tagRows[$_key]["urlRow"] = $this->url_process($_arr_tagRow);
		}

		return $_arr_tagRows;
	}


	/**
	 * mdl_status function.
	 *
	 * @access public
	 * @param mixed $this->tagIds["tag_ids"]
	 * @param mixed $str_status
	 * @return void
	 */
	function mdl_status($str_status) {
		$_str_tagId = implode(",", $this->tagIds["tag_ids"]);

		$_arr_tagData = array(
			"tag_status" => $str_status,
		);

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "tag",  $_arr_tagData, "tag_id IN (" . $_str_tagId . ")"); //更新数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y130103";
		} else {
			$_str_alert = "x130103";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @param mixed $this->tagIds["tag_ids"]
	 * @return void
	 */
	function mdl_del() {
		$_str_tagId = implode(",", $this->tagIds["tag_ids"]);

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "tag",  "tag_id IN (" . $_str_tagId . ")"); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y130104";
			$this->obj_db->delete(BG_DB_TABLE . "tag_belong", "belong_tag_id IN (" . $_str_tagId . ")"); //更新数据
		} else {
			$_str_alert = "x130104";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	function mdl_count($str_key = "", $str_status = "") {

		$_str_sqlWhere = "tag_id > 0";

		if ($str_key) {
			$_str_sqlWhere .= " AND tag_name LIKE '%" . $str_key . "%'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND tag_status='" . $str_status . "'";
		}

		$_num_tagCount = $this->obj_db->count(BG_DB_TABLE . "tag", $_str_sqlWhere); //查询数据

		/*print_r($_arr_userRow);
		exit;*/

		return $_num_tagCount;
	}


	function input_submit() {
		if (!fn_token("chk")) { //令牌
			return array(
				"str_alert" => "x030102",
			);
			exit;
		}

		$this->tagSubmit["tag_id"] = fn_getSafe($_POST["tag_id"], "int", 0);

		if ($this->tagSubmit["tag_id"] > 0) {
			$_arr_tagRow = $this->mdl_read($this->tagSubmit["tag_id"]);
			if ($_arr_tagRow["str_alert"] != "y130102") {
				return $_arr_tagRow;
				exit;
			}
		}

		$_arr_tagName = validateStr($_POST["tag_name"], 1, 30);
		switch ($_arr_tagName["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x130201",
				);
				exit;
			break;

			case "too_long":
				return array(
					"str_alert" => "x130202",
				);
				exit;
			break;

			case "ok":
				$this->tagSubmit["tag_name"] = $_arr_tagName["str"];
			break;
		}

		$_arr_tagRow = $this->mdl_read($this->tagSubmit["tag_name"], "tag_name", $this->tagSubmit["tag_id"]);
		if ($_arr_tagRow["str_alert"] == "y130102") {
			return array(
				"str_alert" => "x130203",
			);
			exit;
		}

		$_arr_tagStatus = validateStr($_POST["tag_status"], 1, 0);
		switch ($_arr_tagStatus["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x130204",
				);
				exit;
			break;

			case "ok":
				$this->tagSubmit["tag_status"] = $_arr_tagStatus["str"];
			break;
		}

		$this->tagSubmit["str_alert"] = "ok";
		return $this->tagSubmit;
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

		$_arr_tagIds = $_POST["tag_id"];

		if ($_arr_tagIds) {
			foreach ($_arr_tagIds as $_key=>$_value) {
				$_arr_tagIds[$_key] = fn_getSafe($_value, "int", 0);
			}
			$_str_alert = "ok";
		} else {
			$_str_alert = "none";
		}

		$this->tagIds = array(
			"str_alert"  => $_str_alert,
			"tag_ids"    => $_arr_tagIds
		);

		return $this->tagIds;
	}


	private function url_process($_arr_tagRow) {
		switch (BG_VISIT_TYPE) {
			case "static":
				$_str_tagUrl        = BG_URL_ROOT . "tag/" . $_arr_tagRow["tag_name"] . "/";
				$_str_pageAttach    = "page_";
			break;

			case "pstatic":
				$_str_tagUrl = BG_URL_ROOT . "tag/" . $_arr_tagRow["tag_name"] . "/";
			break;

			default:
				$_str_tagUrl        = BG_URL_ROOT . "index.php?mod=tag&act_get=show&tag_name=" . $_arr_tagRow["tag_name"];
				$_str_pageAttach    = "&page=";
			break;
		}

		return array(
			"tag_url"       => $_str_tagUrl,
			"page_attach"   => $_str_pageAttach,
		);
	}
}
?>