<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\index;

use app\model\Custom as Custom_Base;
use ginkgo\Cache;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------自定义字段模型-------------*/
class Custom extends Custom_Base {

  protected function m_init() { //构造函数
    parent::m_init();

    $this->obj_cache    = Cache::instance();
  }

  public function cache($is_tree = true) {
    $_arr_return = array();

    if ($is_tree) {
      $_str_cacheName = 'custom_tree';

      if (!$this->obj_cache->check($_str_cacheName, true)) {
        $this->cacheTreeProcess();
      }
    } else {
      $_str_cacheName = 'custom_lists';

      if (!$this->obj_cache->check($_str_cacheName, true)) {
        $this->cacheProcess();
      }
    }

    $_arr_return = $this->obj_cache->read($_str_cacheName);

    return $_arr_return;
  }


  public function cacheProcess() {
    $_arr_search = array(
      'status'    => 'enable',
    );

    $_arr_customRows = $this->lists(array(1000, 'limit'), $_arr_search);

    return $this->obj_cache->write('custom_lists', $_arr_customRows);
  }


  public function cacheTreeProcess() {
    $_arr_search = array(
      'parent_id' => 0,
      'status'    => 'enable',
    );

    $_arr_customRows = $this->listsTree($_arr_search);

    //print_r($_arr_customRows);

    return $this->obj_cache->write('custom_tree', $_arr_customRows);
  }
}
