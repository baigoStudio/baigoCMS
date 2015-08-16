<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------管理员模型-------------*/
class MODEL_OPT {

	function mdl_const($str_type) {
		if (!fn_token("chk")) { //令牌
			$this->obj_ajax->halt_alert("x030102");
		}

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
		}

		if ($str_type == "base") {
			$_str_content .= "define(\"BG_SITE_SSIN\", \"" . fn_rand(6) . "\");" . PHP_EOL;
		} else if ($str_type == "visit") {
			if ($_arr_opt["BG_VISIT_TYPE"] != "static") {
				$_str_content .= "define(\"BG_VISIT_FILE\", \"html\");" . PHP_EOL;
			}
		}

		$_str_content = str_replace("||", "", $_str_content);

		$_num_size    = file_put_contents(BG_PATH_CONFIG . "opt_" . $str_type . ".inc.php", $_str_content);

		if ($_num_size > 0) {
			$_str_alert = "y060101";
		} else {
			$_str_alert = "x060101";
		}

		return array(
			"alert" => $_str_alert,
		);
	}


	function mdl_htaccess() {
		$_str_content = "# BEGIN baigo CMS" . PHP_EOL;
		$_str_content .= "<IfModule mod_rewrite.c>" . PHP_EOL;
			$_str_content .= "RewriteEngine On" . PHP_EOL;
			$_str_content .= "RewriteBase " . BG_URL_ROOT . PHP_EOL;
			$_str_content .= "RewriteRule ^article/id-(\d+)/?.*$ " . BG_URL_ROOT . "index.php?mod=article&act_get=show&article_id=$1 [L]" . PHP_EOL;
			$_str_content .= "RewriteRule ^cate/[^\\x00\-\\xff]+/id-(\d+)(/key-([^\\x00\-\\xff^/]*))?(/customs-((\w|%)*))?(/page-(\d+))?/?.*$ " . BG_URL_ROOT . "index.php?mod=cate&act_get=show&cate_id=$1&key=$3&customs=$5&page=$8 [L]" . PHP_EOL;
			$_str_content .= "RewriteRule ^tag/tag-([^\\x00\-\\xff^/]*)(/page-(\d+))?/?.*$ " . BG_URL_ROOT . "index.php?mod=tag&act_get=show&tag_name=$1&page=$3 [L]" . PHP_EOL;
			$_str_content .= "RewriteRule ^spec/id-(\d+)(/page-(\d+))?/?.*$ " . BG_URL_ROOT . "index.php?mod=spec&act_get=show&spec_id=$1&page=$3 [L]" . PHP_EOL;
			$_str_content .= "RewriteRule ^spec(/page-(\d+))?/?.*$ " . BG_URL_ROOT . "index.php?mod=spec&act_get=list&page=$2 [L]" . PHP_EOL;
			$_str_content .= "RewriteRule ^search(/key-([^\\x00\-\\xff^/]*))?(/customs-((\w|%)*))?(/cate-(\d+))?(/page-(\d+))?/?.*$ " . BG_URL_ROOT . "index.php?mod=search&act_get=show&key=$2&customs=$4&cate_id=$7&page=$9 [L]" . PHP_EOL;
		$_str_content .= "</IfModule>" . PHP_EOL;
		$_str_content .= "# END baigo CMS" . PHP_EOL;

		$_num_size = file_put_contents(BG_PATH_ROOT . ".htaccess", $_str_content);

		if ($_num_size > 0) {
			$_str_alert = "y060101";
		} else {
			$_str_alert = "x060101";
		}

		return array(
			"alert" => $_str_alert,
		);
	}


	function mdl_dbconfig() {
		if (!fn_token("chk")) { //令牌
			return array(
				"alert" => "x030102",
			);
			exit;
		}

		$_str_dbHost      = fn_getSafe(fn_post("db_host"), "txt", "localhost");
		$_str_dbPort      = fn_getSafe(fn_post("db_port"), "txt", "3306");
		$_str_dbName      = fn_getSafe(fn_post("db_name"), "txt", "baigo_cms");
		$_str_dbUser      = fn_getSafe(fn_post("db_user"), "txt", "baigo_cms");
		$_str_dbPass      = fn_getSafe(fn_post("db_pass"), "txt", "");
		$_str_dbCharset   = fn_getSafe(fn_post("db_charset"), "txt", "utf8");
		$_str_dbTable     = fn_getSafe(fn_post("db_table"), "txt", "cms_");

		$_str_content     = "<?php" . PHP_EOL;
		$_str_content    .= "define(\"BG_DB_HOST\", \"" . $_str_dbHost . "\");" . PHP_EOL;
		$_str_content    .= "define(\"BG_DB_PORT\", \"" . $_str_dbPort . "\");" . PHP_EOL;
		$_str_content    .= "define(\"BG_DB_NAME\", \"" . $_str_dbName . "\");" . PHP_EOL;
		$_str_content    .= "define(\"BG_DB_USER\", \"" . $_str_dbUser . "\");" . PHP_EOL;
		$_str_content    .= "define(\"BG_DB_PASS\", \"" . $_str_dbPass . "\");" . PHP_EOL;
		$_str_content    .= "define(\"BG_DB_CHARSET\", \"" . $_str_dbCharset . "\");" . PHP_EOL;
		$_str_content    .= "define(\"BG_DB_TABLE\", \"" . $_str_dbTable . "\");" . PHP_EOL;

		$_num_size        = file_put_contents(BG_PATH_CONFIG . "config_db.inc.php", $_str_content);

		if ($_num_size > 0) {
			$_str_alert = "y060101";
		} else {
			$_str_alert = "x060101";
		}

		return array(
			"alert" => $_str_alert,
		);
	}


	function mdl_over() {
		if (!fn_token("chk")) { //令牌
			return array(
				"alert" => "x030102",
			);
			exit;
		}

		$_str_content = "<?php" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_VER\", \"" . PRD_CMS_VER . "\");" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_PUB\", " . PRD_CMS_PUB . ");" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_TIME\", " . time() . ");" . PHP_EOL;

		$_num_size = file_put_contents(BG_PATH_CONFIG . "is_install.php", $_str_content);
		if ($_num_size > 0) {
			$_str_alert = "y060101";
		} else {
			$_str_alert = "x060101";
		}

		return array(
			"alert" => $_str_alert,
		);
	}
}
