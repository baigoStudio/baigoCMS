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

/*-------------栏目归属模型-------------*/
class Cate_Belong extends Model {

    private $create;

    function m_init() {
        $this->create = array(
            'belong_id' => array(
                'type'      => 'int(11)',
                'not_null'  => true,
                'ai'        => true,
                'comment'   => 'ID',
            ),
            'belong_cate_id' => array(
                'type'      => 'smallint(6)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '栏目ID',
            ),
            'belong_article_id' => array(
                'type'      => 'int(11)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '文章ID',
            ),
        );
    }

    function createTable() {
        $_num_count  = $this->create($this->create, 'belong_id', '栏目从属');

        if ($_num_count !== false) {
            $_str_rcode = 'y220105'; //更新成功
            $_str_msg   = 'Create table successfully';
        } else {
            $_str_rcode = 'x220105'; //更新成功
            $_str_msg   = 'Create table failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }


    function createIndex() {
        $_str_rcode     = 'y220109'; //更新成功
        $_str_msg       = 'Create index successfully';

        $_num_count  = $this->index('search')->create('belong_article_id');

        if ($_num_count === false) {
            $_str_rcode = 'x220109'; //更新成功
            $_str_msg   = 'Create index failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }


    function alterTable() {
        $_arr_alter = $this->alterProcess($this->create);

        $_str_rcode = 'y220111';
        $_str_msg   = 'No need to update table';

        if (!Func::isEmpty($_arr_alter)) {
            $_num_count  = $this->alter($_arr_alter);

            if ($_num_count !== false) {
                $_str_rcode = 'y220106';
                $_str_msg   = 'Update table successfully';
            } else {
                $_str_rcode = 'x220106';
                $_str_msg   = 'Update table failed';
            }
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }

}
