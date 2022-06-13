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

class Group extends Ctrl {

  protected function c_init($param = array()) {
    parent::c_init();

    $this->mdl_group    = Loader::model('Group');

    $_str_hrefBase = $this->hrefBase . 'group/';

    $_arr_hrefRow = array(
      'index'        => $_str_hrefBase . 'index/',
      'add'          => $_str_hrefBase . 'form/',
      'show'         => $_str_hrefBase . 'show/id/',
      'edit'         => $_str_hrefBase . 'form/id/',
      'submit'       => $_str_hrefBase . 'submit/',
      'delete'       => $_str_hrefBase . 'delete/',
      'status'       => $_str_hrefBase . 'status/',
    );

    $this->generalData['status']  = $this->mdl_group->arr_status;
    $this->generalData['hrefRow'] = array_replace_recursive($this->generalData['hrefRow'], $_arr_hrefRow);
  }


  public function index() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->groupAllow['group']['browse']) && !$this->isSuper) { //判断权限
      return $this->error('You do not have permission', 'x040301');
    }

    $_arr_searchParam = array(
      'key'       => array('str', ''),
      'status'    => array('str', ''),
    );

    $_arr_search = $this->obj_request->param($_arr_searchParam);

    $_arr_getData   = $this->mdl_group->lists($this->config['var_default']['perpage'], $_arr_search); //列出

    $_arr_tplData = array(
      'search'     => $_arr_search,
      'pageRow'    => $_arr_getData['pageRow'],
      'groupRows'  => $_arr_getData['dataRows'],
      'token'      => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function show() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->groupAllow['group']['browse']) && !$this->isSuper) { //判断权限
      return $this->error('You do not have permission', 'x040301');
    }

    $_num_groupId = 0;

    if (isset($this->param['id'])) {
      $_num_groupId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    if ($_num_groupId < 1) {
      return $this->error('Missing ID', 'x040202');
    }

    $_arr_groupRow = $this->mdl_group->read($_num_groupId);

    if ($_arr_groupRow['rcode'] != 'y040102') {
      return $this->error($_arr_groupRow['msg'], $_arr_groupRow['rcode']);
    }

    $_arr_tplData = array(
      'groupRow'  => $_arr_groupRow,
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function form() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_num_groupId = 0;

    if (isset($this->param['id'])) {
      $_num_groupId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    $_arr_groupRow = $this->mdl_group->read($_num_groupId);

    if ($_num_groupId > 0) {
      if (!isset($this->groupAllow['group']['edit']) && !$this->isSuper) { //判断权限
        return $this->error('You do not have permission', 'x040303');
      }
      if ($_arr_groupRow['rcode'] != 'y040102') {
        return $this->error($_arr_groupRow['msg'], $_arr_groupRow['rcode']);
      }
    } else {
      if (!isset($this->groupAllow['group']['add']) && !$this->isSuper) { //判断权限
        return $this->error('You do not have permission', 'x040302');
      }
    }

    $_arr_tplData = array(
      'groupRow'  => $_arr_groupRow,
      'token'     => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

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

    $_arr_inputSubmit = $this->mdl_group->inputSubmit();

    if ($_arr_inputSubmit['rcode'] != 'y040201') {
      return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
    }

    if ($_arr_inputSubmit['group_id'] > 0) {
      if (!isset($this->groupAllow['group']['edit']) && !$this->isSuper) {
        return $this->fetchJson('You do not have permission', 'x040303');
      }
    } else {
      if (!isset($this->groupAllow['group']['add']) && !$this->isSuper) {
        return $this->fetchJson('You do not have permission', 'x040302');
      }
    }

    $_arr_submitResult = $this->mdl_group->submit();

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

    if (!isset($this->groupAllow['group']['delete']) && !$this->isSuper) { //判断权限
      return $this->fetchJson('You do not have permission', 'x040304');
    }

    $_arr_inputDelete = $this->mdl_group->inputDelete();

    if ($_arr_inputDelete['rcode'] != 'y040201') {
      return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
    }

    $_arr_deleteResult = $this->mdl_group->delete();

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

    if (!isset($this->groupAllow['group']['edit']) && !$this->isSuper) { //判断权限
      return $this->fetchJson('You do not have permission', 'x040303');
    }

    $_arr_inputStatus = $this->mdl_group->inputStatus();

    if ($_arr_inputStatus['rcode'] != 'y040201') {
      return $this->fetchJson($_arr_inputStatus['msg'], $_arr_inputStatus['rcode']);
    }

    $_arr_statusResult = $this->mdl_group->status();

    $_arr_langReplace = array(
      'count' => $_arr_statusResult['count'],
    );

    return $this->fetchJson($_arr_statusResult['msg'], $_arr_statusResult['rcode'], '', $_arr_langReplace);
  }
}
