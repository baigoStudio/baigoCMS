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

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_articleCateView  = Loader::model('Article_Cate_View');
    }


    function index() {
        $_mix_init = $this->indexInit();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_cateId = 0;

        if (isset($this->param['id'])) {
            $_num_cateId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        //print_r($_GET);

        if ($_num_cateId < 1) {
            return $this->error('Missing ID', 'x250202', 400);
        }

        $_arr_cateRow    = $this->obj_index->cateRead($_num_cateId);

        if ($_arr_cateRow['rcode'] != 'y250102') {
            return $this->error($_arr_cateRow['msg'], $_arr_cateRow['rcode']);
        }

        if (isset($_arr_cateRow['cate_link']) && !Func::isEmpty($_arr_cateRow['cate_link'])) {
            return $this->error($_arr_cateRow['msg'], $_arr_cateRow['rcode']);
        }

        $_arr_search = array(
            'cate_ids' => $_arr_cateRow['cate_ids'],
        );

        $_num_articleCount  = $this->mdl_articleCateView->count($_arr_search); //统计记录数
        $_arr_pageRow       = $this->obj_request->pagination($_num_articleCount, $_arr_cateRow['cate_perpage']); //取得分页数据
        $_arr_articleRows   = $this->mdl_articleCateView->lists($_arr_cateRow['cate_perpage'], $_arr_pageRow['except'], $_arr_search); //列出

        $_arr_cateRow['cate_content'] = $this->obj_index->linkProcess($_arr_cateRow['cate_content'], $_arr_cateRow['cate_ids']);
        $_arr_cateRow['cate_content'] = $this->obj_index->albumProcess($_arr_cateRow['cate_content']);

        $_arr_tplData = array(
            'urlRow'        => $_arr_cateRow['cate_url'],
            'pageRow'       => $_arr_pageRow,
            //'search'        => $_arr_search,
            'articleRows'   => $this->obj_index->articleListsProcess($_arr_articleRows),
            'cateRow'       => $_arr_cateRow,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $_mix_result = Plugin::listen('filter_pub_cate_show', $_arr_tpl); //编辑文章时触发
        $_arr_tpl    = Plugin::resultProcess($_arr_tpl, $_mix_result);

        $this->assign($_arr_tpl);

        $this->obj_view->setPath(BG_TPL_INDEX . $_arr_cateRow['cate_tpl_do']);

        return $this->fetch();
    }
}
