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
include_once(BG_PATH_FUNC . "admin.func.php"); //载入开放平台类
include_once(BG_PATH_CLASS . "sso.class.php"); //载入 AJAX 基类
include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "opt.class.php"); //载入管理帐号模型
include_once(BG_PATH_MODEL . "admin.class.php"); //载入管理帐号模型

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
		if (strlen(BG_DB_HOST) < 1 || strlen(BG_DB_NAME) < 1 || strlen(BG_DB_USER) < 1 || strlen(BG_DB_PASS) < 1 || strlen(BG_DB_CHARSET) < 1) {
			$this->obj_ajax->halt_alert("x030404");
		}

		$this->obj_db = new CLASS_MYSQL(); //初始化基类

		$_str_sql = "CREATE TABLE IF NOT EXISTS `" . BG_DB_TABLE . "admin` (
			`admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`admin_name` varchar(30) NOT NULL COMMENT '用户名',
			`admin_note` varchar(30) NOT NULL COMMENT '备注',
			`admin_rand` varchar(6) NOT NULL COMMENT '随机码',
			`admin_allow_cate` varchar(1000) NOT NULL COMMENT '栏目权限',
			`admin_group_id` int(11) NOT NULL COMMENT '从属用户组ID',
			`admin_time` int(11) NOT NULL COMMENT '登录时间',
			`admin_time_login` int(11) NOT NULL COMMENT '最后登录',
			`admin_status` varchar(10) NOT NULL COMMENT '状态',
			`admin_ip` varchar(15) NOT NULL COMMENT 'IP',
			PRIMARY KEY (`admin_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理帐号' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030103");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `" . BG_DB_TABLE . "article` (
			`article_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`article_cate_id` int(11) NOT NULL COMMENT '栏目ID',
			`article_title` varchar(300) NOT NULL COMMENT '标题',
			`article_excerpt` varchar(900) NOT NULL COMMENT '内容提要',
			`article_content` text NOT NULL COMMENT '内容',
			`article_mark_id` int(11) NOT NULL COMMENT '标记 ID',
			`article_status` varchar(20) NOT NULL COMMENT '状态',
			`article_box` varchar(20) NOT NULL COMMENT '盒子',
			`article_link` varchar(900) NOT NULL COMMENT '链接',
			`article_tag` varchar(300) NOT NULL COMMENT 'TAG',
			`article_time` int(11) NOT NULL COMMENT '时间',
			`article_time_pub` int(11) NOT NULL COMMENT '定时发布',
			`article_admin_id` int(11) NOT NULL COMMENT '发布用户',
			`article_hits_day` int(11) NOT NULL COMMENT '日点击',
			`article_hits_week` int(11) NOT NULL COMMENT '周点击',
			`article_hits_month` int(11) NOT NULL COMMENT '月点击',
			`article_hits_year` int(11) NOT NULL COMMENT '年点击',
			`article_hits_all` int(11) NOT NULL COMMENT '总点击',
			`article_top` int(11) NOT NULL COMMENT '置顶',
			`article_upfile_id` int(11) NOT NULL COMMENT '附件ID',
			PRIMARY KEY (`article_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030104");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `" . BG_DB_TABLE . "call` (
			`call_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`call_show` varchar(300) NOT NULL COMMENT '现实选项',
			`call_name` varchar(300) NOT NULL COMMENT '调用名',
			`call_type` varchar(20) NOT NULL COMMENT '调用类型',
			`call_cate_ids` varchar(300) NOT NULL COMMENT '栏目ID',
			`call_cate_id` int(11) NOT NULL COMMENT '栏目ID',
			`call_file` varchar(10) NOT NULL COMMENT '静态文件类型',
			`call_amount` varchar(300) NOT NULL COMMENT '显示数选项',
			`call_mark_ids` varchar(300) NOT NULL COMMENT '标记ID',
			`call_upfile` varchar(20) NOT NULL COMMENT '含有附件',
			`call_hits` varchar(20) NOT NULL COMMENT '排行类型',
			`call_trim` int(11) NOT NULL COMMENT '标题字数',
			`call_status` varchar(20) NOT NULL COMMENT '状态',
			`call_css` varchar(300) NOT NULL COMMENT 'CSS名',
			PRIMARY KEY (`call_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='调用' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030105");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `" . BG_DB_TABLE . "cate` (
			`cate_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`cate_name` varchar(300) NOT NULL COMMENT '站点名称',
			`cate_domain` varchar(3000) NOT NULL COMMENT '绑定域名',
			`cate_type` varchar(50) NOT NULL COMMENT '类型',
			`cate_tpl` varchar(1000) NOT NULL COMMENT '模板',
			`cate_content` text NOT NULL COMMENT '栏目内容',
			`cate_link` varchar(3000) NOT NULL COMMENT '链接地址',
			`cate_parent_id` int(11) NOT NULL COMMENT '父栏目',
			`cate_alias` varchar(300) NOT NULL COMMENT '别名',
			`cate_ftp_host` varchar(3000) NOT NULL COMMENT '站点FTP服务器',
			`cate_ftp_port` varchar(5) NOT NULL COMMENT 'FTP端口',
			`cate_ftp_user` varchar(300) NOT NULL COMMENT '站点FTP用户名',
			`cate_ftp_pass` varchar(300) NOT NULL COMMENT '站点FTP密码',
			`cate_ftp_path` varchar(3000) NOT NULL COMMENT '站点FTP目录',
			`cate_status` varchar(20) NOT NULL COMMENT '状态',
			`cate_order` int(11) NOT NULL COMMENT '排序',
			PRIMARY KEY (`cate_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='栏目' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030106");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `" . BG_DB_TABLE . "cate_belong` (
			`belong_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`belong_cate_id` int(11) NOT NULL COMMENT '栏目 ID',
			`belong_article_id` int(11) NOT NULL COMMENT '文章 ID',
			PRIMARY KEY (`belong_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='栏目从属' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030107");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `" . BG_DB_TABLE . "group` (
			`group_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`group_name` varchar(30) NOT NULL COMMENT '组名',
			`group_note` varchar(30) NOT NULL COMMENT '备注',
			`group_allow` varchar(1000) NOT NULL COMMENT '权限',
			`group_type` varchar(20) NOT NULL COMMENT '类型',
			PRIMARY KEY (`group_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理组' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030108");
		}

		$_str_sql = "DELETE FROM `" . BG_DB_TABLE . "group`";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030109");
		}

		$_arr_grouAllow = array(
			"article" => array(
				"browse"     => 1,
				"add"        => 1,
				"edit"       => 1,
				"del"        => 1,
				"approve"    => 1,
				"tag"        => 1,
				"mark"       => 1,
			),
			"cate"    => array(
				"browse" => 1,
				"add"    => 1,
				"edit"   => 1,
				"del"    => 1,
			),
			"upfile"  => array(
				"browse" => 1,
				"del"    => 1,
				"upload" => 1,
				"mime"   => 1,
				"thumb"  => 1,
			),
			"call"    => array(
				"browse" => 1,
				"add"    => 1,
				"edit"   => 1,
				"del"    => 1,
				"gen"    => 1,
			),
			"admin"   => array(
				"browse"     => 1,
				"add"        => 1,
				"edit"       => 1,
				"del"        => 1,
				"toGroup"    => 1,
			),
			"group"   => array(
				"browse" => 1,
				"add"    => 1,
				"edit"   => 1,
				"del"    => 1,
			),
			"opt"     => array(
				"db"     => 1,
				"base"   => 1,
				"visit"  => 1,
				"upfile" => 1,
				"sso"    => 1,
				"gen"    => 1,
			),
		);

		$_str_grouAllow = json_encode($_arr_grouAllow);

		$_str_sql = "INSERT INTO `" . BG_DB_TABLE . "group` (`group_id`, `group_name`, `group_note`, `group_allow`, `group_type`) VALUES (1, '超级管理组', '拥有全部权限', '" . $_str_grouAllow . "', 'admin')";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030109");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `" . BG_DB_TABLE . "mark` (
			`mark_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`mark_name` varchar(30) NOT NULL COMMENT '标记名称',
			PRIMARY KEY (`mark_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='标记' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030110");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `" . BG_DB_TABLE . "mime` (
			`mime_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`mime_name` varchar(300) NOT NULL COMMENT 'MIME',
			`mime_note` varchar(300) NOT NULL COMMENT '备注',
			`mime_ext` varchar(10) NOT NULL COMMENT '扩展名',
			PRIMARY KEY (`mime_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='允许类型' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030111");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `" . BG_DB_TABLE . "opt` (
			`opt_key` varchar(100) NOT NULL COMMENT '键',
			`opt_value` varchar(3000) NOT NULL COMMENT '值',
			PRIMARY KEY (`opt_key`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='配置'";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030112");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `" . BG_DB_TABLE . "tag` (
			`tag_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`tag_name` varchar(30) NOT NULL COMMENT '标题',
			`tag_status` varchar(20) NOT NULL COMMENT '状态',
			`tag_article_count` int(11) NOT NULL COMMENT '标签统计',
			PRIMARY KEY (`tag_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='TAG' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030113");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `" . BG_DB_TABLE . "tag_belong` (
			`belong_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`belong_tag_id` int(11) NOT NULL COMMENT '标签 ID',
			`belong_article_id` int(11) NOT NULL COMMENT '文章 ID',
			PRIMARY KEY (`belong_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='标签从属' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030114");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `" . BG_DB_TABLE . "thumb` (
			`thumb_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`thumb_width` int(11) NOT NULL COMMENT '宽度',
			`thumb_height` int(11) NOT NULL COMMENT '高度',
			`thumb_type` varchar(10) NOT NULL COMMENT '类型',
			PRIMARY KEY (`thumb_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='缩略图' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030115");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `" . BG_DB_TABLE . "upfile` (
			`upfile_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`upfile_ext` varchar(10) NOT NULL COMMENT '扩展名',
			`upfile_time` int(11) NOT NULL COMMENT '时间',
			`upfile_size` int(11) NOT NULL COMMENT '大小',
			`upfile_name` varchar(1000) NOT NULL COMMENT '原始文件名',
			`upfile_admin_id` int(50) NOT NULL COMMENT '上传用户 ID',
			PRIMARY KEY (`upfile_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='上传文件' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030116");
		}

		$this->obj_ajax->halt_alert("y030103");
	}


	/**
	 * install_2_do function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_base() {
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
		$_arr_optPost = $this->opt_post("visit");

		if ($_POST["opt"]["BG_VISIT_TYPE"] == "pstatic") {

			$_str_content = "# BEGIN baigoCMS" . PHP_EOL;
			$_str_content .= "<IfModule mod_rewrite.c>" . PHP_EOL;
				$_str_content .= "RewriteEngine On" . PHP_EOL;
				$_str_content .= "RewriteBase /" . PHP_EOL;
				$_str_content .= "RewriteRule ^article/([0-9]*)$ /index.php?mod=article&act_get=show&article_id=$1 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^cate/(.*/)([0-9]*)/$ /index.php?mod=cate&act_get=show&cate_id=$2 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^cate/(.*/)([0-9]*)/([0-9]*)$ /index.php?mod=cate&act_get=show&cate_id=$2&page=$3 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^tag/$ /index.php?mod=tag&act_get=list [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^tag/(.*)/$ /index.php?mod=tag&act_get=show&tag_name=$1 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^tag/(.*)/([0-9]*)$ /index.php?mod=tag&act_get=show&tag_name=$1&page=$2 [L]" . PHP_EOL;
				$_str_content .= "RewriteRule ^search/$ /index.php?mod=search&act_get=show [L]" . PHP_EOL;
			$_str_content .= "</IfModule>" . PHP_EOL;
			$_str_content .= "# END baigoCMS" . PHP_EOL;

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
	function ajax_upfile() {
		$_arr_optPost = $this->opt_post("upfile");

		$this->obj_ajax->halt_alert("y030407");
	}


	/**
	 * install_6 function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_sso() {
		$_arr_optPost = $this->opt_post("sso");

		$this->obj_ajax->halt_alert("y030408");
	}


	/**
	 * install_7 function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_ssoauto() {
		if (file_exists(BG_PATH_SSO . "config/is_install.php")) {
			$this->obj_ajax->halt_alert("x030408");
		}

		if (strlen(BG_DB_HOST) < 1 || strlen(BG_DB_NAME) < 1 || strlen(BG_DB_USER) < 1 || strlen(BG_DB_PASS) < 1 || strlen(BG_DB_CHARSET) < 1) {
			$this->obj_ajax->halt_alert("x030404");
		}

		$_str_content = "<?php" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_HOST\", \"" . BG_DB_HOST . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_NAME\", \"" . BG_DB_NAME . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_USER\", \"" . BG_DB_USER . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_PASS\", \"" . BG_DB_PASS . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_CHARSET\", \"" . BG_DB_CHARSET . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_DB_TABLE\", \"sso_\");" . PHP_EOL;
		$_str_content .= "?>";

		file_put_contents(BG_PATH_SSO . "config/config_db.inc.php", $_str_content);

		$this->obj_db = new CLASS_MYSQL(); //初始化基类

		$_str_sql = "CREATE TABLE IF NOT EXISTS `sso_admin` (
			`admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`admin_name` varchar(30) NOT NULL COMMENT '用户名',
			`admin_pass` varchar(32) NOT NULL COMMENT '密码',
			`admin_rand` varchar(6) NOT NULL COMMENT '随机串',
			`admin_note` varchar(30) NOT NULL COMMENT '备注',
			`admin_status` varchar(20) NOT NULL COMMENT '状态',
			`admin_allow` varchar(3000) NOT NULL COMMENT '权限',
			`admin_time` int(11) NOT NULL COMMENT '创建时间',
			`admin_time_login` int(11) NOT NULL COMMENT '登录时间',
			`admin_ip` varchar(15) NOT NULL COMMENT '最后IP地址',
			PRIMARY KEY (`admin_id`),
			UNIQUE KEY `admin_name` (`admin_name`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理员' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030117");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `sso_user` (
			`user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`user_name` varchar(30) NOT NULL COMMENT '用户名',
			`user_mail` varchar(300) NOT NULL COMMENT 'E-mail',
			`user_pass` varchar(32) NOT NULL COMMENT '密码',
			`user_rand` varchar(6) NOT NULL COMMENT '随机串',
			`user_nick` varchar(30) NOT NULL COMMENT '备注',
			`user_status` varchar(20) NOT NULL COMMENT '状态',
			`user_note` varchar(30) NOT NULL COMMENT '备注',
			`user_time` int(11) NOT NULL COMMENT '创建时间',
			`user_time_login` int(11) NOT NULL COMMENT '登录时间',
			`user_ip` varchar(15) NOT NULL COMMENT '最后IP地址',
			PRIMARY KEY (`user_id`),
			UNIQUE KEY `user_name` (`user_name`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030118");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `sso_app` (
			`app_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`app_name` varchar(30) NOT NULL COMMENT '应用名',
			`app_key` varchar(64) NOT NULL COMMENT '校验码',
			`app_notice` varchar(3000) NOT NULL COMMENT '通知接口URL',
			`app_token` varchar(64) NOT NULL COMMENT '访问口令',
			`app_token_expire` int(11) NOT NULL COMMENT '口令存活期',
			`app_token_time` int(11) NOT NULL COMMENT '上次授权时间',
			`app_status` varchar(20) NOT NULL COMMENT '状态',
			`app_note` varchar(30) NOT NULL COMMENT '备注',
			`app_time` int(11) NOT NULL COMMENT '创建时间',
			`app_ip_allow` varchar(1000) NOT NULL COMMENT '允许调用IP地址',
			`app_ip_bad` varchar(1000) NOT NULL COMMENT '禁止IP',
			`app_sync` varchar(30) NOT NULL COMMENT '是否同步',
			`app_allow` varchar(3000) NOT NULL COMMENT '权限',
			PRIMARY KEY (`app_id`),
			UNIQUE KEY `app_name` (`app_name`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='应用' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030119");
		}


		$_str_sql = "DELETE FROM `sso_app`";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030120");
		}

		$_str_appKey = fn_rand(64);

		$_str_content = "<?php" . PHP_EOL;
			$_str_content .= "define(\"BG_SSO_URL\", \"" . BG_SITE_URL . BG_URL_SSO . "api/api.php\");" . PHP_EOL;
			$_str_content .= "define(\"BG_SSO_APPID\", 1);" . PHP_EOL;
			$_str_content .= "define(\"BG_SSO_APPKEY\", \"" . $_str_appKey . "\");" . PHP_EOL;
			$_str_content .= "define(\"BG_SSO_SYNLOGON\", \"on\");" . PHP_EOL;
		$_str_content .= "?>";

		file_put_contents(BG_PATH_CONFIG . "opt_sso.inc.php", $_str_content);

		$_arr_appAllow = array(
			"user" => array(
				"reg"       => 1,
				"login"     => 1,
				"get"       => 1,
				"edit"      => 1,
				"del"       => 1,
				"chkname"   => 1,
				"chkmail"   => 1,
			),
			"code" => array(
				"signature" => 1,
				"verify"    => 1,
				"encode"    => 1,
				"decode"    => 1,
			),
		);

		$_str_appAllow = json_encode($_arr_appAllow);

		$_str_sql = "INSERT INTO `sso_app` (`app_id`, `app_name`, `app_key`, `app_notice`, `app_token`, `app_token_expire`, `app_token_time`, `app_status`, `app_note`, `app_time`, `app_ip_allow`, `app_ip_bad`, `app_sync`, `app_allow`) VALUES
		(1, 'baigoCMS', '" . BG_SSO_APPKEY . "', '" . BG_SITE_URL . BG_URL_API . "sso_note.php', '', 604800, " . time() . ", 'enable', 'baigoCMS', " . time() . ", '', '', 'on', '" . $_str_appAllow . "')";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030120");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `sso_log` (
			`log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
			`log_time` int(11) NOT NULL COMMENT '时间',
			`log_operator_id` int(11) NOT NULL COMMENT '操作者 ID',
			`log_targets` text NOT NULL COMMENT '目标 JSON',
			`log_target_type` varchar(20) NOT NULL COMMENT '目标类型',
			`log_title` varchar(1000) NOT NULL COMMENT '操作标题',
			`log_result` varchar(1000) NOT NULL COMMENT '操作结果',
			`log_type` varchar(30) NOT NULL COMMENT '日志类型',
			`log_status` varchar(20) NOT NULL COMMENT '状态',
			`log_level` varchar(30) NOT NULL COMMENT '日志级别',
			PRIMARY KEY (`log_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='日志' AUTO_INCREMENT=1";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030121");
		}


		$_str_sql = "CREATE TABLE IF NOT EXISTS `sso_opt` (
			`opt_key` varchar(100) NOT NULL COMMENT '设置键名',
			`opt_value` varchar(1000) NOT NULL COMMENT '设置键值',
			PRIMARY KEY (`opt_key`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='选项'";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030122");
		}

		$_str_sql = "DELETE FROM `sso_opt`";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030123");
		}

		$_str_sql = "INSERT INTO `sso_opt` (`opt_key`, `opt_value`) VALUES
		('BG_REG_ONEMAIL', 'false'),
		('BG_REG_NEEDMAIL', 'off'),
		('BG_ACC_MAIL', ''),
		('BG_BAD_MAIL', ''),
		('BG_BAD_NAME', ''),
		('BG_SITE_DATE', 'Y-m-d'),
		('BG_SITE_DATESHORT', 'm-d'),
		('BG_SITE_DOMAIN', '" . BG_SITE_DOMAIN . "'),
		('BG_SITE_NAME', 'baigo SSO'),
		('BG_SITE_PERPAGE', '30'),
		('BG_SITE_TIME', 'H:i:s'),
		('BG_SITE_TIMESHORT', 'H:i'),
		('BG_SITE_TIMEZONE', 'Etc/GMT+8'),
		('BG_SITE_URL', '" . BG_SITE_URL . "')";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030123");
		}

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

		$_str_content = "<?php" . PHP_EOL;
			$_str_content .= "define(\"BG_REG_NEEDMAIL\", \"off\");" . PHP_EOL;
			$_str_content .= "define(\"BG_REG_ONEMAIL\", \"false\");" . PHP_EOL;
			$_str_content .= "define(\"BG_ACC_MAIL\", \"\");" . PHP_EOL;
			$_str_content .= "define(\"BG_BAD_MAIL\", \"\");" . PHP_EOL;
			$_str_content .= "define(\"BG_BAD_NAME\", BG_BAD_NAME);" . PHP_EOL;
		$_str_content .= "?>";

		file_put_contents(BG_PATH_SSO . "config/opt_reg.inc.php", $_str_content);

		$_str_sql = "DELETE FROM `" . BG_DB_TABLE . "opt` WHERE `opt_key`='BG_SSO_URL' OR `opt_key`='BG_SSO_APPID' OR `opt_key`='BG_SSO_APPKEY' OR `opt_key`='BG_SSO_SYNLOGON'";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030124");
		}

		$_str_sql = "INSERT INTO `" . BG_DB_TABLE . "opt` (`opt_key`, `opt_value`) VALUES
		('BG_SSO_URL', '" . BG_SITE_URL . BG_URL_SSO . "api/api.php'),
		('BG_SSO_APPID', 1),
		('BG_SSO_APPKEY', '" . BG_SSO_APPKEY . "'),
		('BG_SSO_SYNLOGON', 'on')";

		$_arr_reselt = $this->obj_db->query($_str_sql);

		if (!$_arr_reselt) {
			$this->obj_ajax->halt_alert("x030124");
		}

		$this->obj_ajax->halt_alert("y030408");
	}


	/**
	 * install_8 function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_admin() {
		if (strlen(BG_DB_HOST) < 1 || strlen(BG_DB_NAME) < 1 || strlen(BG_DB_USER) < 1 || strlen(BG_DB_PASS) < 1 || strlen(BG_DB_CHARSET) < 1) {
			$this->obj_ajax->halt_alert("x030404");
		}

		$GLOBALS["obj_db"]    = new CLASS_MYSQL(); //初始化基类
		$this->mdl_admin      = new MODEL_ADMIN(); //设置管理组模型

		$_arr_adminPost       = fn_adminPost();

		if ($_arr_adminPost["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_adminPost["str_alert"]);
		}

		$_arr_adminPass = validateStr($_POST["admin_pass"], 1, 0);
		switch ($_arr_adminPass["status"]) {
			case "too_short":
				$this->obj_ajax->halt_alert("x020210");
			break;

			case "ok":
				$_str_adminPass = $_arr_adminPass["str"];
			break;
		}

		$_arr_adminPassConfirm = validateStr($_POST["admin_pass_confirm"], 1, 0);
		switch ($_arr_adminPassConfirm["status"]) {
			case "too_short":
				$this->obj_ajax->halt_alert("x020215");
			break;

			case "ok":
				$_str_adminPassConfirm = $_arr_adminPassConfirm["str"];
			break;
		}

		if ($_str_adminPass != $_str_adminPassConfirm) {
			$this->obj_ajax->halt_alert("x020211");
		}

		$this->obj_sso = new CLASS_SSO();

		$_arr_ssoReg = $this->obj_sso->sso_reg($_arr_adminPost["admin_name"], $_str_adminPass, $_arr_adminPost["admin_mail"], $_arr_adminPost["admin_note"]);
		if ($_arr_ssoReg["str_alert"] != "y010101") {
			$this->obj_ajax->halt_alert($_arr_ssoReg["str_alert"]);
		}

		$_arr_adminRow = $this->mdl_admin->mdl_submit($_arr_ssoReg["user_id"], $_arr_adminPost["admin_name"], $_arr_adminPost["admin_note"], $_str_adminRand, $_arr_adminPost["admin_status"], $_arr_adminPost["admin_allow_cate"]);

		$this->mdl_admin->mdl_toGroup($_arr_ssoReg["user_id"], 1);

		if (file_exists(BG_PATH_SSO) && !file_exists(BG_PATH_SSO . "config/is_install.php")) {
			$_str_sql = "DELETE FROM `sso_admin`";

			$_arr_reselt = $GLOBALS["obj_db"]->query($_str_sql);

			$_arr_adminSsoAllow = array(
				"user" => array(
					"browse"   => 1,
					"add"      => 1,
					"edit"     => 1,
					"del"      => 1,
				),
				"app" => array(
					"browse"   => 1,
					"add"      => 1,
					"edit"     => 1,
					"del"      => 1,
				),
				"log" => array(
					"browse"   => 1,
					"edit"     => 1,
					"del"      => 1,
				),
				"admin" => array(
					"browse"   => 1,
					"add"      => 1,
					"edit"     => 1,
					"del"      => 1,
				),
				"opt" => array(
					"db"   => 1,
					"base" => 1,
					"reg"  => 1,
				),
			);

			$_str_adminSsoAllow  = json_encode($_arr_adminSsoAllow);
			$_str_adminRand      = fn_rand(6);
			$_str_adminPassDo    = fn_baigoEncrypt($_str_adminPass, $_str_adminRand);

			$_str_sql = "INSERT INTO `sso_admin` (`admin_id`, `admin_name`, `admin_pass`, `admin_rand`, `admin_note`, `admin_status`, `admin_allow`, `admin_time`, `admin_time_login`, `admin_ip`) VALUES
			(1, '" . $_arr_adminPost["admin_name"] . "', '" . $_str_adminPassDo . "', '" . $_str_adminRand . "', '" . $_arr_adminPost["admin_name"] . "', 'enable', '" . $_str_adminSsoAllow . "', " . time() . ", " . time() . ", '" . fn_getIp() . "')";

			$_arr_reselt = $GLOBALS["obj_db"]->query($_str_sql);

			include_once(BG_PATH_SSO . "core/inc/version.inc.php");

			$_str_content = "<?php" . PHP_EOL;
			$_str_content .= "define(\"BG_INSTALL_VER\", " . PRD_SSO_VER . ");" . PHP_EOL;
			$_str_content .= "define(\"BG_INSTALL_PUB\", " . PRD_SSO_PUB . ");" . PHP_EOL;
			$_str_content .= "define(\"BG_INSTALL_TIME\", " . time() . ");" . PHP_EOL;
			$_str_content .= "?>";

			file_put_contents(BG_PATH_SSO . "config/is_install.php", $_str_content);
		}

		$_str_content = "<?php" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_VER\", " . PRD_CMS_VER . ");" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_PUB\", " . PRD_CMS_PUB . ");" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_TIME\", " . time() . ");" . PHP_EOL;
		$_str_content .= "?>";

		file_put_contents(BG_PATH_CONFIG . "is_install.php", $_str_content);

		$this->obj_ajax->halt_alert("y030409");
	}


	/**
	 * opt_post function.
	 *
	 * @access private
	 * @param mixed $str_type
	 * @return void
	 */
	private function opt_post($str_type) {
		if (strlen(BG_DB_HOST) < 1 || strlen(BG_DB_NAME) < 1 || strlen(BG_DB_USER) < 1 || strlen(BG_DB_PASS) < 1 || strlen(BG_DB_CHARSET) < 1) {
			$this->obj_ajax->halt_alert("x030404");
		}

		$GLOBALS["obj_db"]    = new CLASS_MYSQL(); //初始化基类
		$this->mdl_opt        = new MODEL_OPT(); //设置管理组模型

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
			$_arr_optRow = $this->mdl_opt->mdl_submit($_key, $_str_optValue);
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