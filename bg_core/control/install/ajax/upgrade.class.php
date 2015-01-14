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
		//$this->table_cate();
		//$this->table_cate_belong();
		$this->table_group();
		//$this->table_mark();
		//$this->table_mime();
		//$this->table_opt();
		//$this->table_tag();
		//$this->table_tag_belong();
		//$this->table_thumb();
		$this->table_attach();
		$this->table_spec();
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
				$_str_content .= "RewriteRule ^cate/(.*/)([0-9]*)/([0-9]*)$ " . BG_URL_ROOT . "index.php?mod=cate&act_get=show&cate_id=$2&page=$3 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^tag/$ " . BG_URL_ROOT . "index.php?mod=tag&act_get=list [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^tag/(.*)/$ " . BG_URL_ROOT . "index.php?mod=tag&act_get=show&tag_name=$1 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^tag/(.*)/([0-9]*)$ " . BG_URL_ROOT . "index.php?mod=tag&act_get=show&tag_name=$1&page=$2 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^spec/$ " . BG_URL_ROOT . "index.php?mod=spec&act_get=list [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^spec/([0-9]*)/$ " . BG_URL_ROOT . "index.php?mod=spec&act_get=show&spec_id=$1 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^spec/([0-9]*)/([0-9]*)$ " . BG_URL_ROOT . "index.php?mod=spec&act_get=show&spec_id=$1&page=$2 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^search/$ " . BG_URL_ROOT . "index.php?mod=search&act_get=show [L]" . PHP_EOL;
			$_str_content .= "</IfModule>" . PHP_EOL;
			$_str_content .= "# END baigo CMS" . PHP_EOL;

			file_put_contents(BG_PATH_ROOT . ".htaccess", $_str_content);

		} else {
			if (file_exists(BG_PATH_ROOT . ".htaccess")) {
				unlink(BG_PATH_ROOT . ".htaccess", $_str_content);
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
		$_str_content .= "?>";

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

		$_str_content .= "?>";

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
		$_mdl_admin  = new MODEL_ADMIN();

		$_arr_col = $_mdl_admin->mdl_column();

		if (!in_array("admin_allow_profile", $_arr_col)) {
			$_arr_alert["admin_allow_profile"] = array("ADD", "varchar(1000) NOT NULL COMMENT '个人权限'");
		}

		if (!in_array("admin_nick", $_arr_col)) {
			$_arr_alert["admin_nick"] = array("ADD", "varchar(300) NOT NULL COMMENT '昵称'");
		}

		if (isset($_arr_alert)) {
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
		$_mdl_article     = new MODEL_ARTICLE();

		$_arr_col = $_mdl_article->mdl_column();

		if (in_array("article_tag", $_arr_col)) {
			$_arr_alert["article_tag"] = array("DROP");
		}

		if (in_array("article_upfile_id", $_arr_col)) {
			$_arr_alert["article_upfile_id"] = array("CHANGE", "int(11) NOT NULL COMMENT '附件ID'", "article_attach_id");
		}

		if (!in_array("article_spec_id", $_arr_col)) {
			$_arr_alert["article_spec_id"] = array("ADD", "int(11) NOT NULL COMMENT '专题ID'");
		}

		if (isset($_arr_alert)) {
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
		$_mdl_call  = new MODEL_CALL();

		$_arr_col = $_mdl_call->mdl_column();

		if (in_array("call_upfile", $_arr_col)) {
			$_arr_alert["call_upfile"] = array("CHANGE", "varchar(20) NOT NULL COMMENT '含有附件'", "call_attach");
		}

		if (isset($_arr_alert)) {
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
		/*include_once(BG_PATH_MODEL . "cate.class.php"); //载入管理帐号模型
		$_mdl_cate  = new MODEL_CATE();
		$_arr_cateRow    = $_mdl_cate->mdl_create();

		if ($_arr_cateRow["str_alert"] != "y110105") {
			$this->obj_ajax->halt_alert($_arr_cateRow["str_alert"]);
		}*/
	}


	/**
	 * table_cate_belong function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_cate_belong() {
		/*include_once(BG_PATH_MODEL . "cateBelong.class.php"); //载入管理帐号模型
		$_mdl_cateBelong = new MODEL_CATE_BELONG();
		$_arr_belongRow       = $_mdl_cateBelong->mdl_create();

		if ($_arr_belongRow["str_alert"] != "y150105") {
			$this->obj_ajax->halt_alert($_arr_belongRow["str_alert"]);
		}*/
	}


	private function view_article() {
		include_once(BG_PATH_MODEL . "articlePub.class.php"); //载入管理帐号模型
		$_mdl_articlePub  = new MODEL_ARTICLE_PUB();

		$_arr_articlePubRow = $_mdl_articlePub->mdl_create();
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
		$_mdl_group  = new MODEL_GROUP();

		$_arr_col = $_mdl_group->mdl_column();

		if (!in_array("group_status", $_arr_col)) {
			$_arr_alert["group_status"] = array("ADD", "varchar(20) NOT NULL COMMENT '状态'");
		}

		if (isset($_arr_alert)) {
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
		/*include_once(BG_PATH_MODEL . "mark.class.php"); //载入管理帐号模型
		$_mdl_mark  = new MODEL_MARK();
		$_arr_markRow    = $_mdl_mark->mdl_create();

		if ($_arr_markRow["str_alert"] != "y140105") {
			$this->obj_ajax->halt_alert($_arr_markRow["str_alert"]);
		}*/
	}


	private function table_spec() {
		include_once(BG_PATH_MODEL . "spec.class.php");
		$_mdl_spec    = new MODEL_SPEC();
		$_arr_specRow = $_mdl_spec->mdl_create();

		if ($_arr_specRow["str_alert"] != "y180105") {
			$this->obj_ajax->halt_alert($_arr_specRow["str_alert"]);
		}
	}


	/**
	 * table_mime function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_mime() {
		/*include_once(BG_PATH_MODEL . "mime.class.php"); //载入管理帐号模型
		$_mdl_mime  = new MODEL_MIME();
		$_arr_mimeRow    = $_mdl_mime->mdl_create();

		if ($_arr_mimeRow["str_alert"] != "y080105") {
			$this->obj_ajax->halt_alert($_arr_mimeRow["str_alert"]);
		}*/
	}


	/**
	 * table_opt function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_opt() {
		/*include_once(BG_PATH_MODEL . "opt.class.php"); //载入管理帐号模型
		$_mdl_opt  = new MODEL_OPT();
		$_arr_optRow    = $_mdl_opt->mdl_create();

		if ($_arr_optRow["str_alert"] != "y060105") {
			$this->obj_ajax->halt_alert($_arr_optRow["str_alert"]);
		}*/
	}


	/**
	 * table_tag function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_tag() {
		/*include_once(BG_PATH_MODEL . "tagPub.class.php"); //载入管理帐号模型
		$_mdl_tagPub      = new MODEL_TAG_PUB();

		$_arr_tagPubRow   = $_mdl_tagPub->mdl_create();
		if ($_arr_tagPubRow["str_alert"] != "y130108") {
			$this->obj_ajax->halt_alert($_arr_tagPubRow["str_alert"]);
		}*/
	}


	/**
	 * table_tag_belong function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_tag_belong() {
		/*include_once(BG_PATH_MODEL . "tagBelong.class.php"); //载入管理帐号模型
		$_mdl_tagBelong  = new MODEL_TAG_BELONG();
		$_arr_belongRow    = $_mdl_tagBelong->mdl_create();

		if ($_arr_belongRow["str_alert"] != "y160105") {
			$this->obj_ajax->halt_alert($_arr_belongRow["str_alert"]);
		}*/
	}

	private function view_tag() {
		include_once(BG_PATH_MODEL . "tagPub.class.php"); //载入管理帐号模型
		$_mdl_tagPub      = new MODEL_TAG_PUB();

		$_arr_tagPubRow   = $_mdl_tagPub->mdl_create();
		if ($_arr_tagPubRow["str_alert"] != "y130108") {
			$this->obj_ajax->halt_alert($_arr_tagPubRow["str_alert"]);
		}
	}


	/**
	 * table_thumb function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_thumb() {
		/*include_once(BG_PATH_MODEL . "thumb.class.php"); //载入管理帐号模型
		$_mdl_thumb  = new MODEL_THUMB();
		$_arr_thumbRow    = $_mdl_thumb->mdl_create();

		if ($_arr_thumbRow["str_alert"] != "y090105") {
			$this->obj_ajax->halt_alert($_arr_thumbRow["str_alert"]);
		}*/
	}


	/**
	 * table_attach function.
	 *
	 * @access private
	 * @return void
	 */
	private function table_attach() {
		include_once(BG_PATH_MODEL . "attach.class.php"); //载入管理帐号模型
		$_mdl_attach  = new MODEL_ATTACH();

		$_arr_tableSelect = array(
			"DISTINCT table_name"
		);

		$_str_sqlWhere = "table_schema='" . BG_DB_NAME . "' AND table_name='" . BG_DB_TABLE . "upfile'";

		$_arr_tableRows = $this->obj_db->select_array("information_schema`.`columns", $_arr_tableSelect, $_str_sqlWhere, 100, 0, "", true);
		if (isset($_arr_tableRows[0])) {
			$_arr_tableRow  = $_arr_tableRows[0];
		}

		if (isset($_arr_tableRow["table_name"])) {
			$_arr_tableRows = $this->obj_db->alert_table(BG_DB_TABLE . "upfile", false, BG_DB_TABLE . "attach");
		}

		$_arr_col     = $_mdl_attach->mdl_column();

		if (in_array("upfile_id", $_arr_col)) {
			$_arr_alert["upfile_id"] = array("CHANGE", "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'", "attach_id");
		}

		if (in_array("upfile_ext", $_arr_col)) {
			$_arr_alert["upfile_ext"] = array("CHANGE", "varchar(10) NOT NULL COMMENT '扩展名'", "attach_ext");
		}

		if (in_array("upfile_time", $_arr_col)) {
			$_arr_alert["upfile_time"] = array("CHANGE", "int(11) NOT NULL COMMENT '时间'", "attach_time");
		}

		if (in_array("upfile_size", $_arr_col)) {
			$_arr_alert["upfile_size"] = array("CHANGE", "int(11) NOT NULL COMMENT '大小'", "attach_size");
		}

		if (in_array("upfile_name", $_arr_col)) {
			$_arr_alert["upfile_name"] = array("CHANGE", "varchar(1000) NOT NULL COMMENT '原始文件名'", "attach_name");
		}

		if (in_array("upfile_admin_id", $_arr_col)) {
			$_arr_alert["upfile_admin_id"] = array("CHANGE", "int(50) NOT NULL COMMENT '上传用户 ID'", "attach_admin_id");
		}

		if (isset($_arr_alert)) {
			$_reselt = $this->obj_db->alert_table(BG_DB_TABLE . "attach", $_arr_alert);
			if (!$_reselt) {
				$this->obj_ajax->halt_alert("x070106");
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
		$_str_content .= "?>";

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
		$_str_content .= "?>";

		file_put_contents(BG_PATH_SSO . "config/opt_reg.inc.php", $_str_content);
	}


	private function check_db() {
		if (!fn_token("chk")) { //令牌
			$this->obj_ajax->halt_alert("x030102");
		}

		if (strlen(BG_DB_HOST) < 1 || strlen(BG_DB_NAME) < 1 || strlen(BG_DB_USER) < 1 || strlen(BG_DB_PASS) < 1 || strlen(BG_DB_CHARSET) < 1) {
			$this->obj_ajax->halt_alert("x030404");
		} else {
			$GLOBALS["obj_db"]   = new CLASS_MYSQL(); //初始化基类
			$this->obj_db        = $GLOBALS["obj_db"];
		}
	}


	private function check_opt() {
		$_arr_tableSelect = array(
			"table_name",
		);

		$_str_sqlWhere    = "table_schema='" . BG_DB_NAME . "'";
		$_arr_tableRows   = $GLOBALS["obj_db"]->select_array("information_schema`.`tables", $_arr_tableSelect, $_str_sqlWhere, 100, 0);

		foreach ($_arr_tableRows as $_key=>$_value) {
			$_arr_chks[] = $_value["table_name"];
		}

		if (!in_array(BG_DB_TABLE . "opt", $_arr_chks)) {
			$this->obj_ajax->halt_alert("x030412");
		}
	}
}
?>