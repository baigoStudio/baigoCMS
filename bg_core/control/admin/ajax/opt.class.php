<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "opt.class.php");

/*-------------管理员控制器-------------*/
class AJAX_OPT {

	private $adminLogged;
	private $obj_ajax;
	private $mdl_opt;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //已登录商家信息
		$this->obj_ajax       = new CLASS_AJAX(); //初始化 AJAX 基对象
		$this->mdl_opt        = new MODEL_OPT();
		if ($this->adminLogged["str_alert"] != "y020102") { //未登录，抛出错误信息
			$this->obj_ajax->halt_alert($this->adminLogged["str_alert"]);
		}
	}

	/**
	 * ajax_upload function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_upload() {
		if ($this->adminLogged["groupRow"]["group_allow"]["opt"]["upload"] != 1) {
			$this->obj_ajax->halt_alert("x060302");
		}

		$this->opt_post("upload");

		$this->obj_ajax->halt_alert("y060402");
	}


	/**
	 * ajax_sso function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_sso() {
		if ($this->adminLogged["groupRow"]["group_allow"]["opt"]["sso"] != 1) {
			$this->obj_ajax->halt_alert("x060303");
		}

		$this->opt_post("sso");

		$this->obj_ajax->halt_alert("y060403");
	}


	/**
	 * ajax_visit function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_visit() {
		if ($this->adminLogged["groupRow"]["group_allow"]["opt"]["visit"] != 1) {
			$this->obj_ajax->halt_alert("x060304");
		}

		$this->opt_post("visit");

		if ($_POST["opt"]["BG_VISIT_TYPE"] == "pstatic") {

			$_str_content = "# BEGIN baigo CMS" . PHP_EOL;
			$_str_content .= "<IfModule mod_rewrite.c>" . PHP_EOL;
				$_str_content .= "RewriteEngine On" . PHP_EOL;
				$_str_content .= "RewriteBase /" . PHP_EOL;
				$_str_content .= "RewriteRule ^article/([0-9]*)$ " . BG_URL_ROOT . "index.php?mod=article&act_get=show&article_id=$1 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^cate/(.*/)([0-9]*)/$ " . BG_URL_ROOT . "index.php?mod=cate&act_get=show&cate_id=$2 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^cate/(.*/)([0-9]*)$ " . BG_URL_ROOT . "index.php?mod=cate&act_get=show&cate_id=$2 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^cate/(.*/)([0-9]*)/([0-9]*)$ " . BG_URL_ROOT . "index.php?mod=cate&act_get=show&cate_id=$2&page=$3 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^tag/$ " . BG_URL_ROOT . "index.php?mod=tag&act_get=list [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^tag/(.*)/$ " . BG_URL_ROOT . "index.php?mod=tag&act_get=show&tag_name=$1 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^tag/(.*)/([0-9]*)$ " . BG_URL_ROOT . "index.php?mod=tag&act_get=show&tag_name=$1&page=$2 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^search/$ " . BG_URL_ROOT . "index.php?mod=search&act_get=show [L]" . PHP_EOL;
			$_str_content .= "</IfModule>" . PHP_EOL;
			$_str_content .= "# END baigo CMS" . PHP_EOL;

			file_put_contents(BG_PATH_ROOT . ".htaccess", $_str_content);

		} else {
			if (file_exists(BG_PATH_ROOT . ".htaccess")) {
				unlink(BG_PATH_ROOT . ".htaccess");
			}
		}

		$this->obj_ajax->halt_alert("y060404");
	}


	/**
	 * ajax_base function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_base() {
		if ($this->adminLogged["groupRow"]["group_allow"]["opt"]["base"] != 1) {
			$this->obj_ajax->halt_alert("x060301");
		}

		$this->opt_post("base");

		$this->obj_ajax->halt_alert("y060401");
	}


	/**
	 * ajax_db function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_db() {
		if ($this->adminLogged["groupRow"]["group_allow"]["opt"]["db"] != 1) {
			$this->obj_ajax->halt_alert("x060306");
		}

		$_str_dbHost      = fn_getSafe($_POST["db_host"], "txt", "localhost");
		$_str_dbName      = fn_getSafe($_POST["db_name"], "txt", "sso");
		$_str_dbUser      = fn_getSafe($_POST["db_user"], "txt", "sso");
		$_str_dbPass      = fn_getSafe($_POST["db_pass"], "txt", "");
		$_str_dbCharset   = fn_getSafe($_POST["db_charset"], "txt", "utf8");
		$_str_dbTable     = fn_getSafe($_POST["db_table"], "txt", "sso_");

		$_str_content = "<?php" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_HOST\", \"" . $_str_dbHost . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_NAME\", \"" . $_str_dbName . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_USER\", \"" . $_str_dbUser . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_PASS\", \"" . $_str_dbPass . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_CHARSET\", \"" . $_str_dbCharset . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_TABLE\", \"" . $_str_dbTable . "\");" . PHP_EOL;
		$_str_content .= "?>";

		file_put_contents(BG_PATH_CONFIG . "config_db.inc.php", $_str_content);

		$this->obj_ajax->halt_alert("y060405");
	}

	/**
	 * opt_post function.
	 *
	 * @access private
	 * @param mixed $str_type
	 * @return void
	 */
	private function opt_post($str_type) {
		if (!fn_token("chk")) { //令牌
			$this->obj_ajax->halt_alert("x030102");
		}

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
			$this->mdl_opt->mdl_submit($_key, $_str_optValue);
		}

		if ($str_type == "base") {
			$_str_content .= "define(\"BG_SITE_SSIN\", \"" . fn_rand(6) . "\");" . PHP_EOL;
		}

		$_str_content .= "?>";

		$_str_content = str_replace("||", "", $_str_content);

		file_put_contents(BG_PATH_CONFIG . "opt_" . $str_type . ".inc.php", $_str_content);
	}
}
?>