<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\install;

use app\classes\install\Model;
use ginkgo\Loader;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------附件模型-------------*/
class Attach extends Model {

  protected $pk = 'attach_id';
  protected $comment = '附件';

  public $arr_box = array();

  protected function m_init() {
    $_mdl_attach = Loader::model('Attach', '', false);
    $this->arr_box = $_mdl_attach->arr_box;

    $_str_box = implode('\',\'', $this->arr_box);

    $this->create = array(
      'attach_id' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'ai'        => true,
        'comment'   => 'ID',
        'old'       => 'upfile_id',
      ),
      'attach_ext' => array(
        'type'      => 'varchar(5)',
        'not_null'  => true,
        'default'   => '',
        'comment'   => '扩展名',
        'old'       => 'upfile_ext',
      ),
      'attach_mime' => array(
        'type'      => 'varchar(100)',
        'not_null'  => true,
        'default'   => '',
        'comment'   => 'MIME',
      ),
      'attach_time' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '时间',
        'old'       => 'upfile_time',
      ),
      'attach_size' => array(
        'type'      => 'mediumint(9)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '大小',
        'old'       => 'upfile_size',
      ),
      'attach_name' => array(
        'type'      => 'varchar(1000)',
        'not_null'  => true,
        'default'   => '',
        'comment'   => '原始文件名',
        'old'       => 'upfile_name',
      ),
      'attach_note' => array(
        'type'      => 'varchar(1000)',
        'not_null'  => true,
        'default'   => '',
        'comment'   => '备注',
      ),
      'attach_admin_id' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '上传用户ID',
        'old'       => 'upfile_admin_id',
      ),
      'attach_album_id' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '上传用户ID',
      ),
      'attach_box' => array(
        'type'      => 'enum(\'' . $_str_box . '\')',
        'not_null'  => true,
        'default'   => $this->arr_box[0],
        'comment'   => '盒子',
        'update'    => $this->arr_box[0],
      ),
      'attach_src_hash' => array(
        'type'      => 'varchar(32)',
        'not_null'  => true,
        'default'   => '',
        'comment'   => 'URL 验证',
        'old'       => 'attach_urlcheck',
      ),
    );
  }


  public function createTable() {
    $_num_count  = $this->create();

    if ($_num_count !== false) {
      $_str_rcode = 'y070105'; //更新成功
      $_str_msg   = 'Create table successfully';
    } else {
      $_str_rcode = 'x070105'; //更新成功
      $_str_msg   = 'Create table failed';
    }

    return array(
      'rcode' => $_str_rcode, //更新成功
      'msg'   => $_str_msg,
    );
  }

  public function renameTable() {
    $_str_rcode = 'y070113';
    $_str_msg   = 'No need to rename table';

    $_num_count  = $this->rename('upfile');

    if ($_num_count === false) {
      $_str_rcode = 'x070112'; //更新成功
      $_str_msg   = 'Rename table failed';
    } else if ($_num_count > 0) {
      $_str_rcode = 'y070112';
      $_str_msg   = 'Rename table successfully';
    }

    return array(
      'rcode' => $_str_rcode, //更新成功
      'msg'   => $_str_msg,
    );
  }


  public function alterTable() {
    $_str_rcode = 'y070111';
    $_str_msg   = 'No need to update table';

    $_num_count  = $this->alter();

    if ($_num_count === false) {
      $_str_rcode = 'x070106';
      $_str_msg   = 'Update table failed';
    } else if ($_num_count > 0) {
      $_str_rcode = 'y070106';
      $_str_msg   = 'Update table successfully';
    }

    return array(
      'rcode' => $_str_rcode,
      'msg'   => $_str_msg,
    );
  }
}
