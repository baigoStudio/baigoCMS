<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\index;

use app\model\Link as Link_Base;
use ginkgo\Cache;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------栏目模型-------------*/
class Link extends Link_Base {
    protected $obj_cache;

    function m_init() { //构造函数
        parent::m_init();

        $this->obj_cache  = Cache::instance();
    }

    function cache($str_type = '', $arr_cateIds = array()) {
        $_arr_return = array();

        if (!Func::isEmpty($str_type)) {
            $_str_cacheName = 'link_' . $str_type;
            if (!$this->obj_cache->check($_str_cacheName, true)) {
                $this->cacheProcess($str_type);
            }

            $_arr_return = $this->obj_cache->read($_str_cacheName);

            if (!Func::isEmpty($_arr_return) && !Func::isEmpty($arr_cateIds)) {
                foreach ($_arr_return as $_key=>$_value) {
                    if (!in_array($_value['link_cate_id'], $arr_cateIds)) {
                        unset($_arr_return[$_key]);
                    }
                }
            }
        }

        return $_arr_return;
    }

    function cacheProcess($str_type) {
        $_arr_search = array(
            'type'      => $str_type,
            'status'    => 'enable',
        );
        $_arr_linkRows = $this->lists(array(1000, 'limit'), $_arr_search);

        return $this->obj_cache->write('link_' . $str_type, $_arr_linkRows);
    }
}
