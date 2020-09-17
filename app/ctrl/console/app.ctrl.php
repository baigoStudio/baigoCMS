<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Config;
use ginkgo\Crypt;
use ginkgo\Sign;
use ginkgo\Json;
use ginkgo\Http;
use ginkgo\Html;
use ginkgo\Log;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

class App extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_app  = Loader::model('App');

        $this->generalData['status']    = $this->mdl_app->arr_status;
    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['app']['browse']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x050301');
        }

        $_arr_searchParam = array(
            'key'       => array('str', ''),
            'status'    => array('str', ''),
        );

        $_arr_search    = $this->obj_request->param($_arr_searchParam);
        $_arr_getData   = $this->mdl_app->lists($this->config['var_default']['perpage'], $_arr_search); //列出

        $_arr_tplData = array(
            'search'    => $_arr_search,
            'pageRow'   => $_arr_getData['pageRow'],
            'appRows'   => $_arr_getData['dataRows'],
            'token'     => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function show() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['app']['browse']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x050301');
        }

        $_num_appId = 0;

        if (isset($this->param['id'])) {
            $_num_appId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_appId < 1) {
            return $this->error('Missing ID', 'x050202');
        }

        $_arr_appRow = $this->mdl_app->read($_num_appId);

        if ($_arr_appRow['rcode'] != 'y050102') {
            return $this->error($_arr_appRow['msg'], $_arr_appRow['rcode']);
        }

        $_arr_appRow['app_key'] = Crypt::crypt($_arr_appRow['app_key'], $_arr_appRow['app_name']);

        $_arr_allowRows     = Config::get('app', 'console');

        $_arr_tplData = array(
            'appRow'    => $_arr_appRow,
            'allowRows' => $_arr_allowRows,
            'token'     => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function form() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_appId = 0;

        if (isset($this->param['id'])) {
            $_num_appId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_appId > 0) {
            if (!isset($this->groupAllow['app']['edit']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x050303');
            }

            $_arr_appRow = $this->mdl_app->read($_num_appId);

            if ($_arr_appRow['rcode'] != 'y050102') {
                return $this->error($_arr_appRow['msg'], $_arr_appRow['rcode']);
            }
        } else {
            if (!isset($this->groupAllow['app']['add']) && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x050302');
            }

            $_arr_appRow = array(
                'app_id'            => 0,
                'app_name'          => '',
                'app_url_notify'    => '',
                'app_ip_allow'      => '',
                'app_ip_bad'        => '',
                'app_note'          => '',
                'app_status'        => $this->mdl_app->arr_status[0],
                'app_allow'         => array(),
                'app_param'         => array(),
            );
        }

        $_arr_allowRows     = Config::get('app', 'console');

        $_arr_tplData = array(
            'appRow'    => $_arr_appRow,
            'allowRows' => $_arr_allowRows,
            'token'     => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function submit() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_arr_inputSubmit = $this->mdl_app->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y050201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        if ($_arr_inputSubmit['app_id'] > 0) {
            if (!isset($this->groupAllow['app']['edit']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x050303');
            }
        } else {
            if (!isset($this->groupAllow['app']['add']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x050302');
            }
        }

        $_arr_submitResult   = $this->mdl_app->submit();

        $_arr_submitResult['msg'] = $this->obj_lang->get($_arr_submitResult['msg']);

        return $this->json($_arr_submitResult);
    }


    function delete() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['app']['delete']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x050304');
        }

        $_arr_inputDelete = $this->mdl_app->inputDelete();

        if ($_arr_inputDelete['rcode'] != 'y050201') {
            return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
        }

        $_arr_deleteResult = $this->mdl_app->delete();

        $_arr_langReplace = array(
            'count' => $_arr_deleteResult['count'],
        );

        $_arr_deleteResult['msg'] = $this->obj_lang->get($_arr_deleteResult['msg'], '', $_arr_langReplace);

        return $this->json($_arr_deleteResult);
    }


    function status() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['app']['edit']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x050303');
        }

        $_arr_inputStatus = $this->mdl_app->inputStatus();

        if ($_arr_inputStatus['rcode'] != 'y050201') {
            return $this->fetchJson($_arr_inputStatus['msg'], $_arr_inputStatus['rcode']);
        }

        $_arr_statusResult = $this->mdl_app->status();

        $_arr_langReplace = array(
            'count' => $_arr_statusResult['count'],
        );

        return $this->fetchJson($_arr_statusResult['msg'], $_arr_statusResult['rcode'], '', $_arr_langReplace);
    }


    function reset() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['app']['edit']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x050303');
        }

        $_arr_inputCommon = $this->mdl_app->inputCommon();

        if ($_arr_inputCommon['rcode'] != 'y050201') {
            return $this->fetchJson($_arr_inputCommon['msg'], $_arr_inputCommon['rcode']);
        }

        $_arr_resetResult = $this->mdl_app->reset();

        return $this->fetchJson($_arr_resetResult['msg'], $_arr_resetResult['rcode']);
    }


    function notify() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['app']['browse']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x050303');
        }

        $_arr_inputCommon = $this->mdl_app->inputCommon();

        if ($_arr_inputCommon['rcode'] != 'y050201') {
            return $this->fetchJson($_arr_inputCommon['msg'], $_arr_inputCommon['rcode']);
        }

        $_arr_appRow = $this->mdl_app->read($_arr_inputCommon['app_id']);

        if ($_arr_appRow['rcode'] != 'y050102') {
            return $this->fetchJson($_arr_appRow['msg'], $_arr_appRow['rcode']);
        }

        $_str_echo = Func::rand();

        $_arr_src  = array(
            'echostr'   => $_str_echo,
            'timestamp' => GK_NOW,
        );

        $_str_src       = Json::encode($_arr_src);

        $_str_appKey    = Crypt::crypt($_arr_appRow['app_key'], $_arr_appRow['app_name']);
        $_str_encrypt   = Crypt::encrypt($_str_src, $_str_appKey, $_arr_appRow['app_secret']);

        $_arr_data = array(
            'app_id'    => $_arr_appRow['app_id'],
            'app_key'   => $_str_appKey,
            'code'      => $_str_encrypt,
            'sign'      => Sign::make($_str_src, $_str_appKey . $_arr_appRow['app_secret']),
        );

        if (!Func::isEmpty($_arr_appRow['app_param'])) {
            foreach ($_arr_appRow['app_param'] as $_key_param=>$_value_param) {
                if (isset($_value_param['key']) && isset($_value_param['value'])) {
                    $_arr_data[$_value_param['key']] = $_value_param['value'];
                }
            }
        }

        $_obj_http = Http::instance();

        $_str_urlNotify    = Html::decode($_arr_appRow['app_url_notify'], 'url');
        $_str_urlNotify    = rtrim($_str_urlNotify, '/');

        if (strpos($_str_urlNotify, '?') === false) {
            $_str_conn = '?';
        } else {
            $_str_conn = '&';
        }

        $_str_urlNotify = $_str_urlNotify . $_str_conn . 'm=sso&c=notify&a=test';

        $_arr_notifyResult = $_obj_http->request($_str_urlNotify, $_arr_data, 'post');

        //print_r($_obj_http->getResult());

        if (isset($_arr_notifyResult['echostr']) && $_arr_notifyResult['echostr'] == $_str_echo) {
            $_arr_return = array(
                'msg'   => 'Testing successfully',
                'rcode' => 'y050401',
            );
        } else {
            $_arr_return = array(
                'msg'   => 'Testing failed',
                'rcode' => 'x050401',
            );

            Log::record('type: notify, action: ' . $_str_urlNotify . ', app_id: ' . $_arr_appRow['app_id'] . ', result: failed ' . Json::encode($_arr_notifyResult), 'log');
        }

        return $this->fetchJson($_arr_return['msg'], $_arr_return['rcode']);
    }
}
