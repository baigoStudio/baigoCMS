<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\api;

use app\classes\api\Ctrl;
use ginkgo\Loader;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------文章类-------------*/
class Mark extends Ctrl {

  protected function c_init($param = array()) { //构造函数
    parent::c_init();

    $this->mdl_mark     = Loader::model('Mark');
  }


  public function lists() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_markRows   = $this->mdl_mark->lists(array(1000, 'limit'));

    $_arr_return = array(
      'markRows'   => $_arr_markRows,
    );

    return $this->json($_arr_return);
  }
}
