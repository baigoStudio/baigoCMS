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

class AJAX_INSTALL {

	private $obj_sso;
	private $obj_ajax;
	private $obj_db;

	function __construct() { //构造函数
		$this->obj_ajax = new CLASS_AJAX(); //初始化 AJAX 基对象
		if (file_exists(BG_PATH_CONFIG . "is_install.php")) {
			$this->obj_ajax->halt_alert("x030403");
		}
	}


	/**
	 * install_1_do function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_dbconfig() {
		if (!fn_token("chk")) { //令牌
			$this->obj_ajax->halt_alert("x030102");
		}

		$_str_dbHost      = fn_getSafe($_POST["db_host"], "txt", "localhost");
		$_str_dbName      = fn_getSafe($_POST["db_name"], "txt", "baigo_cms");
		$_str_dbUser      = fn_getSafe($_POST["db_user"], "txt", "baigo_cms");
		$_str_dbPass      = fn_getSafe($_POST["db_pass"], "txt", "");
		$_str_dbCharset   = fn_getSafe($_POST["db_charset"], "txt", "utf8");
		$_str_dbTable     = fn_getSafe($_POST["db_table"], "txt", "bg_");

		$_str_content = "<?php" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_HOST\", \"" . $_str_dbHost . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_NAME\", \"" . $_str_dbName . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_USER\", \"" . $_str_dbUser . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_PASS\", \"" . $_str_dbPass . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_CHARSET\", \"" . $_str_dbCharset . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_TABLE\", \"" . $_str_dbTable . "\");" . PHP_EOL;
		$_str_content .= "?>";

		file_put_contents(BG_PATH_CONFIG . "config_db.inc.php", $_str_content);

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
		$this->table_group();
		$this->table_mark();
		$this->table_mime();
		$this->table_opt();
		$this->table_tag();
		$this->table_tag_belong();
		$this->table_thumb();
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

		if ($_POST["opt"]["BG_VISIT_TYPE"] == "pstatic") {

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


	/**
	 * install_7 function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_ssoAuto() {
		if (file_exists(BG_PATH_SSO . "config/is_install.php")) {
			$this->obj_ajax->halt_alert("x030408");
		}

		$this->check_db();
		$this->check_opt();

		$this->sso_dbconfig();
		$this->sso_base();
		$this->sso_reg();

		$this->obj_ajax->halt_alert("y030410");
	}


	/**
	 * install_8 function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_admin() {
		$this->check_db();
		$this->check_opt();

		include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型
		$_mdl_admin  = new MODEL_ADMIN(); //设置管理组模型

		$_arr_adminSubmit = $_mdl_admin->input_submit();
		if ($_arr_adminSubmit["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminSubmit["str_alert"]);
		}

		$_arr_adminInput = $this->input_admin();

		if ($_arr_adminInput["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminInput["str_alert"]);
		}

		$this->obj_sso = new CLASS_SSO();

		$_arr_ssoReg = $this->obj_sso->sso_reg($_arr_adminSubmit["admin_name"], $this->adminSubmit["admin_pass"], $_arr_adminSubmit["admin_mail"], $_arr_adminSubmit["admin_nick"]);
		if ($_arr_ssoReg["str_alert"] != "y010101") {
			$this->obj_ajax->halt_alert($_arr_ssoReg["str_alert"]);
		}

		$_mdl_admin->mdl_submit($_arr_ssoReg["user_id"]);
		$_mdl_admin->mdl_toGroup($_arr_ssoReg["user_id"], 1);

		$this->obj_ajax->halt_alert("y030409");
	}


	function ajax_auth() {
		$this->check_db();
		$this->check_opt();

		include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型
		$_mdl_admin  = new MODEL_ADMIN(); //设置管理组模型

		$_arr_adminSubmit = $_mdl_admin->input_submit();
		if ($_arr_adminSubmit["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminSubmit["str_alert"]);
		}

		$_arr_adminAuth = $this->input_auth();

		if ($_arr_adminAuth["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminAuth["str_alert"]);
		}

		$this->obj_sso = new CLASS_SSO();

		$_arr_ssoLogin = $this->obj_sso->sso_login($_arr_adminSubmit["admin_name"], $this->adminAuth["admin_pass"]);
		if ($_arr_ssoLogin["str_alert"] != "y010401") {
			$this->obj_ajax->halt_alert($_arr_ssoLogin["str_alert"]);
		}

		$_mdl_admin->mdl_submit($_arr_ssoLogin["user_id"]);
		$_mdl_admin->mdl_toGroup($_arr_ssoLogin["user_id"], 1);

		$this->obj_ajax->halt_alert("y030409");
	}


	function ajax_ssoAdmin() {
		$this->check_db();
		$this->check_opt();

		include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型
		$_mdl_admin  = new MODEL_ADMIN(); //设置管理组模型

		$_arr_adminSubmit = $_mdl_admin->input_submit();
		if ($_arr_adminSubmit["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminSubmit["str_alert"]);
		}

		$_arr_adminInput = $this->input_admin();

		if ($_arr_adminInput["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminInput["str_alert"]);
		}

		$this->obj_sso = new CLASS_SSO();

		$_arr_ssoReg = $this->obj_sso->sso_reg($_arr_adminSubmit["admin_name"], $this->adminSubmit["admin_pass"], $_arr_adminSubmit["admin_mail"], $_arr_adminSubmit["admin_nick"]);
		if ($_arr_ssoReg["str_alert"] != "y010101") {
			$this->obj_ajax->halt_alert($_arr_ssoReg["str_alert"]);
		}

		$_mdl_admin->mdl_submit($_arr_ssoReg["user_id"]);
		$_mdl_admin->mdl_toGroup($_arr_ssoReg["user_id"], 1);


		if (file_exists(BG_PATH_SSO)) {
			if (!file_exists(BG_PATH_SSO . "config/is_install.php")) {

				$_arr_ssoAdmin = $this->obj_sso->sso_admin($_arr_adminSubmit["admin_name"], $this->adminSubmit["admin_pass"]);

				if ($_arr_ssoAdmin["str_alert"] != "y020101" && $_arr_ssoAdmin["str_alert"] != "y020103") {
					$this->obj_ajax->halt_alert($_arr_ssoAdmin["str_alert"]);
				}

				$this->install_sso_over();
			}
		}

		$this->obj_ajax->halt_alert("y030409");
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


	function ajax_chkauth() {
		include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型
		$_mdl_admin       = new MODEL_ADMIN(); //设置管理组模型
		$this->obj_sso    = new CLASS_SSO();

		$_str_adminName   = fn_getSafe($_GET["admin_name"], "txt", "");
		$_arr_ssoGet      = $this->obj_sso->sso_get($_str_adminName, "user_name");

		if ($_arr_ssoGet["str_alert"] != "y010102") {
			if ($_arr_ssoGet["str_alert"] == "x010102") {
				$this->obj_ajax->halt_re("x020205");
			} else {
				$this->obj_ajax->halt_re($_arr_ssoGet["str_alert"]);
			}
		} else {
			//检验用户是否存在
			$_arr_adminRow = $this->mdl_admin->mdl_read($_arr_ssoGet["user_id"]);
			if ($_arr_adminRow["str_alert"] == "y020102") {
				$this->obj_ajax->halt_re("x020206");
			}
		}

		$arr_re = array(
			"re" => "ok"
		);

		exit(json_encode($arr_re));
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

		$_arr_opt = $_POST["opt"];

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
		$_arr_adminRow    = $_mdl_admin->mdl_create();

		if ($_arr_adminRow["str_alert"] != "y020105") {
			$this->obj_ajax->halt_alert($_arr_adminRow["str_alert"]);
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

		$_arr_articleRow  = $_mdl_article->mdl_create();
		if ($_arr_articleRow["str_alert"] != "y120105") {
			$this->obj_ajax->halt_alert($_arr_articleRow["str_alert"]);
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
		$_arr_callRow    = $_mdl_call->mdl_create();

		if ($_arr_callRow["str_alert"] != "y170105") {
			$this->obj_ajax->halt_alert($_arr_callRow["str_alert"]);
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
		$_mdl_cate  = new MODEL_CATE();
		$_arr_cateRow    = $_mdl_cate->mdl_create();

		if ($_arr_cateRow["str_alert"] != "y110105") {
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
		$_mdl_cateBelong = new MODEL_CATE_BELONG();
		$_arr_belongRow       = $_mdl_cateBelong->mdl_create();

		if ($_arr_belongRow["str_alert"] != "y150105") {
			$this->obj_ajax->halt_alert($_arr_belongRow["str_alert"]);
		}
	}


	private function view_article() {
		include_once(BG_PATH_MODEL . "articlePub.class.php"); //载入管理帐号模型
		$_mdl_articlePub  = new MODEL_ARTICLE_PUB();

		$_arr_articlePubRow  = $_mdl_articlePub->mdl_create();
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
		$_arr_groupRow    = $_mdl_group->mdl_create();

		if ($_arr_groupRow["str_alert"] != "y040105") {
			$this->obj_ajax->halt_alert($_arr_groupRow["str_alert"]);
		}

		$_arr_groupRow = $_mdl_group->mdl_read(1);

		$_arr_grouAllow   = array(
			"article"        => array(
				"browse"        => 1,
				"add"           => 1,
				"edit"          => 1,
				"del"           => 1,
				"approve"       => 1,
				"tag"           => 1,
				"mark"          => 1,
			),
			"cate"           => array(
				"browse"        => 1,
				"add"           => 1,
				"edit"          => 1,
				"del"           => 1,
			),
			"attach"         => array(
				"browse"        => 1,
				"del"           => 1,
				"upload"        => 1,
				"mime"          => 1,
				"thumb"         => 1,
			),
			"call"           => array(
				"browse"        => 1,
				"add"           => 1,
				"edit"          => 1,
				"del"           => 1,
				"gen"           => 1,
			),
			"admin"          => array(
				"browse"        => 1,
				"add"           => 1,
				"edit"          => 1,
				"del"           => 1,
				"toGroup"       => 1,
			),
			"group"          => array(
				"browse"        => 1,
				"add"           => 1,
				"edit"          => 1,
				"del"           => 1,
			),
			"opt"            => array(
				"db"            => 1,
				"base"          => 1,
				"visit"         => 1,
				"upload"        => 1,
				"sso"           => 1,
				"gen"           => 1,
			),
		);

		$_str_grouAllow = json_encode($_arr_grouAllow);

		$_arr_groupData = array(
			"group_name"     => "超级管理组",
			"group_note"     => "拥有所有权限",
			"group_allow"    => $_str_grouAllow,
			"group_type"     => "admin",
			"group_status"   => "enable",
		);

		if ($_arr_groupRow["str_alert"] == "y040102") {
			$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "group", $_arr_groupData, "group_id=1");
		} else {
			$_num_groupId = $this->obj_db->insert(BG_DB_TABLE . "group", $_arr_groupData);
			if ($_num_groupId <= 0 || !$_num_groupId) {
				$this->obj_ajax->halt_alert("x040101");
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
		$_arr_markRow = $_mdl_mark->mdl_create();

		if ($_arr_markRow["str_alert"] != "y140105") {
			$this->obj_ajax->halt_alert($_arr_markRow["str_alert"]);
		}
	}


	private function table_spec() {
		include_once(BG_PATH_MODEL . "spec.class.php"); //载入管理帐号模型
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
		include_once(BG_PATH_MODEL . "mime.class.php"); //载入管理帐号模型
		$_mdl_mime    = new MODEL_MIME();
		$_arr_mimeRow = $_mdl_mime->mdl_create();

		if ($_arr_mimeRow["str_alert"] != "y080105") {
			$this->obj_ajax->halt_alert($_arr_mimeRow["str_alert"]);
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
		$_arr_optRow  = $_mdl_opt->mdl_create();

		if ($_arr_optRow["str_alert"] != "y060105") {
			$this->obj_ajax->halt_alert($_arr_optRow["str_alert"]);
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
		$_mdl_tag     = new MODEL_TAG();

		$_arr_tagRow  = $_mdl_tag->mdl_create();
		if ($_arr_tagRow["str_alert"] != "y130105") {
			$this->obj_ajax->halt_alert($_arr_tagRow["str_alert"]);
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
		$_arr_belongRow    = $_mdl_tagBelong->mdl_create();

		if ($_arr_belongRow["str_alert"] != "y160105") {
			$this->obj_ajax->halt_alert($_arr_belongRow["str_alert"]);
		}
	}


	private function view_tag() {
		include_once(BG_PATH_MODEL . "tagPub.class.php"); //载入管理帐号模型
		$_mdl_tagPub  = new MODEL_TAG_PUB();

		$_arr_tagPubRow  = $_mdl_tagPub->mdl_create();
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
		include_once(BG_PATH_MODEL . "thumb.class.php"); //载入管理帐号模型
		$_mdl_thumb  = new MODEL_THUMB();
		$_arr_thumbRow    = $_mdl_thumb->mdl_create();

		if ($_arr_thumbRow["str_alert"] != "y090105") {
			$this->obj_ajax->halt_alert($_arr_thumbRow["str_alert"]);
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
		$_mdl_attach  = new MODEL_ATTACH();
		$_arr_attachRow    = $_mdl_attach->mdl_create();

		if ($_arr_attachRow["str_alert"] != "y070105") {
			$this->obj_ajax->halt_alert($_arr_attachRow["str_alert"]);
		}
	}


	/**
	 * sso_dbconfig function.
	 *
	 * @access private
	 * @return void
	 */
	private function sso_dbconfig() {
		$_str_content = "<?php" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_HOST\", \"" . BG_DB_HOST . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_NAME\", \"" . BG_DB_NAME . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_USER\", \"" . BG_DB_USER . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_PASS\", \"" . BG_DB_PASS . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_CHARSET\", \"utf8\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_TABLE\", \"sso_\");" . PHP_EOL;
		$_str_content .= "?>";

		file_put_contents(BG_PATH_SSO . "config/config_db.inc.php", $_str_content);
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


	private function input_admin() {
		$_arr_adminPass = validateStr($_POST["admin_pass"], 1, 0);
		switch ($_arr_adminPass["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x020210",
				);
				exit;
			break;

			case "ok":
				$this->adminSubmit["admin_pass"] = $_arr_adminPass["str"];
			break;
		}

		$_arr_adminPassConfirm = validateStr($_POST["admin_pass_confirm"], 1, 0);
		switch ($_arr_adminPassConfirm["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x020215",
				);
				exit;
			break;

			case "ok":
				$this->adminSubmit["admin_pass_confirm"] = $_arr_adminPassConfirm["str"];
			break;
		}

		if ($this->adminSubmit["admin_pass"] != $this->adminSubmit["admin_pass_confirm"]) {
			return array(
				"str_alert" => "x020211",
			);
			exit;
		}

		$this->adminSubmit["str_alert"] = "ok";

		return $this->adminSubmit;
	}


	private function input_auth() {
		$_arr_adminPass = validateStr($_POST["admin_pass"], 1, 0);
		switch ($_arr_adminPass["status"]) {
			case "too_short":
				return array(
					"str_alert" => "x020210",
				);
				exit;
			break;

			case "ok":
				$this->adminAuth["admin_pass"] = $_arr_adminPass["str"];
			break;
		}

		$this->adminAuth["str_alert"] = "ok";

		return $this->adminAuth;
	}


	private function install_sso_over() {
		include_once(BG_PATH_SSO . "core/inc/version.inc.php");

		$_str_content = "<?php" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_VER\", \"" . PRD_SSO_VER . "\");" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_PUB\", " . PRD_SSO_PUB . ");" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_TIME\", " . time() . ");" . PHP_EOL;
		$_str_content .= "?>";

		file_put_contents(BG_PATH_SSO . "config/is_install.php", $_str_content);
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