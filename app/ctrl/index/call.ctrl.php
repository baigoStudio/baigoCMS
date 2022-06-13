<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\index;

use app\classes\index\Ctrl;
use ginkgo\Loader;
use ginkgo\Plugin;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Call extends Ctrl {

  public function index() {
    /*$_mix_init = $this->indexInit();

    if ($_mix_init !== true) {
        return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }*/

    $_arr_searchParam = array(
      'id'     => array('int', 0),
      'type'   => array('str', 'json'),
    );

    $_arr_search = $this->obj_request->param($_arr_searchParam);

    if ($_arr_search['id'] < 1) {
      return $this->fetchJson('Missing ID', 'x170202', 400);
    }

    $_arr_callRow = $this->obj_call->get($_arr_search['id']);

    $_arr_callRow = Plugin::listen('filter_pub_call_show', $_arr_callRow);

    switch ($_arr_search['type']) {
      case 'jsonp':
        $_mix_return = $this->jsonp($_arr_callRow);
      break;

      default:
        $_mix_return = $this->json($_arr_callRow);
      break;
    }

    return $_mix_return;
  }
}
