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

/*-------------TAG 归属模型-------------*/
class Tag_Belong extends Model {

  protected $pk = 'belong_id';
  protected $comment = '标签从属';

  protected function m_init() {
    $this->create = array(
      'belong_id' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'ai'        => true,
        'comment'   => 'ID',
      ),
      'belong_tag_id' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => 'TAG ID',
      ),
      'belong_article_id' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '文章ID',
      ),
    );
  }


  public function createTable() {
    $_num_count  = $this->create();

    if ($_num_count !== false) {
      $_str_rcode = 'y160105'; //更新成功
      $_str_msg   = 'Create table successfully';
    } else {
      $_str_rcode = 'x160105'; //更新成功
      $_str_msg   = 'Create table failed';
    }

    return array(
      'rcode' => $_str_rcode, //更新成功
      'msg'   => $_str_msg,
    );
  }


  public function createIndex() {
    $_str_rcode     = 'y160109'; //更新成功
    $_str_msg       = 'Create index successfully';

    $_num_count  = $this->index('search_article', 'belong_article_id');

    if ($_num_count === false) {
      return array(
        'rcode' => 'x160109',
        'msg'   => 'Create index failed',
      );
    }

    $_num_count  = $this->index('search_tag', 'belong_tag_id');

    if ($_num_count === false) {
      return array(
        'rcode' => 'x160110',
        'msg'   => 'Create index failed',
      );
    }

    return array(
      'rcode' => $_str_rcode, //更新成功
      'msg'   => $_str_msg,
    );
  }


  public function alterTable() {
    $_str_rcode = 'y160111';
    $_str_msg   = 'No need to update table';

    $_num_count  = $this->alter();

    if ($_num_count === false) {
      $_str_rcode = 'x160106';
      $_str_msg   = 'Update table failed';
    } else if ($_num_count > 0) {
      $_str_rcode = 'y160106';
      $_str_msg   = 'Update table successfully';
    }

    return array(
      'rcode' => $_str_rcode,
      'msg'   => $_str_msg,
    );
  }
}
