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

    private $create;

    function m_init() {
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


    function createTable() {
        $_num_count  = $this->create($this->create, 'mark_id', '标记');

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



    function alterTable() {
        $_arr_alter = $this->alterProcess($this->create);

        $_str_rcode = 'y140111';
        $_str_msg   = 'No need to update table';

        if (!Func::isEmpty($_arr_alter)) {
            $_num_count  = $this->alter($_arr_alter);

            if ($_num_count !== false) {
                $_str_rcode = 'y140106';
                $_str_msg   = 'Update table successfully';
            } else {
                $_str_rcode = 'x140106';
                $_str_msg   = 'Update table failed';
            }
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }
}
