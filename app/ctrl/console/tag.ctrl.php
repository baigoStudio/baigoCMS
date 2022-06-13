<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\File;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Tag extends Ctrl {

  protected function c_init($param = array()) {
    parent::c_init();

    $this->mdl_tag        = Loader::model('Tag');

    $_str_hrefBase = $this->hrefBase . 'tag/';

    $_arr_hrefRow = array(
      'index'  => $_str_hrefBase . 'index/',
      'add'    => $_str_hrefBase . 'form/',
      'show'   => $_str_hrefBase . 'show/id/',
      'edit'   => $_str_hrefBase . 'form/id/',
      'submit' => $_str_hrefBase . 'submit/',
      'status' => $_str_hrefBase . 'status/',
      'delete' => $_str_hrefBase . 'delete/',
    );

    $this->generalData['status']    = $this->mdl_tag->arr_status;
    $this->generalData['hrefRow']   = array_replace_recursive($this->generalData['hrefRow'], $_arr_hrefRow);
  }


  public function index() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->groupAllow['article']['tag']) && !$this->isSuper) { //判断权限
      return $this->error('You do not have permission', 'x130301');
    }

    $_arr_searchParam = array(
      'key'       => array('str', ''),
      'status'    => array('str', ''),
    );

    $_arr_search = $this->obj_request->param($_arr_searchParam);

    $_arr_getData  = $this->mdl_tag->lists($this->config['var_default']['perpage'], $_arr_search); //列出

    $_arr_tplData = array(
      'search'    => $_arr_search,
      'pageRow'   => $_arr_getData['pageRow'],
      'tagRows'   => $_arr_getData['dataRows'],
      'token'     => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function typeahead() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->groupAllow['article']['tag']) && !$this->isSuper) { //判断权限
      return $this->fetchJson('You do not have permission', 'x130301');
    }

    $_arr_searchParam = array(
      'key' => array('str', ''),
    );

    $_arr_search = $this->obj_request->param($_arr_searchParam);

    $_arr_search['status'] = 'show';

    $_arr_getData  = $this->mdl_tag->lists(array(1000, 'limit'), $_arr_search); //列出

    $_arr_tags = array();

    foreach ($_arr_getData as $_key=>$_value) {
      $_arr_tags[] = $_value['tag_name'];
    }

    return $this->json($_arr_tags);
  }


  public function form() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_num_tagId = 0;

    if (isset($this->param['id'])) {
      $_num_tagId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    $_arr_tagRow = $this->mdl_tag->read($_num_tagId);

    if ($_num_tagId > 0) {
      if (!isset($this->groupAllow['article']['tag']) && !$this->isSuper) { //判断权限
        return $this->error('You do not have permission', 'x130303');
      }
      if ($_arr_tagRow['rcode'] != 'y130102') {
        return $this->error($_arr_tagRow['msg'], $_arr_tagRow['rcode']);
      }
    } else {
      if (!isset($this->groupAllow['article']['tag']) && !$this->isSuper) { //判断权限
        return $this->error('You do not have permission', 'x130302');
      }
    }

    $_arr_tplRows  = File::instance()->dirList(BG_TPL_TAG);

    foreach ($_arr_tplRows as $_key=>&$_value) {
      $_value['name_s'] = basename($_value['name'], GK_EXT_TPL);
    }

    $_arr_tplData = array(
      'tplRows'   => $_arr_tplRows,
      'tagRow'    => $_arr_tagRow,
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

    $_arr_inputSubmit = $this->mdl_tag->inputSubmit();

    if ($_arr_inputSubmit['rcode'] != 'y130201') {
      return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
    }

    if ($_arr_inputSubmit['tag_id'] > 0) {
      if (!isset($this->groupAllow['article']['tag']) && !$this->isSuper) {
        return $this->fetchJson('You do not have permission', 'x130303');
      }
    } else {
      if (!isset($this->groupAllow['article']['tag']) && !$this->isSuper) {
        return $this->fetchJson('You do not have permission', 'x130302');
      }
    }

    $_arr_submitResult = $this->mdl_tag->submit();

    return $this->fetchJson($_arr_submitResult['msg'], $_arr_submitResult['rcode']);
  }


  public function status() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (!isset($this->groupAllow['article']['tag']) && !$this->isSuper) { //判断权限
      return $this->fetchJson('You do not have permission', 'x130303');
    }

    $_arr_inputStatus = $this->mdl_tag->inputStatus();

    if ($_arr_inputStatus['rcode'] != 'y130201') {
      return $this->fetchJson($_arr_inputStatus['msg'], $_arr_inputStatus['rcode']);
    }

    $_arr_statusResult = $this->mdl_tag->status();

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

    if (!isset($this->groupAllow['article']['tag']) && !$this->isSuper) { //判断权限
      return $this->fetchJson('You do not have permission', 'x130304');
    }

    $_arr_inputDelete = $this->mdl_tag->inputDelete();

    if ($_arr_inputDelete['rcode'] != 'y130201') {
      return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
    }

    $_arr_deleteResult = $this->mdl_tag->delete();

    $_arr_langReplace = array(
      'count' => $_arr_deleteResult['count'],
    );

    return $this->fetchJson($_arr_deleteResult['msg'], $_arr_deleteResult['rcode'], '', $_arr_langReplace);
  }
}
