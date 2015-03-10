<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------文章类-------------*/
class MODEL_ARTICLE {

	private $obj_db;

	function __construct() { //构造函数
		$this->obj_db = $GLOBALS["obj_db"]; //设置数据库对象
	}

	function mdl_create_table() {
		$_arr_articleCreat = array(
			"article_id"         => "int NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"article_cate_id"    => "smallint NOT NULL COMMENT '栏目ID'",
			"article_title"      => "varchar(300) NOT NULL COMMENT '标题'",
			"article_excerpt"    => "varchar(900) NOT NULL COMMENT '内容提要'",
			"article_status"     => "enum('pub','wait','hide') NOT NULL COMMENT '状态'",
			"article_box"        => "enum('normal','draft','recycle') NOT NULL COMMENT '盒子'",
			"article_mark_id"    => "smallint NOT NULL COMMENT '标记 ID'",
			"article_spec_id"    => "mediumint NOT NULL COMMENT '专题ID'",
			"article_link"       => "varchar(900) NOT NULL COMMENT '链接'",
			"article_time"       => "int NOT NULL COMMENT '时间'",
			"article_time_pub"   => "int NOT NULL COMMENT '定时发布'",
			"article_admin_id"   => "smallint NOT NULL COMMENT '发布用户'",
			"article_hits_day"   => "mediumint NOT NULL COMMENT '日点击'",
			"article_hits_week"  => "mediumint NOT NULL COMMENT '周点击'",
			"article_hits_month" => "mediumint NOT NULL COMMENT '月点击'",
			"article_hits_year"  => "mediumint NOT NULL COMMENT '年点击'",
			"article_hits_all"   => "int NOT NULL COMMENT '总点击'",
			"article_time_day"   => "int NOT NULL COMMENT '日点击重置时间'",
			"article_time_week"  => "int NOT NULL COMMENT '周点击重置时间'",
			"article_time_month" => "int NOT NULL COMMENT '月点击重置时间'",
			"article_time_year"  => "int NOT NULL COMMENT '年点击重置时间'",
			"article_top"        => "tinyint NOT NULL COMMENT '置顶'",
			"article_attach_id"  => "int NOT NULL COMMENT '附件ID'",
		);

		$_num_mysql = $this->obj_db->create_table(BG_DB_TABLE . "article", $_arr_articleCreat, "article_id", "文章");

		if ($_num_mysql > 0) {
			$_str_alert = "y120105"; //更新成功
		} else {
			$_str_alert = "x120105"; //更新成功
		}

		return array(
			"str_alert" => $_str_alert, //更新成功
		);
	}


	function mdl_create_index() {
		$_str_alert = "y120109";
		$_arr_indexRow    = $this->obj_db->show_index(BG_DB_TABLE . "article");

		$is_exists        = false;
		foreach ($_arr_indexRow as $_key=>$_value) {
			if (in_array("order_top", $_value)) {
				$is_exists = true;
				break;
			}
		}

		$_arr_articleIndex = array(
			"article_top",
			"article_time_pub",
		);

		$_num_mysql = $this->obj_db->create_index("order_top", BG_DB_TABLE . "article", $_arr_articleIndex, "BTREE", $is_exists);

		if ($_num_mysql <= 0) {
			$_str_alert = "x120109";
		}

		$is_exists        = false;
		foreach ($_arr_indexRow as $_key=>$_value) {
			if (in_array("order_day", $_value)) {
				$is_exists = true;
				break;
			}
		}

		$_arr_articleIndex = array(
			"article_hits_day",
			"article_time_pub",
		);

		$_num_mysql = $this->obj_db->create_index("order_day", BG_DB_TABLE . "article", $_arr_articleIndex, "BTREE", $is_exists);

		if ($_num_mysql <= 0) {
			$_str_alert = "x120109";
		}

		$is_exists        = false;
		foreach ($_arr_indexRow as $_key=>$_value) {
			if (in_array("order_week", $_value)) {
				$is_exists = true;
				break;
			}
		}

		$_arr_articleIndex = array(
			"article_hits_week",
			"article_time_pub",
		);

		$_num_mysql = $this->obj_db->create_index("order_week", BG_DB_TABLE . "article", $_arr_articleIndex, "BTREE", $is_exists);

		if ($_num_mysql <= 0) {
			$_str_alert = "x120109";
		}

		$is_exists        = false;
		foreach ($_arr_indexRow as $_key=>$_value) {
			if (in_array("order_month", $_value)) {
				$is_exists = true;
				break;
			}
		}

		$_arr_articleIndex = array(
			"article_hits_month",
			"article_time_pub",
		);

		$_num_mysql = $this->obj_db->create_index("order_month", BG_DB_TABLE . "article", $_arr_articleIndex, "BTREE", $is_exists);

		if ($_num_mysql <= 0) {
			$_str_alert = "x120109";
		}

		$is_exists        = false;
		foreach ($_arr_indexRow as $_key=>$_value) {
			if (in_array("order_year", $_value)) {
				$is_exists = true;
				break;
			}
		}

		$_arr_articleIndex = array(
			"article_hits_year",
			"article_time_pub",
		);

		$_num_mysql = $this->obj_db->create_index("order_year", BG_DB_TABLE . "article", $_arr_articleIndex, "BTREE", $is_exists);

		if ($_num_mysql <= 0) {
			$_str_alert = "x120109";
		}

		$is_exists        = false;
		foreach ($_arr_indexRow as $_key=>$_value) {
			if (in_array("order_all", $_value)) {
				$is_exists = true;
				break;
			}
		}

		$_arr_articleIndex = array(
			"article_hits_all",
			"article_time_pub",
		);

		$_num_mysql = $this->obj_db->create_index("order_all", BG_DB_TABLE . "article", $_arr_articleIndex, "BTREE", $is_exists);

		if ($_num_mysql <= 0) {
			$_str_alert = "x120109";
		}

		return array(
			"str_alert" => $_str_alert, //更新成功
		);
	}


