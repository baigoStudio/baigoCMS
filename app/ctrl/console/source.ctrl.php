<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Source extends Ctrl {

  protected function c_init($param = array()) {
    parent::c_init();

    $this->mdl_source    = Loader::model('Source');

    $_str_hrefBase = $this->hrefBase . 'source/';

    $_arr_hrefRow = array(
      'index'  => $_str_hrefBase . 'index/',
      'add'    => $_str_hrefBase . 'form/',
      'show'   => $_str_hrefBase . 'show/id/',
      'edit'   => $_str_hrefBase . 'form/id/',
      'submit' => $_str_hrefBase . 'submit/',
      'delete' => $_str_hrefBase . 'delete/',
    );

    $this->generalData['hrefRow']   = array_replace_recursive($this->generalData['hrefRow'], $_arr_hrefRow);
  }


  public function index() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->groupAllow['source']['browse']) && !$this->isSuper) { //判断权限
      return $this->error('You do not have permission', 'x260301');
    }

    $_arr_searchParam = array(
      'key'       => array('str', ''),
    );

    $_arr_search = $this->obj_request->param($_arr_searchParam);

    $_arr_sourceRows  = $this->mdl_source->lists(array(1000, 'limit'), $_arr_search); //列出

    $_arr_tplData = array(
      'search'        => $_arr_search,
      'sourceRows'    => $_arr_sourceRows,
      'token'         => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_sourceRows);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function show() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->groupAllow['source']['browse']) && !$this->isSuper) { //判断权限
      return $this->error('You do not have permission', 'x260301');
    }

    $_num_sourceId = 0;

    if (isset($this->param['id'])) {
      $_num_sourceId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    if ($_num_sourceId < 1) {
      return $this->error('Missing ID', 'x260202');
    }

    $_arr_sourceRow = $this->mdl_source->read($_num_sourceId);

    if ($_arr_sourceRow['rcode'] != 'y260102') {
      return $this->error($_arr_sourceRow['msg'], $_arr_sourceRow['rcode']);
    }

    $_arr_tplData = array(
      'sourceRow'  => $_arr_sourceRow,
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_sourceRows);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function form() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_num_sourceId = 0;

    if (isset($this->param['id'])) {
      $_num_sourceId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    $_arr_sourceRow = $this->mdl_source->read($_num_sourceId);

    if ($_num_sourceId > 0) {
      if (!isset($this->groupAllow['source']['edit']) && !$this->isSuper) { //判断权限
        return $this->error('You do not have permission', 'x260303');
      }
      if ($_arr_sourceRow['rcode'] != 'y260102') {
        return $this->error($_arr_sourceRow['msg'], $_arr_sourceRow['rcode']);
      }
    } else {
      if (!isset($this->groupAllow['source']['add']) && !$this->isSuper) { //判断权限
        return $this->error('You do not have permission', 'x260302');
      }
    }

    $_arr_tplData = array(
      'sourceRow'   => $_arr_sourceRow,
      'token'       => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_sourceRows);

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

    $_arr_inputSubmit = $this->mdl_source->inputSubmit();

    if ($_arr_inputSubmit['rcode'] != 'y260201') {
      return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
    }

    if ($_arr_inputSubmit['source_id'] > 0) {
      if (!isset($this->groupAllow['source']['edit']) && !$this->isSuper) {
        return $this->fetchJson('You do not have permission', 'x260303');
      }
    } else {
      if (!isset($this->groupAllow['source']['add']) && !$this->isSuper) {
        return $this->fetchJson('You do not have permission', 'x260302');
      }
    }

    $_arr_submitResult = $this->mdl_source->submit();

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

    if (!isset($this->groupAllow['source']['delete']) && !$this->isSuper) { //判断权限
      return $this->fetchJson('You do not have permission', 'x260304');
    }

    $_arr_inputDelete = $this->mdl_source->inputDelete();

    if ($_arr_inputDelete['rcode'] != 'y260201') {
      return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
    }

    $_arr_deleteResult = $this->mdl_source->delete();

    $_arr_langReplace = array(
      'count' => $_arr_deleteResult['count'],
    );

    return $this->fetchJson($_arr_deleteResult['msg'], $_arr_deleteResult['rcode'], '', $_arr_langReplace);
  }
}
