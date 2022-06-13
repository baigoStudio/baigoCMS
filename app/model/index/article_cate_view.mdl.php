<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\index;

use ginkgo\Func;
use ginkgo\Arrays;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------前台文章模型-------------*/
class Article_Cate_View extends Article {

  /**
   * mdl_list function.
   *
   * @access public
   * @param string $str_key (default: '')
   * @param string $str_year (default: '')
   * @param string $str_month (default: '')
   * @param bool $arr_cateIds (default: false)
   * @param bool $arr_markIds (default: false)
   * @param string $str_attachType (default: '')
   * @param string $str_orderType (default: '')
   * @return void
   */
  public function lists($pagination = 0, $arr_search = array(), $arr_order = array(), $arr_group = array()) {
    $_arr_articleSelect = array(
      'article_id',
      'article_title',
      'article_cate_id',
      'article_excerpt',
      'article_link',
      'article_time',
      'article_time_show',
      'article_is_time_pub',
      'article_time_pub',
      'article_is_time_hide',
      'article_time_hide',
      'article_attach_id',
      'article_is_gen',
      'article_hits_day',
      'article_hits_week',
      'article_hits_month',
      'article_hits_year',
      'article_hits_all',
    );

    if (Func::isEmpty($arr_order)) {
      $arr_order = array(
        array('article_top', 'DESC'),
        array('article_time_pub', 'DESC'),
        array('article_id', 'DESC'),
      );
    }

    if (Func::isEmpty($arr_group)) {
      $arr_group = array('article_top', 'article_time_pub', 'article_id');
    }

    $_arr_where         = $this->queryProcess($arr_search);
    $_arr_pagination    = $this->paginationProcess($pagination);
    $_arr_getData       = $this->where($_arr_where)->whereAnd($this->whereAnd_1)->whereAnd($this->whereAnd_2)->whereAnd($this->whereAnd_3)->order($arr_order)->group($arr_group)->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_articleSelect);

    if (isset($_arr_getData['dataRows'])) {
      $_arr_eachData = &$_arr_getData['dataRows'];
    } else {
      $_arr_eachData = &$_arr_getData;
    }

    if (Func::notEmpty($_arr_eachData)) {
      foreach ($_arr_eachData as $_key=>&$_value) {
        $_value                     = $this->rowProcess($_value);
        $_value['article_customs']  = $this->mdl_articleCustom->read($_value['article_id']);
      }
    }

    return $_arr_getData;
  }


  /**
   * mdl_count function.
   *
   * @access public
   * @param string $str_key (default: '')
   * @param string $str_year (default: '')
   * @param string $str_month (default: '')
   * @param bool $arr_cateIds (default: false)
   * @param bool $arr_markIds (default: false)
   * @param string $str_attachType (default: '')
   * @param string $str_orderType (default: '')
   * @return void
   */
  public function counts($arr_search = array(), $arr_group = array()) {
    $_arr_where = $this->queryProcess($arr_search);

    if (Func::isEmpty($arr_group)) {
        $arr_group = array('article_top', 'article_time_pub', 'article_id');
    }

    return $this->where($_arr_where)->whereAnd($this->whereAnd_1)->whereAnd($this->whereAnd_2)->whereAnd($this->whereAnd_3)->group($arr_group)->count();
  }


  public function pagination($arr_search = array(), $perpage = 0, $current = 'get', $pageparam = 'page', $pergroup = 0) {
    $_arr_where = $this->queryProcess($arr_search);

    return $this->where($_arr_where)->pagination($perpage, $current, $pageparam, $pergroup);
  }

  protected function queryProcess($arr_search = array()) {
    $_arr_where = array(
      array('article_status', '=', 'pub'),
      array('article_box', '=', 'normal'),
    );

    if (isset($arr_search['key']) && Func::notEmpty($arr_search['key'])) {
      $_arr_where[] = array('article_title|article_id', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
    }

    if (isset($arr_search['year']) && Func::notEmpty($arr_search['year'])) {
      $_arr_where[] = array('FROM_UNIXTIME(`article_time_pub`, \'%Y\')', '=', $arr_search['year'], 'year');
    }

    if (isset($arr_search['month']) && Func::notEmpty($arr_search['month'])) {
      $_arr_where[] = array('FROM_UNIXTIME(`article_time_pub`, \'%m\')', '=', $arr_search['month'], 'month');
    }

    if (isset($arr_search['mark_id']) && $arr_search['mark_id'] > 0) {
      $_arr_where[] = array('article_mark_id', '=', $arr_search['mark_id']);
    }

    if (isset($arr_search['cate_ids']) && Func::notEmpty($arr_search['cate_ids'])) {
      $arr_search['cate_ids'] = Arrays::unique($arr_search['cate_ids']);

      if (Func::notEmpty($arr_search['cate_ids'])) {
        $_arr_where[] = array('belong_cate_id', 'IN', $arr_search['cate_ids'], 'cate_ids');
      }
    }

    if (isset($arr_search['attach_type'])) {
      switch ($arr_search['attach_type']) {
        case 'attach':
          $_arr_where[] = array('article_attach_id', '>', 0);
        break;

        case 'none':
          $_arr_where[] = array('article_attach_id', '<', 1);
        break;
      }
    }

    return $_arr_where;
  }
}
