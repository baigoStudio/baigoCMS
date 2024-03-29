<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes\console;

use app\classes\Ctrl as Ctrl_Base;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\File;
use ginkgo\Session;
use ginkgo\Cookie;
use ginkgo\Config;
use ginkgo\Crypt;
use ginkgo\Plugin;
use ginkgo\Auth;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}


/*-------------控制中心通用控制器-------------*/
abstract class Ctrl extends Ctrl_Base {

  protected $isSuper     = false;

  protected $adminLogged = array(
    'admin_status' => '',
  );

  protected $groupAllow = array();

  protected $mdl_login;

  protected function c_init($param = array()) { //构造函数
    parent::c_init();

    Plugin::listen('action_console_init'); //管理后台初始化时触发

    $this->langReplace = array(
      'host'      => $this->config['var_extra']['upload']['ftp_host'],
      'tag_count' => $this->config['var_extra']['visit']['count_tag'],
    );

    $this->obj_auth     = Auth::instance(array(), 'admin');
    $this->mdl_login    = Loader::model('Login', '', 'console');

    $this->hrefBase     = $this->url['route_console'];

    $_arr_adminLogged   = $this->sessionRead();

    if (isset($_arr_adminLogged['admin_shortcut']) && Func::notEmpty($_arr_adminLogged['admin_shortcut'])) {
      foreach ($_arr_adminLogged['admin_shortcut'] as $_key=>&$_value) {
        $_value['href'] = $this->url['route_console'] . $_value['ctrl'] . '/' . $_value['act'] . '/';
      }
    }

    if (isset($_arr_adminLogged['admin_type']) && $_arr_adminLogged['admin_type'] == 'super') {
      $this->isSuper = true;
    }

    if (isset($_arr_adminLogged['groupRow']['group_allow'])) {
      $this->groupAllow = $_arr_adminLogged['groupRow']['group_allow'];
    }

    $this->generalData['hrefRow'] = array(
      'logout'              => $this->url['route_console'] . 'login/logout/',
      'token'               => $this->url['route_console'] . 'token/make/',
      'pm-send'             => $this->url['route_console'] . 'pm/send/',
      'gen-article'         => $this->url['route_gen'] . 'article/index/view/iframe/overall/',
      'gen-article-overall' => $this->url['route_gen'] . 'article/index/view/iframe/overall/',
      'gen-article-enforce' => $this->url['route_gen'] . 'article/enforce/view/iframe/',
      'gen-spec'            => $this->url['route_gen'] . 'spec/index/view/iframe/',
      'gen-call'            => $this->url['route_gen'] . 'call/index/view/iframe/',
      'gen-cate'            => $this->url['route_gen'] . 'cate/one-by-one/view/iframe/',
    );

    $this->generalData['adminLogged']   = $_arr_adminLogged;
    $this->adminLogged                  = $_arr_adminLogged;
  }


  protected function init($chk_admin = true) {
    $_arr_chkResult = $this->chkInstall();

    if (Func::notEmpty($_arr_chkResult['rcode'])) {
      return $_arr_chkResult;
    }

    if ($chk_admin) {
      $_arr_adminResult = $this->isAdmin();

      if (Func::notEmpty($_arr_adminResult['rcode'])) {
        return $_arr_adminResult;
      }
    }

    $_mdl_link     = Loader::model('Link', '', 'index');
    $_obj_base     = Loader::classes('Base', 'sso', 'console');

    $_arr_data = array(
      'pm_type'   => $_obj_base->pm(),
      'urls'      => $_obj_base->urls(),
      'links'     => $_mdl_link->cache('console'),
    );

    if (!isset($_arr_data['pm_type']['type'])) {
      $_arr_data['pm_type']['type'] = array();
    }

    if (!isset($_arr_data['urls']['url_forgot'])) {
      $_arr_data['urls']['url_forgot'] = '';
    }

    foreach ($_arr_data['pm_type']['type'] as $_key=>&$_value) {
      $_value = array(
        'href'  => $this->url['route_console'] . 'pm/index/type/' . $_key . '/',
        'title' => $_value,
      );
    }

    //print_r($_arr_data['pm_type']);

    $this->generalData = array_replace_recursive($this->generalData, $_arr_data);

    return true;
  }


