<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/
namespace app\model\console;

use app\model\Article_Custom as Article_Custom_Base;
use ginkgo\Loader;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------应用归属-------------*/
class Article_Custom extends Article_Custom_Base {

  public $inputClear = array();

  protected function m_init() { //构造函数
    parent::m_init();

    $_mdl_custom = Loader::model('Custom', '', false);

    $_arr_search = array(
      'status' => 'enable',
    );

    $_arr_customRows = $_mdl_custom->lists(array(1000, 'limit'), $_arr_search);

    $this->customRows = $_arr_customRows;
  }


  public function chkAttach($arr_attachRow) {
    $_arr_where = array();

    foreach ($this->customRows as $_key=>$_value) {
      $_arr_where[] = array('custom_' . $_value['custom_id'], '=', $arr_attachRow['attach_id'], 'custom_' . $_value['custom_id'], 'str', 'OR');
    }

    return $this->where($_arr_where)->find('article_id');
  }


  public function submit($arr_inputSubmit) {
    $_str_rcode = 'x210101';

    if (isset($arr_inputSubmit['article_id']) && $arr_inputSubmit['article_id'] > 0) {
      $_arr_articleCustomRow = $this->check($arr_inputSubmit['article_id']);

      if ($_arr_articleCustomRow['rcode'] == 'x210102') {
        $_num_articleId     = $this->insert($arr_inputSubmit);

        if ($_num_articleId > 0) {
          $_str_rcode      = 'y210101';
        } else {
          $_str_rcode      = 'x210101';
        }
      } else {
        $_num_count     = $this->where('article_id', '=', $arr_inputSubmit['article_id'])->update($arr_inputSubmit);

        if ($_num_count > 0) {
          $_str_rcode      = 'y210103';
        } else {
          $_str_rcode      = 'x210103';
        }
      }
    }

    return array(
      'rcode' => $_str_rcode,
    );
  }


  public function clear() {
    $_arr_where = array();

    if (isset($this->inputClear['max_id']) && $this->inputClear['max_id'] > 0) {
      $_arr_where[] = array('article_id', '<', $this->inputClear['max_id'], 'max_id');
    }

    $_arr_pagination    = $this->paginationProcess(array(10, 'post'));
    $_arr_getData       = $this->where($_arr_where)->order('article_id', 'DESC')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select('article_id');

    if (isset($_arr_getData['dataRows'])) {
      $_arr_clearData = $_arr_getData['dataRows'];
    } else {
      $_arr_clearData = $_arr_getData;
    }

    if (Func::notEmpty($_arr_clearData)) {
      $_mdl_article = Loader::model('Article');

      foreach ($_arr_clearData as $_key=>$_value) {
        $_arr_articleRow = $_mdl_article->check($_value['article_id']);

        if ($_arr_articleRow['rcode'] != 'y120102') {
          $this->where('article_id', '=', $_value['article_id'])->delete();
        }
      }
    }

    return $_arr_getData;
  }


  public function inputClear() {
    $_arr_inputParam = array(
      'max_id'    => array('int', 0),
      '__token__' => array('str', ''),
    );

    $_arr_inputClear = $this->obj_request->post($_arr_inputParam);

    $_mix_vld = $this->validate($_arr_inputClear);

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x210201',
        'msg'   => end($_mix_vld),
      );
    }

    $_arr_inputClear['rcode'] = 'y210201';

    $this->inputClear = $_arr_inputClear;

    return $_arr_inputClear;
  }
}
