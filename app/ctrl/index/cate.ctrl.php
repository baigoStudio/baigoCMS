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

class Cate extends Ctrl {

    function index() {
        $_mix_init = $this->indexInit();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_searchParam = array(
            'id'    => array('int', 0),
            'key'   => array('str', ''),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        if ($_arr_search['id'] < 1) {
            return $this->error('Missing ID', 'x250202', 400);
        }

        $_arr_cateRow = $this->obj_index->cateRead($_arr_search['id']);

        if ($_arr_cateRow['rcode'] != 'y250102') {
            return $this->error($_arr_cateRow['msg'], $_arr_cateRow['rcode']);
        }

        if (isset($_arr_cateRow['cate_link']) && !Func::isEmpty($_arr_cateRow['cate_link'])) {
            return $this->error($_arr_cateRow['msg'], $_arr_cateRow['rcode']);
        }

        $_arr_searchDo = array(
            'key'      => $_arr_search['key'],
            'cate_ids' => $_arr_cateRow['cate_ids'],
        );

        $_mdl_articleView        = Loader::model('Article_Cate_View');
        $_arr_getData            = $_mdl_articleView->lists($_arr_cateRow['cate_perpage'], $_arr_searchDo); //列出

        $_arr_cateRow['cate_content'] = $this->obj_index->linkProcess($_arr_cateRow['cate_content'], $_arr_cateRow['cate_ids']);
        $_arr_cateRow['cate_content'] = $this->obj_index->albumProcess($_arr_cateRow['cate_content']);

        $_arr_tplData = array(
            'urlRow'        => $this->urlProcess($_arr_cateRow['cate_url'], $_arr_search),
            'pageRow'       => $_arr_getData['pageRow'],
            'articleRows'   => $this->obj_index->articleListsProcess($_arr_getData['dataRows']),
            'cateRow'       => $_arr_cateRow,
        );

        $_arr_tpl    = array_replace_recursive($this->generalData, $_arr_tplData);

        $_arr_tpl = Plugin::listen('filter_pub_cate_show', $_arr_tpl); //编辑文章时触发

        $this->assign($_arr_tpl);

        $this->obj_view->setPath(BG_TPL_INDEX . $_arr_cateRow['cate_tpl_do']);

        return $this->fetch();
    }


    private function urlProcess($arr_cateUrl, $arr_search) {
        if (isset($arr_search['key']) && !Func::isEmpty($arr_search['key'])) {
            $arr_cateUrl['url'] .= 'key/' . $arr_search['key'] . '/';
        }

        return $arr_cateUrl;
    }
}
