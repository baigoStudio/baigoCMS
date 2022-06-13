<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Cate_Belong extends Ctrl {

  protected function c_init($param = array()) {
    parent::c_init();

    $this->mdl_cateBelong       = Loader::model('Cate_Belong');
  }


  public function clear() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (!isset($this->groupAllow['cate']['edit']) && !$this->isSuper) {
      return $this->fetchJson('You do not have permission', 'x250305');
    }

    $_arr_inputClear = $this->mdl_cateBelong->inputClear();

    if ($_arr_inputClear['rcode'] != 'y150201') {
      return $this->fetchJson($_arr_inputClear['msg'], $_arr_inputClear['rcode']);
    }

    $_num_maxId = $_arr_inputClear['max_id'];

    $_arr_getData  = $this->mdl_cateBelong->clear();

    if (Func::isEmpty($_arr_getData['dataRows'])) {
      $_str_status    = 'complete';
      $_str_msg       = 'Complete';
    } else {
      $_arr_belongRow = end($_arr_getData['dataRows']);
      $_str_status    = 'loading';
      $_str_msg       = 'Submitting';
      $_num_maxId     = $_arr_belongRow['belong_id'];
    }

    $_arr_return = array(
      'msg'       => $this->obj_lang->get($_str_msg, 'console.common'),
      'count'     => $_arr_getData['pageRow']['total'],
      'max_id'    => $_num_maxId,
      'status'    => $_str_status,
    );

    return $this->json($_arr_return);
  }
}
