<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Mark as Mark_Base;
use ginkgo\Arrays;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------标记模型-------------*/
class Mark extends Mark_Base {

  public $inputSubmit = array();
  public $inputDelete = array();

  /**
   * mdl_submit function.
   *
   * @access public
   * @param mixed $num_markId
   * @param mixed $str_markName
   * @param mixed $str_markType
   * @param mixed $str_markStatus
   * @return void
   */
  public function submit() {
    $_arr_markData = array(
      'mark_name'   => $this->inputSubmit['mark_name'],
    );

    $_mix_vld = $this->validate($_arr_markData, '', 'submit_db');

    if ($_mix_vld !== true) {
      return array(
        'mark_id'   => $this->inputSubmit['mark_id'],
        'rcode'     => 'x140201',
        'msg'       => end($_mix_vld),
      );
    }

    if ($this->inputSubmit['mark_id'] > 0) {
      $_num_markId = $this->inputSubmit['mark_id'];

      $_num_count     = $this->where('mark_id', '=', $_num_markId)->update($_arr_markData);

      if ($_num_count > 0) {
        $_str_rcode = 'y140103';
        $_str_msg   = 'Update mark successfully';
      } else {
        $_str_rcode = 'x140103';
        $_str_msg   = 'Did not make any changes';
      }
    } else {
      $_num_markId    = $this->insert($_arr_markData);

      if ($_num_markId > 0) { //数据库插入是否成功
        $_str_rcode = 'y140101';
        $_str_msg   = 'Add mark successfully';
      } else {
        $_str_rcode = 'x140101';
        $_str_msg   = 'Add mark failed';
      }
    }

    return array(
      'mark_id'   => $_num_markId,
      'rcode'     => $_str_rcode,
      'msg'       => $_str_msg,
    );
  }


  /**
   * mdl_del function.
   *
   * @access public
   * @param mixed $this->inputDelete['mark_ids']
   * @return void
   */
  public function delete() {
    $_num_count     = $this->where('mark_id', 'IN', $this->inputDelete['mark_ids'])->delete();

    //如车影响行数小于0则返回错误
    if ($_num_count > 0) {
      $_str_rcode = 'y140104';
      $_str_msg   = 'Successfully deleted {:count} marks';
    } else {
      $_str_rcode = 'x140104';
      $_str_msg   = 'No mark have been deleted';
    }

    return array(
      'count' => $_num_count,
      'rcode' => $_str_rcode,
      'msg'   => $_str_msg,
    );
  }


  public function inputSubmit() {
    $_arr_inputParam = array(
      'mark_id'       => array('int', 0),
      'mark_name'     => array('str', ''),
      '__token__'     => array('str', ''),
    );

    $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

    $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x140201',
        'msg'   => end($_mix_vld),
      );
    }

    if ($_arr_inputSubmit['mark_id'] > 0) {
      $_arr_markRow = $this->check($_arr_inputSubmit['mark_id']);

      if ($_arr_markRow['rcode'] != 'y140102') {
        return $_arr_markRow;
      }
    }

    $_arr_checkResult = $this->check($_arr_inputSubmit['mark_name'], 'mark_name', $_arr_inputSubmit['mark_id']);
    if ($_arr_checkResult['rcode'] == 'y140102') {
      return array(
        'rcode' => 'x140404',
        'msg'   => 'Mark already exists',
      );
    }

    $_arr_inputSubmit['rcode'] = 'y140201';

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
      'mark_ids' => array('arr', array()),
      '__token__' => array('str', ''),
    );

    $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

    //print_r($_arr_inputDelete);

    $_arr_inputDelete['mark_ids'] = Arrays::unique($_arr_inputDelete['mark_ids']);

    $_mix_vld = $this->validate($_arr_inputDelete, '', 'delete');

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x140201',
        'msg'   => end($_mix_vld),
      );
    }

    $_arr_inputDelete['rcode'] = 'y140201';

    $this->inputDelete = $_arr_inputDelete;

    return $_arr_inputDelete;
  }
}
