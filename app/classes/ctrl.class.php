<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes;

use ginkgo\Ctrl as Gk_Ctrl;
use ginkgo\Loader;
use ginkgo\Route;
use ginkgo\Config;
use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

/*-------------控制中心通用控制器-------------*/
abstract class Ctrl extends Gk_Ctrl {

    protected $isAjaxPost   = false;
    protected $isPost       = false;
    protected $ftpInit      = false;
    protected $ftpOpen      = false;
    protected $genOpen      = false;
    protected $generalData  = array();
    protected $url          = array();
    protected $configRoute  = array();
    protected $config;

    protected function c_init($param = array()) { //构造函数
        $this->configProcess();
        $this->pathProcess();

        $_arr_config = Config::get();

        if (!isset($_arr_config['var_extra']['base']['site_date'])) {
            $_arr_config['var_extra']['base']['site_date'] = 'Y-m-d';
        }

        if (!isset($_arr_config['var_extra']['base']['site_date_short'])) {
            $_arr_config['var_extra']['base']['site_date_short'] = 'm-d';
        }

        if (!isset($_arr_config['var_extra']['base']['site_time'])) {
            $_arr_config['var_extra']['base']['site_time'] = 'H:i:s';
        }

        if (!isset($_arr_config['var_extra']['base']['site_time_short'])) {
            $_arr_config['var_extra']['base']['site_time_short'] = 'H:i';
        }

        if (!isset($_arr_config['var_extra']['visit']['count_tag'])) {
            $_arr_config['var_extra']['visit']['count_tag'] = 5;
        }

        if (!isset($_arr_config['var_extra']['base']['site_thumb_default'])) {
            $_arr_config['var_extra']['base']['site_thumb_default'] = 0;
        }

        if ($this->obj_request->isAjax() && $this->obj_request->isPost()) {
            $this->isAjaxPost = true;
            $this->isPost     = true;
        }

        if ($this->obj_request->isPost()) {
            $this->isPost = true;
        }

        if (isset($_arr_config['module']['ftp']) && ($_arr_config['module']['ftp'] === true || $_arr_config['module']['ftp'] === 'true')) {
            $this->ftpOpen = true;
        }

        $_arr_configUi = Config::get('ui_ctrl');

        if (isset($_arr_configUi['update_check']) && $_arr_configUi['update_check'] != 'on') {
            //print_r('dis');
            Config::delete('chkver', 'console.opt');
            if (isset($_arr_config['console']['opt']['chkver'])) {
                unset($_arr_config['console']['opt']['chkver']);
            }
        }

        if (!isset($_arr_configUi['logo_console_login']) || Func::isEmpty($_arr_configUi['logo_console_login'])) {
            $_arr_configUi['logo_console_login'] = '{:DIR_STATIC}cms/image/logo_blue.svg';
        }

        if (!isset($_arr_configUi['logo_console_head']) || Func::isEmpty($_arr_configUi['logo_console_head'])) {
            $_arr_configUi['logo_console_head'] = '{:DIR_STATIC}cms/image/logo_white.svg';
        }

        if (!isset($_arr_configUi['logo_console_foot']) || Func::isEmpty($_arr_configUi['logo_console_foot'])) {
            $_arr_configUi['logo_console_foot'] = '{:DIR_STATIC}cms/image/logo_white.svg';
        }

        if (!isset($_arr_configUi['logo_install']) || Func::isEmpty($_arr_configUi['logo_install'])) {
            $_arr_configUi['logo_install'] = '{:DIR_STATIC}cms/image/logo_blue.svg';
        }

        $_arr_data = array(
            'ui_ctrl'       => $_arr_configUi,
            'ftp_open'      => $this->ftpOpen,
            'gen_open'      => $this->genOpen,
            'config'        => $_arr_config,
            'route'         => $this->route,
            'route_orig'    => $this->routeOrig,
            'param'         => $this->param,
        );

        $this->generalData = array_replace_recursive($this->generalData, $_arr_data);

        $this->config       = $_arr_config;
        $_arr_configBase    = Config::get('base', 'var_extra');

        if (!isset($_arr_configBase['site_tpl'])) {
            $_arr_configBase['site_tpl'] = 'default';
        }

        $this->configBase   = $_arr_configBase;

        $_arr_configVisit  = Config::get('visit', 'var_extra');

        if (!isset($_arr_configVisit['visit_type'])) {
            $_arr_configVisit['visit_type'] = 'default';
        }

        if (!isset($_arr_configVisit['visit_pagecount'])) {
            $_arr_configVisit['visit_pagecount'] = 10;
        }

        if (!isset($_arr_configVisit['perpage_spec'])) {
            $_arr_configVisit['perpage_spec'] = 30;
        }

        if (!isset($_arr_configVisit['perpage_album'])) {
            $_arr_configVisit['perpage_album'] = 30;
        }

        if (!isset($_arr_configVisit['perpage_in_spec'])) {
            $_arr_configVisit['perpage_in_spec'] = 30;
        }

        if (!isset($_arr_configVisit['perpage_in_tag'])) {
            $_arr_configVisit['perpage_in_tag'] = 30;
        }

        if (!isset($_arr_configVisit['perpage_in_search'])) {
            $_arr_configVisit['perpage_in_search'] = 30;
        }

        if (!isset($_arr_configVisit['perpage_in_ajax'])) {
            $_arr_configVisit['perpage_in_ajax'] = 30;
        }

        if (!isset($_arr_configVisit['perpage_in_api'])) {
            $_arr_configVisit['perpage_in_api'] = 30;
        }

        if (!isset($_arr_configVisit['perpage_in_album'])) {
            $_arr_configVisit['perpage_in_album'] = 30;
        }

        if (!isset($_arr_configVisit['count_tag'])) {
            $_arr_configVisit['count_tag'] = 5;
        }

        if (isset($_arr_config['module']['gen']) && ($_arr_config['module']['gen'] === true || $_arr_config['module']['gen'] === 'true') && $_arr_configVisit['visit_type'] == 'static') {
            $this->genOpen = true;
        }

        $this->configVisit  = $_arr_configVisit;
    }


