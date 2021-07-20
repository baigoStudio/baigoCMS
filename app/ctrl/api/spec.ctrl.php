<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\api;

use app\classes\api\Ctrl;
use ginkgo\Loader;
use ginkgo\Plugin;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------文章类-------------*/
class Spec extends Ctrl {

    protected function c_init($param = array()) { //构造函数
        parent::c_init();

        $this->mdl_attach   = Loader::model('Attach');
        $this->mdl_spec     = Loader::model('Spec');
    }


    function read() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_specId   = $this->obj_request->get('spec_id', 'int', 0);

        if ($_num_specId < 1) {
            return $this->fetchJson('Missing ID', 'x180202', 400);
        }

        $_arr_specRow = $this->obj_index->specRead($_num_specId);

        if ($_arr_specRow['rcode'] != 'y180102') {
            return $this->fetchJson($_arr_specRow['msg'], $_arr_specRow['rcode'], 404);
        }

        $_arr_attachRow = $this->mdl_attach->read($_arr_specRow['spec_attach_id']);

        $_arr_return = array(
            'specRow'    => $_arr_specRow,
            'attachRow'  => $_arr_attachRow,
        );

        $_arr_return  = Plugin::listen('filter_api_spec_read', $_arr_return); //编辑文章时触发

        return $this->json($_arr_return);
    }


    function lists() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_searchParam = array(
            'key'       => array('str', ''),
            'perpage'   => array('int', $this->configVisit['perpage_spec']),
        );

        $_arr_search = $this->obj_request->get($_arr_searchParam);
        $_arr_search['status'] = 'show';

        $_arr_getData    = $this->mdl_spec->lists($_arr_search['perpage'], $_arr_search);

        $_arr_return = array(
            'pageRow'    => $_arr_getData['pageRow'],
            'specRows'   => $this->obj_index->specListsProcess($_arr_getData['dataRows']),
        );

        $_arr_return    = Plugin::listen('filter_api_spec_lists', $_arr_return); //编辑文章时触发

        return $this->json($_arr_return);
    }
}