	function mdl_copy_table() {
		$_arr_articleCreat = array(
			"article_id"         => "int NOT NULL AUTO_INCREMENT COMMENT 'ID'",
			"article_content"    => "text NOT NULL COMMENT '内容'",
		);

		$_num_mysql = $this->obj_db->copy_table(BG_DB_TABLE . "article_content", BG_DB_TABLE . "article", $_arr_articleCreat, "article_id", "文章内容");

		if ($_num_mysql > 0) {
			$_str_alert = "y120105"; //更新成功
		} else {
			$_str_alert = "x120105"; //更新成功
		}

		return array(
			"str_alert" => $_str_alert, //更新成功
		);
	}


	function mdl_column() {
		$_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . "article");

		foreach ($_arr_colRows as $_key=>$_value) {
			$_arr_col[] = $_value["Field"];
		}

		return $_arr_col;
	}


	function mdl_submit($num_adminId = 0) {

		$_arr_articleData = array(
			"article_title"      => $this->articleSubmit["article_title"],
			"article_excerpt"    => $this->articleSubmit["article_excerpt"],
			"article_cate_id"    => $this->articleSubmit["article_cate_id"],
			"article_mark_id"    => $this->articleSubmit["article_mark_id"],
			"article_status"     => $this->articleSubmit["article_status"],
			"article_box"        => $this->articleSubmit["article_box"],
			"article_link"       => $this->articleSubmit["article_link"],
			"article_time_pub"   => $this->articleSubmit["article_time_pub"],
			"article_attach_id"  => $this->articleSubmit["article_attach_id"],
			"article_spec_id"    => $this->articleSubmit["article_spec_id"],
		);

		//print_r($_arr_articleData);

		if ($this->articleSubmit["article_id"] == 0) {
			$_arr_articleData["article_admin_id"]    = $num_adminId;
			$_arr_articleData["article_time"]        = time();

			$_num_articleId = $this->obj_db->insert(BG_DB_TABLE . "article", $_arr_articleData); //插入数据

			if ($_num_articleId > 0) {
				$_arr_contentData = array(
					"article_id"       => $_num_articleId,
					"article_content"  => $this->articleSubmit["article_content"],
				);
				$_num_articleId = $this->obj_db->insert(BG_DB_TABLE . "article_content", $_arr_contentData); //插入数据
				$_str_alert     = "y120101";
			} else {
				return array(
					"str_alert" => "x120101", //失败
				);
				exit;
			}
		} else {
			$_num_articleId  = $this->articleSubmit["article_id"];
			$_num_mysql      = $this->obj_db->update(BG_DB_TABLE . "article", $_arr_articleData, "article_id=" . $_num_articleId); //更新数据

			if ($_num_mysql > 0) {
				$_arr_contentData = array(
					"article_content"  => $this->articleSubmit["article_content"],
				);
				$_num_mysql      = $this->obj_db->update(BG_DB_TABLE . "article_content", $_arr_contentData, "article_id=" . $_num_articleId); //更新数据
				$_str_alert = "y120103";
			} else {
				return array(
					"article_id"   => $_num_articleId,
					"str_alert"    => "x120103", //失败
				);
				exit;
			}
		}

		/*print_r($_arr_userRow);
		exit;*/

		return array(
			"article_id" => $_num_articleId,
			"str_alert"  => $_str_alert,
		);
	}


	function mdl_list($num_no, $num_except = 0, $str_key = "", $str_year = "", $str_month = "", $str_status = "", $str_box = "", $arr_cateIds = false, $num_markId = 0, $num_specId = 0, $num_adminId = 0, $not_specId = 0) {
		$_arr_articleSelect = array(
			"article_id",
			"article_cate_id",
			"article_title",
			"article_excerpt",
			"article_status",
			"article_box",
			"article_link",
			"article_admin_id",
			"article_mark_id",
			"article_spec_id",
			"article_hits_day",
			"article_hits_week",
			"article_hits_month",
			"article_hits_year",
			"article_hits_all",
			"article_time",
			"article_time_pub",
			"article_top",
		);

		$_str_sqlWhere = "1=1";

		if ($str_key) {
			$_str_sqlWhere .= " AND (article_title LIKE '%" . $str_key . "%' OR article_content like '%" . $str_key . "%')";
		}

		if ($str_year) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(article_time_pub, '%Y')='" . $str_year . "'";
		}

		if ($str_month) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(article_time_pub, '%m')='" . $str_month . "'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND article_status='" . $str_status . "'";
		}

		if ($str_box) {
			$_str_sqlWhere .= " AND article_box='" . $str_box . "'";
		} else {
			$_str_sqlWhere .= " AND article_box='normal'";
		}

		if ($arr_cateIds) {
			$_str_cateIds = implode(",", $arr_cateIds);
			$_str_sqlWhere .= " AND  article_cate_id IN (" . $_str_cateIds . ")";
		}

		if ($num_markId > 0) {
			$_str_sqlWhere .= " AND article_mark_id=" . $num_markId;
		}

		if ($num_specId > 0) {
			$_str_sqlWhere .= " AND article_spec_id=" . $num_specId;
		}

		if ($not_specId > 0) {
			$_str_sqlWhere .= " AND article_spec_id<>" . $not_specId;
		}

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND article_admin_id=" . $num_adminId;
		}

		$_arr_articleRows = $this->obj_db->select_array(BG_DB_TABLE . "article", $_arr_articleSelect, $_str_sqlWhere . " ORDER BY article_top DESC, article_time_pub DESC", $num_no, $num_except);

		return $_arr_articleRows;
	}


	/**
	 * mdl_read function.
	 *
	 * @access public
	 * @param mixed $num_articleId
	 * @return void
	 */
	function mdl_read($num_articleId) {
		$_arr_articleSelect = array(
			"article_id",
			"article_cate_id",
			"article_mark_id",
			"article_title",
			"article_excerpt",
			"article_status",
			"article_box",
			"article_link",
			"article_admin_id",
			"article_hits_day",
			"article_time_day",
			"article_hits_week",
			"article_time_week",
			"article_hits_month",
			"article_time_month",
			"article_hits_year",
			"article_time_year",
			"article_hits_all",
			"article_time",
			"article_time_pub",
			"article_top",
			"article_spec_id",
		);

		$_arr_articleRows = $this->obj_db->select_array(BG_DB_TABLE . "article", $_arr_articleSelect, "article_id=" . $num_articleId, 1, 0); //读取数据

		if (isset($_arr_articleRows[0])) {
			$_arr_articleRow = $_arr_articleRows[0];
		} else {
			return array(
				"str_alert" => "x120102",
			);
		}

		$_arr_articleSelect = array(
			"article_content",
		);

		$_arr_contentRows = $this->obj_db->select_array(BG_DB_TABLE . "article_content", $_arr_articleSelect, "article_id=" . $num_articleId, 1, 0); //读取数据

		if (isset($_arr_contentRows[0])) {
			$_arr_contentRow = $_arr_contentRows[0];
		} else {
			return array(
				"str_alert" => "x120102",
			);
		}

		$_arr_articleRow["article_content"]   = $_arr_contentRow["article_content"];
		$_arr_articleRow["str_alert"]         = "y120102";

		return $_arr_articleRow;
	}


	/**
	 * mdl_top function.
	 *
	 * @access public
	 * @param mixed $this->articleIds["article_ids"]
	 * @param mixed $num_top
	 * @param bool $arr_cateIds (default: false)
	 * @return void
	 */
	function mdl_top($num_top, $arr_cateIds = false) {

		$_arr_articleUpdate = array(
			"article_top" => $num_top,
		);

		$_str_articleId   = implode(",", $this->articleIds["article_ids"]);
		$_str_sqlWhere    = "article_id IN (" . $_str_articleId . ")";

		if ($arr_cateIds) {
			$_str_cateIds    = implode(",", $arr_cateIds);
			$_str_sqlWhere   .= " AND article_cate_id IN (" . $_str_cateIds . ")";
		}

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "article", $_arr_articleUpdate, $_str_sqlWhere); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y120103";
		} else {
			$_str_alert = "x120103";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	/**
	 * mdl_status function.
	 *
	 * @access public
	 * @param mixed $str_status
	 * @param bool $arr_cateIds (default: false)
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_status($str_status, $arr_cateIds = false, $num_adminId = 0) {


		$_arr_articleUpdate = array(
			"article_status" => $str_status,
		);

		$_str_articleId   = implode(",", $this->articleIds["article_ids"]);
		$_str_sqlWhere    = "article_id IN (" . $_str_articleId . ")";

		if ($arr_cateIds) {
			$_str_cateIds    = implode(",", $arr_cateIds);
			$_str_sqlWhere  .= " AND article_cate_id IN (" . $_str_cateIds . ")";
		}

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND article_admin_id=" . $num_adminId;
		}

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "article", $_arr_articleUpdate, $_str_sqlWhere); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y120103";
		} else {
			$_str_alert = "x120103";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	function mdl_toSpec($str_act, $num_specId = 0) {

		if ($str_act != "to") {
			$num_specId = 0;
		}

		$_arr_articleUpdate = array(
			"article_spec_id" => $num_specId,
		);

		$_str_articleId   = implode(",", $this->articleIds["article_ids"]);
		$_str_sqlWhere    = "article_id IN (" . $_str_articleId . ")";

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "article", $_arr_articleUpdate, $_str_sqlWhere); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y120103";
		} else {
			$_str_alert = "x120103";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	/**
	 * mdl_box function.
	 *
	 * @access public
	 * @param mixed $str_box
	 * @param bool $arr_cateIds (default: false)
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_box($str_box, $arr_cateIds = false, $num_adminId = 0) {

		$_arr_articleUpdate = array(
			"article_box"        => $str_box,
		);

		$_str_articleId   = implode(",", $this->articleIds["article_ids"]);
		$_str_sqlWhere    = "article_id IN (" . $_str_articleId . ")";

		if ($arr_cateIds) {
			$_str_cateIds    = implode(",", $arr_cateIds);
			$_str_sqlWhere  .= " AND article_cate_id IN (" . $_str_cateIds . ")";
		}

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND article_admin_id=" . $num_adminId;
		}

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "article", $_arr_articleUpdate, $_str_sqlWhere); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y120103";
		} else {
			$_str_alert = "x120103";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	/**
	 * mdl_del function.
	 *
	 * @access public
	 * @param bool $arr_cateIds (default: false)
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_del($arr_cateIds = false, $num_adminId = 0) {

		$_str_articleId   = implode(",", $this->articleIds["article_ids"]);
		$_str_sqlWhere    = "article_id IN (" . $_str_articleId . ")";

		if ($arr_cateIds) {
			$_str_cateIds    = implode(",", $arr_cateIds);
			$_str_sqlWhere   .= " AND article_cate_id IN (" . $_str_cateIds . ")";
		}

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND article_admin_id=" . $num_adminId;
		}

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "article", $_str_sqlWhere); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y120104";
		} else {
			$_str_alert = "x120104";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	/**
	 * mdl_empty function.
	 *
	 * @access public
	 * @param int $num_adminId (default: 0)
	 * @return void
	 */
	function mdl_empty($num_adminId = 0) {
		$_str_sqlWhere = "article_box='recycle'";

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND article_admin_id=" . $num_adminId;
		}

		$_num_mysql = $this->obj_db->delete(BG_DB_TABLE . "article", $_str_sqlWhere); //删除数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y120104";
		} else {
			$_str_alert = "x120104";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	/**
	 * mdl_unknowCate function.
	 *
	 * @access public
	 * @return void
	 */
	function mdl_unknowCate($arr_articleId) {

		$_arr_articleData = array(
			"article_cate_id" => -1,
		);

		$_str_articleId   = implode(",", $arr_articleId);
		$_str_sqlWhere    = "article_id IN (" . $_str_articleId . ")";

		$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "article",  $_arr_articleData, $_str_sqlWhere); //更新数据

		//如车影响行数小于0则返回错误
		if ($_num_mysql > 0) {
			$_str_alert = "y120103";
		} else {
			$_str_alert = "x120103";
		}

		return array(
			"str_alert" => $_str_alert,
		); //成功
	}


	/**
	 * mdl_count function.
	 *
	 * @access public
	 * @param string $str_key (default: "")
	 * @param string $str_tag (default: "")
	 * @param string $str_year (default: "")
	 * @param string $str_month (default: "")
	 * @param string $str_status (default: "")
	 * @param string $str_box (default: "")
	 * @param bool $arr_cateIds (default: false)
	 * @param int $arr_markIds (default: 0)
	 * @param int $num_adminId (default: 0)
	 * @param bool $is_pub (default: false)
	 * @return void
	 */
	function mdl_count($str_key = "", $str_year = "", $str_month = "", $str_status = "", $str_box = "", $arr_cateIds = false, $num_markId = 0, $num_adminId = 0, $is_pub = false) {
		$_str_sqlWhere = "1=1";

		if ($str_key) {
			$_str_sqlWhere .= " AND (article_title LIKE '%" . $str_key . "%' OR article_content like '%" . $str_key . "%')";
		}

		if ($str_year) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(article_time_pub, '%Y')='" . $str_year . "'";
		}

		if ($str_month) {
			$_str_sqlWhere .= " AND FROM_UNIXTIME(article_time_pub, '%m')='" . $str_month . "'";
		}

		if ($str_status) {
			$_str_sqlWhere .= " AND article_status='" . $str_status . "'";
		}

		if ($str_box) {
			$_str_sqlWhere .= " AND article_box='" . $str_box . "'";
		} else {
			$_str_sqlWhere .= " AND article_box='normal'";
		}

		if ($arr_cateIds) {
			$_str_cateIds = implode(",", $arr_cateIds);
			$_str_sqlWhere .= " AND  article_cate_id IN (" . $_str_cateIds . ")";
		}

		if ($num_markId > 0) {
			$_str_sqlWhere .= " AND article_mark_id=" . $num_markId;
		}

		if ($num_adminId > 0) {
			$_str_sqlWhere .= " AND article_admin_id=" . $num_adminId;
		}

		$_num_articleCount = $this->obj_db->count(BG_DB_TABLE . "article", $_str_sqlWhere); //查询数据

		return $_num_articleCount;
	}


	/**
	 * mdl_year function.
	 *
	 * @access public
	 * @return void
	 */
	function mdl_year() {
		$_arr_articleSelect = array(
			"DISTINCT FROM_UNIXTIME(article_time_pub, '%Y') AS article_year",
		);

		$_str_sqlWhere = "article_time > 0";

		$_arr_articleRows = $this->obj_db->select_array(BG_DB_TABLE . "article", $_arr_articleSelect, $_str_sqlWhere . " ORDER BY article_time ASC", 100, 0, false, true);

		return $_arr_articleRows;
	}


	function input_submit() {
		if (!fn_token("chk")) { //令牌
			return array(
				"str_alert" => "x030102",
			);
			exit;
		}

		$this->articleSubmit["article_id"] = fn_getSafe(fn_post("article_id"), "int", 0);

		if ($this->articleSubmit["article_id"] > 0) {
			$_arr_articleRow = $this->mdl_read($this->articleSubmit["article_id"]);
			if ($_arr_articleRow["str_alert"] != "y120102") {
				return $_arr_articleRow;
				exit;
			}
		}

		$_arr_articleTitle = validateStr(fn_post("article_title"), 1, 300);
		switch ($_arr_articleTitle["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x120201",
				);
				exit;
			break;

			case "too_long":
				return array(
					"str_alert" => "x120202",
				);
				exit;
			break;

			case "ok":
				$this->articleSubmit["article_title"] = $_arr_articleTitle["str"];
			break;

		}

		$_arr_articleLink = validateStr(fn_post("article_link"), 0, 900, "str", "url");
		switch ($_arr_articleLink["status"]) {
			case "too_long":
				return array(
					"str_alert" => "x120204",
				);
				exit;
			break;

			case "format_err":
				return array(
					"str_alert" => "x120204",
				);
				exit;
			break;

			case "ok":
				$this->articleSubmit["article_link"] = $_arr_articleLink["str"];
			break;
		}

		$_arr_articleExcerpt = validateStr(fn_post("article_excerpt"), 0, 900);
		switch ($_arr_articleExcerpt["status"]) {
			case "too_long":
				return array(
					"str_alert" => "x120205",
				);
				exit;
			break;

			case "ok":
				$this->articleSubmit["article_excerpt"] = $_arr_articleExcerpt["str"];
			break;
		}

		$_arr_articleStatus = validateStr(fn_post("article_status"), 1, 0);
		switch ($_arr_articleStatus["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x120208",
				);
				exit;
			break;

			case "ok":
				$this->articleSubmit["article_status"] = $_arr_articleStatus["str"];
			break;

		}

		$_arr_articleBox = validateStr(fn_post("article_box"), 1, 0);
		switch ($_arr_articleBox["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x120209",
				);
				exit;
			break;

			case "ok":
				$this->articleSubmit["article_box"] = $_arr_articleBox["str"];
			break;

		}


		$_arr_articleTimePub = validateStr(fn_post("article_time_pub"), 1, 0, "str", "datetime");
		switch ($_arr_articleTimePub["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x120210",
				);
				exit;
			break;

			case "format_err":
				return array(
					"str_alert" => "x120211",
				);
				exit;
			break;

			case "ok":
				$this->articleSubmit["article_time_pub"] = strtotime($_arr_articleTimePub["str"]);
			break;
		}

		$_arr_articleCateId = validateStr(fn_post("article_cate_id"), 1, 0);
		switch ($_arr_articleCateId["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x120207",
				);
				exit;
			break;

			case "ok":
				$this->articleSubmit["article_cate_id"] = $_arr_articleCateId["str"];
			break;
		}

		$_arr_cateIds = fn_post("cate_ids");
		if (isset($_arr_cateIds) && is_array($_arr_cateIds)) {
			foreach ($_arr_cateIds as $_value) {
				$this->articleSubmit["cate_ids"][] = fn_getSafe($_value, "int", 0);
			}
		}

		$this->articleSubmit["cate_ids"][]        = $this->articleSubmit["article_cate_id"];
		$this->articleSubmit["cate_ids"]          = array_unique($this->articleSubmit["cate_ids"]);
		$this->articleSubmit["article_content"]   = fn_post("article_content");

		if (!$this->articleSubmit["article_excerpt"] || $this->articleSubmit["article_excerpt"] == "<br>") {
			$this->articleSubmit["article_excerpt"] = fn_substr_utf8($this->articleSubmit["article_content"], 0, 300);
		}

		$this->articleSubmit["article_attach_id"] = fn_getAttach($this->articleSubmit["article_content"]);
		$this->articleSubmit["article_mark_id"]   = fn_getSafe(fn_post("article_mark_id"), "int", 0);
		$this->articleSubmit["article_spec_id"]   = fn_getSafe(fn_post("article_spec_id"), "int", 0);
		$this->articleSubmit["article_tags"]      = fn_getSafe(fn_post("hidden-article_tag"), "txt", "");
		$this->articleSubmit["str_alert"]         = "ok";

		return $this->articleSubmit;
	}


	/**
	 * fn_articleDo function.
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

		$_arr_articleIds = fn_post("article_id");

		if ($_arr_articleIds) {
			foreach ($_arr_articleIds as $_key=>$_value) {
				$_arr_articleIds[$_key] = fn_getSafe($_value, "int", 0);
			}
			$_str_alert = "ok";
		} else {
			$_str_alert = "none";
		}

		$this->articleIds = array(
			"str_alert"      => $_str_alert,
			"article_ids"    => $_arr_articleIds
		);

		return $this->articleIds;
	}
}
