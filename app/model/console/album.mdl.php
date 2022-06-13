<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Album as Album_Base;
use ginkgo\Arrays;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------群组模型-------------*/
class Album extends Album_Base {

  public $inputStatus = array();
  public $inputSubmit = array();
  public $inputDelete = array();
  public $inputCover  = array();

  /**
   * mdl_submit function.
   *
   * @access public
   * @param mixed $num_albumId
   * @param mixed $str_albumName
   * @param mixed $str_albumType
   * @param string $str_albumNote (default: '')
   * @param string $str_albumAllow (default: '')
   * @return void
   */
  public function submit() {
    $_arr_albumData = array(
      'album_name'      => $this->inputSubmit['album_name'],
      'album_content'   => $this->inputSubmit['album_content'],
      'album_status'    => $this->inputSubmit['album_status'],
      'album_tpl'       => $this->inputSubmit['album_tpl'],
      'album_attach_id' => $this->inputSubmit['album_attach_id'],
    );

    $_mix_vld = $this->validate($_arr_albumData, '', 'submit_db');

    if ($_mix_vld !== true) {
      return array(
        'album_id'  => $this->inputSubmit['album_id'],
        'rcode'     => 'x060201',
        'msg'       => end($_mix_vld),
      );
    }

    if ($this->inputSubmit['album_id'] > 0) { //插入
      $_num_albumId   = $this->inputSubmit['album_id'];
      $_num_count     = $this->where('album_id', '=', $_num_albumId)->update($_arr_albumData); //更新数

      if ($_num_count > 0) { //数据库更新是否成功
        $_str_rcode = 'y060103';
        $_str_msg   = 'Update album successfully';
      } else {
        $_str_rcode = 'x060103';
        $_str_msg   = 'Did not make any changes';
      }
    } else {
      $_num_albumId   = $this->insert($_arr_albumData);

      if ($_num_albumId > 0) { //数据库插入是否成功
        $_str_rcode = 'y060101';
        $_str_msg   = 'Add album successfully';
      } else {
        $_str_rcode = 'x060101';
        $_str_msg   = 'Add album failed';
      }
    }

    return array(
      'album_id'  => $_num_albumId,
      'rcode'     => $_str_rcode,
      'msg'       => $_str_msg,
    );
  }


  public function cover() {
    $_arr_albumData = array(
      'album_attach_id'  => $this->inputCover['attach_id'],
    );

    $_num_albumId   = $this->inputCover['album_id'];

    $_num_count     = $this->where('album_id', '=', $_num_albumId)->update($_arr_albumData); //更新数

    if ($_num_count > 0) { //数据库更新是否成功
      $_str_rcode = 'y060103';
      $_str_msg   = 'Set cover successfully';
    } else {
      $_str_rcode = 'x060103';
      $_str_msg   = 'Did not make any changes';
    }

    return array(
      'album_id'  => $_num_albumId,
      'rcode'     => $_str_rcode,
      'msg'       => $_str_msg,
    );
  }


  public function status() {
    $_arr_albumUpdate = array(
      'album_status' => $this->inputStatus['act'],
    );

    $_num_count     = $this->where('album_id', 'IN', $this->inputStatus['album_ids'])->update($_arr_albumUpdate); //更新数

    //如车影响行数小于0则返回错误
    if ($_num_count > 0) {
      $_str_rcode = 'y060103';
      $_str_msg   = 'Successfully updated {:count} albums';
    } else {
      $_str_rcode = 'x060103';
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
   * @param mixed $this->inputDelete['album_ids']
   * @return void
   */
  public function delete() {
    $_num_count     = $this->where('album_id', 'IN', $this->inputDelete['album_ids'])->delete(); //更新数

    //如车影响行数小于0则返回错误
    if ($_num_count > 0) {
      $_str_rcode = 'y060104';
      $_str_msg   = 'Successfully deleted {:count} albums';
    } else {
      $_str_rcode = 'x060104';
      $_str_msg   = 'No album have been deleted';
    }

    return array(
      'rcode' => $_str_rcode,
      'count' => $_num_count,
      'msg'   => $_str_msg,
    );
  }


  public function chkAttach($arr_attachRow) {
      return $this->where('album_attach_id', '=', $arr_attachRow['attach_id'])->find('album_id');
  }


  public function inputCover() {
    $_arr_inputParam = array(
      'album_id'  => array('int', 0),
      'attach_id' => array('int', 0),
      '__token__' => array('str', ''),
    );

    $_arr_inputCover = $this->obj_request->post($_arr_inputParam);

    $_mix_vld = $this->validate($_arr_inputCover, '', 'cover');

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x060201',
        'msg'   => end($_mix_vld),
      );
    }

    $_arr_albumRow = $this->check($_arr_inputCover['album_id']);

    if ($_arr_albumRow['rcode'] != 'y060102') {
        return $_arr_albumRow;
    }

    $_arr_inputCover['rcode'] = 'y060201';

    $this->inputCover = $_arr_inputCover;

    return $_arr_inputCover;
  }


  public function inputSubmit() {
    $_arr_inputParam = array(
      'album_id'        => array('int', 0),
      'album_name'      => array('str', ''),
      'album_content'   => array('str', ''),
      'album_status'    => array('str', ''),
      'album_tpl'       => array('str', ''),
      'album_attach_id' => array('int', 0),
      '__token__'       => array('str', ''),
    );

    $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

    $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x060201',
        'msg'   => end($_mix_vld),
      );
    }

    if ($_arr_inputSubmit['album_id'] > 0) {
      $_arr_albumRow = $this->check($_arr_inputSubmit['album_id']);

      if ($_arr_albumRow['rcode'] != 'y060102') {
        return $_arr_albumRow;
      }
    }

    $_arr_inputSubmit['rcode'] = 'y060201';

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
      'album_ids' => array('arr', array()),
      '__token__' => array('str', ''),
    );

    $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

    //print_r($_arr_inputDelete);

    $_arr_inputDelete['album_ids'] = Arrays::unique($_arr_inputDelete['album_ids']);

    $_mix_vld = $this->validate($_arr_inputDelete, '', 'delete');

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x060201',
        'msg'   => end($_mix_vld),
      );
    }

    $_arr_inputDelete['rcode'] = 'y060201';

    $this->inputDelete = $_arr_inputDelete;

    return $_arr_inputDelete;
  }


  public function inputStatus() {
    $_arr_inputParam = array(
      'album_ids' => array('arr', array()),
      'act'       => array('str', ''),
      '__token__' => array('str', ''),
    );

    $_arr_inputStatus = $this->obj_request->post($_arr_inputParam);

    //print_r($_arr_inputStatus);

    $_arr_inputStatus['album_ids'] = Arrays::unique($_arr_inputStatus['album_ids']);

    $_mix_vld = $this->validate($_arr_inputStatus, '', 'status');

    if ($_mix_vld !== true) {
      return array(
        'rcode' => 'x060201',
        'msg'   => end($_mix_vld),
      );
    }

    $_arr_inputStatus['rcode'] = 'y060201';

    $this->inputStatus = $_arr_inputStatus;

    return $_arr_inputStatus;
  }
}
