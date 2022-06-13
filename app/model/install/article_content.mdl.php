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

/*-------------文章模型-------------*/
class Article_Content extends Model {

  protected $pk = 'article_id';
  protected $comment = '文章内容';

  protected function m_init() {
    $this->create = array(
      'article_id' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'ai'        => true,
        'comment'   => 'ID',
      ),
      'article_content' => array(
        'type'      => 'text',
        'not_null'  => true,
        'default'   => '',
        'comment'   => '内容',
      ),
      'article_source' => array(
        'type'      => 'varchar(300)',
        'not_null'  => true,
        'default'   => '',
        'comment'   => '来源',
      ),
      'article_source_url' => array(
        'type'      => 'varchar(900)',
        'not_null'  => true,
        'default'   => '',
        'comment'   => '来源 URL',
      ),
      'article_author' => array(
        'type'      => 'varchar(300)',
        'not_null'  => true,
        'default'   => '',
        'comment'   => '作者',
        'old'       => 'article_auther',
      ),
    );
  }


  public function createTable() {
    $_num_count  = $this->create();

    if ($_num_count !== false) {
      $_str_rcode = 'y150105';
      $_str_msg   = 'Create table successfully';
    } else {
      $_str_rcode = 'x150105';
      $_str_msg   = 'Create table failed';
    }

    return array(
      'rcode' => $_str_rcode, //更新成功
      'msg'   => $_str_msg,
    );
  }


  /** 修改表
   * mdl_alter_table function.
   *
   * @access public
   * @return void
   */
  public function alterTable() {
    $_str_rcode = 'y150111';
    $_str_msg   = 'No need to update table';

    $_num_count  = $this->alter();

    if ($_num_count === false) {
      $_str_rcode = 'x150106';
      $_str_msg   = 'Update table failed';
    } else if ($_num_count > 0) {
      $_str_rcode = 'y150106';
      $_str_msg   = 'Update table successfully';
    }

    return array(
      'rcode' => $_str_rcode,
      'msg'   => $_str_msg,
    );
  }
}
