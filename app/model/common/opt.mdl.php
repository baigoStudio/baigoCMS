<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\common;

use app\model\Opt as Opt_Base;
use ginkgo\Config;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------设置项模型-------------*/
class Opt extends Opt_Base {

  public $inputDbconfig = array();
  public $inputCommon   = array();

  public function dbconfig() {
    $_arr_opt = array(
      'host'      => $this->inputDbconfig['host'],
      'port'      => (int)$this->inputDbconfig['port'],
      'name'      => $this->inputDbconfig['name'],
      'user'      => $this->inputDbconfig['user'],
      'pass'      => $this->inputDbconfig['pass'],
      'charset'   => $this->inputDbconfig['charset'],
      'prefix'    => $this->inputDbconfig['prefix'],
    );

    $_num_size   = Config::write(GK_APP_CONFIG . 'dbconfig' . GK_EXT_INC, $_arr_opt);

    if ($_num_size > 0) {
      $_str_rcode = 'y030401';
      $_str_msg   = 'Database set successful';
    } else {
      $_str_rcode = 'x030401';
      $_str_msg   = 'Database set failed';
    }

    return array(
      'rcode' => $_str_rcode,
      'msg'   => $_str_msg,
    );
  }


  public function inputDbconfig($arr_data = '') {
    $_arr_inputParam = array(
      'host'      => array('str', 'localhost'),
      'port'      => array('num', 3306),
      'name'      => array('str', ''),
      'user'      => array('str', ''),
      'pass'      => array('str', ''),
      'charset'   => array('str', ''),
      'prefix'    => array('str', ''),
      '__token__' => array('str', ''),
    );

    $_arr_inputDbconfig  = $this->obj_request->post($_arr_inputParam);

    $_is_vld = $this->vld_opt->scene('dbconfig')->verify($_arr_inputDbconfig);

    if ($_is_vld !== true) {
      $_arr_message = $this->vld_opt->getMessage();
      return array(
        'rcode' => 'x030201',
        'msg'   => end($_arr_message),
      );
    }

    $_arr_inputDbconfig['rcode'] = 'y030201';

    $this->inputDbconfig = $_arr_inputDbconfig;

    return $_arr_inputDbconfig;
  }


  public function inputCommon() {
    $_arr_inputParam = array(
      '__token__' => array('str', ''),
    );

    $_arr_inputCommon = $this->obj_request->post($_arr_inputParam);

    $_is_vld = $this->vld_opt->scene('common')->verify($_arr_inputCommon);

    if ($_is_vld !== true) {
      $_arr_message = $this->vld_opt->getMessage();
      return array(
        'rcode' => 'x030201',
        'msg'   => end($_arr_message),
      );
    }

    $_arr_inputCommon['rcode'] = 'y030201';

    $this->inputCommon = $_arr_inputCommon;

    return $_arr_inputCommon;
  }
}
