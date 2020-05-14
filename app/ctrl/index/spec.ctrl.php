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

class Spec extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_spec             = Loader::model('Spec');
        $this->mdl_articleSpecView  = Loader::model('Article_Spec_View');

        $this->obj_view->setPath(BG_TPL_INDEX . $this->configBase['site_tpl']);
    }


    function index() {
        $_mix_init = $this->indexInit();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_searchParam = array(
            'key' => array('str', ''),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        $_arr_search['status'] = 'show';

        $_num_specCount = $this->mdl_spec->count($_arr_search); //统计记录数
        $_arr_pageRow   = $this->obj_request->pagination($_num_specCount, $this->configVisit['perpage_spec']); //取得分页数据
        $_arr_specRows  = $this->mdl_spec->lists($this->configVisit['perpage_spec'], $_arr_pageRow['except'], $_arr_search); //列出

        $_arr_tplData = array(
            'urlRow'    => $this->mdl_spec->urlLists(),
            'pageRow'   => $_arr_pageRow,
            'search'    => $_arr_search,
            'specRows'  => $this->obj_index->specListsProcess($_arr_specRows),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $_mix_result = Plugin::listen('filter_pub_spec_lists', $_arr_tpl);
        $_arr_tpl    = Plugin::resultProcess($_arr_tpl, $_mix_result);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function show() {
        $_mix_init = $this->indexInit();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_specId = 0;

        if (isset($this->param['id'])) {
            $_num_specId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_specId < 1) {
            return $this->error('Missing ID', 'x180202', 400);
        }

        $_arr_specRow = $this->obj_index->specRead($_num_specId);

        if ($_arr_specRow['rcode'] != 'y180102') {
            return $this->error($_arr_specRow['msg'], $_arr_specRow['rcode'], 404);
        }

        $_arr_search['spec_ids']  = array($_num_specId);

        $_num_articleCount  = $this->mdl_articleSpecView->count($_arr_search); //统计记录数
        $_arr_pageRow       = $this->obj_request->pagination($_num_articleCount); //取得分页数据
        $_arr_articleRows   = $this->mdl_articleSpecView->lists($this->configVisit['perpage_in_spec'], $_arr_pageRow['except'], $_arr_search); //列出

        $_arr_specRow['spec_content'] = $this->obj_index->albumProcess($_arr_specRow['spec_content']);

        $_arr_tplData = array(
            'urlRow'        => $_arr_specRow['spec_url'],
            'pageRow'       => $_arr_pageRow,
            'search'        => $_arr_search,
            'articleRows'   => $this->obj_index->articleListsProcess($_arr_articleRows),
            'specRow'       => $_arr_specRow,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $_mix_result = Plugin::listen('filter_pub_spec_show', $_arr_tpl);
        $_arr_tpl    = Plugin::resultProcess($_arr_tpl, $_mix_result);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }
}
