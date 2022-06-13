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

/*-------------专题模型-------------*/
class Spec extends Model {

  protected $pk = 'spec_id';
  protected $comment = '专题';

  public $arr_status  = array();

  protected function m_init() {
    $_mdl_spec = Loader::model('Spec', '', false);
    $this->arr_status = $_mdl_spec->arr_status;

    $_str_status = implode('\',\'', $this->arr_status);

    $this->create = array(
      'spec_id' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'ai'        => true,
        'comment'   => 'ID',
      ),
      'spec_name' => array(
        'type'      => 'varchar(300)',
        'not_null'  => true,
        'default'   => '',
        'comment'   => '专题名称',
      ),
      'spec_status' => array(
        'type'      => 'enum(\'' . $_str_status . '\')',
        'not_null'  => true,
        'default'   => $this->arr_status[0],
        'comment'   => '状态',
        'update'    => $this->arr_status[0],
      ),
      'spec_content' => array(
        'type'      => 'varchar(9000)',
        'not_null'  => true,
        'default'   => '',
        'comment'   => '专题内容',
      ),
      'spec_attach_id' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '附件ID',
      ),
      'spec_time' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '时间',
      ),
      'spec_time_update' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '更新时间',
      ),
      'spec_tpl' => array(
        'type'      => 'varchar(1000)',
        'not_null'  => true,
        'default'   => '',
        'comment'   => '模板',
      ),
    );
  }


  public function createTable() {
    $_num_count  = $this->create();

    if ($_num_count !== false) {
      $_str_rcode = 'y180105'; //更新成功
      $_str_msg   = 'Create table successfully';
    } else {
      $_str_rcode = 'x180105'; //更新成功
      $_str_msg   = 'Create table failed';
    }

    return array(
        'rcode' => $_str_rcode, //更新成功
        'msg'   => $_str_msg,
    );
  }


  public function alterTable() {
    $_str_rcode = 'y180111';
    $_str_msg   = 'No need to update table';

    $_num_count  = $this->alter();

    if ($_num_count === false) {
      $_str_rcode = 'x180106';
      $_str_msg   = 'Update table failed';
    } else if ($_num_count > 0) {
      $_str_rcode = 'y180106';
      $_str_msg   = 'Update table successfully';
    }

    return array(
      'rcode' => $_str_rcode,
      'msg'   => $_str_msg,
    );
  }
}
