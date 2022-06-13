<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\api;

use app\classes\api\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Html;
use ginkgo\Plugin;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------文章类-------------*/
class Article extends Ctrl {

  protected function c_init($param = array()) { //构造函数
    parent::c_init();

    $this->mdl_attach = Loader::model('Attach');
  }


  public function lists() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_searchParam = array(
      'key'       => array('str', ''),
      'year'      => array('str', ''),
      'month'     => array('str', ''),
      'mark_ids'  => array('arr', array()),
      'tag_ids'   => array('arr', array()),
      'spec_ids'  => array('arr', array()),
      'cate_id'   => array('int', 0),
      'perpage'   => array('int', $this->configVisit['perpage_in_api']),
    );

    foreach ($this->generalData['customRows'] as $_key=>$_value) {
      $_arr_searchParam['custom_' . $_value['custom_id']] = array('str', '');
    }

    $_arr_search = $this->obj_request->get($_arr_searchParam);

    if ($_arr_search['cate_id'] > 0) {
      $_arr_cateRow = $this->obj_index->cateRead($_arr_search['cate_id']);

      if ($_arr_cateRow['rcode'] == 'y250102') {
        $_arr_search['cate_ids'] = $_arr_cateRow['cate_ids'];
      }
    }

    foreach ($this->generalData['customRows'] as $_key=>$_value) {
      if (Func::notEmpty($_arr_search['custom_' . $_value['custom_id']]) && !isset($_arr_search['has_custom'])) {
        $_arr_search['has_custom'] = true;
        break;
      }
    }

    if (Func::notEmpty($_arr_search['tag_ids'])) {
      $_mdl_article  = Loader::model('Article_Tag_View');
    } else if (isset($_arr_search['has_custom'])) {
      $_mdl_article  = Loader::model('Article_Custom_View');
    } else {
      $_mdl_article  = Loader::model('Article_Spec_View');
    }

    $_arr_getData     = $_mdl_article->lists($_arr_search['perpage'], $_arr_search);

    $_arr_return = array(
      'search'        => $_arr_search,
      'pageRow'       => $_arr_getData['pageRow'],
      'articleRows'   => $this->obj_index->articleListsProcess($_arr_getData['dataRows'], false),
    );

    $_arr_return    = Plugin::listen('filter_api_article_lists', $_arr_return); //编辑文章时触发

    return $this->json($_arr_return);
  }


  public function read() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_num_articleId = $this->obj_request->get('article_id', 'int', 0);

    if ($_num_articleId < 1) {
      return $this->fetchJson('Missing ID', 'x120202', 400);
    }

    $_arr_articleRow = $this->obj_index->articleRead($_num_articleId);

    if ($_arr_articleRow['rcode'] != 'y120102') {
      return $this->fetchJson($_arr_articleRow['msg'], $_arr_articleRow['rcode'], 404);
    }

    $_arr_cateRow    = $this->obj_index->cateRead($_arr_articleRow['article_cate_id']);

    if ($_arr_cateRow['rcode'] != 'y250102') {
      return $this->fetchJson($_arr_cateRow['msg'], $_arr_cateRow['rcode'], 404);
    }

    $_arr_tagRows    = $this->obj_index->tagLists($_num_articleId);

    $_arr_tagIds    = array();
    $_arr_assRows   = array();

    foreach ($_arr_tagRows as $_key=>$_value) {
      $_arr_tagIds[] = $_value['tag_id'];
    }

    $_arr_assRows = $this->obj_index->assLists($_arr_tagIds, $_arr_cateRow['cate_ids']);

    $_arr_articleRow['article_content'] = $this->obj_index->linkProcess($_arr_articleRow['article_content'], $_arr_cateRow['cate_ids']);
    $_arr_articleRow['article_content'] = $this->obj_index->albumProcess($_arr_articleRow['article_content']);

    $_arr_attachRow = $this->mdl_attach->read($_arr_articleRow['article_attach_id']);

    $_arr_return = array(
      'cateRow'       => $_arr_cateRow,
      'attachRow'     => $_arr_attachRow,
      'articleRow'    => $_arr_articleRow,
      'tagRows'       => $_arr_tagRows,
      'associateRows' => $_arr_assRows,
    );

    $_arr_return    = Plugin::listen('filter_api_article_read', $_arr_return); //编辑文章时触发

    return $this->json($_arr_return);
  }


  public function hits() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_num_articleId = $this->obj_request->get('article_id', 'int', 0);

    if ($_num_articleId < 1) {
      return $this->fetchJson('Missing ID', 'x120202', 400);
    }

    $_mdl_article    = Loader::model('Article');

    $_arr_articleRow = $_mdl_article->check($_num_articleId);

    if ($_arr_articleRow['rcode'] != 'y120102') {
      return $this->fetchJson($_arr_articleRow['msg'], $_arr_articleRow['rcode'], 404);
    }

    $_arr_hitsResult = $_mdl_article->hits($_arr_articleRow['article_id']);

    return $this->fetchJson($_arr_hitsResult['msg'], $_arr_hitsResult['rcode']);
  }


  public function submit() {
    if (!$this->isPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_mdl_article     = Loader::model('Article');

    $_arr_inputSubmit = $_mdl_article->inputSubmit($this->generalData['decrypt']);

    if ($_arr_inputSubmit['rcode'] != 'y120201') {
      return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
    }

    $_arr_return = array(
      'rcode' => '',
      'msg'   => '',
    );

    return $this->fetchJson($_arr_return['msg'], $_arr_return['rcode']);
  }
}
