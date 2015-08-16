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

class AJAX_INSTALL {

	private $obj_sso;
	private $obj_ajax;
	private $obj_db;

	function __construct() { //构造函数
		$this->obj_ajax = new CLASS_AJAX(); //初始化 AJAX 基对象
		if (file_exists(BG_PATH_CONFIG . "is_install.php")) {
			$this->obj_ajax->halt_alert("x030403");
		}
		$this->install_init();
		$this->mdl_opt = new MODEL_OPT();
	}


	/**
	 * install_1_do function.
	 *
	 * @access public
	 * @return void
	 */
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
		$this->table_group();
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

		$_arr_opt = fn_post("opt");

		if ($_arr_opt["BG_VISIT_TYPE"] == "pstatic") {

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

		include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型
		include_once(BG_PATH_MODEL . "group.class.php"); //载入管理帐号模型
		$_mdl_admin  = new MODEL_ADMIN(); //设置管理组模型
		$_mdl_group  = new MODEL_GROUP(); //设置管理组模型

		$_arr_adminSubmit = $_mdl_admin->input_submit();
		if ($_arr_adminSubmit["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminSubmit["alert"]);
		}

		$_arr_adminInput = $this->input_admin();

		if ($_arr_adminInput["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminInput["alert"]);
		}

		$this->obj_sso = new CLASS_SSO();

		$_arr_ssoReg = $this->obj_sso->sso_reg($_arr_adminSubmit["admin_name"], $this->adminSubmit["admin_pass"], $_arr_adminSubmit["admin_mail"], $_arr_adminSubmit["admin_nick"]);
		if ($_arr_ssoReg["alert"] != "y010101") {
			$this->obj_ajax->halt_alert($_arr_ssoReg["alert"]);
		}

		$_mdl_admin->mdl_submit($_arr_ssoReg["user_id"]);

		$_arr_groupRow    = $_mdl_group->mdl_read(1);

		$_str_grouAllow   = json_encode($_arr_adminSubmit["group_allow"]);

		$_arr_groupData   = array(
			"group_name"     => "超级管理组",
			"group_note"     => "拥有所有权限",
			"group_allow"    => $_str_grouAllow,
			"group_type"     => "admin",
			"group_status"   => "enable",
		);

		if ($_arr_groupRow["alert"] == "y040102") {
			$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "group", $_arr_groupData, "group_id=1");
		} else {
			$_num_groupId = $this->obj_db->insert(BG_DB_TABLE . "group", $_arr_groupData);
			if ($_num_groupId <= 0 || !$_num_groupId) {
				$this->obj_ajax->halt_alert("x040101");
			}
		}

		$_mdl_admin->mdl_toGroup($_arr_ssoReg["user_id"], 1);

		$this->obj_ajax->halt_alert("y030409");
	}


	function ajax_auth() {
		$this->check_db();

		include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型
		include_once(BG_PATH_MODEL . "group.class.php"); //载入管理帐号模型
		$_mdl_admin  = new MODEL_ADMIN(); //设置管理组模型
		$_mdl_group  = new MODEL_GROUP(); //设置管理组模型

		$_arr_adminSubmit = $_mdl_admin->input_submit();
		if ($_arr_adminSubmit["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminSubmit["alert"]);
		}

		$_arr_adminAuth = $this->input_auth();

		if ($_arr_adminAuth["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminAuth["alert"]);
		}

		$this->obj_sso = new CLASS_SSO();

		$_arr_ssoLogin = $this->obj_sso->sso_login($_arr_adminSubmit["admin_name"], $this->adminAuth["admin_pass"]);
		if ($_arr_ssoLogin["alert"] != "y010401") {
			$this->obj_ajax->halt_alert($_arr_ssoLogin["alert"]);
		}

		$_mdl_admin->mdl_submit($_arr_ssoLogin["user_id"]);

		$_arr_groupRow    = $_mdl_group->mdl_read(1);

		$_str_grouAllow   = json_encode($_arr_adminSubmit["group_allow"]);

		$_arr_groupData   = array(
			"group_name"     => "超级管理组",
			"group_note"     => "拥有所有权限",
			"group_allow"    => $_str_grouAllow,
			"group_type"     => "admin",
			"group_status"   => "enable",
		);

		if ($_arr_groupRow["alert"] == "y040102") {
			$_num_mysql = $this->obj_db->update(BG_DB_TABLE . "group", $_arr_groupData, "group_id=1");
		} else {
			$_num_groupId = $this->obj_db->insert(BG_DB_TABLE . "group", $_arr_groupData);
			if ($_num_groupId <= 0 || !$_num_groupId) {
				$this->obj_ajax->halt_alert("x040101");
			}
		}

		$_mdl_admin->mdl_toGroup($_arr_ssoLogin["user_id"], 1);

		$this->obj_ajax->halt_alert("y030409");
	}


	function ajax_ssoAdmin() {
		$this->check_db();

		include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型
		$_mdl_admin  = new MODEL_ADMIN(); //设置管理组模型

		$_arr_adminSubmit = $_mdl_admin->input_submit();
		if ($_arr_adminSubmit["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminSubmit["alert"]);
		}

		$_arr_adminInput = $this->input_admin();

		if ($_arr_adminInput["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminInput["alert"]);
		}

		$this->obj_sso = new CLASS_SSO();

		$_arr_ssoReg = $this->obj_sso->sso_reg($_arr_adminSubmit["admin_name"], $this->adminSubmit["admin_pass"], $_arr_adminSubmit["admin_mail"], $_arr_adminSubmit["admin_nick"]);
		if ($_arr_ssoReg["alert"] != "y010101") {
			$this->obj_ajax->halt_alert($_arr_ssoReg["alert"]);
		}

		$_mdl_admin->mdl_submit($_arr_ssoReg["user_id"]);
		$_mdl_admin->mdl_toGroup($_arr_ssoReg["user_id"], 1);


		if (file_exists(BG_PATH_SSO)) {
			if (!file_exists(BG_PATH_SSO . "config/is_install.php")) {

				$_arr_ssoAdmin = $this->obj_sso->sso_admin($_arr_adminSubmit["admin_name"], $this->adminSubmit["admin_pass"]);

				if ($_arr_ssoAdmin["alert"] != "y020101" && $_arr_ssoAdmin["alert"] != "y020103") {
					$this->obj_ajax->halt_alert($_arr_ssoAdmin["alert"]);
				}

				$this->install_sso_over();
			}
		}

		$this->obj_ajax->halt_alert("y030409");
	}


	function ajax_over() {
		$this->check_db();

		$_arr_return = $this->mdl_opt->mdl_over();

		if ($_arr_return["alert"] != "y060101") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		$this->obj_ajax->halt_alert("y030411");
	}


	function ajax_chkauth() {
		include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型
		$_mdl_admin       = new MODEL_ADMIN(); //设置管理组模型
		$this->obj_sso    = new CLASS_SSO();

		$_str_adminName   = fn_getSafe(fn_get("admin_name"), "txt", "");
		$_arr_ssoGet      = $this->obj_sso->sso_get($_str_adminName, "user_name");

		if ($_arr_ssoGet["alert"] != "y010102") {
			if ($_arr_ssoGet["alert"] == "x010102") {
				$this->obj_ajax->halt_re("x020205");
			} else {
				$this->obj_ajax->halt_re($_arr_ssoGet["alert"]);
			}
		} else {
			//检验用户是否存在
			$_arr_adminRow = $this->mdl_admin->mdl_read($_arr_ssoGet["user_id"]);
			if ($_arr_adminRow["alert"] == "y020102") {
				$this->obj_ajax->halt_re("x020206");
			}
		}

		$arr_re = array(
			"re" => "ok"
		);

		exit(json_encode($arr_re));
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

		$_arr_adminRow    = $_mdl_admin->mdl_create_table();
		if ($_arr_adminRow["alert"] != "y020105") {
			$this->obj_ajax->halt_alert($_arr_adminRow["alert"]);
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

		$_arr_articleRow  = $_mdl_article->mdl_create_table();
		if ($_arr_articleRow["alert"] != "y120105") {
			$this->obj_ajax->halt_alert($_arr_articleRow["alert"]);
		}

		$_arr_articleRow  = $_mdl_article->mdl_create_index();
		if ($_arr_articleRow["alert"] != "y120109") {
			$this->obj_ajax->halt_alert($_arr_articleRow["alert"]);
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

		$_arr_callRow    = $_mdl_call->mdl_create_table();
		if ($_arr_callRow["alert"] != "y170105") {
			$this->obj_ajax->halt_alert($_arr_callRow["alert"]);
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

		$_arr_cateRow    = $_mdl_cate->mdl_create_table();
		if ($_arr_cateRow["alert"] != "y110105") {
			$this->obj_ajax->halt_alert($_arr_cateRow["alert"]);
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
		$_mdl_cateBelong = new MODEL_CATE_BELONG();

		$_arr_belongRow       = $_mdl_cateBelong->mdl_create_table();
		if ($_arr_belongRow["alert"] != "y150105") {
			$this->obj_ajax->halt_alert($_arr_belongRow["alert"]);
		}
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
		$_mdl_group       = new MODEL_GROUP();

		$_arr_groupRow    = $_mdl_group->mdl_create_table();
		if ($_arr_groupRow["alert"] != "y040105") {
			$this->obj_ajax->halt_alert($_arr_groupRow["alert"]);
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

		$_arr_markRow = $_mdl_mark->mdl_create_table();
		if ($_arr_markRow["alert"] != "y140105") {
			$this->obj_ajax->halt_alert($_arr_markRow["alert"]);
		}
	}


	private function table_spec() {
		include_once(BG_PATH_MODEL . "spec.class.php"); //载入管理帐号模型
		$_mdl_spec    = new MODEL_SPEC();

		$_arr_specRow = $_mdl_spec->mdl_create_table();
		if ($_arr_specRow["alert"] != "y180105") {
			$this->obj_ajax->halt_alert($_arr_specRow["alert"]);
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

		$_arr_mimeRow = $_mdl_mime->mdl_create_table();
		if ($_arr_mimeRow["alert"] != "y080105") {
			$this->obj_ajax->halt_alert($_arr_mimeRow["alert"]);
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

		$_arr_tagRow  = $_mdl_tag->mdl_create_table();
		if ($_arr_tagRow["alert"] != "y130105") {
			$this->obj_ajax->halt_alert($_arr_tagRow["alert"]);
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
		$_mdl_tagBelong   = new MODEL_TAG_BELONG();

		$_arr_belongRow   = $_mdl_tagBelong->mdl_create_table();
		if ($_arr_belongRow["alert"] != "y160105") {
			$this->obj_ajax->halt_alert($_arr_belongRow["alert"]);
		}

		$_arr_belongRow   = $_mdl_tagBelong->mdl_create_index();
		if ($_arr_belongRow["alert"] != "y160109") {
			$this->obj_ajax->halt_alert($_arr_belongRow["alert"]);
		}
	}


	private function view_tag() {
		include_once(BG_PATH_MODEL . "tagBelong.class.php"); //载入管理帐号模型
		$_mdl_tagBelong  = new MODEL_TAG_BELONG();

		$_arr_tagBelongRow  = $_mdl_tagBelong->mdl_create_view();
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
		$_mdl_thumb  = new MODEL_THUMB();

		$_arr_thumbRow    = $_mdl_thumb->mdl_create_table();
		if ($_arr_thumbRow["alert"] != "y090105") {
			$this->obj_ajax->halt_alert($_arr_thumbRow["alert"]);
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

		$_arr_attachRow    = $_mdl_attach->mdl_create_table();
		if ($_arr_attachRow["alert"] != "y070105") {
			$this->obj_ajax->halt_alert($_arr_attachRow["alert"]);
		}
	}


	private function table_app() {
		include_once(BG_PATH_MODEL . "app.class.php"); //载入管理帐号模型
		$_mdl_app     = new MODEL_APP();

		$_arr_appRow  = $_mdl_app->mdl_create_table();
		if ($_arr_appRow["alert"] != "y190105") {
			$this->obj_ajax->halt_alert($_arr_appRow["alert"]);
		}
	}


	private function table_custom() {
		include_once(BG_PATH_MODEL . "custom.class.php"); //载入管理帐号模型
		$_mdl_custom     = new MODEL_CUSTOM();

		$_arr_customRow  = $_mdl_custom->mdl_create_table();
		if ($_arr_customRow["alert"] != "y200105") {
			$this->obj_ajax->halt_alert($_arr_customRow["alert"]);
		}
	}



	private function view_custom() {

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
		$_str_content .= "define(\"BG_DB_PORT\", \"" . BG_DB_PORT . "\");" . PHP_EOL;
		$_str_content .= "define(\"BG_DB_NAME\", \"" . BG_DB_NAME . "\");" . PHP_EOL;
		$_str_content .= "define(\"BG_DB_USER\", \"" . BG_DB_USER . "\");" . PHP_EOL;
		$_str_content .= "define(\"BG_DB_PASS\", \"" . BG_DB_PASS . "\");" . PHP_EOL;
		$_str_content .= "define(\"BG_DB_CHARSET\", \"utf8\");" . PHP_EOL;
		$_str_content .= "define(\"BG_DB_TABLE\", \"sso_\");" . PHP_EOL;

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


	private function input_admin() {
		$_arr_adminPass = validateStr(fn_post("admin_pass"), 1, 0);
		switch ($_arr_adminPass["status"]) {
			case "too_short":
				return array(
					"alert" => "x020210",
				);
				exit;
			break;

			case "ok":
				$this->adminSubmit["admin_pass"] = $_arr_adminPass["str"];
			break;
		}

		$_arr_adminPassConfirm = validateStr(fn_post("admin_pass_confirm"), 1, 0);
		switch ($_arr_adminPassConfirm["status"]) {
			case "too_short":
				return array(
					"alert" => "x020215",
				);
				exit;
			break;

			case "ok":
				$this->adminSubmit["admin_pass_confirm"] = $_arr_adminPassConfirm["str"];
			break;
		}

		if ($this->adminSubmit["admin_pass"] != $this->adminSubmit["admin_pass_confirm"]) {
			return array(
				"alert" => "x020211",
			);
			exit;
		}

		$this->adminSubmit["group_allow"] = fn_post("group_allow");

		$this->adminSubmit["alert"]       = "ok";

		return $this->adminSubmit;
	}


	private function input_auth() {
		$_arr_adminPass = validateStr(fn_post("admin_pass"), 1, 0);
		switch ($_arr_adminPass["status"]) {
			case "too_short":
				return array(
					"alert" => "x020210",
				);
				exit;
			break;

			case "ok":
				$this->adminAuth["admin_pass"] = $_arr_adminPass["str"];
			break;
		}

		$this->adminAuth["alert"] = "ok";

		return $this->adminAuth;
	}


	private function install_sso_over() {
		include_once(BG_PATH_SSO . "core/inc/version.inc.php");

		$_str_content = "<?php" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_VER\", \"" . PRD_SSO_VER . "\");" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_PUB\", " . PRD_SSO_PUB . ");" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_TIME\", " . time() . ");" . PHP_EOL;

		file_put_contents(BG_PATH_SSO . "config/is_install.php", $_str_content);
	}


	private function check_db() {
		if (strlen(BG_DB_HOST) < 1 || strlen(BG_DB_NAME) < 1 || strlen(BG_DB_USER) < 1 || strlen(BG_DB_PASS) < 1 || strlen(BG_DB_CHARSET) < 1) {
			$this->obj_ajax->halt_alert("x030404");
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


	private function install_init() {
		$_arr_extRow     = get_loaded_extensions();
		$_num_errCount   = 0;

		foreach ($this->obj_ajax->type["ext"] as $_key=>$_value) {
			if (!in_array($_key, $_arr_extRow)) {
				$_num_errCount++;
			}
		}

		if ($_num_errCount > 0) {
			$this->obj_ajax->halt_alert("x030417");
		}
	}
}