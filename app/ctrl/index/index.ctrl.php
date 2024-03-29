<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\index;

use app\classes\index\Ctrl;
use ginkgo\Loader;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Index extends Ctrl {

  public function index() {
    $_mix_init = $this->indexInit();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_tplData = array( );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }

  public function test($id = 3) {
    return $this->fetch('..' . DS . 'index' . DS . 'index');
  }
}
