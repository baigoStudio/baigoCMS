<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\index;

use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------附件模型-------------*/
class Attach_Album_View extends Attach {

  public function lists($pagination = 0, $arr_search = array(), $arr_order = array(), $arr_select = array()) {
    $_arr_attachSelect = array(
      'attach_id',
      'attach_name',
      'attach_time',
      'attach_ext',
      //'attach_box',
    );

    $_arr_where         = $this->queryProcess($arr_search);
    $_arr_pagination    = $this->paginationProcess($pagination);
    $_arr_getData       = $this->where($_arr_where)->order('attach_id', 'DESC')->group('attach_id')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_attachSelect);

    if (isset($_arr_getData['dataRows'])) {
      $_arr_eachData = &$_arr_getData['dataRows'];
    } else {
      $_arr_eachData = &$_arr_getData;
    }

    if (Func::notEmpty($_arr_eachData)) {
      foreach ($_arr_eachData as $_key=>&$_value) {
        $_value = $this->rowProcess($_value);
        $_value = $this->thumbProcess($_value);
      }
    }

    return $_arr_getData;
  }


  public function counts($arr_search = array()) {
    $_arr_where = $this->queryProcess($arr_search);

    $_num_attachCount     = $this->where($_arr_where)->group('attach_id')->count();

    return $_num_attachCount;
  }


  /** 列出及统计 SQL 处理
   * sqlProcess function.
   *
   * @access private
   * @param array $arr_search (default: array())
   * @return void
   */
  protected function queryProcess($arr_search = array()) {
    $_arr_where[] = array('attach_box', '=', 'normal');

    if (isset($arr_search['key']) && Func::notEmpty($arr_search['key'])) {
      $_arr_where[] = array('attach_name|attach_note|attach_id', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
    }

    if (isset($arr_search['year']) && Func::notEmpty($arr_search['year'])) {
      $_arr_where[] = array('FROM_UNIXTIME(`attach_time`, \'%Y\')', '=', $arr_search['year'], 'year');
    }

    if (isset($arr_search['month']) && Func::notEmpty($arr_search['month'])) {
      $_arr_where[] = array('FROM_UNIXTIME(`attach_time`, \'%m\')', '=', $arr_search['month'], 'month');
    }

    if (isset($arr_search['ext']) && Func::notEmpty($arr_search['ext'])) {
      $_arr_where[] = array('attach_ext', '=', $arr_search['ext']);
    }

    if (isset($arr_search['album_id']) && $arr_search['album_id'] > 0) {
      $_arr_where[] = array('belong_album_id', '=', $arr_search['album_id']);
    }

    return $_arr_where;
  }
}
