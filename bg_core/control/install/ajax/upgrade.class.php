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
		$this->table_opt();
		$this->table_tag();
		$this->table_tag_belong();
		$this->table_thumb();
		$this->table_attach();
		$this->table_spec();
		$this->table_app();
		$this->view_article();
		$this->view_tag();

		$this->obj_ajax->halt_alert("y030103");
	}


	/**
	 * install_2_do function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_base() {
		$this->check_db();
		$this->check_opt();

		$_arr_optPost = $this->opt_post("base");

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
		$this->check_opt();

		$_arr_optPost = $this->opt_post("visit");

		$_arr_post = fn_post("opt");

		if ($_arr_post["BG_VISIT_TYPE"] == "pstatic") {

			$_str_content = "# BEGIN baigo CMS" . PHP_EOL;
			$_str_content .= "<IfModule mod_rewrite.c>" . PHP_EOL;
				$_str_content .= "RewriteEngine On" . PHP_EOL;
				$_str_content .= "RewriteBase /" . PHP_EOL;
				$_str_content .= "RewriteRule ^article/([0-9]*)$ " . BG_URL_ROOT . "index.php?mod=article&act_get=show&article_id=$1 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^cate/(.*/)([0-9]*)/$ " . BG_URL_ROOT . "index.php?mod=cate&act_get=show&cate_id=$2 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^cate/(.*/)([0-9]*)$ " . BG_URL_ROOT . "index.php?mod=cate&act_get=show&cate_id=$2 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^cate/(.*/)([0-9]*)/([0-9]*)$ " . BG_URL_ROOT . "index.php?mod=cate&act_get=show&cate_id=$2&page=$3 [L]" . PHP_EOL;
				/*$_str_content .= "RewriteRule ^tag/$ " . BG_URL_ROOT . "index.php?mod=tag&act_get=list [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^tag/([0-9]*)$ " . BG_URL_ROOT . "index.php?mod=tag&act_get=list&page=$1 [L]" . PHP_EOL;*/
				$_str_content .= "RewriteRule ^tag/(.*)/$ " . BG_URL_ROOT . "index.php?mod=tag&act_get=show&tag_name=$1 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^tag/(.*)/([0-9]*)$ " . BG_URL_ROOT . "index.php?mod=tag&act_get=show&tag_name=$1&page=$2 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^spec/$ " . BG_URL_ROOT . "index.php?mod=spec&act_get=list [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^spec/([0-9]*)$ " . BG_URL_ROOT . "index.php?mod=spec&act_get=list&page=$1 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^spec/([0-9]*)/$ " . BG_URL_ROOT . "index.php?mod=spec&act_get=show&spec_id=$1 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^spec/([0-9]*)/([0-9]*)$ " . BG_URL_ROOT . "index.php?mod=spec&act_get=show&spec_id=$1&page=$2 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^search/$ " . BG_URL_ROOT . "index.php?mod=search&act_get=show [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^search/(.*)/$ " . BG_URL_ROOT . "index.php?mod=search&act_get=show&key=$1 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^search/(.*)/([0-9]*)$ " . BG_URL_ROOT . "index.php?mod=search&act_get=show&key=$1&page=$2 [L]" . PHP_EOL;
			$_str_content .= "</IfModule>" . PHP_EOL;
			$_str_content .= "# END baigo CMS" . PHP_EOL;

			file_put_contents(BG_PATH_ROOT . ".htaccess", $_str_content);

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
		$this->check_opt();

		$_arr_optPost = $this->opt_post("upload");

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
		$this->check_opt();

		$_arr_optPost = $this->opt_post("sso");

		$this->obj_ajax->halt_alert("y030408");
	}


	function ajax_over() {
		$this->check_db();
		$this->check_opt();

		$_str_content = "<?php" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_VER\", \"" . PRD_CMS_VER . "\");" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_PUB\", " . PRD_CMS_PUB . ");" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_TIME\", " . time() . ");" . PHP_EOL;

		file_put_contents(BG_PATH_CONFIG . "is_install.php", $_str_content);
		$this->obj_ajax->halt_alert("y030411");
	}


	/**
	 * opt_post function.
	 *
	 * @access private
	 * @param mixed $str_type
	 * @return void
	 */
	private function opt_post($str_type) {
		include_once(BG_PATH_MODEL . "opt.class.php"); //载入管理帐号模型
		$_mdl_opt    = new MODEL_OPT();

		$_arr_opt = fn_post("opt");

		$_str_content = "<?php" . PHP_EOL;
		foreach ($_arr_opt as $_key=>$_value) {
			$_arr_optChk = validateStr($_value, 1, 900);
			$_str_optValue = $_arr_optChk["str"];
			if (is_numeric($_value)) {
				$_str_content .= "define(\"" . $_key . "\", " . $_str_optValue . ");" . PHP_EOL;
			} else {
				$_str_content .= "define(\"" . $_key . "\", \"" . str_replace(PHP_EOL, "|", $_str_optValue) . "\");" . PHP_EOL;
			}
			$_arr_optRow = $_mdl_opt->mdl_submit($_key, $_str_optValue);
		}

		if ($str_type == "base") {
			$_str_content .= "define(\"BG_SITE_SSIN\", \"" . fn_rand(6) . "\");" . PHP_EOL;
		}

		$_str_content = str_replace("||", "", $_str_content);

		file_put_contents(BG_PATH_CONFIG . "opt_" . $str_type . ".inc.php", $_str_content);
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
			$_arr_alert["admin_id"] = array("CHANGE", "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID'", "admin_id");
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

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "article", $_arr_alert);
			if (!$_reselt) {
				$this->obj_ajax->halt_alert("x120106");
			}
		}

		$_arr_articleRow  = $_mdl_article->mdl_create_index();
		if ($_arr_articleRow["str_alert"] != "y120109") {
			$this->obj_ajax->halt_alert($_arr_articleRow["str_alert"]);
		}

		$_arr_articleRow  = $_mdl_article->mdl_copy_table();
		if ($_arr_articleRow["str_alert"] != "y120105") {
			$this->obj_ajax->halt_alert($_arr_articleRow["str_alert"]);
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
			$_arr_alert["call_upfile"] = array("CHANGE", "enum('html','js','xml','json') NOT NULL COMMENT '含有附件'", "call_attach");
		}

		if (in_array("call_attach", $_arr_col)) {
			$_arr_alert["call_attach"] = array("CHANGE", "enum('html','js','xml','json') NOT NULL COMMENT '含有附件'", "call_attach");
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

		if (in_array("call_trim", $_arr_col)) {
			$_arr_alert["call_trim"] = array("CHANGE", "smallint NOT NULL COMMENT '标题字数'", "call_trim");
		}

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
		if ($_arr_cateRow["str_alert"] != "y110109") {
			$this->obj_ajax->halt_alert($_arr_cateRow["str_alert"]);
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
		if ($_arr_cateBelongRow["str_alert"] != "y150109") {
			$this->obj_ajax->halt_alert($_arr_cateBelongRow["str_alert"]);
		}*/
	}


	private function view_article() {
		include_once(BG_PATH_MODEL . "articlePub.class.php"); //载入管理帐号模型
		$_mdl_articlePub  = new MODEL_ARTICLE_PUB();

		$_arr_articlePubRow  = $_mdl_articlePub->mdl_create_cate_view();
		if ($_arr_articlePubRow["str_alert"] != "y120108") {
			$this->obj_ajax->halt_alert($_arr_articlePubRow["str_alert"]);
		}

		$_arr_articlePubRow  = $_mdl_articlePub->mdl_create_tag_view();
		if ($_arr_articlePubRow["str_alert"] != "y120108") {
			$this->obj_ajax->halt_alert($_arr_articlePubRow["str_alert"]);
		}
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

		if ($_arr_specRow["str_alert"] != "y180105") {
			$this->obj_ajax->halt_alert($_arr_specRow["str_alert"]);
		}

		$_arr_col     = $_mdl_spec->mdl_column();
		$_arr_alert   = array();

		if (in_array("spec_id", $_arr_col)) {
			$_arr_alert["spec_id"] = array("CHANGE", "mediumint NOT NULL AUTO_INCREMENT COMMENT 'ID'", "spec_id");
		}

		if (in_array("spec_status", $_arr_col)) {
			$_arr_alert["spec_status"] = array("CHANGE", "enum('show','hide') NOT NULL COMMENT '状态'", "spec_status");
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
	 * table_opt function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_opt() {
		include_once(BG_PATH_MODEL . "opt.class.php"); //载入管理帐号模型
		$_mdl_opt     = new MODEL_OPT();
		$_arr_col     = $_mdl_opt->mdl_column();
		$_arr_alert   = array();

		if (!in_array("opt_id", $_arr_col)) {
			$_arr_alert["opt_id"] = array("ADD", "smallint NOT NULL AUTO_INCREMENT COMMENT 'ID' FIRST");
		}

		$_arr_alert[] = array("DROP PRIMARY KEY");

		if (in_array("opt_value", $_arr_col)) {
			$_arr_alert["opt_value"] = array("CHANGE", "varchar(1000) NOT NULL COMMENT '值'", "opt_value");
		}

		$_arr_alert[] = array("ADD PRIMARY KEY", "opt_id");

		if ($_arr_alert) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "opt", $_arr_alert);
			if (!$_reselt) {
				$this->obj_ajax->halt_alert("x060106");
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
		if ($_arr_tagRow["str_alert"] != "y130109") {
			$this->obj_ajax->halt_alert($_arr_tagRow["str_alert"]);
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
		if ($_arr_belongRow["str_alert"] != "y160109") {
			$this->obj_ajax->halt_alert($_arr_belongRow["str_alert"]);
		}
	}


	private function view_tag() {
		include_once(BG_PATH_MODEL . "tagBelong.class.php"); //载入管理帐号模型
		$_mdl_tagBelong      = new MODEL_TAG_BELONG();

		$_arr_tagBelongRow   = $_mdl_tagBelong->mdl_create_view();
		if ($_arr_tagBelongRow["str_alert"] != "y160108") {
			$this->obj_ajax->halt_alert($_arr_tagBelongRow["str_alert"]);
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
			$_arr_alert["upfile_ext"] = array("CHANGE", "char(4) NOT NULL COMMENT '扩展名'", "attach_ext");
		}

		if (in_array("attach_ext", $_arr_col)) {
			$_arr_alert["attach_ext"] = array("CHANGE", "char(4) NOT NULL COMMENT '扩展名'", "attach_ext");
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

		if ($_arr_appRow["str_alert"] != "y190105") {
			$this->obj_ajax->halt_alert($_arr_appRow["str_alert"]);
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


	/**
	 * sso_base function.
	 *
	 * @access private
	 * @return void
	 */
	private function sso_base() {
		$_str_content = "<?php" . PHP_EOL;
		$_str_content .= "define(\"BG_SITE_NAME\", \"baigo SSO\");" . PHP_EOL;
		$_str_content .= "define(\"BG_SITE_DOMAIN\", \"" . BG_SITE_DOMAIN . "\");" . PHP_EOL;
		$_str_content .= "define(\"BG_SITE_URL\", \"" . BG_SITE_URL . "\");" . PHP_EOL;
		$_str_content .= "define(\"BG_SITE_PERPAGE\", 30);" . PHP_EOL;
		$_str_content .= "define(\"BG_SITE_TIMEZONE\", \"Etc/GMT+8\");" . PHP_EOL;
		$_str_content .= "define(\"BG_SITE_DATE\", \"Y-m-d\");" . PHP_EOL;
		$_str_content .= "define(\"BG_SITE_DATESHORT\", \"m-d\");" . PHP_EOL;
		$_str_content .= "define(\"BG_SITE_TIME\", \"H:i:s\");" . PHP_EOL;
		$_str_content .= "define(\"BG_SITE_TIMESHORT\", \"H:i\");" . PHP_EOL;
		$_str_content .= "define(\"BG_SITE_SSIN\", \"" . fn_rand(6) . "\");" . PHP_EOL;

		file_put_contents(BG_PATH_SSO . "config/opt_base.inc.php", $_str_content);
	}


	/**
	 * sso_reg function.
	 *
	 * @access private
	 * @return void
	 */
	private function sso_reg() {
		$_str_content = "<?php" . PHP_EOL;
		$_str_content .= "define(\"BG_REG_NEEDMAIL\", \"off\");" . PHP_EOL;
		$_str_content .= "define(\"BG_REG_ONEMAIL\", \"false\");" . PHP_EOL;
		$_str_content .= "define(\"BG_ACC_MAIL\", \"\");" . PHP_EOL;
		$_str_content .= "define(\"BG_BAD_MAIL\", \"\");" . PHP_EOL;
		$_str_content .= "define(\"BG_BAD_NAME\", BG_BAD_NAME);" . PHP_EOL;

		file_put_contents(BG_PATH_SSO . "config/opt_reg.inc.php", $_str_content);
	}


	private function check_db() {
		if (!fn_token("chk")) { //令牌
			$this->obj_ajax->halt_alert("x030102");
		}

		if (strlen(BG_DB_HOST) < 1 || strlen(BG_DB_NAME) < 1 || strlen(BG_DB_USER) < 1 || strlen(BG_DB_PASS) < 1 || strlen(BG_DB_CHARSET) < 1) {
			$this->obj_ajax->halt_alert("x030404");
		} else {
			$_cfg_host = array(
				"host"      => BG_DB_HOST,
				"name"      => BG_DB_NAME,
				"user"      => BG_DB_USER,
				"pass"      => BG_DB_PASS,
				"charset"   => BG_DB_CHARSET,
				"debug"     => BG_DB_DEBUG,
			);
			$GLOBALS["obj_db"]   = new CLASS_MYSQL($_cfg_host); //初始化基类
			$this->obj_db        = $GLOBALS["obj_db"];
		}
	}


	private function check_opt() {
		$_arr_tableRows = $this->obj_db->show_tables();

		foreach ($_arr_tableRows as $_key=>$_value) {
			$_arr_tables[] = $_value["Tables_in_" . BG_DB_NAME];
		}

		if (!in_array(BG_DB_TABLE . "opt", $_arr_tables)) {
			$this->obj_ajax->halt_alert("x030412");
		}
	}
}