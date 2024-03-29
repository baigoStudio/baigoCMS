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
class Article extends Model {

  protected $pk = 'article_id';
  protected $comment = '文章';
  protected $drop = array(
    'article_tag',
    'article_content',
  );

  public $arr_status = array();
  public $arr_box    = array();
  public $arr_gen    = array();

  protected function m_init() {
    $_mdl_article = Loader::model('Article', '', false);
    $this->arr_status   = $_mdl_article->arr_status;
    $this->arr_box      = $_mdl_article->arr_box;
    $this->arr_gen      = $_mdl_article->arr_gen;

    $_str_status    = implode('\',\'', $this->arr_status);
    $_str_box       = implode('\',\'', $this->arr_box);
    $_str_gen       = implode('\',\'', $this->arr_gen);

    $this->create = array(
      'article_id' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'ai'        => true,
        'comment'   => 'ID',
      ),
      'article_cate_id' => array(
        'type'      => 'smallint(6)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '栏目ID',
      ),
      'article_title' => array(
        'type'      => 'varchar(300)',
        'not_null'  => true,
        'default'   => '',
        'comment'   => '标题',
      ),
      'article_excerpt' => array(
        'type'      => 'varchar(900)',
        'not_null'  => true,
        'default'   => '',
        'comment'   => '内容提要',
      ),
      'article_status' => array(
        'type'      => 'enum(\'' . $_str_status . '\')',
        'not_null'  => true,
        'default'   => $this->arr_status[0],
        'comment'   => '状态',
        'update'    => $this->arr_status[0],
      ),
      'article_box' => array(
        'type'      => 'enum(\'' . $_str_box . '\')',
        'not_null'  => true,
        'default'   => $this->arr_box[0],
        'comment'   => '盒子',
        'update'    => $this->arr_box[0],
      ),
      'article_is_gen' => array(
        'type'      => 'enum(\'' . $_str_gen . '\')',
        'not_null'  => true,
        'default'   => $this->arr_gen[0],
        'comment'   => '是否已生成',
        'update'    => $this->arr_gen[0],
      ),
      'article_mark_id' => array(
        'type'      => 'smallint(6)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '标记ID',
      ),
      'article_attach_id' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '附件ID',
        'old'       => 'article_upfile_id',
      ),
      'article_link' => array(
        'type'      => 'varchar(900)',
        'not_null'  => true,
        'default'   => '',
        'comment'   => '链接',
      ),
      'article_time' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '记录时间',
      ),
      'article_time_show' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '显示时间',
        'update'    => '`article_time_pub`',
      ),
      'article_is_time_pub' => array(
        'type'      => 'tinyint(1)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '是否定时上线',
      ),
      'article_time_pub' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '定时上线',
      ),
      'article_is_time_hide' => array(
        'type'      => 'tinyint(1)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '是否定时下线',
      ),
      'article_time_hide' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '定时下线',
      ),
      'article_admin_id' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '发布用户',
      ),
      'article_hits_day' => array(
        'type'      => 'mediumint(9)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '日点击',
      ),
      'article_hits_week' => array(
        'type'      => 'mediumint(9)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '周点击',
      ),
      'article_hits_month' => array(
        'type'      => 'mediumint(9)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '月点击',
      ),
      'article_hits_year' => array(
        'type'      => 'mediumint(9)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '年点击',
      ),
      'article_hits_all' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '总点击',
      ),
      'article_time_day' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '日点击重置时间',
      ),
      'article_time_week' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '周点击重置时间',
      ),
      'article_time_month' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '月点击重置时间',
      ),
      'article_time_year' => array(
        'type'      => 'int(11)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '年点击重置时间',
      ),
      'article_top' => array(
        'type'      => 'tinyint(1)',
        'not_null'  => true,
        'default'   => 0,
        'comment'   => '置顶',
      ),
      'article_tpl' => array(
        'type'      => 'varchar(1000)',
        'not_null'  => true,
        'default'   => '',
        'comment'   => '模板',
      ),
    );
  }


  /** 创建表
   * mdl_create_table function.
   *
   * @access public
   * @return void
   */
  public function createTable() {
    $_num_count  = $this->create();

    if ($_num_count !== false) {
      $_str_rcode = 'y120105';
      $_str_msg   = 'Create table successfully';
    } else {
      $_str_rcode = 'x120105';
      $_str_msg   = 'Create table failed';
    }

    return array(
      'rcode' => $_str_rcode, //更新成功
      'msg'   => $_str_msg,
    );
  }


  /** 创建索引
   * mdl_create_index function.
   *
   * @access public
   * @return void
   */
  public function createIndex() {
    $_str_rcode       = 'y120109';
    $_str_msg         = 'Create index successfully';

    $_num_count  = $this->index('order_top', array('article_top', 'article_time_pub', 'article_id'));

    if ($_num_count === false) {
      return array(
        'rcode' => 'x120117', //更新成功
        'msg'   => 'Create index failed',
      );
    }

    $_num_count  = $this->index('order_day', array('article_hits_day', 'article_time_pub', 'article_id'));

    if ($_num_count === false) {
      return array(
        'rcode' => 'x120118', //更新成功
        'msg'   => 'Create index failed',
      );
    }

    $_num_count  = $this->index('order_week', array('article_hits_week', 'article_time_pub', 'article_id'));

    if ($_num_count === false) {
      return array(
        'rcode' => 'x120119',
        'msg'   => 'Create index failed',
      );
    }

    $_num_count  = $this->index('order_month', array('article_hits_month', 'article_time_pub', 'article_id'));

    if ($_num_count === false) {
      return array(
        'rcode' => 'x120120',
        'msg'   => 'Create index failed',
      );
    }

    $_num_count  = $this->index('order_year', array('article_hits_year', 'article_time_pub', 'article_id'));

    if ($_num_count === false) {
      return array(
        'rcode' => 'x120121',
        'msg'   => 'Create index failed',
      );
    }

    $_num_count  = $this->index('order_all', array('article_hits_all', 'article_time_pub', 'article_id'));

    if ($_num_count === false) {
      return array(
        'rcode' => 'x120122',
        'msg'   => 'Create index failed',
      );
    }

    return array(
      'rcode' => $_str_rcode, //更新成功
      'msg'   => $_str_msg,
    );
  }


  /** 复制表, 主要用于将文章内容移到独立表
   * mdl_copy_table function.
   *
   * @access public
   * @return void
   */
  public function copyTable() {
    $_arr_field = $this->getFields();

    $_str_rcode = 'y120111';
    $_str_msg   = 'No need to update table';

    if (in_array('article_content', $_arr_field)) {
      $_arr_articleCreate = array(
        'article_id' => array(
          'type'      => 'int(11)',
          'not_null'  => true,
          'ai'        => true,
          'comment'   => 'ID',
          //'target'    => 'article_id',
        ),
        'article_content' => array(
          'type'      => 'text',
          'not_null'  => true,
          'default'   => '',
          'comment'   => '内容',
          //'target'    => 'article_content',
        ),
      );

      $_num_count = $this->copyTo('article_content')->copy($_arr_articleCreate, '文章内容');

      if ($_num_count > 0) {
        $_str_rcode = 'y120112'; //更新成功
        $_str_msg   = 'Copy table successfully';
      } else {
        $_str_rcode = 'x120112'; //更新成功
        $_str_msg   = 'Copy table failed';
      }
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
    $_str_rcode = 'y120111';
    $_str_msg   = 'No need to update table';

    $_num_count  = $this->alter();

    if ($_num_count === false) {
      $_str_rcode = 'x020106';
      $_str_msg   = 'Update table failed';
    } else if ($_num_count > 0) {
      $_str_rcode = 'y120106';
      $_str_msg   = 'Update table successfully';
    }

    return array(
      'rcode' => $_str_rcode,
      'msg'   => $_str_msg,
    );
  }
}
