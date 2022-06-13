<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Cate_Belong as Cate_Belong_Base;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Arrays;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------栏目归属模型-------------*/
class Cate_Belong extends Cate_Belong_Base {

  public $inputClear = array();

  public function move($num_articleId, $num_cateSrc, $num_cateTarget, $arr_cateIds) {
    $_arr_belongUpdate = array(
      'belong_cate_id' => $num_cateTarget,
    );

    $_arr_where = array(
      array('belong_article_id', '=', $num_articleId),
      array('belong_cate_id', '=', $num_cateTarget),
    );

    if (Func::notEmpty($arr_cateIds)) {
      $arr_cateIds        = Arrays::unique($arr_cateIds);
      $_arr_where[] = array('belong_cate_id', 'IN', $arr_cateIds, 'cate_ids');
    }

    $_num_count     = $this->where($_arr_where)->update($_arr_belongUpdate); //更新数

    if ($_num_count > 0) {
      $_str_rcode = 'y220103';
    } else {
      $_str_rcode = 'x220103';
    }

    return array(
      'rcode' => $_str_rcode,
    );
  }

  /**
   * mdl_submit function.
   *
   * @access public
   * @param mixed $num_belongId
   * @param mixed $num_cateId
   * @param mixed $num_belongId
   * @return void
   */
  public function submitProcess($num_articleId, $num_cateId) {
    $_str_rcode = 'x220101';

    if ($num_articleId > 0 && $num_cateId > 0) { //插入
      $_arr_belongRow = $this->read($num_cateId, $num_articleId);

      if ($_arr_belongRow['rcode'] == 'x220102') { //插入
        $_arr_belongData = array(
          'belong_article_id'  => $num_articleId,
          'belong_cate_id'     => $num_cateId,
        );

        $_arr_belongRowSub = $this->read(0, $num_articleId);

        if ($_arr_belongRowSub['rcode'] == 'y220102') {
          $_num_count     = $this->where('belong_id', '=', $_arr_belongRowSub['belong_id'])->update($_arr_belongData); //更新数

          if ($_num_count > 0) {
            $_str_rcode = 'y220103';
          } else {
            $_str_rcode = 'x220103';
          }
        } else {
          $_num_belongId   = $this->insert($_arr_belongData);

          if ($_num_belongId > 0) { //数据库插入是否成功
            $_str_rcode = 'y220101';
          } else {
            $_str_rcode = 'x220101';
          }
        }
      }
    }

    return array(
      'rcode'  => $_str_rcode,
    );
  }


  public function clear() {
    $_arr_belongSelect = array(
      'belong_id',
      'belong_cate_id',
      'belong_article_id',
    );

    $_arr_search = array(
      'max_id' => $this->inputClear['max_id'],
    );

    $_arr_where         = $this->queryProcess($_arr_search);
    $_arr_pagination    = $this->paginationProcess(array(10, 'post'));
    $_arr_getData       = $this->where($_arr_where)->order('belong_id', 'DESC')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_belongSelect);

    if (isset($_arr_getData['dataRows'])) {
      $_arr_clearData = $_arr_getData['dataRows'];
    } else {
      $_arr_clearData = $_arr_getData;
    }

    if (Func::notEmpty($_arr_clearData)) {
      $_mdl_article = Loader::model('Article');
      $_mdl_cate    = Loader::model('Cate');

      foreach ($_arr_clearData as $_key=>$_value) {
        $_arr_articleRow = $_mdl_article->check($_value['belong_article_id']);

        if ($_arr_articleRow['rcode'] != 'y120102') {
          $this->delete(0, 0, false, false, false, false, $_value['belong_id']);
        }

        $_arr_cateRow = $_mdl_cate->check($_value['belong_cate_id']);

        if ($_arr_cateRow['rcode'] != 'y250102') {
          $this->delete(0, 0, false, false, false, false, $_value['belong_id']);
        }
      }
    }

    return $_arr_getData;
  }


  /**
   * delete function.
   *
   * @access public
   * @param int $num_cateId (default: 0)
   * @param int $num_articleId (default: 0)
   * @return void
   */
  public function delete($num_cateId = 0, $num_articleId = 0, $arr_cateIds = false, $arr_articleIds = false, $arr_notCateIds = false, $arr_notArticleIds = false, $num_belongId = 0) {

    $_arr_where = array();

    if ($num_cateId > 0) {
      $_arr_where[] = array('belong_cate_id', '=', $num_cateId);
    }

    if ($num_articleId > 0) {
      $_arr_where[] = array('belong_article_id', '=', $num_articleId);
    }

    if (Func::notEmpty($arr_cateIds)) {
      $arr_cateIds = Arrays::unique($arr_cateIds);

      $_arr_where[] = array('belong_cate_id', 'IN', $arr_cateIds, 'cate_ids');
    }

    if (Func::notEmpty($arr_articleIds)) {
      $arr_articleIds = Arrays::unique($arr_articleIds);

      $_arr_where[] = array('belong_article_id', 'IN', $arr_articleIds, 'article_ids');
    }

    if (Func::notEmpty($arr_notCateIds)) {
      $arr_notCateIds = Arrays::unique($arr_notCateIds);

      $_arr_where[] = array('belong_cate_id', 'NOT IN', $arr_notCateIds, 'not_cate_ids');
    }

    if (Func::notEmpty($arr_notArticleIds)) {
      $arr_notArticleIds = Arrays::unique($arr_notArticleIds);

      $_arr_where[] = array('belong_article_id', 'NOT IN', $arr_notArticleIds, 'not_article_ids');
    }

    if ($num_belongId > 0) {
      $_arr_where[] = array('belong_id', '=', $num_belongId);
    }

    $_arr_belongData = array(
      //'belong_article_id' => 0,
      'belong_cate_id'    => 0,
    );

    $_num_count     = $this->where($_arr_where)->update($_arr_belongData); //更新数

    return $_num_count; //成功
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
        'rcode' => 'x220201',
        'msg'   => end($_mix_vld),
      );
    }

    $_arr_inputClear['rcode'] = 'y220201';

    $this->inputClear = $_arr_inputClear;

    return $_arr_inputClear;
  }
}
