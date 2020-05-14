<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes\index;

use app\classes\Ctrl as Ctrl_Base;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Config;
use ginkgo\Plugin;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');


/*-------------控制中心通用控制器-------------*/
abstract class Ctrl extends Ctrl_Base {

    protected function c_init($param = array()) { //构造函数
        parent::c_init();

        $this->obj_index = Loader::classes('Index', '', false);

        if ($this->configVisit['visit_type'] != 'default') {
            Config::set('route_type', 'noBaseFile', 'route');
        }

        Plugin::listen('action_pub_init');

        $this->obj_call = Loader::classes('Call');
        $this->setObj('call', $this->obj_call);
    }
}
