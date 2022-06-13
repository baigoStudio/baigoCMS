<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Config;
use ginkgo\Arrays;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Mime extends Ctrl {

  protected function c_init($param = array()) {
    parent::c_init();

    $this->mdl_mime = Loader::model('Mime');

    $_str_hrefBase  = $this->hrefBase . 'mime/';

    $_arr_hrefRow = array(
      'index'        => $_str_hrefBase . 'index/',
      'add'          => $_str_hrefBase . 'form/',
      'edit'         => $_str_hrefBase . 'form/id/',
      'submit'       => $_str_hrefBase . 'submit/',
      'delete'       => $_str_hrefBase . 'delete/',
      'cache'        => $_str_hrefBase . 'cache/',
      'check'        => $_str_hrefBase . 'check/',
    );

    $this->generalData['hrefRow']   = array_replace_recursive($this->generalData['hrefRow'], $_arr_hrefRow);
  }


  public function index() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->groupAllow['attach']['mime']) && !$this->isSuper) { //判断权限
      return $this->error('You do not have permission', 'x080301');
    }

    $_arr_mimeRows   = $this->mdl_mime->lists(array(1000, 'limit')); //列出

    $_arr_tplData = array(
      'mimeRows'   => $_arr_mimeRows,
      'token'      => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_mimeRows);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function show() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->groupAllow['attach']['mime']) && !$this->isSuper) { //判断权限
      return $this->error('You do not have permission', 'x080301');
    }

    $_num_mimeId = 0;

    if (isset($this->param['id'])) {
      $_num_mimeId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    if ($_num_mimeId < 1) {
      return $this->error('Missing ID', 'x080202');
    }

    $_arr_mimeRow = $this->mdl_mime->read($_num_mimeId);

    if ($_arr_mimeRow['rcode'] != 'y080102') {
      return $this->error($_arr_mimeRow['msg'], $_arr_mimeRow['rcode']);
    }

    $_arr_tplData = array(
      'mimeRow'  => $_arr_mimeRow,
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_mimeRows);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function form() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_num_mimeId = 0;

    if (isset($this->param['id'])) {
      $_num_mimeId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    $_arr_mimeRow = $this->mdl_mime->read($_num_mimeId);

    if ($_num_mimeId > 0) {
      if (!isset($this->groupAllow['attach']['mime']) && !$this->isSuper) { //判断权限
        return $this->error('You do not have permission', 'x080303');
      }
      if ($_arr_mimeRow['rcode'] != 'y080102') {
        return $this->error($_arr_mimeRow['msg'], $_arr_mimeRow['rcode']);
      }
    } else {
      if (!isset($this->groupAllow['attach']['mime']) && !$this->isSuper) { //判断权限
        return $this->error('You do not have permission', 'x080302');
      }
    }

    $_arr_mimeRows   = $this->mdl_mime->lists(array(1000, 'limit'));
    $_arr_mimes      = array();

    foreach ($_arr_mimeRows as $_key=>$_value) {
      $_arr_mimes[] = $_value['mime_ext'];
    }

    $_arr_mimeOften  = Config::get('mime', 'console');

    foreach ($_arr_mimeOften as $_key=>&$_value) {
      if (in_array($_key, $_arr_mimes)) {
        $_value['exist'] = true;
      }

      $_value['note'] = $this->obj_lang->get($_value['note']);
    }

    $_arr_tplData = array(
      'mimeOftenJson' => Arrays::toJson($_arr_mimeOften),
      'mimeOften'     => $_arr_mimeOften,
      'mimeRow'       => $_arr_mimeRow,
      'token'         => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_mimeRows);

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

    $_arr_inputSubmit = $this->mdl_mime->inputSubmit();

    if ($_arr_inputSubmit['rcode'] != 'y080201') {
      return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
    }

    if ($_arr_inputSubmit['mime_id'] > 0) {
      if (!isset($this->groupAllow['attach']['mime']) && !$this->isSuper) {
        return $this->fetchJson('You do not have permission', 'x080303');
      }
    } else {
      if (!isset($this->groupAllow['attach']['mime']) && !$this->isSuper) {
        return $this->fetchJson('You do not have permission', 'x080302');
      }
    }

    $_arr_submitResult = $this->mdl_mime->submit();

    $this->cacheProcess();

    return $this->fetchJson($_arr_submitResult['msg'], $_arr_submitResult['rcode']);
  }


  public function delete() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (!isset($this->groupAllow['attach']['mime']) && !$this->isSuper) { //判断权限
      return $this->fetchJson('You do not have permission', 'x080304');
    }

    $_arr_inputDelete = $this->mdl_mime->inputDelete();

    if ($_arr_inputDelete['rcode'] != 'y080201') {
      return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
    }

    $_arr_deleteResult = $this->mdl_mime->delete();

    $this->cacheProcess();

    $_arr_langReplace = array(
      'count' => $_arr_deleteResult['count'],
    );

    return $this->fetchJson($_arr_deleteResult['msg'], $_arr_deleteResult['rcode'], '', $_arr_langReplace);
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
      'mime_id'   => array('int', 0),
      'mime_ext'  => array('str', ''),
    );

    $_arr_inputCheck = $this->obj_request->get($_arr_inputParam);

    if (Func::notEmpty($_arr_inputCheck['mime_ext'])) {
      $_arr_mimeRow   = $this->mdl_mime->read($_arr_inputCheck['mime_ext'], 'mime_ext', $_arr_inputCheck['mime_id']);

      if ($_arr_mimeRow['rcode'] == 'y080102') {
        $_arr_return = array(
          'rcode' => 'x080404',
          'error_msg' => $this->obj_lang->get('MIME already exists'),
        );
      }
    }

    return $this->json($_arr_return);
  }


  public function cache() {
    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    $_arr_inputCommon = $this->mdl_mime->inputCommon();

    if ($_arr_inputCommon['rcode'] != 'y080201') {
      return $this->fetchJson($_arr_inputCommon['msg'], $_arr_inputCommon['rcode']);
    }

    $_arr_cacheResult = $this->cacheProcess();

    return $this->fetchJson($_arr_cacheResult['msg'], $_arr_cacheResult['rcode']);
  }


  private function cacheProcess() {
    $_num_cacheSize = $this->mdl_mime->cacheProcess();

    if ($_num_cacheSize > 0) {
      $_str_rcode = 'y080110';
      $_str_msg   = 'Refresh cache successfully';
    } else {
      $_str_rcode = 'x080110';
      $_str_msg   = 'Refresh cache failed';
    }

    return array(
      'rcode'     => $_str_rcode,
      'msg'       => $_str_msg,
    );
  }
}
