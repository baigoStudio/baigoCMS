<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Attach as Attach_Base;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------附件模型-------------*/
class Attach_Album_View extends Attach_Base {

  public function lists($pagination = 0, $arr_search = array(), $arr_order = array(), $arr_select = array()) {
    if (Func::isEmpty($arr_select)) {
      $arr_select = array(
        'attach_id',
        'attach_name',
        'attach_note',
        'attach_time',
        'attach_ext',
        'attach_box',
      );
    }

    $_arr_getData = parent::lists($pagination, $arr_search, $arr_order, $arr_select);

    return $_arr_getData;
  }


  /** 列出及统计 SQL 处理
   * sqlProcess function.
   *
   * @access private
   * @param array $arr_search (default: array())
   * @return void
   */
  protected function queryProcess($arr_search = array()) {
    $_arr_where = parent::queryProcess($arr_search);

    if (isset($arr_search['album_id']) && $arr_search['album_id'] > 0) {
      $_arr_where[] = array('belong_album_id', '=', $arr_search['album_id']);
    }

    if (isset($arr_search['album_ids']) && Func::notEmpty($arr_search['album_ids'])) {
      $arr_search['album_ids'] = Arrays::unique($arr_search['album_ids']);

      if (Func::notEmpty($arr_search['album_ids'])) {
        $_arr_where[] = array('belong_album_id', 'IN', $arr_search['album_ids'], 'album_ids');
      }
    }

    return $_arr_where;
  }
}
