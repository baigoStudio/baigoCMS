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
defined('IN_GINKGO') or exit('Access denied');

class Tag extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_tag              = Loader::model('Tag');
        $this->mdl_articleTagView   = Loader::model('Article_Tag_View');
    }


    function index() {
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
        } else if (!Func::isEmpty($_arr_search['tag'])) {
            $_arr_tagRow = $this->mdl_tag->read($_arr_search['tag'], 'tag_name');
        }

        if ($_arr_tagRow['rcode'] != 'y130102') {
            return $this->error($_arr_tagRow['msg'], $_arr_tagRow['rcode'], 404);
        }

        if ($_arr_tagRow['tag_status'] != 'show') {
            return $this->error('Tag is invalid', 'x130102');
        }

        $_arr_search['tag_ids'] = array($_arr_tagRow['tag_id']);

        $_num_articleCount  = $this->mdl_articleTagView->count($_arr_search); //统计记录数
        $_arr_pageRow       = $this->obj_request->pagination($_num_articleCount, $this->configVisit['perpage_in_tag']); //取得分页数据
        $_arr_articleRows   = $this->mdl_articleTagView->lists($this->configVisit['perpage_in_tag'], $_arr_pageRow['except'], $_arr_search); //列出

        $_arr_tplData = array(
            'urlRow'        => $this->mdl_tag->urlProcess($_arr_tagRow),
            'pageRow'       => $_arr_pageRow,
            //'search'        => $_arr_search,
            'articleRows'   => $this->obj_index->articleListsProcess($_arr_articleRows),
            'tagRow'        => $_arr_tagRow,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $_mix_result = Plugin::listen('filter_pub_tag_show', $_arr_tpl);
        $_arr_tpl    = Plugin::resultProcess($_arr_tpl, $_mix_result);

        $this->assign($_arr_tpl);

        $this->obj_view->setPath(BG_TPL_INDEX . $this->configBase['site_tpl']);

        return $this->fetch();
    }
}
