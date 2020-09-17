<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\index;

use app\model\Call as Call_Base;
use ginkgo\Cache;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------栏目模型-------------*/
class Call extends Call_Base {

    protected $obj_cache;

    function m_init() { //构造函数
        parent::m_init();

        $this->obj_cache  = Cache::instance();
    }

    function cache($num_callId = 0) {
        if ($num_callId > 0) {
            $_str_cacheName = 'call_' . $num_callId;

            if (!$this->obj_cache->check($_str_cacheName, true)) {
                $this->cacheProcess($num_callId);
            }
        } else {
            $_str_cacheName = 'call_lists';

            if (!$this->obj_cache->check($_str_cacheName, true)) {
                $this->cacheListsProcess();
            }
        }

        $_arr_return = $this->obj_cache->read($_str_cacheName);

        if ($num_callId > 0) {
            if (!isset($_arr_return['rcode'])) {
                $_arr_return['rcode'] = 'x170102';
            }

            if (!isset($_arr_return['msg'])) {
                $_arr_return['msg'] = 'Call not found';
            }
        }

        return $_arr_return;
    }


    function cacheProcess($num_callId) {
        $_return = 0;
        $_arr_callRow = $this->read($num_callId);

        //print_r($_arr_callRow);

        if ($_arr_callRow['rcode'] == 'y170102') {
            $_return = $this->obj_cache->write('call_' . $num_callId, $_arr_callRow);
        }

        return $_return;
    }


    function cacheListsProcess() {
        $_arr_search = array(
            'status' => 'enable',
        );

        $_arr_callRows = $this->lists(array(1000, 'limit'), $_arr_search);

        return $this->obj_cache->write('call_lists', $_arr_callRows);
    }
}
