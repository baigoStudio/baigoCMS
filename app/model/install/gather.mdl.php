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
defined('IN_GINKGO') or exit('Access Denied');

/*-------------文章模型-------------*/
class Gather extends Model {

    private $create;

    function m_init() {
        $this->create = array(
            'gather_id' => array(
                'type'      => 'int(11)',
                'not_null'  => true,
                'ai'        => true,
                'comment'   => 'ID',
            ),
            'gather_title' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '标题',
            ),
            'gather_time' => array(
                'type'      => 'int(11)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '记录时间',
            ),
            'gather_time_show' => array(
                'type'      => 'int(11)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '显示时间',
            ),
            'gather_content' => array(
                'type'      => 'text',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '内容',
            ),
            'gather_source' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '来源',
            ),
            'gather_source_url' => array(
                'type'      => 'varchar(900)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '来源 URL',
            ),
            'gather_author' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '作者',
                'old'       => 'gather_auther',
            ),
            'gather_cate_id' => array(
                'type'      => 'smallint(6)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '栏目 ID',
            ),
            'gather_article_id' => array(
                'type'      => 'int(11)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '已审核文章 ID',
            ),
            'gather_admin_id' => array(
                'type'      => 'int(11)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '发布用户 ID',
            ),
            'gather_gsite_id' => array(
                'type'      => 'int(11)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '隶属采集点 ID',
            ),
        );
    }


    /** 创建表
     * mdl_create_table function.
     *
     * @access public
     * @return void
     */
    function createTable() {
        $_num_count  = $this->create($this->create, 'gather_id', '采集');

        if ($_num_count !== false) {
            $_str_rcode = 'y280105';
            $_str_msg   = 'Create table successfully';
        } else {
            $_str_rcode = 'x280105';
            $_str_msg   = 'Create table failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }



    function alterTable() {
        $_arr_alter = $this->alterProcess($this->create);

        $_str_rcode = 'y280111';
        $_str_msg   = 'No need to update table';

        if (!Func::isEmpty($_arr_alter)) {
            $_num_count  = $this->alter($_arr_alter);

            if ($_num_count !== false) {
                $_str_rcode = 'y280106';
                $_str_msg   = 'Update table successfully';
            } else {
                $_str_rcode = 'x280106';
                $_str_msg   = 'Update table failed';
            }
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }
}