  /*============验证 session, 并获取用户信息============
  返回数组
      admin_id ID
      admin_open_label OPEN ID
      admin_open_site OPEN 站点
      admin_note 备注
      group_allow 权限
      str_rcode 提示信息
  */
  protected function sessionRead() {
    $_num_adminId  = 0;
    $_arr_authRow  = $this->obj_auth->read();

    $_arr_session  = $_arr_authRow['session'];
    $_arr_remember = $_arr_authRow['remember'];

    if (isset($_arr_session['admin_id']) && $_arr_session['admin_id'] > 0) {
      $_num_adminId = $_arr_session['admin_id'];
    } else if (isset($_arr_remember['admin_id']) && $_arr_remember['admin_id'] > 0) {
      $_num_adminId = $_arr_remember['admin_id'];
    }

    $_arr_adminRow = $this->mdl_login->read($_num_adminId);
    //print_r($_arr_adminRow);
    if ($_arr_adminRow['rcode'] != 'y020102') {
      $this->obj_auth->end();

      return $_arr_adminRow;
    }

    if ($_arr_adminRow['admin_status'] == 'disabled') {
      $this->obj_auth->end();
      return array(
        'rcode' => 'x020402',
      );
    }

    if (!$this->obj_auth->check($_arr_adminRow, array($this->url['route_console'], $this->url['route_gen']))) {
      return array(
        'msg'   => $this->obj_auth->getError(),
        'rcode' => 'x020403',
      );
    }

    if ($_arr_adminRow['admin_group_id'] > 0) {
      $_mdl_group    = Loader::model('Group', '', 'console');

      $_arr_groupRow = $_mdl_group->read($_arr_adminRow['admin_group_id']);

      if (isset($_arr_groupRow['group_status']) && $_arr_groupRow['group_status'] == 'disabled') {
        $this->obj_auth->end();
        return array(
          'rcode' => 'x040401',
        );
      }

      $_arr_adminRow['groupRow'] = $_arr_groupRow;
    }

    return $_arr_adminRow;
  }


  protected function sessionLogin($arr_adminRow, $str_remember = '', $str_type = 'form') {
    $this->mdl_login->inputSubmit   = array_replace_recursive($this->mdl_login->inputSubmit, $arr_adminRow);

    $_arr_loginResult               = $this->mdl_login->login();

    $arr_adminRow = array_replace_recursive($arr_adminRow, $_arr_loginResult);

    $this->obj_auth->write($arr_adminRow, false, $str_type, $str_remember, array($this->url['route_console'], $this->url['route_gen']));

    return array(
      'rcode' => 'y020401',
      'msg'   => $this->obj_lang->get('Login successful', $this->route['mod'] . '.common'),
    );
  }


  private function isAdmin() {
    $_str_rcode     = '';
    $_str_jump      = '';
    $_str_msg       = '';

    //print_r($this->param);

    if ($this->adminLogged['rcode'] != 'y020102') {
      $this->obj_auth->end();
      $_str_rcode = $this->adminLogged['rcode'];
      $_str_msg   = $this->obj_lang->get('You have not logged in', $this->route['mod'] . '.common');

      if (!$this->isAjaxPost && !$this->isAjax && !$this->isPost && (!isset($this->param['view']) || ($this->param['view'] != 'iframe' && $this->param['view'] != 'modal'))) {
        $_str_jump = $this->url['route_console'] . 'login/';
      }
    }

    if (Func::notEmpty($_str_jump) && !$this->isAjaxPost) {
      $_obj_redirect = $this->redirect($_str_jump);
      $_obj_redirect->remember();
      return $_obj_redirect->send();
    }

    return array(
      'rcode' => $_str_rcode,
      'msg'   => $this->obj_lang->get($_str_msg, $this->route['mod'] . '.common'),
    );
  }


