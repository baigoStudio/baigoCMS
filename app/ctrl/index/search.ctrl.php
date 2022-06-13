<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\index;

use app\classes\index\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Search extends Ctrl {

  public function index() {
    $_mix_init = $this->indexInit();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_searchParam = array(
      'key'       => array('str', ''),
      'year'      => array('str', ''),
      'month'     => array('str', ''),
      'cate'      => array('int', 0),
    );

    foreach ($this->generalData['customRows'] as $_key=>$_value) {
      $_arr_searchParam['custom_' . $_value['custom_id']] = array('str', '');
    }

    $_arr_search = $this->obj_request->param($_arr_searchParam);

    foreach ($this->generalData['customRows'] as $_key=>$_value) {
      if (Func::notEmpty($_arr_search['custom_' . $_value['custom_id']]) && !isset($_arr_search['has_custom'])) {
        $_arr_search['has_custom'] = true;
        break;
      }
    }

    $_arr_getData   = array(
      'dataRows' => array(),
      'pageRow'  => array(),
    );

    if (Func::notEmpty($_arr_search['key']) || isset($_arr_search['has_custom'])) {
      $_arr_search['cate_ids'] = false;

      if ($_arr_search['cate'] > 0) {
          $_arr_cateRow = $this->obj_index->cateRead($_arr_search['cate']);

          if (isset($_arr_cateRow['cate_ids'])) {
              $_arr_search['cate_ids']  = $_arr_cateRow['cate_ids'];
          }
      }

      $_mdl_articleCustomView = Loader::model('Article_Custom_View');
      $_arr_getData           = $_mdl_articleCustomView->lists($this->configVisit['perpage_in_search'], $_arr_search); //列出
    }

    if (Func::notEmpty($_arr_getData['dataRows'])) {
      foreach ($_arr_getData['dataRows'] as $_key=>&$_value) {
        $_value['article_title'] = str_ireplace($_arr_search['key'], '<span class="highlight">' . $_arr_search['key'] . '</span>', $_value['article_title']);
      }
    }

    $_arr_tplData = array(
      'urlRow'        => $this->urlProcess($_arr_search),
      'search'        => $_arr_search,
      'pageRow'       => $_arr_getData['pageRow'],
      'articleRows'   => $this->obj_index->articleListsProcess($_arr_getData['dataRows']),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function typeahead() {
    $_mix_init = $this->indexInit();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_searchParam = array(
      'key'       => array('str', ''),
    );

    $_arr_search = $this->obj_request->param($_arr_searchParam);

    $_arr_getData   = array();

    if (Func::notEmpty($_arr_search['key'])) {
      $_mdl_articleCateView    = Loader::model('Article_Cate_View');
      $_arr_getData            = $_mdl_articleCateView->lists(array($this->configVisit['perpage_in_ajax'], 'limit'), $_arr_search); //列出
    }

    $_arr_getData = $this->obj_index->articleListsProcess($_arr_getData);

    return $this->json($_arr_getData);
  }


  private function urlProcess($arr_search) {
    $_str_urlPrefix     = $this->obj_request->baseUrl() . $this->configRoute['search'] . '/';

    $_arr_urlRow = array(
      'url'           => $_str_urlPrefix,
      'url_more'      => '',
      'param'         => 'page/',
      'param_more'    => 'page/',
      'suffix'        => '',
    );

    if (isset($arr_search['key']) && Func::notEmpty($arr_search['key'])) {
      $_arr_urlRow['url'] .= 'key/' . $arr_search['key'] . '/';
    }

    if (isset($arr_search['year']) && Func::notEmpty($arr_search['year'])) {
      $_arr_urlRow['url'] .= 'year/' . $arr_search['year'] . '/';
    }

    if (isset($arr_search['month']) && Func::notEmpty($arr_search['month'])) {
      $_arr_urlRow['url'] .= 'month/' . $arr_search['month'] . '/';
    }

    if (isset($arr_search['cate']) && $arr_search['cate'] > 0) {
      $_arr_urlRow['url'] .= 'cate/' . $arr_search['cate'] . '/';
    }

    return $_arr_urlRow;
  }
}
