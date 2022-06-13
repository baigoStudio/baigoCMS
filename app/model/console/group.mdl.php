<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Group as Group_Base;
use ginkgo\Arrays;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------群组模型-------------*/
class Group extends Group_Base {

  public $inputSubmit = array();
  public $inputDelete = array();
  public $inputStatus = array();

  public function submit() {
    $_arr_groupData = array(
      'group_name'     => $this->inputSubmit['group_name'],
      'group_note'     => $this->inputSubmit['group_note'],
      'group_allow'    => $this->inputSubmit['group_allow'],
      'group_status'   => $this->inputSubmit['group_status'],
    );

    $_mix_vld = $this->validate($_arr_groupData, '', 'submit_db');

    if ($_mix_vld !== true) {
      return array(
        'group_id'  => $this->inputSubmit['group_id'],
        'rcode'     => 'x040201',
        'msg'       => end($_mix_vld),
      );
    }

    $_arr_groupData['group_allow'] = Arrays::toJson($_arr_groupData['group_allow']);

    if ($this->inputSubmit['group_id'] > 0) { //插入
      $_num_groupId   = $this->inputSubmit['group_id'];

      $_num_count     = $this->where('group_id', '=', $_num_groupId)->update($_arr_groupData);

      if ($_num_count > 0) { //数据库更新是否成功
        $_str_rcode = 'y040103';
        $_str_msg   = 'Update group successfully';
      } else {
        $_str_rcode = 'x040103';
        $_str_msg   = 'Did not make any changes';
      }
    } else {
      $_num_groupId   = $this->insert($_arr_groupData);

      if ($_num_groupId > 0) { //数据库插入是否成功
        $_str_rcode = 'y040101';
        $_str_msg   = 'Add group successfully';
      } else {
        $_str_rcode = 'x040101';
        $_str_msg   = 'Add group failed';
      }
    }

    return array(
      'group_id'  => $_num_groupId,
      'rcode'     => $_str_rcode,
      'msg'       => $_str_msg,
    );
  }


  public function status() {
    $_arr_groupUpdate = array(
      'group_status' => $this->inputStatus['act'],
    );

    $_num_count     = $this->where('group_id', 'IN', $this->inputStatus['group_ids'])->update($_arr_groupUpdate);

    //如车影响行数小于0则返回错误
    if ($_num_count > 0) {
      $_str_rcode = 'y040103';
      $_str_msg   = 'Successfully updated {:count} groups';
    } else {
      $_str_rcode = 'x040103';
      $_str_msg   = 'Did not make any changes';
    }

    return array(
      'count' => $_num_count,
      'rcode' => $_str_rcode,
      'msg'   => $_str_msg,
    ); //成功
  }


  /**
   * mdl_del function.
   *
   * @access public
   * @param mixed $this->inputDelete['group_ids']
   * @return void
   */
  public function delete() {
    $_num_count     = $this->where('group_id', 'IN', $this->inputDelete['group_ids'])->delete();

    //如车影响行数小于0则返回错误
    if ($_num_count > 0) {
      $_str_rcode = 'y040104';
      $_str_msg   = 'Successfully deleted {:count} groups';
    } else {
      $_str_rcode = 'x040104';
      $_str_msg   = 'No group have been deleted';
    }

    return array(
      'count' => $_num_count,
      'rcode' => $_str_rcode,
      'msg'   => $_str_msg,
    );
  }


  public function inputSubmit() {
    $_arr_inputParam = array(
      'group_id'      => array('int', 0),
      'group_name'    => array('str', ''),
      'group_note'    => array('str', ''),
      'group_status'  => array('str', ''),
      'group_allow'   => array('arr', array()),
      '__token__'     => array('str', ''),
    );

    $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

    $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x040201',
        'msg'   => end($_mix_vld),
      );
    }

    if ($_arr_inputSubmit['group_id'] > 0) {
      $_arr_groupRow = $this->check($_arr_inputSubmit['group_id']);

      if ($_arr_groupRow['rcode'] != 'y040102') {
        return $_arr_groupRow;
      }
    }

    $_arr_inputSubmit['rcode'] = 'y040201';

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
      'group_ids' => array('arr', array()),
      '__token__' => array('str', ''),
    );

    $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

    //print_r($_arr_inputDelete);

    $_arr_inputDelete['group_ids'] = Arrays::unique($_arr_inputDelete['group_ids']);

    $_mix_vld = $this->validate($_arr_inputDelete, '', 'delete');

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x040201',
        'msg'   => end($_mix_vld),
      );
    }

    $_arr_inputDelete['rcode'] = 'y040201';

    $this->inputDelete = $_arr_inputDelete;

    return $_arr_inputDelete;
  }


  public function inputStatus() {
    $_arr_inputParam = array(
      'group_ids' => array('arr', array()),
      'act'       => array('str', ''),
      '__token__' => array('str', ''),
    );

    $_arr_inputStatus = $this->obj_request->post($_arr_inputParam);

    //print_r($_arr_inputStatus);

    $_arr_inputStatus['group_ids'] = Arrays::unique($_arr_inputStatus['group_ids']);

    $_mix_vld = $this->validate($_arr_inputStatus, '', 'status');

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x040201',
        'msg'   => end($_mix_vld),
      );
    }

    $_arr_inputStatus['rcode'] = 'y040201';

    $this->inputStatus = $_arr_inputStatus;

    return $_arr_inputStatus;
  }
}
