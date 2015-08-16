<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

define("IN_BAIGO", true); //程序是否合法被包含
define("BG_SYS_DEBUG", false); //系统调试开关
define("BG_DB_DEBUG", false); //数据库调试开关

define("PRD_SSO_URL", "http://www.baigo.net/Products/baigoSSO/"); //sso 官网

/*-------------------------开关-------------------------*/
define("BG_SWITCH_LANG", false); //语言选择开关 true 允许选择
define("BG_SWITCH_UI", false); //界面选择开关 true 允许选择
define("BG_SWITCH_TOKEN", true); //表单提交令牌开关 true 验证令牌
define("BG_SWITCH_SMARTY_DEBUG", false); //Smarty 调试开关

/*-------------------------默认-------------------------*/
define("BG_DEFAULT_LANG", "zh_CN"); //默认语言
define("BG_DEFAULT_UI", "default"); //默认界面
define("BG_DEFAULT_SESSION", 1200); //默认会话过期时间，秒
define("BG_DEFAULT_PERPAGE", 30); //默认会话过期时间，秒
define("BG_DEFAULT_TOKEN", 604800); //默认口令过期时间，秒

/*-------------------------目录名称-------------------------*/
define("BG_NAME_CONFIG", "bg_config"); //配置文件
define("BG_NAME_CACHE", "bg_cache"); //缓存 v1.1.2

define("BG_NAME_HTML", "bg_html"); //生成文件目录
define("BG_NAME_INCLUDE", "include"); //静态模式时引用存放目录

define("BG_NAME_BGHELP", "bg_help"); //帮助目录
define("BG_NAME_HELP", "help"); //帮助目录
define("BG_NAME_ARTICLE", "article"); //静态模式时文章存放目录
define("BG_NAME_ATTACH", "bg_attach"); //附件目录
define("BG_NAME_SSO", "bg_sso"); //sso 目录

define("BG_NAME_BGTPL", "bg_tpl"); //前台模板
define("BG_NAME_TPL", "tpl"); //系统模板
define("BG_NAME_COMPILE", "compile"); //模板编译目录

define("BG_NAME_STATIC", "bg_static"); //静态文件(图片、CSS、JS 等)
define("BG_NAME_CSS", "css"); //CSS
define("BG_NAME_JS", "js"); //JS
define("BG_NAME_IMAGE", "image"); //图片

define("BG_NAME_BGADMIN", "bg_admin"); //管理目录名(入口)
define("BG_NAME_ADMIN", "admin"); //管理目录名(模型、控制器、模块等)
define("BG_NAME_PUB", "pub"); //前台目录名(模型、控制器、模块等)
define("BG_NAME_BGAPI", "bg_api"); //后台
define("BG_NAME_API", "api"); //后台
define("BG_NAME_BGNOTICE", "bg_notice"); //后台
define("BG_NAME_NOTICE", "notice"); //后台

define("BG_NAME_BGINSTALL", "bg_install"); //安装目录名(入口)
define("BG_NAME_INSTALL", "install"); //安装目录名(模型、控制器、模块等)

define("BG_NAME_CORE", "bg_core"); //内核
define("BG_NAME_MODULE", "module"); //模块
define("BG_NAME_CONTROL", "control"); //控制器

define("BG_NAME_CLASS", "class"); //类目录
define("BG_NAME_FUNC", "func"); //函数目录
define("BG_NAME_FONT", "font"); //字体
define("BG_NAME_INC", "inc"); //共用程序
define("BG_NAME_LANG", "lang"); //语言
define("BG_NAME_MODEL", "model"); //数据库模型
define("BG_NAME_SMARTY", "smarty"); //Smarty 目录

/*-------------------------路径-------------------------*/
define("BG_PATH_ROOT", str_replace("\\", "/", substr(dirname(__FILE__), 0, strrpos(dirname(__FILE__), BG_NAME_CONFIG)))); //根目录
define("BG_PATH_CONFIG", BG_PATH_ROOT . BG_NAME_CONFIG . "/"); //配置文件目录
define("BG_PATH_CACHE", BG_PATH_ROOT . BG_NAME_CACHE . "/"); //缓存文件目录 v1.1.2

define("BG_PATH_HTML", BG_PATH_ROOT . BG_NAME_HTML . "/"); //静态模式时 HTML 存放目录
define("BG_PATH_INCLUDE", BG_PATH_HTML . BG_NAME_INCLUDE . "/"); //静态模式时引用存放目录

define("BG_PATH_ARTICLE", BG_PATH_ROOT . BG_NAME_ARTICLE . "/"); //静态模式时文章存放目录
define("BG_PATH_ATTACH", BG_PATH_ROOT . BG_NAME_ATTACH . "/"); //附件文件目录
define("BG_PATH_SSO", BG_PATH_ROOT . BG_NAME_SSO . "/"); //sso 目录

define("BG_PATH_TPL", BG_PATH_ROOT . BG_NAME_BGTPL . "/"); //前台模板
define("BG_PATH_TPL_PUB", BG_PATH_TPL . BG_NAME_PUB . "/"); //栏目模板
define("BG_PATH_TPL_COMPILE", BG_PATH_TPL . BG_NAME_COMPILE . "/"); //模板编译

define("BG_PATH_CORE", BG_PATH_ROOT . BG_NAME_CORE . "/"); //内核

