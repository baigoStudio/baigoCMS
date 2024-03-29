<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Mime as Mime_Base;
use ginkgo\Func;
use ginkgo\Arrays;
use ginkgo\Cache;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------MIME 模型-------------*/
class Mime extends Mime_Base {

  public $inputSubmit = array();
  public $inputDelete = array();
  public $inputCommon = array();

  protected $obj_cache;

  protected function m_init() { //构造函数
    parent::m_init();

    $this->obj_cache    = Cache::instance();
  }

  /*============提交允许类型============
  @str_mimeName 允许类型

  返回多维数组
      num_mimeId ID
      str_rcode 提示
  */
  public function submit() {
    $_arr_mimeData = array(
      'mime_content'  => $this->inputSubmit['mime_content'],
      'mime_ext'      => $this->inputSubmit['mime_ext'],
      'mime_note'     => $this->inputSubmit['mime_note'],
    );

    $_mix_vld = $this->validate($_arr_mimeData, '', 'submit_db');

    if ($_mix_vld !== true) {
      return array(
        'mime_id'   => $this->inputSubmit['mime_id'],
        'rcode'     => 'x080201',
        'msg'       => end($_mix_vld),
      );
    }

    $_arr_mimeData['mime_content']    = Arrays::toJson($_arr_mimeData['mime_content']);

    if ($this->inputSubmit['mime_id'] > 0) {
      $_num_mimeId = $this->inputSubmit['mime_id'];

      $_num_count     = $this->where('mime_id', '=', $_num_mimeId)->update($_arr_mimeData);

      if ($_num_count > 0) { //数据库插入是否成功
        $_str_rcode = 'y080103';
        $_str_msg   = 'Update MIME successfully';
      } else {
        $_str_rcode = 'x080103';
        $_str_msg   = 'Did not make any changes';
        }
    } else {
      $_num_mimeId    = $this->insert($_arr_mimeData);

      if ($_num_mimeId > 0) { //数据库插入是否成功
        $_str_rcode = 'y080101';
        $_str_msg   = 'Add MIME successfully';
      } else {
        $_str_rcode = 'x080101';
        $_str_msg   = 'Add MIME failed';
      }
    }

    return array(
        'mime_id'   => $_num_mimeId,
        'rcode'     => $_str_rcode,
        'msg'       => $_str_msg,
    );
  }


  /*============删除允许类型============
  @arr_mimeId 允许类型 ID 数组

  返回提示信息
  */
  public function delete() {
    $_num_count     = $this->where('mime_id', 'IN', $this->inputDelete['mime_ids'])->delete();

    //如车影响行数小于0则返回错误
    if ($_num_count > 0) {
      $_str_rcode = 'y080104';
      $_str_msg   = 'Successfully deleted {:count} MIME';
    } else {
      $_str_rcode = 'x080104';
      $_str_msg   = 'No MIME have been deleted';
    }

    return array(
      'count' => $_num_count,
      'rcode' => $_str_rcode,
      'msg'   => $_str_msg,
    );
  }


  public function inputSubmit() {
    $_arr_inputParam = array(
      'mime_id'       => array('int', 0),
      'mime_ext'      => array('str', ''),
      'mime_note'     => array('str', ''),
      'mime_content'  => array('arr', array()),
      '__token__'     => array('str', ''),
    );

    $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

    $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x080201',
        'msg'   => end($_mix_vld),
      );
    }

    if ($_arr_inputSubmit['mime_id'] > 0) {
      $_arr_mimeRow = $this->check($_arr_inputSubmit['mime_id']);

      if ($_arr_mimeRow['rcode'] != 'y080102') {
        return $_arr_mimeRow;
      }
    }

    $_arr_checkResult = $this->check($_arr_inputSubmit['mime_ext'], 'mime_ext', $_arr_inputSubmit['mime_id']);
    if ($_arr_checkResult['rcode'] == 'y080102') {
      return array(
        'rcode' => 'x080404',
        'msg'   => 'MIME already exists',
      );
    }

    $_arr_inputSubmit['rcode'] = 'y080201';

    $this->inputSubmit = $_arr_inputSubmit;

    return $_arr_inputSubmit;
  }


  /**
   * input_ids function.
   *
   * @access public
   * @return void
   */
  public function inputDelete() {
    $_arr_inputParam = array(
      'mime_ids'  => array('arr', array()),
      '__token__' => array('str', ''),
    );

    $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

    //print_r($_arr_inputDelete);

    $_arr_inputDelete['mime_ids'] = Arrays::unique($_arr_inputDelete['mime_ids']);

    $_mix_vld = $this->validate($_arr_inputDelete, '', 'delete');

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x080201',
        'msg'   => end($_mix_vld),
      );
    }

    $_arr_inputDelete['rcode'] = 'y080201';

    $this->inputDelete = $_arr_inputDelete;

    return $_arr_inputDelete;
  }


  public function inputCommon() {
    $_arr_inputParam = array(
      '__token__' => array('str', ''),
    );

    $_arr_inputCommon = $this->obj_request->post($_arr_inputParam);

    $_mix_vld = $this->validate($_arr_inputCommon, '', 'common');

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x080201',
        'msg'   => end($_mix_vld),
      );
    }

    $_arr_inputCommon['rcode'] = 'y080201';

    $this->inputCommon = $_arr_inputCommon;

    return $_arr_inputCommon;
  }


  public function cache($str_name = '') {
    $_arr_return = array();

    if (Func::isEmpty($str_name)) {
      $str_name = 'mime_lists';
    }

    if (!$this->obj_cache->check($str_name, true)) {
      $this->cacheProcess();
    }

    $_arr_return = $this->obj_cache->read($str_name);

    return $_arr_return;
  }


  public function cacheProcess() {
    $_arr_mimeRows      = $this->lists(array(1000, 'limit'));

    $_num_cacheSize     = 0;
    $_arr_mimes         = array();
    $_arr_allowMimes    = array();
    $_arr_allowExts     = array();

    foreach ($_arr_mimeRows as $_key=>$_value) {
      $_arr_allowExts[] = strtolower($_value['mime_ext']);
      if (is_array($_value['mime_content'])) {
        if (Func::isEmpty($_arr_allowMimes)) {
          $_arr_allowMimes  = $_value['mime_content'];
        } else {
          $_arr_allowMimes  = array_merge($_arr_allowMimes, $_value['mime_content']);
        }

        $_arr_mimes[strtolower($_value['mime_ext'])] = $_value['mime_content'];
      }
    }

    $_num_cacheSize += $this->obj_cache->write('mime_lists', $_arr_mimes);
    $_num_cacheSize += $this->obj_cache->write('allow_mime', Arrays::unique($_arr_allowMimes));
    $_num_cacheSize += $this->obj_cache->write('allow_ext', Arrays::unique($_arr_allowExts));

    return $_num_cacheSize;
  }
}