  private function chkInstall() {
    $_str_rcode     = '';
    $_str_jump      = '';
    $_str_msg       = '';

    $_str_configInstalled     = GK_APP_CONFIG . 'installed' . GK_EXT_INC;

    if (File::fileHas($_str_configInstalled)) { //如果新文件存在
      $_arr_installed       = Config::load($_str_configInstalled, 'installed');

      if (PRD_CMS_PUB > $_arr_installed['prd_installed_pub']) { //如果小于当前版本
        $_str_rcode = 'x030404';
        $_str_msg   = $this->obj_lang->get('Need to execute the upgrader', $this->route['mod'] . '.common');
        $_str_jump  = $this->url['route_install'] . 'upgrade';
      }
    } else { //如已安装文件未找到
      $_str_rcode = 'x030403';
      $_str_msg   = $this->obj_lang->get('Need to execute the installer', $this->route['mod'] . '.common');
      $_str_jump  = $this->url['route_install'];
    }

    if (Func::notEmpty($_str_jump) && !$this->isAjaxPost) {
      return $this->redirect($_str_jump)->send();
    }

    return array(
      'rcode' => $_str_rcode,
      'msg'   => $this->obj_lang->get($_str_msg, $this->route['mod'] . '.common'),
    );
  }


  protected function configProcess() {
    parent::configProcess();

    $_arr_configOptExtra   = Config::get('opt_extra', 'console');

    $_str_configOpt        = BG_PATH_CONFIG . 'console' . DS . 'opt' . GK_EXT_INC;
    $_arr_configOpt        = Config::load($_str_configOpt, 'opt', 'console');

    $_str_configConsoleMod = BG_PATH_CONFIG . 'console' . DS . 'console_mod' . GK_EXT_INC;
    $_arr_configConsoleMod = Config::load($_str_configConsoleMod, 'console_mod', 'console');

    $_str_configProfile    = BG_PATH_CONFIG . 'console' . DS . 'profile_mod' . GK_EXT_INC;
    $_arr_configProfile    = Config::load($_str_configProfile, 'profile_mod', 'console');

    if (is_array($_arr_configOptExtra) && Func::notEmpty($_arr_configOptExtra)) {
      foreach ($_arr_configOptExtra as $_key_m=>&$_value_m) {
        $_value_m['href'] = $this->url['route_console'] . $_value_m['ctrl'] . '/' . $_value_m['act'] . '/';
      }
    }

    if (is_array($_arr_configOpt) && Func::notEmpty($_arr_configOpt)) {
      foreach ($_arr_configOpt as $_key_m=>&$_value_m) {
        $_value_m['href'] = $this->url['route_console'] . 'opt/' . $_key_m . '/';
      }
    }

    if (is_array($_arr_configConsoleMod) && Func::notEmpty($_arr_configConsoleMod)) {
      foreach ($_arr_configConsoleMod as $_key_m=>&$_value_m) {
        $_value_m['main']['href'] = $this->url['route_console'] . $_value_m['main']['ctrl'] . '/';

        if (isset($_value_m['lists']) && Func::notEmpty($_value_m['lists'])) {
          foreach ($_value_m['lists'] as $_key_s=>&$_value_s) {
            $_value_s['href'] = $this->url['route_console'] . $_value_s['ctrl'] . '/' . $_value_s['act'] . '/';
          }
        }
      }
    }

    if (is_array($_arr_configProfile) && Func::notEmpty($_arr_configProfile)) {
      foreach ($_arr_configProfile as $_key_m=>&$_value_m) {
        $_value_m['href'] = $this->url['route_console'] . 'profile/' . $_key_m . '/';
      }
    }

    Config::set('opt_extra', $_arr_configOptExtra, 'console');
    Config::set('opt', $_arr_configOpt, 'console');
    Config::set('console_mod', $_arr_configConsoleMod, 'console');
    Config::set('profile_mod', $_arr_configProfile, 'console');
  }
}
