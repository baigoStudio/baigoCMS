<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------TAG 模型-------------*/
class Tag extends Model {

  public $arr_status = array('show', 'hide');

  public function check($mix_tag, $str_by = 'tag_id', $num_notId = 0) {
    $_arr_select = array(
      'tag_id',
    );

    $_arr_tagRow = $this->read($mix_tag, $str_by, $num_notId, $_arr_select);

    return $_arr_tagRow;
  }


  /**
   * read function.
   *
   * @access public
   * @param mixed $mix_tag
   * @param string $str_by (default: 'tag_id')
   * @param int $num_parentId (default: 0)
   * @return void
   */
  public function read($mix_tag, $str_by = 'tag_id', $num_notId = 0, $arr_select = array()) {
    if (Func::isEmpty($arr_select)) {
      $arr_select = array(
        'tag_id',
        'tag_name',
        'tag_status',
        'tag_tpl',
        'tag_article_count',
      );
    }

    $_arr_where = $this->readQueryProcess($mix_tag, $str_by, $num_notId);

    $_arr_tagRow = $this->where($_arr_where)->find($arr_select);

    if ($_arr_tagRow === false) {
      $_arr_tagRow          = $this->obj_request->fillParam(array(), $arr_select);
      $_arr_tagRow['msg']   = 'Tag not found';
      $_arr_tagRow['rcode'] = 'x130102';
    } else {
      $_arr_tagRow['rcode'] = 'y130102';
      $_arr_tagRow['msg']   = '';
    }

    return $_arr_tagRow;
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
      $_arr_order = array('tag_article_count', 'DESC');
    } else {
      $_arr_order = array('tag_id', 'DESC');
    }

    $_arr_where         = $this->queryProcess($arr_search);
    $_arr_pagination    = $this->paginationProcess($pagination);
    $_arr_getData       = $this->where($_arr_where)->order($_arr_order)->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_tagSelect);

    return $_arr_getData;
  }


  public function counts($arr_search = array()) {
    $_arr_where = $this->queryProcess($arr_search);

    $_num_tagCount = $this->where($_arr_where)->count();

    /*print_r($_arr_userRow);
    exit;*/

    return $_num_tagCount;
  }


  protected function queryProcess($arr_search = array()) {
    $_arr_where = array();

    if (isset($arr_search['key']) && Func::notEmpty($arr_search['key'])) {
      $_arr_where[] = array('tag_name', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
    }

    if (isset($arr_search['status']) && Func::notEmpty($arr_search['status'])) {
      $_arr_where[] = array('tag_status', '=', $arr_search['status']);
    }

    return $_arr_where;
  }


  protected function readQueryProcess($mix_tag, $str_by = 'tag_id', $num_notId = 0) {
    $_arr_where[] = array($str_by, '=', $mix_tag);

    if ($num_notId > 0) {
      $_arr_where[] = array('tag_id', '<>', $num_notId);
    }

    return $_arr_where;
  }
}
