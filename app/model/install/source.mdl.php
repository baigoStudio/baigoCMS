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

/*-------------来源模型-------------*/
class Source extends Model {

    private $create;

    function m_init() {
        $this->create = array(
            'source_id' => array(
                'type'      => 'smallint',
                'not_null'  => true,
                'ai'        => true,
                'comment'   => 'ID',
            ),
            'source_name' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '来源名称',
            ),
            'source_author' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '作者',
                'old'       => 'source_auther',
            ),
            'source_url' => array(
                'type'      => 'varchar(900)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '来源 URL',
            ),
            'source_note' => array(
                'type'      => 'varchar(30)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '备注',
            ),
        );
    }


    function createTable() {
        $_num_count  = $this->create($this->create, 'source_id', '来源');

        if ($_num_count !== false) {
            $_str_rcode = 'y260105'; //更新成功
            $_str_msg   = 'Create table successfully';
        } else {
            $_str_rcode = 'x260105'; //更新成功
            $_str_msg   = 'Create table failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }


    function alterTable() {
        $_arr_alter = $this->alterProcess($this->create);

        $_str_rcode = 'y260111';
        $_str_msg   = 'No need to update table';

        if (!Func::isEmpty($_arr_alter)) {
            $_num_count  = $this->alter($_arr_alter);

            if ($_num_count !== false) {
                $_str_rcode = 'y260106';
                $_str_msg   = 'Update table successfully';
            } else {
                $_str_rcode = 'x260106';
                $_str_msg   = 'Update table failed';
            }
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }
}
