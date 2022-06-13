<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\File;
use ginkgo\Func;
use ginkgo\Plugin;
use ginkgo\Arrays;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Cate extends Ctrl {

  protected function c_init($param = array()) {
    parent::c_init();

    $this->obj_qlist  = Loader::classes('Qlist');
    $this->mdl_cate   = Loader::model('Cate');
    $this->mdl_admin  = Loader::model('Admin');
    $this->mdl_attach = Loader::model('Attach');

    $_str_hrefBase = $this->hrefBase . 'cate/';

    $_arr_hrefRow = array(
      'index'         => $_str_hrefBase . 'index/',
      'add'           => $_str_hrefBase . 'form/',
      'show'          => $_str_hrefBase . 'show/id/',
      'edit'          => $_str_hrefBase . 'form/id/',
      'attach'        => $_str_hrefBase . 'attach/id/',
      'order'         => $_str_hrefBase . 'order/id/',
      'order-submit'  => $_str_hrefBase . 'order-submit/',
      'submit'        => $_str_hrefBase . 'submit/',
      'check'         => $_str_hrefBase . 'check/',
      'duplicate'     => $_str_hrefBase . 'duplicate/',
      'delete'        => $_str_hrefBase . 'delete/',
      'status'        => $_str_hrefBase . 'status/',
      'cache'         => $_str_hrefBase . 'cache/',
      'cover'         => $_str_hrefBase . 'cover/',
      'album-choose'  => $this->url['route_console'] . 'album/choose/',
      'attach-choose' => $this->url['route_console'] . 'attach/choose/cate/',
      'attach-cover'  => $this->url['route_console'] . 'attach/choose/target/cate_cover/cate/',
      'attach-index'  => $this->url['route_console'] . 'attach/index/ids/',
      'attach-show'   => $this->url['route_console'] . 'attach/show/id/',
      'article-index' => $this->url['route_console'] . 'article/index/cate/',
      'gen'           => $this->url['route_gen'] . 'cate/single/id/',
    );

    $this->generalData['status']    = $this->mdl_cate->arr_status;
    $this->generalData['pasv']      = $this->mdl_cate->arr_pasv;
    $this->generalData['hrefRow']   = array_replace_recursive($this->generalData['hrefRow'], $_arr_hrefRow);
  }


  public function index() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->groupAllow['cate']['browse']) && !$this->isSuper) { //判断权限
      return $this->error('You do not have permission', 'x250301');
    }

    $_arr_searchParam = array(
      'key'       => array('str', ''),
      'status'    => array('str', ''),
    );

    $_arr_search = $this->obj_request->param($_arr_searchParam);

    if (Func::isEmpty($_arr_search['key']) && Func::isEmpty($_arr_search['status'])) {
      $_arr_search['parent_id'] = 0;
      $_arr_cateRows   = $this->mdl_cate->listsTree($_arr_search); //列出
    } else {
      $_arr_cateRows   = $this->mdl_cate->lists(array(1000, 'limit'), $_arr_search); //列出
    }


    $_arr_tplData = array(
      'search'     => $_arr_search,
      'cateRows'   => $_arr_cateRows,
      'token'      => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_cateRows);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function show() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->groupAllow['cate']['browse']) && !$this->isSuper) { //判断权限
      return $this->error('You do not have permission', 'x250301');
    }

    $_num_cateId = 0;

    if (isset($this->param['id'])) {
      $_num_cateId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    if ($_num_cateId < 1) {
      return $this->error('Missing ID', 'x250202');
    }

    $_arr_cateRow = $this->mdl_cate->read($_num_cateId);

    if ($_arr_cateRow['rcode'] != 'y250102') {
      return $this->error($_arr_cateRow['msg'], $_arr_cateRow['rcode']);
    }

    $_arr_cateParent = $this->mdl_cate->read($_arr_cateRow['cate_parent_id']);
    $_arr_attachRow  = $this->mdl_attach->read($_arr_cateRow['cate_attach_id']);

    $_arr_tplData = array(
      'cateParent'    => $_arr_cateParent,
      'cateRow'       => $_arr_cateRow,
      'attachRow'     => $_arr_attachRow,
      'token'         => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_cateRows);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function form() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_num_cateId = 0;

    if (isset($this->param['id'])) {
      $_num_cateId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    $_arr_cateRow = $this->mdl_cate->read($_num_cateId);

    if ($_num_cateId > 0) {
      if (!isset($this->groupAllow['cate']['edit']) && !isset($this->adminLogged['admin_allow_cate'][$_num_cateId]['cate']) && !$this->isSuper) { //判断权限
        return $this->error('You do not have permission', 'x250303');
      }

      if ($_arr_cateRow['rcode'] != 'y250102') {
        return $this->error($_arr_cateRow['msg'], $_arr_cateRow['rcode']);
      }

      $_arr_attachRow = $this->mdl_attach->read($_arr_cateRow['cate_attach_id']);
    } else {
      if (!isset($this->groupAllow['cate']['add']) && !$this->isSuper) { //判断权限
        return $this->error('You do not have permission', 'x250302');
      }

      $_arr_attachRow = array(
        'attach_thumb' => '',
      );
    }

    $_arr_search['parent_id'] = 0;

    $_arr_cateRows   = $this->mdl_cate->listsTree($_arr_search);

    $_arr_tplData = array(
      'tplRows'   => File::instance()->dirList(BG_TPL_INDEX),
      'cateRow'   => $_arr_cateRow,
      'cateRows'  => $_arr_cateRows,
      'attachRow' => $_arr_attachRow,
      'token'     => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_cateRows);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function submit() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    $_arr_inputSubmit = $this->mdl_cate->inputSubmit();

    if ($_arr_inputSubmit['rcode'] != 'y250201') {
      return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
    }

    if ($_arr_inputSubmit['cate_id'] > 0) {
      if (!isset($this->groupAllow['cate']['edit']) && !isset($this->adminLogged['admin_allow_cate'][$_arr_inputSubmit['cate_id']]['cate']) && !$this->isSuper) {
        return $this->fetchJson('You do not have permission', 'x250303');
      }
    } else {
      if (!isset($this->groupAllow['cate']['add']) && !$this->isSuper) {
        return $this->fetchJson('You do not have permission', 'x250302');
      }
    }

    if ($_arr_inputSubmit['cate_attach_id'] < 1) {
      $_arr_attachIds = $this->obj_qlist->getAttachIds($_arr_inputSubmit['cate_content']);

      if ($_arr_attachIds[0] > 0) {
        $this->mdl_cate->inputSubmit['cate_attach_id'] = $_arr_attachIds[0];
      }
    }

    $_arr_submitResult = $this->mdl_cate->submit();

    $this->cacheProcess();

    $_arr_submitResult['msg'] = $this->obj_lang->get($_arr_submitResult['msg']);

    return $this->json($_arr_submitResult);
  }


  public function order() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->groupAllow['cate']['edit']) && !$this->isSuper) { //判断权限
      return $this->error('You do not have permission', 'x250301');
    }

    $_arr_search['parent_id'] = 0;
    $_arr_cateRow             = array();

    if (isset($this->param['id']) && $this->param['id'] > 1) {
      $_arr_search['parent_id'] = $this->obj_request->input($this->param['id'], 'int', 0);

      $_arr_cateRow = $this->mdl_cate->read($_arr_search['parent_id']);

      if ($_arr_cateRow['rcode'] != 'y250102') {
        return $this->error($_arr_cateRow['msg'], $_arr_cateRow['rcode']);
      }
    }

    $_arr_cateRows   = $this->mdl_cate->lists(array(1000, 'limit'), $_arr_search); //列出

    $_arr_tplData = array(
      'cateRow'    => $_arr_cateRow,
      'cateRows'   => $_arr_cateRows,
      'token'      => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_cateRows);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function orderSubmit() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (!isset($this->groupAllow['cate']['edit']) && !$this->isSuper) {
      return $this->fetchJson('You do not have permission', 'x250303');
    }

    $_arr_inputOrder = $this->mdl_cate->inputOrder();

    if ($_arr_inputOrder['rcode'] != 'y250201') {
      return $this->fetchJson($_arr_inputOrder['msg'], $_arr_inputOrder['rcode']);
    }

    $_arr_orderResult = $this->mdl_cate->order();

    $this->cacheProcess();

    return $this->fetchJson($_arr_orderResult['msg'], $_arr_orderResult['rcode']);
  }


  public function attach() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_num_cateId = 0;

    if (isset($this->param['id'])) {
      $_num_cateId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    if ($_num_cateId < 1) {
      return $this->error('Missing ID', 'x250202');
    }

    $_arr_cateRow = $this->mdl_cate->read($_num_cateId);

    if ($_arr_cateRow['rcode'] != 'y250102') {
      return $this->error($_arr_cateRow['msg'], $_arr_cateRow['rcode']);
    }

    if (!isset($this->groupAllow['cate']['edit']) && !isset($this->adminLogged['admin_allow_cate'][$_num_cateId]['cate']) && !$this->isSuper) { //判断权限
      return $this->error('You do not have permission', 'x250303');
    }

    $_arr_search = array(
      'box'           => 'normal',
      'attach_ids'    => $this->obj_qlist->getAttachIds($_arr_cateRow['cate_content']),
    );

    if ($_arr_cateRow['cate_attach_id'] > 0) {
      $_arr_search['attach_ids'][] = $_arr_cateRow['cate_attach_id'];
    }

    $_arr_search['attach_ids'] = Arrays::unique($_arr_search['attach_ids'], true);

    $_arr_attachRows   = array();

    $_arr_attachRows   = array();

    if (Func::notEmpty($_arr_search['attach_ids'])) {
      $_arr_attachRows   = $this->mdl_attach->lists(array(1000, 'limit'), $_arr_search); //列出
    }

    foreach ($_arr_attachRows as $_key=>&$_value) {
      $_value['adminRow'] = $this->mdl_admin->read($_value['attach_admin_id']);
    }

    $_arr_attachRow = $this->mdl_attach->read($_arr_cateRow['cate_attach_id']);

    $_arr_tplData = array(
      'ids'        => implode(',', $_arr_search['attach_ids']),
      'cateRow'    => $_arr_cateRow,
      'attachRows' => $_arr_attachRows,
      'attachRow'  => $_arr_attachRow,
      'token'      => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function cover() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    $_arr_inputCover = $this->mdl_cate->inputCover();

    if ($_arr_inputCover['rcode'] != 'y250201') {
      return $this->fetchJson($_arr_inputCover['msg'], $_arr_inputCover['rcode']);
    }

    if (!isset($this->groupAllow['cate']['edit']) && !isset($this->adminLogged['admin_allow_cate'][$_arr_inputCover['cate_id']]['cate']) && !$this->isSuper) { //判断权限
      return $this->fetchJson('You do not have permission', 'x250303');
    }

    $_arr_attachRow = $this->mdl_attach->check($_arr_inputCover['attach_id']);

    if ($_arr_attachRow['rcode'] != 'y070102') {
      return $this->fetchJson($_arr_attachRow['msg'], $_arr_attachRow['rcode']);
    }

    $_arr_coverResult   = $this->mdl_cate->cover();

    return $this->fetchJson($_arr_coverResult['msg'], $_arr_coverResult['rcode']);
  }


  public function duplicate() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (!isset($this->groupAllow['cate']['add']) && !$this->isSuper) {
      return $this->fetchJson('You do not have permission', 'x250302');
    }

    $_arr_inputDuplicate = $this->mdl_cate->inputDuplicate();

    if ($_arr_inputDuplicate['rcode'] != 'y250201') {
      return $this->fetchJson($_arr_inputDuplicate['msg'], $_arr_inputDuplicate['rcode']);
    }

    $_arr_duplicateResult = $this->mdl_cate->duplicate();

    $this->cacheProcess();

    return $this->fetchJson($_arr_duplicateResult['msg'], $_arr_duplicateResult['rcode']);
  }


  public function delete() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (!isset($this->groupAllow['cate']['delete']) && !$this->isSuper) { //判断权限
      return $this->fetchJson('You do not have permission', 'x250304');
    }

    $_arr_inputDelete = $this->mdl_cate->inputDelete();

    if ($_arr_inputDelete['rcode'] != 'y250201') {
      return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
    }

    $_arr_return = array(
      'cate_ids'      => $_arr_inputDelete['cate_ids'],
    );

    Plugin::listen('action_console_cate_delete', $_arr_return); //删除链接时触发

    $_arr_deleteResult = $this->mdl_cate->delete();

    $this->cacheProcess();

    $_arr_langReplace = array(
      'count' => $_arr_deleteResult['count'],
    );

    return $this->fetchJson($_arr_deleteResult['msg'], $_arr_deleteResult['rcode'], '', $_arr_langReplace);
  }


  public function status() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (!isset($this->groupAllow['cate']['edit']) && !$this->isSuper) { //判断权限
      return $this->fetchJson('You do not have permission', 'x250303');
    }

    $_arr_inputStatus = $this->mdl_cate->inputStatus();

    if ($_arr_inputStatus['rcode'] != 'y250201') {
      return $this->fetchJson($_arr_inputStatus['msg'], $_arr_inputStatus['rcode']);
    }

    $_arr_return = array(
      'cate_ids'      => $_arr_inputStatus['cate_ids'],
      'cate_status'   => $_arr_inputStatus['act'],
    );

    Plugin::listen('action_console_cate_status', $_arr_return); //删除链接时触发

    $_arr_statusResult = $this->mdl_cate->status();

    $this->cacheProcess();

    $_arr_langReplace = array(
      'count' => $_arr_statusResult['count'],
    );

    return $this->fetchJson($_arr_statusResult['msg'], $_arr_statusResult['rcode'], '', $_arr_langReplace);
  }


  public function cache() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    $_arr_inputCommon = $this->mdl_cate->inputCommon();

    if ($_arr_inputCommon['rcode'] != 'y250201') {
      return $this->fetchJson($_arr_inputCommon['msg'], $_arr_inputCommon['rcode']);
    }

    $_arr_cacheResult = $this->cacheProcess();

    return $this->fetchJson($_arr_cacheResult['msg'], $_arr_cacheResult['rcode']);
  }


  public function check() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_return = array(
      'msg' => '',
    );

    $_arr_inputParam = array(
      'cate_id'           => array('int', 0),
      'cate_parent_id'    => array('int', 0),
      'cate_alias'        => array('str', ''),
    );

    $_arr_inputCheck = $this->obj_request->get($_arr_inputParam);

    if (Func::notEmpty($_arr_inputCheck['cate_alias'])) {
      $_arr_cateRow   = $this->mdl_cate->check($_arr_inputCheck['cate_alias'], 'cate_alias', $_arr_inputCheck['cate_id'], $_arr_inputCheck['cate_parent_id']);

      if ($_arr_cateRow['rcode'] == 'y250102') {
        $_arr_return = array(
          'rcode' => 'x250404',
          'error_msg' => $this->obj_lang->get('Alias already exists'),
        );
      } else {
        if (is_numeric($_arr_inputCheck['cate_alias'])) {
          $_arr_cateRow   = $this->mdl_cate->check($_arr_inputCheck['cate_alias'], 'cate_id', $_arr_inputCheck['cate_id'], $_arr_inputCheck['cate_parent_id']);
          if ($_arr_cateRow['rcode'] == 'y250102') {
            $_arr_return = array(
              'rcode' => 'x250404',
              'error_msg' => $this->obj_lang->get('Alias already exists'),
            );
          }
        }
      }
    }

    return $this->json($_arr_return);
  }


  private function cacheProcess() {
    $_mdl_cate      = Loader::model('Cate', '', 'index');
    $_arr_cateRows  = $this->mdl_cate->lists(array(1000, 'limit'));
    $_num_cacheSize = 0;

    foreach ($_arr_cateRows as $_key=>$_value) {
      $_num_cacheSize = $_mdl_cate->cacheProcess($_value['cate_id']);
    }

    $_num_cacheTreeSize = $_mdl_cate->cacheTreeProcess();

    if ($_num_cacheSize > 0 && $_num_cacheTreeSize > 0) {
      $_str_rcode = 'y250110';
      $_str_msg   = 'Refresh cache successfully';
    } else {
      $_str_rcode = 'x250110';
      $_str_msg   = 'Refresh cache failed';
    }

    return array(
      'rcode'     => $_str_rcode,
      'msg'       => $_str_msg,
    );
  }
}
