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
defined('IN_GINKGO') or exit('Access denied');

/*-------------应用归属-------------*/
class Article_Custom extends Model {

    function m_init() { //构造函数
        $_mdl_custom = Loader::model('Custom', '', false);

        $_arr_create = array(
            'article_id' => array(
                'type'      => 'int(11)',
                'not_null'  => true,
                'ai'        => true,
                'comment'   => 'ID',
            ),
        );

        $_arr_search = array(
            'status' => 'enable',
        );

        $_arr_customRows = $_mdl_custom->lists(array(1000, 'limit'), $_arr_search);

        foreach ($_arr_customRows as $_key=>$_value) {
            if ($_value['custom_size'] < 1) {
                $_value['custom_size'] = 90;
            }

            $_arr_create['custom_' . $_value['custom_id']] = array(
                'type'      => 'varchar(' . $_value['custom_size'] . ')',
                'not_null'  => true,
                'default'   => '',
                'comment'   => $_key . ' ' . $_value['custom_name'],
            );
        }

        $this->create = $_arr_create;

        $this->customRows = $_arr_customRows;
    }


    function createTable() {
        $_num_count  = $this->create($this->create, 'article_id', '自定义字段值');

        if ($_num_count !== false) {
            $_str_rcode = 'y210105'; //更新成功
            $_str_msg   = 'Create table successfully';
        } else {
            $_str_rcode = 'x210105'; //更新成功
            $_str_msg   = 'Create table failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }


    function alterTable() {
        $_arr_alter = $this->alterProcess($this->create);

        $_arr_col   = $this->show();

        foreach ($_arr_col as $_key => $_value) {
            if (!isset($this->create[$_key]) && $_key != 'article_id') {
                $_arr_alter[$_key] = array('DROP');
            }
        }

        $_str_rcode = 'y210111';
        $_str_msg   = 'No need to update table';

        if (!Func::isEmpty($_arr_alter)) {
            $_num_count  = $this->alter($_arr_alter);

            if ($_num_count !== false) {
                $_str_rcode = 'y210106';
                $_str_msg   = 'Update table successfully';
            } else {
                $_str_rcode = 'x210106';
                $_str_msg   = 'Update table failed';
            }
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }
}
