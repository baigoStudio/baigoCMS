<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

class Article_Custom extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_articleCustom       = Loader::model('Article_Custom');
    }


    function clear() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['article']['edit']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x120303');
        }

        $_arr_inputClear = $this->mdl_articleCustom->inputClear();

        if ($_arr_inputClear['rcode'] != 'y210201') {
            return $this->fetchJson($_arr_inputClear['msg'], $_arr_inputClear['rcode']);
        }

        $_num_maxId = $_arr_inputClear['max_id'];

        $_arr_search = array(
            'max_id' => $_arr_inputClear['max_id'],
        );

        $_arr_getData  = $this->mdl_articleCustom->clear(array(10, 'post'), $_arr_search);

        if (Func::isEmpty($_arr_getData['dataRows'])) {
            $_str_status    = 'complete';
            $_str_msg       = 'Complete';
        } else {
            $_arr_articleRow = end($_arr_getData['dataRows']);
            $_str_status    = 'loading';
            $_str_msg       = 'Submitting';
            $_num_maxId     = $_arr_articleRow['article_id'];
        }

        $_arr_return = array(
            'msg'       => $this->obj_lang->get($_str_msg),
            'count'     => $_arr_getData['pageRow']['total'],
            'max_id'    => $_num_maxId,
            'status'    => $_str_status,
        );

        return $this->json($_arr_return);
    }
}
