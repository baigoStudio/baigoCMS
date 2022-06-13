<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\api;

use app\classes\api\Ctrl;
use ginkgo\Loader;
use ginkgo\Plugin;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------文章类-------------*/
class Tag extends Ctrl {

  protected function c_init($param = array()) { //构造函数
    parent::c_init();

    $this->mdl_tag     = Loader::model('Tag');
  }


  public function read() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_num_tagId = $this->obj_request->get('tag_id', 'int', 0);

    if ($_num_tagId < 1) {
      return $this->fetchJson('Missing ID', 'x130202', 400);
    }

    $_arr_tagRow = $this->mdl_tag->read($_num_tagId);

    if ($_arr_tagRow['rcode'] != 'y130102') {
      return $this->fetchJson($_arr_tagRow['msg'], $_arr_tagRow['rcode'], 404);
    }

    if ($_arr_tagRow['tag_status'] != 'show') {
      return $this->fetchJson('Tag is invalid', 'x130102');
    }

    $_arr_return = array(
      'tagRow'   => $_arr_tagRow,
    );

    $_arr_return = Plugin::listen('filter_api_tag_read', $_arr_return); //编辑文章时触发

    return $this->json($_arr_return);
  }
}
