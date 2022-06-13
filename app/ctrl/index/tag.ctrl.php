<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\index;

use app\classes\index\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Plugin;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Tag extends Ctrl {

  protected function c_init($param = array()) {
    parent::c_init();

    $this->mdl_tag              = Loader::model('Tag');
    $this->mdl_tagView          = Loader::model('Tag_View');
    $this->mdl_articleTagView   = Loader::model('Article_Tag_View');
  }


  public function index() {
    $_mix_init = $this->indexInit();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_searchParam = array(
      'id'  => array('int', 0),
      'tag' => array('str', ''),
    );

    $_arr_search = $this->obj_request->param($_arr_searchParam);

    if ($_arr_search['id'] < 1 && Func::isEmpty($_arr_search['tag'])) {
      return $this->error('Missing ID or Tag', 'x130202', 400);
    }

    if ($_arr_search['id'] > 0) {
      $_arr_tagRow = $this->mdl_tag->read($_arr_search['id']);
    } else if (Func::notEmpty($_arr_search['tag'])) {
      $_arr_tagRow = $this->mdl_tag->read($_arr_search['tag'], 'tag_name');
    }

    if ($_arr_tagRow['rcode'] != 'y130102') {
      return $this->error($_arr_tagRow['msg'], $_arr_tagRow['rcode'], 404);
    }

    if ($_arr_tagRow['tag_status'] != 'show') {
      return $this->error('Tag is invalid', 'x130102');
    }

    $_arr_search['tag_ids'] = array($_arr_tagRow['tag_id']);

    $_arr_getData   = $this->mdl_articleTagView->lists($this->configVisit['perpage_in_tag'], $_arr_search); //列出

    $this->mdl_tag->updateCount($_arr_tagRow['tag_id'], $_arr_getData['pageRow']['count']); // 更新文章数

    $_arr_tplData = array(
      'urlRow'        => $this->mdl_tag->urlProcess($_arr_tagRow),
      //'search'        => $_arr_search,
      'pageRow'       => $_arr_getData['pageRow'],
      'articleRows'   => $this->obj_index->articleListsProcess($_arr_getData['dataRows']),
      'tagRow'        => $_arr_tagRow,
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $_arr_tpl = Plugin::listen('filter_pub_tag_show', $_arr_tpl);

    $this->assign($_arr_tpl);

    $_str_tpl = '';

    if (Func::notEmpty($_arr_tagRow['tag_tpl']) && $_arr_tagRow['tag_tpl'] !== '-1') {
      $_str_tpl = BG_TPL_TAG . $_arr_tagRow['tag_tpl'] . GK_EXT_TPL;
    }

    //print_r($_arr_tagRow);

    return $this->fetch($_str_tpl);
  }
}
