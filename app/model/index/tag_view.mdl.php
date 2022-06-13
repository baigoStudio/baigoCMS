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

/*-------------栏目模型-------------*/
class Tag_View extends Tag {

  public function counts($arr_search = array()) {
    $_arr_where = $this->queryProcess($arr_search);

    return $this->where($_arr_where)->count();
  }


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
    $_arr_tagSelect = array(
      'tag_id',
      'tag_name',
      'tag_article_count',
      'tag_status',
    );

    if (isset($arr_search['type']) && $arr_search['type'] == 'tag_rank') {
      $_arr_order = array(
        array('tag_article_count', 'DESC'),
        array('tag_id', 'DESC'),
      );
    } else {
      $_arr_order = array('tag_id', 'DESC');
    }

    $_arr_where         = $this->queryProcess($arr_search);
    $_arr_pagination    = $this->paginationProcess($pagination);
    $_arr_getData       = $this->where($_arr_where)->order($_arr_order)->group('tag_id')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_tagSelect);

    return $_arr_getData;
  }


  protected function queryProcess($arr_search = array()) {
    $_arr_where = array();

    if (isset($arr_search['tag_id']) && $arr_search['tag_id'] > 0) {
      $_arr_where[] = array('tag_id', '=', $arr_search['tag_id']);
    }

    if (isset($arr_search['status']) && Func::notEmpty($arr_search['status'])) {
      $_arr_where[] = array('tag_status', '=', $arr_search['status']);
    }

    if (isset($arr_search['article_id']) && $arr_search['article_id'] > 0) {
      $_arr_where[] = array('belong_article_id', '=', $arr_search['article_id']);
    }

    return $_arr_where;
  }
}
