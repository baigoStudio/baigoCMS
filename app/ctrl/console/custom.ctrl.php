<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Config;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Custom extends Ctrl {

  protected function c_init($param = array()) {
    parent::c_init();

    $this->mdl_cate     = Loader::model('Cate');

    $this->mdl_custom   = Loader::model('Custom');

    $_str_hrefBase = $this->hrefBase . 'custom/';

    $_arr_hrefRow = array(
      'index'        => $_str_hrefBase . 'index/',
      'add'          => $_str_hrefBase . 'form/',
      'show'         => $_str_hrefBase . 'show/id/',
      'edit'         => $_str_hrefBase . 'form/id/',
      'order'        => $_str_hrefBase . 'order/id/',
      'order-submit' => $_str_hrefBase . 'order-submit/',
      'submit'       => $_str_hrefBase . 'submit/',
      'delete'       => $_str_hrefBase . 'delete/',
      'status'       => $_str_hrefBase . 'status/',
      'cache'        => $_str_hrefBase . 'cache/',
    );

    $this->generalData['status']    = $this->mdl_custom->arr_status;
    $this->generalData['type']      = $this->mdl_custom->arr_type;
    $this->generalData['format']    = $this->mdl_custom->arr_format;
    $this->generalData['hrefRow']   = array_replace_recursive($this->generalData['hrefRow'], $_arr_hrefRow);
  }


  public function index() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->groupAllow['article']['custom']) && !$this->isSuper) { //判断权限
      return $this->error('You do not have permission', 'x200301');
    }

    $_arr_searchParam = array(
      'key'       => array('str', ''),
      'status'    => array('str', ''),
    );

    $_arr_search = $this->obj_request->param($_arr_searchParam);

    if (Func::isEmpty($_arr_search['key']) && Func::isEmpty($_arr_search['status'])) {
      $_arr_search['parent_id'] = 0;
      $_arr_customRows  = $this->mdl_custom->listsTree($_arr_search); //列出
    } else {
      $_arr_customRows  = $this->mdl_custom->lists(array(1000, 'limit'), $_arr_search); //列出
    }

    $_arr_tplData = array(
      'search'        => $_arr_search,
      'customRows'    => $_arr_customRows,
      'token'         => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_customRows);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function show() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->groupAllow['article']['custom']) && !$this->isSuper) { //判断权限
      return $this->error('You do not have permission', 'x200303');
    }

    $_num_customId = 0;

    if (isset($this->param['id'])) {
      $_num_customId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    if ($_num_customId < 0) {
      return $this->error('Missing ID', 'x200202');
    }

    $_arr_customRow = $this->mdl_custom->read($_num_customId);

    if ($_arr_customRow['rcode'] != 'y200102') {
      return $this->error($_arr_customRow['msg'], $_arr_customRow['rcode']);
    }

    $_arr_customParent = $this->mdl_custom->read($_arr_customRow['custom_parent_id']);
    $_arr_cateRow      = $this->mdl_cate->read($_arr_customRow['custom_cate_id']);

    $_arr_tplData = array(
      'cateRow'       => $_arr_cateRow,
      'customRow'     => $_arr_customRow,
      'customParent'  => $_arr_customParent,
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_customRows);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function form() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_num_customId = 0;

    if (isset($this->param['id'])) {
      $_num_customId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    $_arr_customRow = $this->mdl_custom->read($_num_customId);

    if ($_num_customId > 0) {
      if (!isset($this->groupAllow['article']['custom']) && !$this->isSuper) { //判断权限
        return $this->error('You do not have permission', 'x200303');
      }
      if ($_arr_customRow['rcode'] != 'y200102') {
        return $this->error($_arr_customRow['msg'], $_arr_customRow['rcode']);
      }
    } else {
      if (!isset($this->groupAllow['article']['custom']) && !$this->isSuper) { //判断权限
        return $this->error('You do not have permission', 'x200302');
      }

      $_arr_configConsole = Config::get('console');

      $_arr_customOpt = array();

      foreach ($this->mdl_custom->arr_type as $_key=>$_value) {
        for ($_iii = 1; $_iii <= $_arr_configConsole['count_option']; ++$_iii) {
          $_arr_customOpt[$_value][$_iii] = '';
        }
      }

      $_arr_customRow['custom_opt'] = $_arr_customOpt;
    }

    $_arr_search['parent_id'] = 0;

    $_arr_cateRows   = $this->mdl_cate->listsTree($_arr_search);
    $_arr_customRows = $this->mdl_custom->listsTree($_arr_search);

    $_arr_tplData = array(
      'cateRows'      => $_arr_cateRows,
      'customRows'    => $_arr_customRows,
      'customRow'     => $_arr_customRow,
      'token'         => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_customRows);

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

    $_arr_inputSubmit = $this->mdl_custom->inputSubmit();

    if ($_arr_inputSubmit['rcode'] != 'y200201') {
      return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
    }

    if ($_arr_inputSubmit['custom_id'] > 0) {
      if (!isset($this->groupAllow['article']['custom']) && !$this->isSuper) {
        return $this->fetchJson('You do not have permission', 'x200303');
      }
    } else {
      if (!isset($this->groupAllow['article']['custom']) && !$this->isSuper) {
        return $this->fetchJson('You do not have permission', 'x200302');
      }
    }

    $_arr_submitResult = $this->mdl_custom->submit();

    $_mix_dbResult = $this->dbProcess();

    if ($_mix_dbResult !== true) {
      return $this->fetchJson($_mix_dbResult['msg'], $_mix_dbResult['rcode']);
    }

    return $this->fetchJson($_arr_submitResult['msg'], $_arr_submitResult['rcode']);
  }


  public function order() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->groupAllow['article']['custom']) && !$this->isSuper) { //判断权限
        return $this->error('You do not have permission', 'x200301');
    }

    $_arr_search['parent_id'] = 0;
    $_arr_customRow = array();

    if (isset($this->param['id']) && $this->param['id'] > 1) {
      $_arr_search['parent_id'] = $this->obj_request->input($this->param['id'], 'int', 0);

      $_arr_customRow = $this->mdl_custom->read($_arr_search['parent_id']);

      if ($_arr_customRow['rcode'] != 'y200102') {
        return $this->error($_arr_customRow['msg'], $_arr_customRow['rcode']);
      }
    }

    $_arr_customRows  = $this->mdl_custom->lists(array(1000, 'limit'), $_arr_search); //列出

    $_arr_tplData = array(
      'search'        => $_arr_search,
      'customRow'     => $_arr_customRow,
      'customRows'    => $_arr_customRows,
      'token'         => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_customRows);

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

    if (!isset($this->groupAllow['article']['custom']) && !$this->isSuper) {
      return $this->fetchJson('You do not have permission', 'x200303');
    }

    $_arr_inputOrder = $this->mdl_custom->inputOrder();

    if ($_arr_inputOrder['rcode'] != 'y200201') {
      return $this->fetchJson($_arr_inputOrder['msg'], $_arr_inputOrder['rcode']);
    }

    $_arr_orderResult = $this->mdl_custom->order();

    $_mix_dbResult = $this->dbProcess();

    if ($_mix_dbResult !== true) {
      return $this->fetchJson($_mix_dbResult['msg'], $_mix_dbResult['rcode']);
    }

    return $this->fetchJson($_arr_orderResult['msg'], $_arr_orderResult['rcode']);
  }


  public function status() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (!isset($this->groupAllow['article']['custom']) && !$this->isSuper) { //判断权限
      return $this->fetchJson('You do not have permission', 'x200303');
    }

    $_arr_inputStatus = $this->mdl_custom->inputStatus();

    if ($_arr_inputStatus['rcode'] != 'y200201') {
      return $this->fetchJson($_arr_inputStatus['msg'], $_arr_inputStatus['rcode']);
    }

    $_arr_statusResult = $this->mdl_custom->status();

    $_mix_dbResult = $this->dbProcess();

    if ($_mix_dbResult !== true) {
      return $this->fetchJson($_mix_dbResult['msg'], $_mix_dbResult['rcode']);
    }

    $_arr_langReplace = array(
      'count' => $_arr_statusResult['count'],
    );

    return $this->fetchJson($_arr_statusResult['msg'], $_arr_statusResult['rcode'], '', $_arr_langReplace);
  }


  public function delete() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (!isset($this->groupAllow['article']['custom']) && !$this->isSuper) { //判断权限
      return $this->fetchJson('You do not have permission', 'x200304');
    }

    $_arr_inputDelete = $this->mdl_custom->inputDelete();

    if ($_arr_inputDelete['rcode'] != 'y200201') {
      return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
    }

    $_arr_deleteResult = $this->mdl_custom->delete();

    $_mix_dbResult = $this->dbProcess();

    if ($_mix_dbResult !== true) {
      return $this->fetchJson($_mix_dbResult['msg'], $_mix_dbResult['rcode']);
    }

    $_arr_langReplace = array(
      'count' => $_arr_deleteResult['count'],
    );

    return $this->fetchJson($_arr_deleteResult['msg'], $_arr_deleteResult['rcode'], '', $_arr_langReplace);
  }


  public function cache() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    $_arr_inputCommon = $this->mdl_custom->inputCommon();

    if ($_arr_inputCommon['rcode'] != 'y200201') {
      return $this->fetchJson($_arr_inputCommon['msg'], $_arr_inputCommon['rcode']);
    }

    $_mix_dbResult = $this->dbProcess();

    if ($_mix_dbResult === true) {
      return $this->fetchJson('Refresh cache successfully', 'y200110');
    } else {
      return $this->fetchJson($_mix_dbResult['msg'], $_mix_dbResult['rcode']);
    }
  }


  private function dbProcess() {
    $_mdl_articleCustom        = Loader::model('Article_Custom', '', 'install');
    $_mdl_articleCustomView    = Loader::model('Article_Custom_View', '', 'install');

    $_arr_result = $_mdl_articleCustom->createTable();
    if ($_arr_result['rcode'] != 'y210105') {
      return $_arr_result;
    }

    $_arr_result = $_mdl_articleCustom->alterTable();
    if ($_arr_result['rcode'] != 'y210106' && $_arr_result['rcode'] != 'y210111') {
      return $_arr_result;
    }

    $_arr_result = $_mdl_articleCustomView->createView();
    if ($_arr_result['rcode'] != 'y120108') {
      return $_arr_result;
    }

    $_mdl_custom = Loader::model('Custom', '', 'index');

    $_num_cacheSize      = $_mdl_custom->cacheProcess();
    $_num_cacheTreeSize  = $_mdl_custom->cacheTreeProcess();

    if ($_num_cacheSize < 1 || $_num_cacheTreeSize < 1) {
      return array(
        'rcode'     => 'x200110',
        'msg'       => 'Refresh cache failed',
      );
    }

    return true;
  }
}
