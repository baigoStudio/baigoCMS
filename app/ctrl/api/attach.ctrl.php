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
class Attach extends Ctrl {

  public function lists() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_searchParam = array(
      'key'       => array('str', ''),
      'year'      => array('str', ''),
      'month'     => array('str', ''),
      'album_id'  => array('int', 0),
      'perpage'   => array('int', $this->configVisit['perpage_in_api']),
    );

    $_arr_search    = $this->obj_request->get($_arr_searchParam);

    $_mdl_attach    = Loader::model('Attach_Album_View');

    $_arr_getData   = $_mdl_attach->lists($_arr_search['perpage'], $_arr_search);

    $_arr_return = array(
      'search'        => $_arr_search,
      'pageRow'       => $_arr_getData['pageRow'],
      'attachRows'    => $_arr_getData['dataRows'],
    );

    $_arr_return    = Plugin::listen('filter_api_attach_lists', $_arr_return); //编辑文章时触发

    return $this->json($_arr_return);
  }


  public function read() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_num_attachId   = $this->obj_request->get('attach_id', 'int', 0);

    if ($_num_attachId < 1) {
      return $this->fetchJson('Missing ID', 'x070202', 400);
    }

    $_mdl_attach   = Loader::model('Attach');

    $_arr_attachRow = $_mdl_attach->read($_num_attachId, 'attach_id', 'normal');

    if ($_arr_attachRow['rcode'] != 'y070102') {
      return $this->fetchJson($_arr_attachRow['msg'], $_arr_attachRow['rcode'], 404);
    }

    $_arr_return = array(
      'attachRow' => $_arr_attachRow,
    );

    $_arr_return   = Plugin::listen('filter_api_attach_read', $_arr_return); //编辑文章时触发

    return $this->json($_arr_return);
  }
}
