<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\index;

use app\model\Thumb as Thumb_Base;
use ginkgo\Func;
use ginkgo\Cache;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------缩略图模型-------------*/
class Thumb extends Thumb_Base {

    protected $obj_cache;

    function m_init() { //构造函数
        $this->obj_cache    = Cache::instance();
    }

    function cache() {
        $_arr_return = array();

        $_str_cacheName = 'thumb_lists';

        if (!$this->obj_cache->check($_str_cacheName, true)) {
            $this->cacheProcess();
        }

        $_arr_return = $this->obj_cache->read($_str_cacheName);

        return $_arr_return;
    }


    function cacheProcess() {
        $_arr_thumbRows = $this->lists(1000);

        $_arr_thumbs = array();

        foreach ($_arr_thumbRows as $_key=>$_value) {
            $_arr_thumbs[$_value['thumb_id']] = $_value;
        }

        return $this->obj_cache->write('thumb_lists', $_arr_thumbs);
    }

}