define("BG_PATH_MODULE", BG_PATH_CORE . BG_NAME_MODULE . "/"); //模块文件
define("BG_PATH_MODULE_ADMIN", BG_PATH_MODULE . BG_NAME_ADMIN ."/"); //后台模块文件
define("BG_PATH_MODULE_INSTALL", BG_PATH_MODULE . BG_NAME_INSTALL ."/"); //安装模块文件
define("BG_PATH_MODULE_PUB", BG_PATH_MODULE . BG_NAME_PUB . "/"); //前台模块文件
define("BG_PATH_MODULE_API", BG_PATH_MODULE . BG_NAME_API . "/"); //模块文件
define("BG_PATH_MODULE_NOTICE", BG_PATH_MODULE . BG_NAME_NOTICE . "/");
define("BG_PATH_MODULE_HELP", BG_PATH_MODULE . BG_NAME_HELP . "/"); //模块文件

define("BG_PATH_CONTROL", BG_PATH_CORE . BG_NAME_CONTROL . "/"); //控制器
define("BG_PATH_CONTROL_ADMIN", BG_PATH_CONTROL . BG_NAME_ADMIN . "/"); //后台控制器
define("BG_PATH_CONTROL_INSTALL", BG_PATH_CONTROL . BG_NAME_INSTALL . "/"); //安装控制器
define("BG_PATH_CONTROL_PUB", BG_PATH_CONTROL . BG_NAME_PUB . "/"); //前台控制器
define("BG_PATH_CONTROL_API", BG_PATH_CONTROL . BG_NAME_API . "/"); //控制
define("BG_PATH_CONTROL_NOTICE", BG_PATH_CONTROL . BG_NAME_NOTICE . "/"); //控制
define("BG_PATH_CONTROL_HELP", BG_PATH_CONTROL . BG_NAME_HELP . "/"); //控制

define("BG_PATH_SYSTPL", BG_PATH_CORE . BG_NAME_TPL . "/"); //系统模板
define("BG_PATH_SYSTPL_ADMIN", BG_PATH_SYSTPL . BG_NAME_ADMIN . "/"); //后台模板
define("BG_PATH_SYSTPL_INSTALL", BG_PATH_SYSTPL . BG_NAME_INSTALL . "/"); //安装模板
define("BG_PATH_SYSTPL_HELP", BG_PATH_SYSTPL . BG_NAME_HELP . "/"); //安装模板

define("BG_PATH_CLASS", BG_PATH_CORE . BG_NAME_CLASS . "/"); //类目录
define("BG_PATH_FONT", BG_PATH_CORE . BG_NAME_FONT . "/"); //字体
define("BG_PATH_FUNC", BG_PATH_CORE . BG_NAME_FUNC . "/"); //函数目录
define("BG_PATH_INC", BG_PATH_CORE . BG_NAME_INC . "/"); //共用
define("BG_PATH_LANG", BG_PATH_CORE . BG_NAME_LANG . "/"); //语言
define("BG_PATH_MODEL", BG_PATH_CORE . BG_NAME_MODEL . "/"); //数据库模型
define("BG_PATH_SMARTY", BG_PATH_CORE . BG_NAME_SMARTY . "/"); //Smarty 目录

/*-------------------------URL-------------------------*/
define("BG_URL_ROOT", str_ireplace(str_ireplace("\\", "/", $_SERVER["DOCUMENT_ROOT"]), "", str_ireplace("\\", "/", BG_PATH_ROOT))); //根目录

define("BG_URL_HELP", BG_URL_ROOT . BG_NAME_BGHELP . "/"); //帮助
define("BG_URL_ARTICLE", BG_URL_ROOT . BG_NAME_ARTICLE . "/"); //静态模式时文章存放目录
define("BG_URL_ATTACH", BG_URL_ROOT . BG_NAME_ATTACH . "/"); //附件文件目录
define("BG_URL_SSO", BG_URL_ROOT . BG_NAME_SSO . "/"); //sso 目录

define("BG_URL_PUB", BG_URL_ROOT); //前台
define("BG_URL_API", BG_URL_ROOT . BG_NAME_BGAPI . "/"); //API 目录
define("BG_URL_NOTICE", BG_URL_ROOT . BG_NAME_BGNOTICE . "/"); //NOTICE 目录
define("BG_URL_ADMIN", BG_URL_ROOT . BG_NAME_BGADMIN . "/"); //后台
define("BG_URL_INSTALL", BG_URL_ROOT . BG_NAME_BGINSTALL . "/"); //安装

define("BG_URL_STATIC", BG_URL_ROOT . BG_NAME_STATIC . "/"); //静态文件目录

define("BG_URL_STATIC_ADMIN", BG_URL_STATIC . BG_NAME_ADMIN . "/"); //后台静态文件目录
define("BG_URL_STATIC_INSTALL", BG_URL_STATIC . BG_NAME_INSTALL . "/"); //安装静态文件目录
define("BG_URL_STATIC_PUB", BG_URL_STATIC . BG_NAME_PUB . "/"); //前台静态文件目录
define("BG_URL_STATIC_HELP", BG_URL_STATIC . BG_NAME_HELP . "/"); //前台静态文件目录

define("BG_URL_IMAGE", BG_URL_STATIC . BG_NAME_IMAGE . "/"); //图片
define("BG_URL_JS", BG_URL_STATIC . BG_NAME_JS . "/"); //JS

/*-------------------------模块-------------------------*/
define("BG_MODULE_GEN", false); //生成静态页面模块 true 已安装
define("BG_MODULE_FTP", false); //FTP 分发模块 true 已安装


/*-------------------------载入其他配置-------------------------*/
include_once(BG_PATH_INC . "version.inc.php"); //版本信息
include_once(BG_PATH_CONFIG . "config_db.inc.php"); //数据库
include_once(BG_PATH_CONFIG . "opt_base.inc.php"); //基本设置
include_once(BG_PATH_CONFIG . "opt_sso.inc.php"); //SSO
include_once(BG_PATH_CONFIG . "opt_upload.inc.php"); //上传
include_once(BG_PATH_CONFIG . "opt_visit.inc.php"); //URL