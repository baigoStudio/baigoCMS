<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\gen;

use app\model\index\Call as Call_Index;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------栏目模型-------------*/
class Call extends Call_Index {

  public $inputSubmit = array();

  public function inputSubmit() {
    $_arr_inputParam = array(
      'call_id'   => array('int', 0),
      'page'      => array('int', 0),
      '__token__' => array('str', ''),
    );

    $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

    $_mix_vld = $this->validate($_arr_inputSubmit);

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x170201',
        'msg'   => end($_mix_vld),
      );
    }

    $_arr_inputSubmit['rcode'] = 'y170201';

    $this->inputSubmit = $_arr_inputSubmit;

    return $_arr_inputSubmit;
  }
}
