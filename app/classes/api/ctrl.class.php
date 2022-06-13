<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes\api;

use app\classes\Ctrl as Ctrl_Base;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Crypt;
use ginkgo\Sign;
use ginkgo\Arrays;
use ginkgo\Plugin;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}


/*-------------安装通用控制器-------------*/
abstract class Ctrl extends Ctrl_Base {

  protected function c_init($param = array()) { //构造函数
    parent::c_init();

    $this->obj_index = Loader::classes('Index', '', false);

    $this->mdl_app   = Loader::model('App');

    Plugin::listen('action_api_init');
  }


  public function init($is_submit = false) {
    $_arr_appRow = $this->chkApp($is_submit);

    if ($_arr_appRow['rcode'] != 'y050102') {
      return $_arr_appRow;
    }

    $_mdl_custom    = Loader::model('Custom');

    $_arr_data['customRows']    = $_mdl_custom->cache(false);

    $this->generalData = array_replace_recursive($this->generalData, $_arr_data);

    return true;
  }


  protected function chkApp($is_submit = false) {
    $_arr_inputCommon = $this->mdl_app->inputCommon($is_submit);

    if ($_arr_inputCommon['rcode'] != 'y050201') {
      $_arr_inputCommon['msg'] = $this->obj_lang->get($_arr_inputCommon['msg'], 'api.common');
      return $_arr_inputCommon;
    }

    $_arr_appRow = $this->mdl_app->read($_arr_inputCommon['app_id']);

    if ($_arr_appRow['rcode'] != 'y050102') {
      return array(
        'msg'   => $this->obj_lang->get($_arr_appRow['msg'], 'api.common'),
        'rcode' => $_arr_appRow['rcode'],
      );
    }

    if ($_arr_appRow['app_status'] != 'enable') {
      return array(
        'msg'   => $this->obj_lang->get('App is disabled', 'api.common'),
        'rcode' => 'x050402',
      );
    }

    $_str_ip = $this->obj_request->ip();

    if (Func::notEmpty($_arr_appRow['app_ip_allow'])) {
      $_str_ipAllow = str_replace(PHP_EOL, '|', $_arr_appRow['app_ip_allow']);
      if (!Func::checkRegex($_str_ip, $_str_ipAllow, true)) {
        return array(
          'msg'   => $this->obj_lang->get('Your IP address is not allowed', 'api.common'),
          'rcode' => 'x050407',
        );
      }
    } else if (Func::notEmpty($_arr_appRow['app_ip_bad'])) {
      $_str_ipBad = str_replace(PHP_EOL, '|', $_arr_appRow['app_ip_bad']);
      if (Func::checkRegex($_str_ip, $_str_ipBad)) {
        return array(
          'msg'   => $this->obj_lang->get('Your IP address is forbidden', 'api.common'),
          'rcode' => 'x050408',
        );
      }
    }

    $_arr_appRow['app_key'] = Crypt::crypt($_arr_appRow['app_key'], $_arr_appRow['app_name']);

    if ($_arr_inputCommon['app_key'] != $_arr_appRow['app_key']) {
      return array(
        'msg'   => $this->obj_lang->get('App Key is incorrect', 'api.common'),
        'rcode' => 'x050201',
      );
    }

    if ($is_submit) {
      $_str_decrypt = Crypt::decrypt($_arr_inputCommon['code'], $_arr_appRow['app_key'], $_arr_appRow['app_secret']);  //解密数据

      if ($_str_decrypt === false) {
        $_str_error = Crypt::getError();

        return array(
          'msg'   => $this->obj_lang->get($_str_error, 'api.common'),
          'rcode' => 'x050406',
        );
      }

      if (!Sign::check($_str_decrypt, $_arr_inputCommon['sign'], $_arr_appRow['app_key'] . $_arr_appRow['app_secret'])) {
        return array(
          'msg'   => $this->obj_lang->get('Signature is incorrect', 'api.common'),
          'rcode' => 'x050403',
        );
      }

      $_arr_data['decrypt'] = Arrays::fromJson($_str_decrypt);
    }

    $this->appRow = $_arr_appRow;

    return $_arr_appRow;
  }
}
