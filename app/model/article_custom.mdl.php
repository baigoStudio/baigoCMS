<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;
use ginkgo\Loader;
use ginkgo\Cache;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------文章模型-------------*/
class Article_Custom extends Model {

  protected $customRows;
  protected $mdl_custom;

  protected function m_init() { //构造函数
    parent::m_init();

    $_obj_cache  = Cache::instance();
    $this->mdl_custom = Loader::model('Custom', '', 'index');

    $_str_cacheName = 'custom_lists';

    if (!$_obj_cache->check($_str_cacheName, true)) {
      $this->mdl_custom->cacheProcess();
    }

    $this->customRows = $_obj_cache->read($_str_cacheName);

    if (!is_array($this->customRows)) {
      $this->customRows = array();
    }
  }


  public function check($num_articleId) {
    $_arr_select = array(
      'article_id',
    );

    return $this->read($num_articleId, $_arr_select);
  }


  /** 读出自定义字段
   * readCustom function.
   *
   * @access public
   * @param mixed $num_articleId
   * @return void
   */
  public function read($num_articleId, $arr_select = array()) {
    if (Func::isEmpty($arr_select)) {
      foreach ($this->customRows as $_key=>$_value) {
        $arr_select[] = 'custom_' . $_value['custom_id'];
      }
    }

    $_arr_articleCustomRow = $this->where('article_id', '=', $num_articleId)->find($arr_select);

    if ($_arr_articleCustomRow === false) {
      $_arr_articleCustomRow          = $this->obj_request->fillParam(array(), $arr_select);
      $_arr_articleCustomRow['rcode'] = 'x210102';
    } else {
      $_arr_articleCustomRow['rcode'] = 'y210102';
    }

    return $_arr_articleCustomRow;
  }
}
