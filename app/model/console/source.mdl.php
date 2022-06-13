<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Source as Source_Base;
use ginkgo\Arrays;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------来源模型-------------*/
class Source extends Source_Base {

  public $inputSubmit = array();
  public $inputDelete = array();
  public $inputStatus = array();

  /**
   * mdl_submit function.
   *
   * @access public
   * @param mixed $num_sourceId
   * @param mixed $str_sourceName
   * @param mixed $str_sourceType
   * @param mixed $str_sourceStatus
   * @return void
   */
  public function submit() {
    $_arr_sourceData = array(
      'source_name'   => $this->inputSubmit['source_name'],
      'source_author' => $this->inputSubmit['source_author'],
      'source_url'    => $this->inputSubmit['source_url'],
      'source_note'   => $this->inputSubmit['source_note'],
    );

    $_mix_vld = $this->validate($_arr_sourceData, '', 'submit_db');

    if ($_mix_vld !== true) {
      return array(
        'source_id' => $this->inputSubmit['source_id'],
        'rcode'     => 'x260201',
        'msg'       => end($_mix_vld),
      );
    }

    if ($this->inputSubmit['source_id'] > 0) {
      $_num_sourceId = $this->inputSubmit['source_id'];

      $_num_count     = $this->where('source_id', '=', $_num_sourceId)->update($_arr_sourceData);

      if ($_num_count > 0) {
        $_str_rcode = 'y260103';
        $_str_msg   = 'Update source successfully';
      } else {
        $_str_rcode = 'x260103';
        $_str_msg   = 'Did not make any changes';
      }
    } else {
      $_num_sourceId     = $this->insert($_arr_sourceData);

      if ($_num_sourceId > 0) { //数据库插入是否成功
        $_str_rcode = 'y260101';
        $_str_msg   = 'Add source successfully';
      } else {
        $_str_rcode = 'x260101';
        $_str_msg   = 'Add source failed';
      }
    }

    return array(
      'source_id' => $_num_sourceId,
      'rcode'     => $_str_rcode,
      'msg'       => $_str_msg,
    );
  }


  /**
   * mdl_del function.
   *
   * @access public
   * @param mixed $this->sourceIds['source_ids']
   * @return void
   */
  public function delete() {
    $_num_count     = $this->where('source_id', 'IN', $this->inputDelete['source_ids'])->delete();

    //如车影响行数小于0则返回错误
    if ($_num_count > 0) {
      $_str_rcode = 'y260104';
      $_str_msg   = 'Successfully deleted {:count} sources';
    } else {
      $_str_rcode = 'x260104';
      $_str_msg   = 'No source have been deleted';
    }

    return array(
      'rcode' => $_str_rcode,
      'count' => $_num_count,
      'msg'   => $_str_msg,
    ); //成功
  }


  /** 创建、编辑表单验证
   * inputSubmit function.
   *
   * @access public
   * @return void
   */
  public function inputSubmit() {
    $_arr_inputParam = array(
      'source_id'     => array('int', 0),
      'source_name'   => array('str', ''),
      'source_name'   => array('str', ''),
      'source_author' => array('str', ''),
      'source_url'    => array('str', ''),
      'source_note'   => array('str', ''),
      '__token__'     => array('str', ''),
    );

    $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

    $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x260201',
        'msg'   => end($_mix_vld),
      );
    }

    if ($_arr_inputSubmit['source_id'] > 0) {
      $_arr_sourceRow = $this->check($_arr_inputSubmit['source_id']);

      if ($_arr_sourceRow['rcode'] != 'y260102') {
        return $_arr_sourceRow;
      }
    }

    $_arr_inputSubmit['rcode'] = 'y260201';

    $this->inputSubmit = $_arr_inputSubmit;

    return $_arr_inputSubmit;
  }


  /** 选择管理员
   * inputDelete function.
   *
   * @access public
   * @return void
   */
  public function inputDelete() {
    $_arr_inputParam = array(
      'source_ids'    => array('arr', array()),
      '__token__'     => array('str', ''),
    );

    $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

    //print_r($_arr_inputDelete);

    $_arr_inputDelete['source_ids'] = Arrays::unique($_arr_inputDelete['source_ids']);

    $_mix_vld = $this->validate($_arr_inputDelete, '', 'delete');

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x260201',
        'msg'   => end($_mix_vld),
      );
    }

    $_arr_inputDelete['rcode'] = 'y260201';

    $this->inputDelete = $_arr_inputDelete;

    return $_arr_inputDelete;
  }


  public function inputStatus() {
    $_arr_inputParam = array(
      'source_ids'    => array('arr', array()),
      'act'           => array('str', ''),
      '__token__'     => array('str', ''),
    );

    $_arr_inputStatus = $this->obj_request->post($_arr_inputParam);

    //print_r($_arr_inputStatus);

    $_arr_inputStatus['source_ids'] = Arrays::unique($_arr_inputStatus['source_ids']);

    $_mix_vld = $this->validate($_arr_inputStatus, '', 'status');

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x260201',
        'msg'   => end($_mix_vld),
      );
    }

    $_arr_inputStatus['rcode'] = 'y260201';

    $this->inputStatus = $_arr_inputStatus;

    return $_arr_inputStatus;
  }
}
