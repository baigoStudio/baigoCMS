<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Config;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Gsite_Step extends Ctrl {

  protected function c_init($param = array()) {
    parent::c_init();

    $_str_configContent  = BG_PATH_CONFIG . 'console' . DS . 'gsite_step_content' . GK_EXT_INC;
    $this->configContent = Config::load($_str_configContent, 'gsite_step_content', 'console');

    $this->mdl_cate      = Loader::model('Cate');

    $this->mdl_gsiteStep = Loader::model('Gsite_Step');

    $_str_hrefBase  = $this->hrefBase . 'gsite_step/';
    $_str_hrefGsite = $this->hrefBase . 'gsite/';

    $_arr_hrefRow = array(
      'index'                      => $_str_hrefGsite . 'index/',
      'add'                        => $_str_hrefGsite . 'form/',
      'edit'                       => $_str_hrefGsite . 'form/id/',
      'lists'                      => $_str_hrefBase . 'lists/id/',
      'content'                    => $_str_hrefBase . 'content/id/',
      'page-lists'                 => $_str_hrefBase . 'page-lists/id/',
      'page-content'               => $_str_hrefBase . 'page-content/id/',
      'lists-submit'               => $_str_hrefBase . 'lists-submit/',
      'content-submit'             => $_str_hrefBase . 'content-submit/',
      'page-lists-submit'          => $_str_hrefBase . 'page-lists-submit/',
      'page-content-submit'        => $_str_hrefBase . 'page-content-submit/',
      'gsite-preview-lists'        => $this->url['route_console'] . 'gsite-preview/lists/id/',
      'gsite-preview-content'      => $this->url['route_console'] . 'gsite-preview/content/id/',
      'gsite-preview-page-lists'   => $this->url['route_console'] . 'gsite-preview/page-lists/id/',
      'gsite-preview-page-content' => $this->url['route_console'] . 'gsite-preview/page-content/id/',
      'gsite-source-lists'         => $this->url['route_console'] . 'gsite-source/lists/id/',
      'gsite-source-content'       => $this->url['route_console'] . 'gsite-source/content/id/',
      'gsite-source-page-lists'    => $this->url['route_console'] . 'gsite-source/page-lists/id/',
      'gsite-source-page-content'  => $this->url['route_console'] . 'gsite-source/page-content/id/',
      'gsite-help'                 => $this->url['route_console'] . 'gsite-help/',
    );

    $this->generalData['hrefRow'] = array_replace_recursive($this->generalData['hrefRow'], $_arr_hrefRow);
  }


  public function form() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->groupAllow['gather']['gsite']) && !$this->isSuper) { //判断权限
      return $this->error('You do not have permission', 'x270303');
    }

    $_num_gsiteId = 0;

    if (isset($this->param['id'])) {
      $_num_gsiteId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    if ($_num_gsiteId < 1) {
      return $this->error('Missing ID', 'x270202');
    }

    $_arr_gsiteRow = $this->mdl_gsiteStep->read($_num_gsiteId);

    if ($_arr_gsiteRow['rcode'] != 'y270102') {
      return $this->error($_arr_gsiteRow['msg'], $_arr_gsiteRow['rcode']);
    }

    $_arr_attrOften         = Config::get('attr_often', 'console.gsite_step');

    if (isset($this->routeOrig['act'])) {
      $_str_act = $this->obj_request->input($this->routeOrig['act'], 'str', 'lists');
    } else {
      $_str_act = 'lists';
    }

    $_arr_cateRow   = $this->mdl_cate->read($_arr_gsiteRow['gsite_cate_id']);

    $_arr_tplData = array(
      'configContent' => $this->configContent,
      'keepTag'       => $this->mdl_gsiteStep->keepTag,
      'keepAttr'      => $this->mdl_gsiteStep->keepAttr, //系统保留属性
      'attrOften'     => $_arr_attrOften,
      'cateRow'       => $_arr_cateRow,
      'gsiteRow'      => $_arr_gsiteRow,
      'token'         => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_gsiteRows);

    $this->assign($_arr_tpl);

    $_str_tpl = 'gsite_step' . DS . $_str_act;

    return $this->fetch($_str_tpl);
  }


  public function listsSubmit() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (!isset($this->groupAllow['gather']['gsite']) && !$this->isSuper) {
      return $this->fetchJson('You do not have permission', 'x270303');
    }

    $_arr_inputLists = $this->mdl_gsiteStep->inputLists();

    if ($_arr_inputLists['rcode'] != 'y270201') {
      return $this->fetchJson($_arr_inputLists['msg'], $_arr_inputLists['rcode']);
    }

    $_arr_listsResult = $this->mdl_gsiteStep->setLists();

    return $this->fetchJson($_arr_listsResult['msg'], $_arr_listsResult['rcode']);
  }


  public function contentSubmit() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (!isset($this->groupAllow['gather']['gsite']) && !$this->isSuper) {
      return $this->fetchJson('You do not have permission', 'x270303');
    }

    $_arr_inputContent = $this->mdl_gsiteStep->inputContent();

    if ($_arr_inputContent['rcode'] != 'y270201') {
      return $this->fetchJson($_arr_inputContent['msg'], $_arr_inputContent['rcode']);
    }

    $_arr_contentResult = $this->mdl_gsiteStep->setContent();

    return $this->fetchJson($_arr_contentResult['msg'], $_arr_contentResult['rcode']);
  }


  public function pageListsSubmit() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (!isset($this->groupAllow['gather']['gsite']) && !$this->isSuper) {
      return $this->fetchJson('You do not have permission', 'x270303');
    }

    $_arr_inputPageLists = $this->mdl_gsiteStep->inputPageLists();

    if ($_arr_inputPageLists['rcode'] != 'y270201') {
      return $this->fetchJson($_arr_inputPageLists['msg'], $_arr_inputPageLists['rcode']);
    }

    $_arr_pageListsResult = $this->mdl_gsiteStep->setPageLists();

    return $this->fetchJson($_arr_pageListsResult['msg'], $_arr_pageListsResult['rcode']);
  }


  public function pageContentSubmit() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (!isset($this->groupAllow['gather']['gsite']) && !$this->isSuper) {
      return $this->fetchJson('You do not have permission', 'x270303');
    }

    $_arr_inputPageContent = $this->mdl_gsiteStep->inputPageContent();

    if ($_arr_inputPageContent['rcode'] != 'y270201') {
      return $this->fetchJson($_arr_inputPageContent['msg'], $_arr_inputPageContent['rcode']);
    }

    $_arr_pageContentResult = $this->mdl_gsiteStep->setPageContent();

    return $this->fetchJson($_arr_pageContentResult['msg'], $_arr_pageContentResult['rcode']);
  }
}
