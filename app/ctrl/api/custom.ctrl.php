<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\api;

use app\classes\api\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------文章类-------------*/
class Custom extends Ctrl {

    protected function c_init($param = array()) { //构造函数
        parent::c_init();

        $this->mdl_custom   = Loader::model('Custom');
    }


    function tree() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_customTree = $this->mdl_custom->cache();

        $_arr_return = array(
            'custom_tree'   => $_arr_customTree,
        );

        return $this->json($_arr_return);
    }


    function lists() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_customRows = $this->mdl_custom->cache(false);

        $_arr_return = array(
            'customRows'   => $_arr_customRows,
        );

        return $this->json($_arr_return);
    }
}
