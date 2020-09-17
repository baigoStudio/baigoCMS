<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\api;

use app\classes\api\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Plugin;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');


/*-------------文章类-------------*/
class Cate extends Ctrl {

    protected function c_init($param = array()) { //构造函数
        parent::c_init();

        $this->mdl_cate     = Loader::model('Cate');
    }


    function read() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_cateId = $this->obj_request->get('cate_id', 'int', 0);

        if ($_num_cateId < 1) {
            return $this->fetchJson('Missing ID', 'x250202', 400);
        }

        $_arr_cateRow = $this->obj_index->cateRead($_num_cateId);

        if ($_arr_cateRow['rcode'] != 'y250102') {
            return $this->fetchJson($_arr_cateRow['msg'], $_arr_cateRow['rcode'], 404);
        }

        $_arr_cateRow['cate_content'] = $this->obj_index->linkProcess($_arr_cateRow['cate_content'], $_arr_cateRow['cate_ids']);

        $_arr_return = array(
            'cateRow'   => $_arr_cateRow,
        );

        $_mix_result  = Plugin::listen('filter_api_cate_read', $_arr_return); //编辑文章时触发
        $_arr_return  = Plugin::resultProcess($_arr_return, $_mix_result);

        return $this->json($_arr_return);
    }


    function tree() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_searchParam = array(
            'parent_id' => array('int', 0),
        );

        $_arr_search = $this->obj_request->get($_arr_searchParam);
        $_arr_search['status'] = 'show';

        $_arr_cateTree    = $this->mdl_cate->listsTree($_arr_search);

        $_arr_return = array(
            'cate_tree'   => $_arr_cateTree,
        );

        $_mix_result   = Plugin::listen('filter_api_cate_tree', $_arr_return); //编辑文章时触发
        $_arr_return   = Plugin::resultProcess($_arr_return, $_mix_result);

        return $this->json($_arr_return);
    }
}
