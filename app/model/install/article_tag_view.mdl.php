<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\install;

use app\classes\install\Model;
use ginkgo\Loader;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------文章模型-------------*/
class Article_Tag_View extends Model {

  protected $create = array(
    array('article.article_id'),
    array('article.article_title'),
    array('article.article_excerpt'),
    array('article.article_link'),
    array('article.article_time'),
    array('article.article_time_show'),
    array('article.article_is_time_pub'),
    array('article.article_time_pub'),
    array('article.article_is_time_hide'),
    array('article.article_time_hide'),
    array('article.article_attach_id'),
    array('article.article_mark_id'),
    array('article.article_status'),
    array('article.article_box'),
    array('article.article_top'),
    array('article.article_cate_id'),
    array('article.article_is_gen'),
    array('article.article_hits_day'),
    array('article.article_hits_week'),
    array('article.article_hits_month'),
    array('article.article_hits_year'),
    array('article.article_hits_all'),
    array('article.article_time_day'),
    array('article.article_time_week'),
    array('article.article_time_month'),
    array('article.article_time_year'),
    array('cate_belong.belong_cate_id'),
    array('tag_belong.belong_tag_id'),
  );


  public function createView() {
    $_arr_join = array(
      array(
        'tag_belong',
        array('article.article_id', '=', 'tag_belong.belong_article_id'),
        'LEFT',
      ),
      array(
        'cate_belong',
        array('article.article_id', '=', 'cate_belong.belong_article_id'),
        'LEFT',
      ),
    );

    $_num_count  = $this->viewFrom('article')->viewJoin($_arr_join)->create();

    if ($_num_count !== false) {
      $_str_rcode = 'y120108';
      $_str_msg   = 'Create view successfully';
    } else if ($_num_count > 0) {
      $_str_rcode = 'x120115'; //更新成功
      $_str_msg   = 'Create view failed';
    }

    return array(
      'rcode' => $_str_rcode, //更新成功
      'msg'   => $_str_msg,
    );
  }
}
