<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Article_Content as Article_Content_Base;
use ginkgo\Loader;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------文章模型-------------*/
class Article_Content extends Article_Content_Base {

  public $inputClear = array();

  public function chkAttach($arr_attachRow) {
    return $this->where('article_content', 'LIKE', '%' . $arr_attachRow['attach_url_name'] . '%')->find('article_id');
  }

  public function submit($arr_inputSubmit) {
    $_str_rcode = 'x150101';

    if (isset($arr_inputSubmit['article_id']) && $arr_inputSubmit['article_id'] > 0) {
      $_arr_contentData['article_id'] = $arr_inputSubmit['article_id'];

      if (isset($arr_inputSubmit['article_content'])) {
        $_arr_contentData['article_content'] = $arr_inputSubmit['article_content'];
      }

      if (isset($arr_inputSubmit['article_source'])) {
        $_arr_contentData['article_source'] = $arr_inputSubmit['article_source'];
      }

      if (isset($arr_inputSubmit['article_source_url'])) {
        $_arr_contentData['article_source_url'] = $arr_inputSubmit['article_source_url'];
      }

      if (isset($arr_inputSubmit['article_author'])) {
        $_arr_contentData['article_author'] = $arr_inputSubmit['article_author'];
      }

      $_arr_contentRow = $this->check($arr_inputSubmit['article_id']);

      if ($_arr_contentRow['rcode'] == 'x150102') {
        $_num_articleId     = $this->insert($_arr_contentData); //更新数据

        //print_r($_num_articleId);

        if ($_num_articleId > 0) {
          $_str_rcode      = 'y150101';
        } else {
          $_str_rcode      = 'x150101';
        }
      } else {
        //print_r($arr_inputSubmit);

        $_num_count     = $this->where('article_id', '=', $arr_inputSubmit['article_id'])->update($_arr_contentData); //更新数据

        if ($_num_count > 0) {
          $_str_rcode      = 'y150103';
        } else {
          $_str_rcode      = 'x150103';
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
        'rcode' => 'x150201',
        'msg'   => end($_mix_vld),
      );
    }

    $_arr_inputClear['rcode'] = 'y150201';

    $this->inputClear = $_arr_inputClear;

    return $_arr_inputClear;
  }
}
