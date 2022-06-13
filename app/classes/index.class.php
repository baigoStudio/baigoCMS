<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes;

use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Html;
use ginkgo\Config;
use ginkgo\View;
use ginkgo\Request;
use ginkgo\Ubbcode;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Index {

  public function __construct() {
    $this->mdl_article  = Loader::model('Article', '', 'index');
    $this->mdl_cate     = Loader::model('Cate', '', 'index');
    $this->mdl_attach   = Loader::model('Attach', '', 'index');
    $this->mdl_spec     = Loader::model('Spec', '', 'index');

    $_str_dirRoot       = Request::instance()->root();
    $this->dirStatic    = $_str_dirRoot . GK_NAME_STATIC . '/';
  }


  public function articleRead($num_articleId) {
    $_arr_articleRow = $this->mdl_article->read($num_articleId);

    if ($_arr_articleRow['rcode'] != 'y120102') {
      return $_arr_articleRow;
    }

    if (!isset($_arr_articleRow['article_title']) || Func::isEmpty($_arr_articleRow['article_title']) || $_arr_articleRow['article_status'] != 'pub' || $_arr_articleRow['article_box'] != 'normal' || ($_arr_articleRow['article_is_time_pub'] > 0 && $_arr_articleRow['article_time_pub'] > GK_NOW) || ($_arr_articleRow['article_is_time_hide'] > 0 && $_arr_articleRow['article_time_hide'] < GK_NOW)) {
      return array(
        'msg'   => 'Article is invalid',
        'rcode' => 'x120404',
      );
    }

    if ($_arr_articleRow['article_cate_id'] < 1) {
      return array(
        'msg'   => 'Missing category ID',
        'rcode' => 'x250202',
      );
    }

    $_arr_cateRow = $this->cateRead($_arr_articleRow['article_cate_id']);

    if ($_arr_cateRow['rcode'] != 'y250102') {
      return $_arr_cateRow;
    }

    $_arr_articleRow['article_url']     = $this->mdl_article->urlProcess($_arr_articleRow, $_arr_cateRow);
    $_arr_articleRow['article_content'] = $this->ubbcode($_arr_articleRow['article_content']);

    return $_arr_articleRow;
  }


  public function cateRead($num_cateId) {
    $_arr_cateRow = $this->mdl_cate->cache($num_cateId);

    if (!isset($_arr_cateRow['rcode'])) {
      return array(
        'msg'   => 'Missing rcode',
        'rcode' => 'x250102',
      );
    }

    if ($_arr_cateRow['rcode'] != 'y250102') {
      return $_arr_cateRow;
    }

    if ($_arr_cateRow['cate_status'] != 'show') {
      return array(
        'msg'   => 'Category is invalid',
        'rcode' => 'x250102',
      );
    }

    if (isset($_arr_cateRow['cate_breadcrumb'])) {
      foreach ($_arr_cateRow['cate_breadcrumb'] as $_key=>$_value) {
        if ($_value['cate_status'] != 'show') {
          return array(
            'msg'   => 'Category is invalid',
            'rcode' => 'x250102',
          );
        }
      }
    }

    return $_arr_cateRow;
  }


  public function cateLists($search) {
    $_arr_searchCate = array(
      'status'    => 'show',
    );

    if (isset($search['not_ids'])) {
      $_arr_searchCate['not_ids'] = $search['not_ids'];
    }

    if (isset($search['parent_id'])) {
      $_arr_searchCate['parent_id'] = $search['parent_id'];
    }

    $_arr_cateRows = $this->mdl_cate->lists(array($search['top'], $search['except'], 'limit'), $_arr_searchCate);

    foreach ($_arr_cateRows as $_key=>&$_value) {
      $_value = $this->cateRead($_value['cate_id']);
    }

    return $_arr_cateRows;
  }


  public function tagLists($num_articleId) {
    $_arr_searchTag = array(
      'status'        => 'show',
      'article_id'    => $num_articleId,
    );

    $_mdl_tagView   = Loader::model('Tag_View');
    $_arr_tagRows   = $_mdl_tagView->lists(array(10, 'limit'), $_arr_searchTag);

    foreach ($_arr_tagRows as $_key=>&$_value) {
      $_value['tag_url'] = $_mdl_tagView->urlProcess($_value);
    }

    return $_arr_tagRows;
  }


  public function specRead($num_specId) {
    $_arr_specRow = $this->mdl_spec->read($num_specId);

    if ($_arr_specRow['rcode'] != 'y180102') {
      return $_arr_specRow;
    }

    if ($_arr_specRow['spec_status'] != 'show') {
      return array(
        'msg'   => 'Topic is invalid',
        'rcode' => 'x180102',
      );
    }

    $_arr_specRow['spec_url']   = $this->mdl_spec->urlProcess($_arr_specRow);

    return $_arr_specRow;
  }


  public function assLists($arr_tagIds = array(), $arr_cateIds = array()) {
    $_arr_configVisit   = Config::get('visit', 'var_extra');
    $_mdl_articleView   = Loader::model('Article_Tag_View', '', 'index');

    if (Func::isEmpty($arr_tagIds)) {
      $_arr_search = array(
        'cate_ids' => $arr_cateIds,
      );
    } else {
      $_arr_search = array(
        'tag_ids' => $arr_tagIds,
      );
    }

    $_arr_assRows = $_mdl_articleView->lists(array($_arr_configVisit['count_associate'], 'limit'), $_arr_search);

    return $this->articleListsProcess($_arr_assRows);
  }


  public function linkProcess($str_articleContent, $arr_cateIds = array()) {
    if (Func::notEmpty($str_articleContent)) {
      $_mdl_link      = Loader::model('Link', '', 'index');

      $_arr_linkRows  = $_mdl_link->cache('auto', $arr_cateIds);

      if (Func::notEmpty($_arr_linkRows)) {
        foreach ($_arr_linkRows as $_key=>$_value) {
          $_str_link  = ' <a href="' . Html::decode($_value['link_url']) . '"';
          if (Func::notEmpty($_value['link_blank'])) {
            $_str_link .= ' target="_blank"';
          }
          $_str_link .= '>' . $_value['link_name'] . '</a> ';

          $str_articleContent = str_ireplace($_value['link_name'], $_str_link, $str_articleContent);
        }
      }
    }

    return $str_articleContent;
  }


  public function albumProcess($str_articleContent) {
    if (Func::notEmpty($str_articleContent)) {
      preg_match_all('/{:bg-album-(\d+)}/i', $str_articleContent, $_arr_albumRows);

      if (isset($_arr_albumRows[1]) && is_array($_arr_albumRows[1]) && Func::notEmpty($_arr_albumRows[1])) {
        foreach ($_arr_albumRows[1] as $_key=>$_value) {
          $_str_albumHtml = $this->albumFetch($_value);
          if (isset($_arr_albumRows[0][$_key])) {
            $str_articleContent = str_ireplace($_arr_albumRows[0][$_key], $_str_albumHtml, $str_articleContent);
          }
        }
      }
    }

    return $str_articleContent;
  }


  public function articleListsProcess($arr_articleRows, $is_detail = true) {
    if (Func::notEmpty($arr_articleRows)) {
      foreach ($arr_articleRows as $_key=>&$_value) {
        if (isset($_value['article_cate_id']) && $_value['article_cate_id'] > 0) {
          $_arr_articleCateRow = $this->cateRead($_value['article_cate_id']);

          if (isset($_arr_articleCateRow['rcode']) && $_arr_articleCateRow['rcode'] == 'y250102') {
            $_arr_attachRow = $this->mdl_attach->read($_value['article_attach_id']);

            if ($_arr_attachRow['rcode'] == 'y070102') {
              if (Func::isEmpty($_arr_attachRow['thumb_default'])) {
                $_value['thumb_default'] = $this->dirStatic . 'image/file_' . $_arr_attachRow['attach_ext'] . '.png';
              }
            } else {
              $_value['thumb_default'] = '';
            }

            $_value['cateRow']     = $_arr_articleCateRow;
            $_value['tagRows']     = $this->tagLists($_value['article_id']);
            $_value['attachRow']   = $_arr_attachRow;

            if ($is_detail) {
              $_value['article_url'] = $this->mdl_article->urlProcess($_value, $_arr_articleCateRow);
            //} else {
              //unset($_value['article_excerpt']);
            }
          } else {
            unset($arr_articleRows[$_key]);
          }
        } else {
          unset($arr_articleRows[$_key]);
        }
      }
    }

    return $arr_articleRows;
  }


  public function specListsProcess($arr_specRows) {
    if (Func::notEmpty($arr_specRows)) {
      foreach ($arr_specRows as $_key=>&$_value) {
        $_arr_attachRow = $this->mdl_attach->read($_value['spec_attach_id']);

        if ($_arr_attachRow['rcode'] == 'y070102') {
          if (Func::isEmpty($_arr_attachRow['thumb_default'])) {
            $_value['thumb_default'] = $this->dirStatic . 'image/file_' . $_arr_attachRow['attach_ext'] . '.png';
          }
        } else {
          $_value['thumb_default'] = '';
        }

        $_value['spec_url']    = $this->mdl_spec->urlProcess($_value);
        $_value['attachRow']   = $_arr_attachRow;
      }
    }

    return $arr_specRows;
  }

  public function callRead($num_callId) {
    $_mdl_call      = Loader::model('Call', '', 'index');
    $_arr_callRow   = $_mdl_call->cache($num_callId);

    if (!isset($_arr_callRow['rcode'])) {
      return array(
        'msg'   => 'Missing rcode',
        'rcode' => 'y170102',
      );
    }

    if ($_arr_callRow['rcode'] != 'y170102') {
      return $_arr_callRow;
    }

    if ($_arr_callRow['call_status'] != 'enable') {
      return array(
        'msg'   => 'Call is invalid',
        'rcode' => 'x170102',
      );
    }

    return $_arr_callRow;
  }


  private function albumFetch($num_albumId) {
    $_obj_view  = View::instance();
    $_mdl_album = Loader::model('Album', '', 'index');

    $num_albumId = (int)$num_albumId;

    $_arr_albumRow = $_mdl_album->read($num_albumId);

    if ($_arr_albumRow['rcode'] != 'y060102') {
      return '';
    }

    if ($_arr_albumRow['album_status'] != 'enable') {
      return '';
    }

    $_arr_albumRow['album_url'] = $_mdl_album->urlProcess($_arr_albumRow);

    $_arr_attachRow = $this->mdl_attach->read($_arr_albumRow['album_attach_id']);

    if ($_arr_attachRow['rcode'] == 'y070102') {
      if (Func::isEmpty($_arr_attachRow['thumb_default'])) {
        $_arr_attachRow['thumb_default'] = $this->dirStatic . 'image/file_' . $_arr_attachRow['attach_ext'] . '.png';
      }
    } else {
      $_arr_attachRow['thumb_default'] = '';
    }

    $_arr_tplData = array(
      'albumRow'  => $_arr_albumRow,
      'attachRow' => $_arr_attachRow,
    );

    $_arr_configBase  = Config::get('base', 'var_extra');

    $_str_pathTpl = BG_TPL_INDEX . $_arr_configBase['site_tpl'] . DS;

    $_obj_view->setPath($str_tplPath);

    $_str_tplName = 'album' . DS . 'content';

    if (!$_obj_view->has($_str_tplName)) {
      return '';
    }

    return $_obj_view->fetch($_str_tplName, $_arr_tplData);
  }


  private function ubbcode($string) {
    $_arr_regs = array(
      '/\[iframe=(.+)\](.+)\[\/iframe\]/is'         => '<div class="embed-responsive embed-responsive-$1"><iframe src="$2" class="embed-responsive-item" scrolling="auto"></iframe></div>',
      '/\[iframe\s+(.+)\](.+)\[\/iframe\]/is'       => '<div class="embed-responsive embed-responsive-$1"><iframe src="$2" class="embed-responsive-item" scrolling="auto"></iframe></div>',
      '/\[iframe\](.+)\[\/iframe\]/is'              => '<div class="embed-responsive embed-responsive-16by9"><iframe src="$1" class="embed-responsive-item" scrolling="auto"></iframe></div>',
    );

    Ubbcode::addRegex($_arr_regs);

    if (stripos($string, '<p>')) {
      Ubbcode::$nl2br = false;
    }

    return Ubbcode::convert($string);
  }
}
