<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;
use ginkgo\Html;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------文章模型-------------*/
class Article_Content extends Model {

  public function check($num_articleId) {
    $_arr_select = array(
      'article_id',
    );

    return $this->read($num_articleId, $_arr_select);
  }


  /** 读出内容
   * readContent function.
   *
   * @access public
   * @param mixed $num_articleId
   * @return void
   */
  public function read($num_articleId, $arr_select = array()) {
    if (Func::isEmpty($arr_select)) {
      $arr_select = array(
        'article_content',
        'article_source',
        'article_source_url',
        'article_author',
      );
    }

    $_arr_contentRow = $this->where('article_id', '=', $num_articleId)->find($arr_select);

    if ($_arr_contentRow === false) {
      $_arr_contentRow          = $this->obj_request->fillParam(array(), $arr_select);
      $_arr_contentRow['rcode'] = 'x150102';
    } else {
      if (isset($_arr_contentRow['article_source_url']) && Func::notEmpty($_arr_contentRow['article_source_url'])) {
        $_arr_contentRow['article_source_url']  = Html::decode($_arr_contentRow['article_source_url'], 'url');
      }

      $_arr_contentRow['rcode'] = 'y150102';
    }

    return $_arr_contentRow;
  }
}
