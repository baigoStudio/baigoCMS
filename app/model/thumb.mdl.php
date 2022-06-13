<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;
use ginkgo\Cache;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------缩略图模型-------------*/
class Thumb extends Model {

  public $arr_type = array('ratio', 'cut');

  protected $obj_cache;

  protected function m_init() { //构造函数
    parent::m_init();

    $this->obj_cache    = Cache::instance();
  }

  public function check($num_thumbId = 0, $thumbWidth = 0, $thumbHeight = 0, $thumbType = '', $notId = 0) {
    if ($num_thumbId === 0 || ($thumbWidth == 100 && $thumbHeight == 100 && $thumbType == 'cut')) {
      return array(
        'thumb_id'      => 0,
        'rcode'         => 'y090102', //存在记录
      );
    }

    $arr_select = array(
      'thumb_id',
    );

    $_arr_where = array();

    if ($num_thumbId > 0) {
      $_arr_where[] = array('thumb_id', '=', $num_thumbId);
    }

    if ($thumbWidth > 0) {
      $_arr_where[] = array('thumb_width', '=', $thumbWidth);
    }

    if ($thumbHeight > 0) {
      $_arr_where[] = array('thumb_height', '=', $thumbHeight);
    }

    if (Func::notEmpty($thumbType)) {
      $_arr_where[] = array('thumb_type', '=', $thumbType);
    }

    if ($notId > 0) {
      $_arr_where[] = array('thumb_id', '<>', $notId);
    }

    $_arr_thumbRow = $this->where($_arr_where)->find($arr_select);

    if (!$_arr_thumbRow) {
      return array(
        'msg'   => 'Thumbnail not found',
        'rcode' => 'x090102', //不存在记录
      );
    }

    $_arr_thumbRow['rcode'] = 'y090102';
    $_arr_thumbRow['msg']   = '';

    return $_arr_thumbRow;
  }


  public function read($num_thumbId) {
    $arr_select = array(
      'thumb_id',
      'thumb_width',
      'thumb_height',
      'thumb_type',
      'thumb_quality',
    );

    $_arr_thumbRow = $this->where('thumb_id', '=', $num_thumbId)->find($arr_select);

    if ($_arr_thumbRow === false) {
      $_arr_thumbRow          = $this->obj_request->fillParam(array(), $arr_select);
      $_arr_thumbRow['msg']   = 'Thumbnail not found';
      $_arr_thumbRow['rcode'] = 'x090102';
    } else {
      $_arr_thumbRow['rcode'] = 'y090102';
      $_arr_thumbRow['msg']   = '';
    }

    return $_arr_thumbRow;
  }


  /*============列出缩略图============
  返回多维数组
      thumb_id 缩略图 ID
      thumb_width 缩略图宽度
      thumb_height 缩略图高度
  */
  public function lists($pagination = 0) {
    $arr_select = array(
      'thumb_id',
      'thumb_width',
      'thumb_height',
      'thumb_type',
      'thumb_quality',
    );

    $_arr_pagination    = $this->paginationProcess($pagination);
    $_arr_getData       = $this->order('thumb_id', 'DESC')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($arr_select);

    $_arr_thumbRow = array(
        'thumb_id'       => 0,
        'thumb_width'    => 100,
        'thumb_height'   => 100,
        'thumb_type'     => 'cut',
        'thumb_quality'  => 90,
    );

    if (isset($_arr_getData['dataRows'])) {
      array_unshift($_arr_getData['dataRows'], $_arr_thumbRow);
    } else {
      array_unshift($_arr_getData, $_arr_thumbRow);
    }

    return $_arr_getData;
  }


  public function counts() {
    return $this->count();
  }


  public function cache() {
    $_arr_return = array();

    $_str_cacheName = 'thumb_lists';

    if (!$this->obj_cache->check($_str_cacheName, true)) {
      $this->cacheProcess();
    }

    $_arr_return = $this->obj_cache->read($_str_cacheName);

    return $_arr_return;
  }


  public function cacheProcess() {
    $_arr_thumbRows = $this->lists(array(1000, 'limit'));

    $_arr_thumbs = array();

    foreach ($_arr_thumbRows as $_key=>$_value) {
      $_arr_thumbs[$_value['thumb_id']] = $_value;
    }

    return $this->obj_cache->write('thumb_lists', $_arr_thumbs);
  }
}
