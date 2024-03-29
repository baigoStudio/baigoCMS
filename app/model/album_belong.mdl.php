<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/
namespace app\model;

use app\classes\Model;
use ginkgo\Func;
use ginkgo\Arrays;


//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------应用归属-------------*/
class Album_Belong extends Model {

  public function ids($arr_search) {
    $_arr_belongSelect = array(
      'belong_album_id',
    );

    $_arr_where = $this->queryProcess($arr_search);

    $_arr_belongRows = $this->where($_arr_where)->select($_arr_belongSelect);

    $_arr_albumIds = array();

    foreach ($_arr_belongRows as $_key=>$_value) {
      $_arr_albumIds[]   = $_value['belong_album_id'];
    }

    return array_values(Arrays::unique($_arr_albumIds));
  }


  /** 读取
   * read function.
   *
   * @access public
   * @param int $num_attachId (default: 0)
   * @param int $num_albumId (default: 0)
   * @return void
   */
  public function read($num_albumId = 0, $num_attachId = 0) {
    $_arr_belongSelect = array(
      'belong_id',
      'belong_album_id',
      'belong_attach_id',
    );

    $_arr_where = $this->readQueryProcess($num_albumId, $num_attachId);

    $_arr_belongRow = $this->where($_arr_where)->find($_arr_belongSelect);

    if ($_arr_belongRow === false) {
      $_arr_belongRow          = $this->obj_request->fillParam(array(), $_arr_belongSelect);
      $_arr_belongRow['msg']   = 'Data not found';
      $_arr_belongRow['rcode'] = 'x290102';
    } else {
      $_arr_belongRow['msg']   = '';
      $_arr_belongRow['rcode'] = 'y290102';
    }

    return $_arr_belongRow;
  }


  /** 计数
   * mdl_count function.
   *
   * @access public
   * @param array $arr_search (default: array())
   * @return void
   */
  public function counts($arr_search = array()) {

    $_arr_where = $this->queryProcess($arr_search);

    $_num_belongCount = $this->where($_arr_where)->count();

    return $_num_belongCount;
  }


  /** 列出及统计 SQL 处理
   * sqlProcess function.
   *
   * @access private
   * @param array $arr_search (default: array())
   * @return void
   */
  protected function queryProcess($arr_search = array()) {
    $_arr_where = array();

    if (isset($arr_search['album_id']) && $arr_search['album_id'] > 0) {
      $_arr_where[] = array('belong_album_id', '=', $arr_search['album_id']);
    }

    if (isset($arr_search['attach_id']) && $arr_search['attach_id'] > 0) {
      $_arr_where[] = array('belong_attach_id', '=', $arr_search['attach_id']);
    }

    if (isset($arr_search['attach_ids']) && Func::notEmpty($arr_search['attach_ids'])) {
      $arr_search['attach_ids'] = Arrays::unique($arr_search['attach_ids']);

      if (Func::notEmpty($arr_search['attach_ids'])) {
        $_arr_where[] = array('belong_attach_id', 'IN', $arr_search['attach_ids'], 'attach_ids');
      }
    }

    if (isset($arr_search['min_id']) && $arr_search['min_id'] > 0) {
      $_arr_where[] = array('belong_id', '>', $arr_search['min_id'], 'min_id');
    }

    if (isset($arr_search['max_id']) && $arr_search['max_id'] > 0) {
      $_arr_where[] = array('belong_id', '<', $arr_search['max_id'], 'max_id');
    }

    return $_arr_where;
  }


  protected function readQueryProcess($num_albumId = 0, $num_attachId = 0) {
    $_arr_where[] = array('belong_album_id', '=', $num_albumId);

    if ($num_attachId > 0) {
      $_arr_where[] = array('belong_attach_id', '=', $num_attachId);
    }

    return $_arr_where;
  }
}
