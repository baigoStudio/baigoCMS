<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "http.func.php"); //载入 http
include_once(BG_PATH_CLASS . "sso.class.php"); //载入 AJAX 基类
include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "opt.class.php"); //载入管理帐号模型

class AJAX_UPGRADE {

	private $obj_sso;
	private $obj_ajax;
	private $obj_db;

	function __construct() { //构造函数
		$this->obj_ajax = new CLASS_AJAX(); //初始化 AJAX 基对象
		if (file_exists(BG_PATH_CONFIG . "is_install.php")) {
			include_once(BG_PATH_CONFIG . "is_install.php"); //载入栏目控制器
			if (defined("BG_INSTALL_PUB") && PRD_CMS_PUB <= BG_INSTALL_PUB) {
				$this->obj_ajax->halt_alert("x030403");
			}
		}
		$this->upgrade_init();
		$this->mdl_opt = new MODEL_OPT();
	}


	function ajax_dbconfig() {
		$_arr_return = $this->mdl_opt->mdl_dbconfig();

		if ($_arr_return["alert"] != "y060101") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$this->obj_ajax->halt_alert("y030404");
	}


	/**
	 * install_2 function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_dbtable() {
		$this->check_db();

		$this->table_admin();
		$this->table_article();
		$this->table_call();
		$this->table_cate();
		$this->table_cate_belong();
		$this->table_mark();
		$this->table_mime();
		$this->table_tag();
		$this->table_tag_belong();
		$this->table_thumb();
		$this->table_attach();
		$this->table_spec();
		$this->table_app();
		$this->table_custom();
		$this->view_article();
		$this->view_tag();
		//$this->view_custom();

		$this->obj_ajax->halt_alert("y030113");
	}


	/**
	 * install_2_do function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_base() {
		$this->check_db();

		$_arr_return = $this->mdl_opt->mdl_const("base");

		if ($_arr_return["alert"] != "y060101") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$this->obj_ajax->halt_alert("y030405");
	}


	/**
	 * install_3_do function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_visit() {
		$this->check_db();

		$_arr_return = $this->mdl_opt->mdl_const("visit");

		if ($_arr_return["alert"] != "y060101") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$_arr_post = fn_post("opt");

		if ($_arr_post["BG_VISIT_TYPE"] == "pstatic") {

			$_arr_return = $this->mdl_opt->mdl_htaccess();

			if ($_arr_return["alert"] != "y060101") {
				$this->obj_ajax->halt_alert($_arr_return["alert"]);
			}

		} else {
			if (file_exists(BG_PATH_ROOT . ".htaccess")) {
				unlink(BG_PATH_ROOT . ".htaccess");
			}
		}

		$this->obj_ajax->halt_alert("y030406");
	}


	/**
	 * install_5 function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_upload() {
		$this->check_db();

		$_arr_return = $this->mdl_opt->mdl_const("upload");

		if ($_arr_return["alert"] != "y060101") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$this->obj_ajax->halt_alert("y030407");
	}


	/**
	 * install_6 function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_sso() {
		$this->check_db();

		$_arr_return = $this->mdl_opt->mdl_const("sso");

		if ($_arr_return["alert"] != "y060101") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$this->obj_ajax->halt_alert("y030408");
	}


	function ajax_over() {
		$this->check_db();

		$_arr_return = $this->mdl_opt->mdl_over();

		if ($_arr_return["alert"] != "y060101") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$this->obj_ajax->halt_alert("y030412");
	}


	/**
	 * table_admin function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_admin() {
		include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型
		$_mdl_admin   = new MODEL_ADMIN();
		$_arr_col     = $_mdl_admin->mdl_column();
		$_arr_alert   = array();

		if (!in_array("admin_allow_profile", $_arr_col)) {
			$_arr_alert["admin_allow_profile"] = array("ADD", "varchar(1000) NOT NULL COMMENT '个人权限'");
		}

		if (!in_array("admin_nick", $_arr_col)) {
			$_arr_alert["admin_nick"] = array("ADD", "varchar(300) NOT NULL COMMENT '昵称'");
		}

		if (in_array("admin_id", $_arr_col)) {
			$_arr_alert["admin_id"] = array("CHANGE", "int NOT NULL AUTO_INCREMENT COMMENT 'ID'", "admin_id");
		}

		if (in_array("admin_group_id", $_arr_col)) {
			$_arr_alert["admin_group_id"] = array("CHANGE", "smallint NOT NULL COMMENT '从属用户组ID'", "admin_group_id");
		}

		if (in_array("admin_status", $_arr_col)) {
			$_arr_alert["admin_status"] = array("CHANGE", "enum('enable','disable') NOT NULL COMMENT '状态'", "admin_status");
		}

		if (in_array("admin_rand", $_arr_col)) {
			$_arr_alert["admin_rand"] = array("CHANGE", "char(6) NOT NULL COMMENT '随机码'", "admin_rand");
		}

		if (in_array("admin_ip", $_arr_col)) {
			$_arr_alert["admin_ip"] = array("CHANGE", "char(15) NOT NULL COMMENT 'IP'", "admin_ip");
		}

		if (in_array("admin_allow_cate", $_arr_col)) {
			$_arr_alert["admin_allow_cate"] = array("CHANGE", "text NOT NULL COMMENT '栏目权限'", "admin_allow_cate");
		}

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "admin", $_arr_alert);
			if (!$_reselt) {
				$this->obj_ajax->halt_alert("x020106");
			}
		}
	}


	/**
	 * table_article function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_article() {
		include_once(BG_PATH_MODEL . "article.class.php"); //载入管理帐号模型
		$_mdl_article = new MODEL_ARTICLE();
		$_arr_col     = $_mdl_article->mdl_column();
		$_arr_alert   = array();

		if (in_array("article_tag", $_arr_col)) {
			$_arr_alert["article_tag"] = array("DROP");
		}

		if (in_array("article_upfile_id", $_arr_col)) {
			$_arr_alert["article_upfile_id"] = array("CHANGE", "int NOT NULL COMMENT '附件ID'", "article_attach_id");
		}

		if (in_array("article_spec_id", $_arr_col)) {
			$_arr_alert["article_spec_id"] = array("CHANGE", "mediumint NOT NULL COMMENT '专题ID'", "article_spec_id");
		} else {
			$_arr_alert["article_spec_id"] = array("ADD", "mediumint NOT NULL COMMENT '专题ID'");
		}

		if (in_array("article_cate_id", $_arr_col)) {
			$_arr_alert["article_cate_id"] = array("CHANGE", "smallint NOT NULL COMMENT '隶属栏目ID'", "article_cate_id");
		}

		if (in_array("article_mark_id", $_arr_col)) {
			$_arr_alert["article_mark_id"] = array("CHANGE", "smallint NOT NULL COMMENT '标记ID'", "article_mark_id");
		}

		if (in_array("article_top", $_arr_col)) {
			$_arr_alert["article_top"] = array("CHANGE", "tinyint NOT NULL COMMENT '置顶'", "article_top");
		}

		if (in_array("article_status", $_arr_col)) {
			$_arr_alert["article_status"] = array("CHANGE", "enum('pub','wait','hide') NOT NULL COMMENT '状态'", "article_status");
		}

		if (in_array("article_box", $_arr_col)) {
			$_arr_alert["article_box"] = array("CHANGE", "enum('normal','draft','recycle') NOT NULL COMMENT '盒子'", "article_box");
		}

		if (in_array("article_hits_day", $_arr_col)) {
			$_arr_alert["article_hits_day"] = array("CHANGE", "mediumint NOT NULL COMMENT '日点击'", "article_hits_day");
		}

		if (in_array("article_hits_week", $_arr_col)) {
			$_arr_alert["article_hits_week"] = array("CHANGE", "mediumint NOT NULL COMMENT '周点击'", "article_hits_week");
		}

		if (in_array("article_hits_month", $_arr_col)) {
			$_arr_alert["article_hits_month"] = array("CHANGE", "mediumint NOT NULL COMMENT '月点击'", "article_hits_month");
		}

		if (in_array("article_hits_year", $_arr_col)) {
			$_arr_alert["article_hits_year"] = array("CHANGE", "mediumint NOT NULL COMMENT '年点击'", "article_hits_year");
		}

		if (!in_array("article_time_day", $_arr_col)) {
			$_arr_alert["article_time_day"] = array("ADD", "int NOT NULL COMMENT '日点击重置时间'");
		}

		if (!in_array("article_time_week", $_arr_col)) {
			$_arr_alert["article_time_week"] = array("ADD", "int NOT NULL COMMENT '周点击重置时间'");
		}

		if (!in_array("article_time_month", $_arr_col)) {
			$_arr_alert["article_time_month"] = array("ADD", "int NOT NULL COMMENT '月点击重置时间'");
		}

		if (!in_array("article_time_year", $_arr_col)) {
			$_arr_alert["article_time_year"] = array("ADD", "int NOT NULL COMMENT '年点击重置时间'");
		}

		/*if (!in_array("article_custom", $_arr_col)) {
			$_arr_alert["article_custom"] = array("ADD", "text NOT NULL COMMENT '自定义字段'");
		}*/

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "article", $_arr_alert);
			if (!$_reselt) {
				$this->obj_ajax->halt_alert("x120106");
			}
		}

		$_arr_articleRow  = $_mdl_article->mdl_create_index();
		if ($_arr_articleRow["alert"] != "y120109") {
			$this->obj_ajax->halt_alert($_arr_articleRow["alert"]);
		}

		if (in_array("article_content", $_arr_col)) {
			$_arr_articleRow  = $_mdl_article->mdl_copy_table();
			if ($_arr_articleRow["alert"] != "y120105") {
				$this->obj_ajax->halt_alert($_arr_articleRow["alert"]);
			}
		}

		$_arr_alert = array();
		if (in_array("article_content", $_arr_col)) {
			$_arr_alert["article_content"] = array("DROP");
		}

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "article", $_arr_alert);
			if (!$_reselt) {
				$this->obj_ajax->halt_alert("x120106");
			}
		}

	}


	/**
	 * table_call function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_call() {
		include_once(BG_PATH_MODEL . "call.class.php"); //载入管理帐号模型
		$_mdl_call    = new MODEL_CALL();
		$_arr_col     = $_mdl_call->mdl_column();
		$_arr_alert   = array();

		if (in_array("call_upfile", $_arr_col)) {
			$_arr_alert["call_upfile"] = array("CHANGE", "enum('all','attach','none') NOT NULL COMMENT '含有附件'", "call_attach");
		}

		if (in_array("call_attach", $_arr_col)) {
			$_arr_alert["call_attach"] = array("CHANGE", "enum('all','attach','none') NOT NULL COMMENT '含有附件'", "call_attach");
		}

		if (!in_array("call_spec_id", $_arr_col)) {
			$_arr_alert["call_spec_id"] = array("ADD", "mediumint NOT NULL COMMENT '专题ID'");
		}

		if (in_array("call_type", $_arr_col)) {
			$_arr_alert["call_type"] = array("CHANGE", "enum('article','hits_day','hits_week','hits_month','hits_year','hits_all','spec','cate','tag_list','tag_rank') NOT NULL COMMENT '调用类型'", "call_type");
		}

		if (in_array("call_cate_id", $_arr_col)) {
			$_arr_alert["call_cate_id"] = array("CHANGE", "smallint NOT NULL COMMENT '栏目ID'", "call_cate_id");
		}

		if (in_array("call_file", $_arr_col)) {
			$_arr_alert["call_file"] = array("CHANGE", "enum('html','js','xml','json') NOT NULL COMMENT '静态文件类型'", "call_file");
		}

		/*if (in_array("call_trim", $_arr_col)) {
			$_arr_alert["call_trim"] = array("CHANGE", "smallint NOT NULL COMMENT '标题字数'", "call_trim");
		}*/

		if (in_array("call_status", $_arr_col)) {
			$_arr_alert["call_status"] = array("CHANGE", "enum('enable','disable') NOT NULL COMMENT '状态'", "call_status");
		}

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "call", $_arr_alert);
			if (!$_reselt) {
				$this->obj_ajax->halt_alert("x170106");
			}
		}
	}


	/**
	 * table_cate function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_cate() {
		include_once(BG_PATH_MODEL . "cate.class.php"); //载入管理帐号模型
		$_mdl_cate    = new MODEL_CATE();
		$_arr_col     = $_mdl_cate->mdl_column();
		$_arr_alert   = array();

		if (in_array("cate_id", $_arr_col)) {
			$_arr_alert["cate_id"] = array("CHANGE", "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID'", "cate_id");
		}

		if (in_array("cate_type", $_arr_col)) {
			$_arr_alert["cate_type"] = array("CHANGE", "enum('normal','single','link') NOT NULL COMMENT '类型'", "cate_type");
		}

		if (in_array("cate_parent_id", $_arr_col)) {
			$_arr_alert["cate_parent_id"] = array("CHANGE", "smallint NOT NULL COMMENT '父栏目'", "cate_parent_id");
		}

		if (in_array("cate_ftp_port", $_arr_col)) {
			$_arr_alert["cate_ftp_port"] = array("CHANGE", "char(5) NOT NULL COMMENT 'FTP端口'", "cate_ftp_port");
		}

		if (in_array("cate_status", $_arr_col)) {
			$_arr_alert["cate_status"] = array("CHANGE", "enum('show','hide') NOT NULL COMMENT '状态'", "cate_status");
		}

		if (in_array("cate_order", $_arr_col)) {
			$_arr_alert["cate_order"] = array("CHANGE", "smallint NOT NULL COMMENT '排序'", "cate_order");
		}

		if (!in_array("cate_perpage", $_arr_col)) {
			$_arr_alert["cate_perpage"] = array("ADD", "tinyint NOT NULL COMMENT '每页文章数'");
		}

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "cate", $_arr_alert);
			if (!$_reselt) {
				$this->obj_ajax->halt_alert("x110106");
			}
		}

		$_arr_cateRow  = $_mdl_cate->mdl_create_index();
		if ($_arr_cateRow["alert"] != "y110109") {
			$this->obj_ajax->halt_alert($_arr_cateRow["alert"]);
		}
	}


	/**
	 * table_cate_belong function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_cate_belong() {
		include_once(BG_PATH_MODEL . "cateBelong.class.php"); //载入管理帐号模型
		$_mdl_cateBelong  = new MODEL_CATE_BELONG();
		$_arr_col         = $_mdl_cateBelong->mdl_column();
		$_arr_alert       = array();

		if (in_array("belong_cate_id", $_arr_col)) {
			$_arr_alert["belong_cate_id"] = array("CHANGE", "smallint NOT NULL COMMENT '栏目 ID'", "belong_cate_id");
		}

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "cate_belong", $_arr_alert);
			if (!$_reselt) {
				$this->obj_ajax->halt_alert("x150106");
			}
		}

		/*$_arr_cateBelongRow   = $_mdl_cateBelong->mdl_create_index();
		if ($_arr_cateBelongRow["alert"] != "y150109") {
			$this->obj_ajax->halt_alert($_arr_cateBelongRow["alert"]);
		}*/
	}


	private function view_article() {
		include_once(BG_PATH_MODEL . "articlePub.class.php"); //载入管理帐号模型
		$_mdl_articlePub  = new MODEL_ARTICLE_PUB();

		$_arr_articlePubRow  = $_mdl_articlePub->mdl_create_cate_view();
		if ($_arr_articlePubRow["alert"] != "y150108") {
			$this->obj_ajax->halt_alert($_arr_articlePubRow["alert"]);
		}

		$_arr_articlePubRow  = $_mdl_articlePub->mdl_create_tag_view();
		if ($_arr_articlePubRow["alert"] != "y160108") {
			$this->obj_ajax->halt_alert($_arr_articlePubRow["alert"]);
		}

		/*$_arr_articlePubRow  = $_mdl_articlePub->mdl_create_custom_view();
		if ($_arr_articlePubRow["alert"] != "y210108") {
			$this->obj_ajax->halt_alert($_arr_articlePubRow["alert"]);
		}*/
	}


	/**
	 * table_group function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_group() {
		include_once(BG_PATH_MODEL . "group.class.php"); //载入管理帐号模型
		$_mdl_group   = new MODEL_GROUP();
		$_arr_col     = $_mdl_group->mdl_column();
		$_arr_alert   = array();

		if (!in_array("group_status", $_arr_col)) {
			$_arr_alert["group_status"] = array("ADD", "enum('enable','disable') NOT NULL COMMENT '状态'");
		}

		if (in_array("group_status", $_arr_col)) {
			$_arr_alert["group_status"] = array("CHANGE", "enum('enable','disable') NOT NULL COMMENT '状态'", "group_status");
		}

		if (in_array("group_id", $_arr_col)) {
			$_arr_alert["group_id"] = array("CHANGE", "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID'", "group_id");
		}

		if (in_array("group_type", $_arr_col)) {
			$_arr_alert["group_type"] = array("CHANGE", "enum('admin','admin') NOT NULL COMMENT '类型'", "group_type");
		}

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "group", $_arr_alert);
			if (!$_reselt) {
				$this->obj_ajax->halt_alert("x040106");
			}
		}
	}


	/**
	 * table_mark function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_mark() {
		include_once(BG_PATH_MODEL . "mark.class.php"); //载入管理帐号模型
		$_mdl_mark    = new MODEL_MARK();
		$_arr_col     = $_mdl_mark->mdl_column();
		$_arr_alert   = array();

		if (in_array("mark_id", $_arr_col)) {
			$_arr_alert["mark_id"] = array("CHANGE", "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID'", "mark_id");
		}

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "mark", $_arr_alert);
			if (!$_reselt) {
				$this->obj_ajax->halt_alert("x140106");
			}
		}
	}


	private function table_spec() {
		include_once(BG_PATH_MODEL . "spec.class.php");
		$_mdl_spec    = new MODEL_SPEC();
		$_arr_specRow = $_mdl_spec->mdl_create_table();

		if ($_arr_specRow["alert"] != "y180105") {
			$this->obj_ajax->halt_alert($_arr_specRow["alert"]);
		}

		$_arr_col     = $_mdl_spec->mdl_column();
		$_arr_alert   = array();

		if (in_array("spec_id", $_arr_col)) {
			$_arr_alert["spec_id"] = array("CHANGE", "mediumint NOT NULL AUTO_INCREMENT COMMENT 'ID'", "spec_id");
		}

		if (in_array("spec_status", $_arr_col)) {
			$_arr_alert["spec_status"] = array("CHANGE", "enum('show','hide') NOT NULL COMMENT '状态'", "spec_status");
		}

		if (in_array("spec_content", $_arr_col)) {
			$_arr_alert["spec_content"] = array("CHANGE", "text NOT NULL COMMENT '专题内容'", "spec_content");
		}

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "spec", $_arr_alert);
			if (!$_reselt) {
				$this->obj_ajax->halt_alert("x180106");
			}
		}
	}


	/**
	 * table_mime function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_mime() {
		include_once(BG_PATH_MODEL . "mime.class.php"); //载入管理帐号模型
		$_mdl_mime    = new MODEL_MIME();
		$_arr_col     = $_mdl_mime->mdl_column();
		$_arr_alert   = array();

		if (in_array("mime_id", $_arr_col)) {
			$_arr_alert["mime_id"] = array("CHANGE", "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID'", "mime_id");
		}

		if (in_array("mime_ext", $_arr_col)) {
			$_arr_alert["mime_ext"] = array("CHANGE", "char(4) NOT NULL COMMENT '扩展名'", "mime_ext");
		}

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "mime", $_arr_alert);
			if (!$_reselt) {
				$this->obj_ajax->halt_alert("x080106");
			}
		}
	}


	/**
	 * table_tag function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_tag() {
		include_once(BG_PATH_MODEL . "tag.class.php"); //载入管理帐号模型
		$_mdl_tag      = new MODEL_TAG();

		$_arr_tagRow   = $_mdl_tag->mdl_create_index();
		if ($_arr_tagRow["alert"] != "y130109") {
			$this->obj_ajax->halt_alert($_arr_tagRow["alert"]);
		}

		$_arr_col     = $_mdl_tag->mdl_column();
		$_arr_alert   = array();

		if (in_array("tag_status", $_arr_col)) {
			$_arr_alert["tag_status"] = array("CHANGE", "enum('show','hide') NOT NULL COMMENT '状态'", "tag_status");
		}

		if (in_array("tag_article_count", $_arr_col)) {
			$_arr_alert["tag_article_count"] = array("CHANGE", "smallint NOT NULL COMMENT '文章数'", "tag_article_count");
		}

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "tag", $_arr_alert);
			if (!$_reselt) {
				$this->obj_ajax->halt_alert("x190106");
			}
		}
	}


	/**
	 * table_tag_belong function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_tag_belong() {
		include_once(BG_PATH_MODEL . "tagBelong.class.php"); //载入管理帐号模型
		$_mdl_tagBelong  = new MODEL_TAG_BELONG();

		$_arr_belongRow    = $_mdl_tagBelong->mdl_create_index();
		if ($_arr_belongRow["alert"] != "y160109") {
			$this->obj_ajax->halt_alert($_arr_belongRow["alert"]);
		}
	}


	private function view_tag() {
		include_once(BG_PATH_MODEL . "tagBelong.class.php"); //载入管理帐号模型
		$_mdl_tagBelong      = new MODEL_TAG_BELONG();

		$_arr_tagBelongRow   = $_mdl_tagBelong->mdl_create_view();
		if ($_arr_tagBelongRow["alert"] != "y160108") {
			$this->obj_ajax->halt_alert($_arr_tagBelongRow["alert"]);
		}
	}


	/**
	 * table_thumb function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_thumb() {
		include_once(BG_PATH_MODEL . "thumb.class.php"); //载入管理帐号模型
		$_mdl_thumb   = new MODEL_THUMB();
		$_arr_col     = $_mdl_thumb->mdl_column();
		$_arr_alert   = array();

		if (in_array("thumb_id", $_arr_col)) {
			$_arr_alert["thumb_id"] = array("CHANGE", "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID'", "thumb_id");
		}

		if (in_array("thumb_width", $_arr_col)) {
			$_arr_alert["thumb_width"] = array("CHANGE", "smallint NOT NULL COMMENT '宽度'", "thumb_width");
		}

		if (in_array("thumb_height", $_arr_col)) {
			$_arr_alert["thumb_height"] = array("CHANGE", "smallint NOT NULL COMMENT '高度'", "thumb_height");
		}

		if (in_array("thumb_type", $_arr_col)) {
			$_arr_alert["thumb_type"] = array("CHANGE", "enum('ratio','cut') NOT NULL COMMENT '类型'", "thumb_type");
		}

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "thumb", $_arr_alert);
			if (!$_reselt) {
				$this->obj_ajax->halt_alert("x090106");
			}
		}
	}


	/**
	 * table_attach function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_attach() {
		include_once(BG_PATH_MODEL . "attach.class.php"); //载入管理帐号模型

		$_arr_tableRows = $this->obj_db->show_tables();

		foreach ($_arr_tableRows as $_key=>$_value) {
			$_arr_tables[] = $_value["Tables_in_" . BG_DB_NAME];
		}

		if (in_array(BG_DB_TABLE . "upfile", $_arr_tables) && !in_array(BG_DB_TABLE . "attach", $_arr_tables)) {
			$this->obj_db->alert_table(BG_DB_TABLE . "upfile", false, BG_DB_TABLE . "attach");
		}

		$_mdl_attach  = new MODEL_ATTACH();
		$_arr_col     = $_mdl_attach->mdl_column();
		$_arr_alert   = array();

		if (in_array("upfile_id", $_arr_col)) {
			$_arr_alert["upfile_id"] = array("CHANGE", "int NOT NULL AUTO_INCREMENT COMMENT 'ID'", "attach_id");
		}

		if (in_array("upfile_ext", $_arr_col)) {
			$_arr_alert["upfile_ext"] = array("CHANGE", "char(5) NOT NULL COMMENT '扩展名'", "attach_ext");
		}

		if (in_array("upfile_time", $_arr_col)) {
			$_arr_alert["upfile_time"] = array("CHANGE", "int NOT NULL COMMENT '时间'", "attach_time");
		}

		if (in_array("upfile_size", $_arr_col)) {
			$_arr_alert["upfile_size"] = array("CHANGE", "mediumint NOT NULL COMMENT '大小'", "attach_size");
		}

		if (in_array("attach_size", $_arr_col)) {
			$_arr_alert["attach_size"] = array("CHANGE", "mediumint NOT NULL COMMENT '大小'", "attach_size");
		}

		if (in_array("upfile_name", $_arr_col)) {
			$_arr_alert["upfile_name"] = array("CHANGE", "varchar(1000) NOT NULL COMMENT '原始文件名'", "attach_name");
		}

		if (in_array("upfile_admin_id", $_arr_col)) {
			$_arr_alert["upfile_admin_id"] = array("CHANGE", "smallint NOT NULL COMMENT '上传用户 ID'", "attach_admin_id");
		}

		if (in_array("attach_admin_id", $_arr_col)) {
			$_arr_alert["attach_admin_id"] = array("CHANGE", "smallint NOT NULL COMMENT '上传用户 ID'", "attach_admin_id");
		}

		if (!in_array("attach_box", $_arr_col)) {
			$_arr_alert["attach_box"] = array("ADD", "enum('normal','recycle') NOT NULL COMMENT '盒子'");
		}

		if (!in_array("attach_mime", $_arr_col)) {
			$_arr_alert["attach_mime"] = array("ADD", "varchar(30) NOT NULL COMMENT 'MIME'");
		}

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "attach", $_arr_alert);
			if (!$_reselt) {
				$this->obj_ajax->halt_alert("x070106");
			}
		}
	}


	private function table_app() {
		include_once(BG_PATH_MODEL . "app.class.php"); //载入管理帐号模型
		$_mdl_app     = new MODEL_APP();
		$_arr_appRow  = $_mdl_app->mdl_create_table();

		if ($_arr_appRow["alert"] != "y190105") {
			$this->obj_ajax->halt_alert($_arr_appRow["alert"]);
		}

		$_arr_col     = $_mdl_app->mdl_column();
		$_arr_alert   = array();

		if (in_array("app_id", $_arr_col)) {
			$_arr_alert["app_id"] = array("CHANGE", "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID'", "app_id");
		}

		if (in_array("app_key", $_arr_col)) {
			$_arr_alert["app_key"] = array("CHANGE", "char(64) NOT NULL COMMENT '校验码'", "app_key");
		}

		if (in_array("app_token", $_arr_col)) {
			$_arr_alert["app_token"] = array("CHANGE", "char(64) NOT NULL COMMENT '访问口令'", "app_token");
		}

		if (in_array("app_status", $_arr_col)) {
			$_arr_alert["app_status"] = array("CHANGE", "enum('enable','disable') NOT NULL COMMENT '状态'", "app_status");
		}

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "app", $_arr_alert);
			if (!$_reselt) {
				$this->obj_ajax->halt_alert("x190106");
			}
		}
	}


	private function table_custom() {
		include_once(BG_PATH_MODEL . "custom.class.php"); //载入管理帐号模型
		$_mdl_custom     = new MODEL_CUSTOM();

		$_arr_customRow  = $_mdl_custom->mdl_create_table();
		if ($_arr_customRow["alert"] != "y200105") {
			$this->obj_ajax->halt_alert($_arr_customRow["alert"]);
		}

		$_arr_col     = $_mdl_custom->mdl_column();
		$_arr_alert   = array();

		if (!in_array("custom_order", $_arr_col)) {
			$_arr_alert["custom_order"] = array("ADD", "smallint NOT NULL COMMENT '排序'");
		}

		if (!in_array("custom_parent_id", $_arr_col)) {
			$_arr_alert["custom_parent_id"] = array("ADD", "smallint NOT NULL COMMENT '父字段'");
		}

		if (in_array("custom_type", $_arr_col)) {
			$_arr_alert["custom_type"] = array("CHANGE", "enum('article','cate') NOT NULL COMMENT '对象'", "custom_target");
		}

		if (!in_array("custom_opt", $_arr_col)) {
			$_arr_alert["custom_opt"] = array("ADD", "varchar(900) NOT NULL COMMENT '选项'");
		}

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "custom", $_arr_alert);
			if (!$_reselt) {
				$this->obj_ajax->halt_alert("x200106");
			}
		}

		$_arr_col     = $_mdl_custom->mdl_column();
		$_arr_alert   = array();

		if (!in_array("custom_type", $_arr_col)) {
			$_arr_alert["custom_type"] = array("ADD", "enum('int','decimal','varchar','text','enum') NOT NULL COMMENT '类型'");
		}

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "custom", $_arr_alert);
			if (!$_reselt) {
				$this->obj_ajax->halt_alert("x200106");
			}
		}
	}


	private function view_custom() {

	}


	private function check_db() {
		if (strlen(BG_DB_HOST) < 1 || strlen(BG_DB_NAME) < 1 || strlen(BG_DB_USER) < 1 || strlen(BG_DB_PASS) < 1 || strlen(BG_DB_CHARSET) < 1) {
			$this->obj_ajax->halt_alert("x030419");
		} else {
			if (!defined("BG_DB_PORT")) {
				define("BG_DB_PORT", "3306");
			}

			$_cfg_host = array(
				"host"      => BG_DB_HOST,
				"name"      => BG_DB_NAME,
				"user"      => BG_DB_USER,
				"pass"      => BG_DB_PASS,
				"charset"   => BG_DB_CHARSET,
				"debug"     => BG_DB_DEBUG,
				"port"      => BG_DB_PORT,
			);

			$GLOBALS["obj_db"]   = new CLASS_MYSQLI($_cfg_host); //设置数据库对象
			$this->obj_db        = $GLOBALS["obj_db"];

			if (!$this->obj_db->connect()) {
				$this->obj_ajax->halt_alert("x030111");
			}

			if (!$this->obj_db->select_db()) {
				$this->obj_ajax->halt_alert("x030112");
			}
		}
	}


	private function upgrade_init() {
		$_arr_extRow      = get_loaded_extensions();
		$_num_errCount    = 0;

		foreach ($this->obj_ajax->type["ext"] as $_key=>$_value) {
			if (!in_array($_key, $_arr_extRow)) {
				$_num_errCount++;
			}
		}

		if ($_num_errCount > 0) {
			$this->obj_ajax->halt_alert("x030418");
		}
	}
}