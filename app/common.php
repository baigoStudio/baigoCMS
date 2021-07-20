<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿编辑
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

define('PRD_CMS_NAME', 'baigo CMS');
define('PRD_CMS_URL', 'http://www.baigo.net/cms/');
define('PRD_CMS_VER', '3.0-alpha-2');
define('PRD_CMS_PUB', 20210720);
define('PRD_CMS_HELP', 'http://doc.baigo.net/cms/');
define('PRD_VER_CHECK', 'http://www.baigo.net/ver_check/check.php');

defined('BG_TPL_INDEX') || define('BG_TPL_INDEX', GK_APP_TPL . 'index' . DS); //前台模板
defined('BG_TPL_CALL') || define('BG_TPL_CALL', GK_APP_TPL . 'call' . DS); //调用模板

defined('BG_TPL_SINGLE') || define('BG_TPL_SINGLE', GK_APP_TPL . 'single' . DS); //独立模板
defined('BG_TPL_TAG') || define('BG_TPL_TAG', BG_TPL_SINGLE . 'tag' . DS); //TAG 模板
defined('BG_TPL_ALBUM') || define('BG_TPL_ALBUM', BG_TPL_SINGLE . 'album' . DS); //相册模板
defined('BG_TPL_SPEC') || define('BG_TPL_SPEC', BG_TPL_SINGLE . 'spec' . DS); //专题模板
defined('BG_TPL_ARTICLE') || define('BG_TPL_ARTICLE', BG_TPL_SINGLE . 'article' . DS); //文章模板

defined('BG_PATH_CONFIG') || define('BG_PATH_CONFIG', GK_PATH_APP . GK_NAME_CONFIG . DS); //配置文件

//error_reporting(E_ALL);