    protected function indexInit() {
        $_mdl_cate     = Loader::model('Cate');
        $_mdl_custom   = Loader::model('Custom');

        $_arr_data['cate_tree']    = $_mdl_cate->cache();
        $_arr_data['custom_tree']  = $_mdl_custom->cache();
        $_arr_data['customRows']    = $_mdl_custom->cache(false);

        $_arr_configRoute   = Config::get('route', 'index');

        $this->configRoute  = $_arr_configRoute;

        $_arr_url = array(
            'url_cate'      => $this->url['route_root'] . '/' . $_arr_configRoute['cate'] . '/',
            'url_search'    => $this->url['route_root'] . '/' . $_arr_configRoute['search'] . '/',
            'url_article'   => $this->url['route_root'] . '/' . $_arr_configRoute['article'] . '/',
            'url_tag'       => $this->url['route_root'] . '/' . $_arr_configRoute['tag'] . '/',
            'url_spec'      => $this->url['route_root'] . '/' . $_arr_configRoute['spec'] . '/',
        );

        $this->url = array_replace_recursive($this->url, $_arr_url);

        $this->generalData = array_replace_recursive($this->generalData, $_arr_data, $_arr_url);

        return true;
    }


    protected function error($msg, $rcode = '', $status = 200, $langReplace = '') {
        $_arr_data = $this->dataProcess($msg, $rcode, $langReplace);

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_data);

        return $this->fetch('common' . DS . 'error', $_arr_tpl, '', $status);
    }


    protected function fetchJson($msg, $rcode = '', $status = 200, $langReplace = '') {
        $_arr_data = $this->dataProcess($msg, $rcode, $langReplace);

        return $this->json($_arr_data, $status);
    }


    protected function fetchJsonp($msg, $rcode = '', $status = 200, $langReplace = '') {
        $_arr_data = $this->dataProcess($msg, $rcode, $langReplace);

        return $this->jsonp($_arr_data, $status);
    }


    private function dataProcess($msg, $rcode = '', $langReplace = '') {
        $_arr_data = array(
            'msg'       => $this->obj_lang->get($msg, '', $langReplace),
            'rcode'     => $rcode,
            'rstatus'   => substr($rcode, 0, 1),
        );

        return $_arr_data;
    }

    protected function configProcess() {
        $_str_pathMod  = BG_PATH_CONFIG . $this->route['mod'] . DS . 'common' . GK_EXT_INC;
        Config::load($_str_pathMod, $this->route['mod']);

        $_str_pathCtrl  = BG_PATH_CONFIG . $this->route['mod'] . DS . $this->route['ctrl'] . GK_EXT_INC;
        Config::load($_str_pathCtrl, $this->route['ctrl'], $this->route['mod']);

        if ($this->route['mod'] != 'index') {
            $_str_configIndex   = BG_PATH_CONFIG . 'index' . DS . 'common' . GK_EXT_INC;
            Config::load($_str_configIndex, 'index');
        }
    }


    protected function pathProcess() {
        $_str_dirRoot       = $this->obj_request->root();
        $_str_urlRoot       = $this->obj_request->baseUrl(true);
        $_str_routeRoot     = $this->obj_request->baseUrl();

        Route::setExclude('page_belong');

        $_arr_url = array(
            'dir_root'      => $_str_dirRoot,
            'dir_static'    => $_str_dirRoot . GK_NAME_STATIC . '/',
            'url_root'      => $_str_urlRoot,
            'url_api'       => $_str_urlRoot . 'api/',
            'url_index'     => $_str_routeRoot . 'index/',
            'route_root'    => $_str_routeRoot,
            'route_install' => $_str_routeRoot . 'install/',
            'route_console' => $_str_routeRoot . 'console/',
            'route_gen'     => $_str_routeRoot . 'gen/',
            'route_misc'    => $_str_routeRoot . 'misc/',
        );

        $this->obj_view->setReplace($_arr_url);

        $this->url = array_replace_recursive($this->url, $_arr_url);

        $this->generalData = array_replace_recursive($this->generalData, $_arr_url);
    }
}
