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

class Article_Content extends Ctrl {

  public $inputSubmit;
  public $inputDelete;

  protected function c_init($param = array()) {
    parent::c_init();

    $this->mdl_articleContent       = Loader::model('Article_Content');
  }


  public function clear() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (!isset($this->groupAllow['article']['edit']) && !$this->isSuper) { //判断权限
      return $this->fetchJson('You do not have permission', 'x120303');
    }

    $_arr_inputClear = $this->mdl_articleContent->inputClear();

    //print_r($_arr_inputClear);

    if ($_arr_inputClear['rcode'] != 'y150201') {
      return $this->fetchJson($_arr_inputClear['msg'], $_arr_inputClear['rcode']);
    }

    $_num_maxId = $_arr_inputClear['max_id'];

    $_arr_getData   = $this->mdl_articleContent->clear();

    if (Func::isEmpty($_arr_getData['dataRows'])) {
      $_str_status    = 'complete';
      $_str_msg       = 'Complete';
    } else {
      $_arr_articleRow = end($_arr_getData['dataRows']);
      $_str_status    = 'loading';
      $_str_msg       = 'Submitting';
      $_num_maxId     = $_arr_articleRow['article_id'];
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
