<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Arrays;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------专题归属模型-------------*/
class Spec_Belong extends Model {

  public function ids($arr_search) {
    $_arr_belongSelect = array(
      'belong_spec_id',
    );

    $_arr_where = $this->queryProcess($arr_search);

    $_arr_belongRows = $this->where($_arr_where)->select($_arr_belongSelect);

    $_arr_specIds = array();

    foreach ($_arr_belongRows as $_key=>$_value) {
        $_arr_specIds[]   = $_value['belong_spec_id'];
    }

    return array_values(Arrays::unique($_arr_specIds));
  }


  /**
   * read function.
   *
   * @access public
   * @param mixed $str_belong
   * @param int $num_parentId (default: 0)
   * @return void
   */
  public function read($num_specId = 0, $num_articleId = 0) {
    $_arr_belongSelect = array(
      'belong_id',
      'belong_article_id',
      'belong_spec_id',
    );

    $_arr_where = $this->readQueryProcess($num_specId, $num_articleId);

    $_arr_belongRow = $this->where($_arr_where)->find($_arr_belongSelect);

    if ($_arr_belongRow === false) {
      $_arr_belongRow          = $this->obj_request->fillParam(array(), $arr_select);
      $_arr_belongRow['msg']   = 'Data not found';
      $_arr_belongRow['rcode'] = 'x230102';
    } else {
      $_arr_belongRow['msg']   = '';
      $_arr_belongRow['rcode'] = 'y230102';
    }

    return $_arr_belongRow;
  }


  public function counts($arr_search = array()) {
    $_arr_where = $this->queryProcess($arr_search);

    $_num_belongCount = $this->where($_arr_where)->count();

    return $_num_belongCount;
  }



  protected function queryProcess($arr_search = array()) {
    $_arr_where = array();

    if (isset($arr_search['spec_id']) && $arr_search['spec_id'] > 0) {
      $_arr_where[] = array('belong_spec_id', '=', $arr_search['spec_id']);
    }

    if (isset($arr_search['article_id']) && $arr_search['article_id'] > 0) {
      $_arr_where[] = array('belong_article_id', '=', $arr_search['article_id']);
    }

    if (isset($arr_search['min_id']) && $arr_search['min_id'] > 0) {
      $_arr_where[] = array('belong_id', '>', $arr_search['min_id'], 'min_id');
    }

    if (isset($arr_search['max_id']) && $arr_search['max_id'] > 0) {
      $_arr_where[] = array('belong_id', '<', $arr_search['max_id'], 'max_id');
    }

    return $_arr_where;
  }


  protected function readQueryProcess($num_specId = 0, $num_articleId = 0) {
    $_arr_where[] = array('belong_spec_id', '=', $num_specId);

    if ($num_articleId > 0) {
      $_arr_where[] = array('belong_article_id', '=', $num_articleId);
    }

    return $_arr_where;
  }
}
