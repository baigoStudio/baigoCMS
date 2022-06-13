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

/*-------------标记模型-------------*/
class Mark extends Model {

  protected $pk = 'mark_id';
  protected $comment = '标记';

  protected function m_init() {
    $this->create = array(
      'mark_id'    => array(
        'type'      => 'smallint(6)',
        'not_null'  => true,
        'ai'        => true,
        'comment'   => 'ID',
      ),
      'mark_name'  => array(
        'type'      => 'varchar(30)',
        'not_null'  => true,
        'default'   => '',
        'comment'   => '标记名称',
      ),
    );
  }


  public function createTable() {
    $_num_count  = $this->create();

    if ($_num_count !== false) {
      $_str_rcode = 'y140105'; //更新成功
      $_str_msg   = 'Create table successfully';
    } else {
      $_str_rcode = 'x140105'; //更新成功
      $_str_msg   = 'Create table failed';
    }

    return array(
      'rcode' => $_str_rcode, //更新成功
      'msg'   => $_str_msg,
    );
  }



  public function alterTable() {
    $_str_rcode = 'y140111';
    $_str_msg   = 'No need to update table';

    $_num_count  = $this->alter();

    if ($_num_count === false) {
      $_str_rcode = 'x140106';
      $_str_msg   = 'Update table failed';
    } else if ($_num_count > 0) {
      $_str_rcode = 'y140106';
      $_str_msg   = 'Update table successfully';
    }

    return array(
      'rcode' => $_str_rcode,
      'msg'   => $_str_msg,
    );
  }
}
