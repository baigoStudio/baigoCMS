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

/*-------------调用模型-------------*/
class Call extends Model {

    private $create;

    function m_init() {
        $_mdl_call = Loader::model('Call', '', false);
        $this->arr_status = $_mdl_call->arr_status;
        $this->arr_type   = $_mdl_call->arr_type;
        $this->arr_attach = $_mdl_call->arr_attach;
        $this->arr_file   = $_mdl_call->arr_file;

        $_str_status    = implode('\',\'', $this->arr_status);
        $_str_type      = implode('\',\'', $this->arr_type);
        $_str_attach    = implode('\',\'', $this->arr_attach);
        $_str_file      = implode('\',\'', $this->arr_file);

        $this->create = array(
            'call_id' => array(
                'type'      => 'smallint(6)',
                'not_null'  => true,
                'ai'        => true,
                'comment'   => 'ID',
            ),
            'call_name' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '调用名',
            ),
            'call_cate_ids' => array(
                'type'      => 'varchar(1000)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '栏目ID',
            ),
            'call_cate_excepts' => array(
                'type'      => 'varchar(1000)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '排除栏目',
            ),
            'call_cate_id' => array(
                'type'      => 'smallint(6)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '栏目ID',
            ),
            'call_spec_ids' => array(
                'type'      => 'varchar(1000)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '专题ID',
            ),
            'call_mark_ids' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '标记ID',
            ),
            'call_amount' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '显示数选项',
            ),
            'call_type' => array(
                'type'      => 'enum(\'' . $_str_type . '\')',
                'not_null'  => true,
                'default'   => $this->arr_type[0],
                'comment'   => '调用类型',
                'update'    => $this->arr_type[0],
            ),
            'call_file' => array(
                'type'      => 'enum(\'' . $_str_file . '\')',
                'not_null'  => true,
                'default'   => $this->arr_file[0],
                'comment'   => '静态页面类型',
                'update'    => $this->arr_file[0],
            ),
            'call_attach' => array(
                'type'      => 'enum(\'' . $_str_attach . '\')',
                'not_null'  => true,
                'default'   => $this->arr_attach[0],
                'comment'   => '含有附件',
                'old'       => 'call_upfile',
                'update'    => $this->arr_attach[0],
            ),
            'call_status' => array(
                'type'      => 'enum(\'' . $_str_status . '\')',
                'not_null'  => true,
                'default'   => $this->arr_status[0],
                'comment'   => '状态',
                'update'    => $this->arr_status[0],
            ),
            'call_tpl' => array(
                'type'      => 'varchar(1000)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '模板',
            ),
            'call_period' => array(
                'type'      => 'int(11)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '时间范围',
            ),
        );
    }


    function createTable() {
        $_num_count  = $this->create($this->create, 'call_id', '调用');

        if ($_num_count !== false) {
            $_str_rcode = 'y170105'; //更新成功
            $_str_msg   = 'Create table successfully';
        } else {
            $_str_rcode = 'x170105'; //更新成功
            $_str_msg   = 'Create table failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }


    function alterTable() {
        $_arr_alter = $this->alterProcess($this->create);

        $_str_rcode = 'y170111';
        $_str_msg   = 'No need to update table';

        if (!Func::isEmpty($_arr_alter)) {
            $_num_count  = $this->alter($_arr_alter);

            if ($_num_count !== false) {
                $_str_rcode = 'y170106';
                $_str_msg   = 'Update table successfully';

                foreach ($this->create as $_key=>$_value) {
                    if (isset($_value['update'])) {
                        $_arr_data = array(
                            $_key => $_value['update'],
                        );
                        $this->where('LENGTH(`' . $_key . '`) < 1')->update($_arr_data);
                    }
                }
            } else {
                $_str_rcode = 'x170106';
                $_str_msg   = 'Update table failed';
            }
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }
}
