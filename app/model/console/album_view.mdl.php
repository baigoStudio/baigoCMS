<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\classes\Model;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------TAG 模型-------------*/
class Album_View extends Model {

  /**
   * mdl_list function.
   *
   * @access public
   * @param string $str_status (default: '')
   * @param string $str_type (default: '')
   * @param int $num_parentId (default: 0)
   * @return void
   */
  public function lists($pagination = 0, $arr_search = array()) {
    $_arr_albumSelect = array(
      'album_id',
      'album_name',
      'album_status',
    );

    $_arr_where         = $this->queryProcess($arr_search);
    $_arr_pagination    = $this->paginationProcess($pagination);
    $_arr_albumRows     = $this->where($_arr_where)->order('album_id', 'DESC')->group('album_id')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_albumSelect);

    return $_arr_albumRows;
  }


  protected function queryProcess($arr_search = array()) {
    $_arr_where = array();

    if (isset($arr_search['attach_id']) && $arr_search['attach_id'] > 0) {
      $_arr_where[] = array('belong_attach_id', '=', $arr_search['attach_id']);
    }

    return $_arr_where;
  }
}
