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

/*-------------栏目模型-------------*/
class Cate extends Model {

    private $create;

    function m_init() {
        $_mdl_cate = Loader::model('Cate', '', false);
        $this->arr_status = $_mdl_cate->arr_status;
        $this->arr_pasv   = $_mdl_cate->arr_pasv;

        $_str_status    = implode('\',\'', $this->arr_status);
        $_str_pasv      = implode('\',\'', $this->arr_pasv);

        $this->create = array(
            'cate_id' => array(
                'type'      => 'smallint(6)',
                'not_null'  => true,
                'ai'        => true,
                'comment'   => 'ID',
            ),
            'cate_name' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '栏目名称',
            ),
            'cate_prefix' => array(
                'type'      => 'varchar(900)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => 'URL 前缀',
                'old'       => 'cate_domain',
            ),
            'cate_tpl' => array(
                'type'      => 'varchar(1000)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '模板',
            ),
            'cate_content' => array(
                'type'      => 'varchar(3000)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '栏目介绍',
            ),
            'cate_link' => array(
                'type'      => 'varchar(900)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '链接地址',
            ),
            'cate_parent_id' => array(
                'type'      => 'smallint(6)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '父栏目',
            ),
            'cate_alias' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '别名',
            ),
            'cate_perpage' => array(
                'type'      => 'tinyint(4)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '每页文章数',
            ),
            'cate_ftp_host' => array(
                'type'      => 'varchar(900)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '分发 FTP 地址',
            ),
            'cate_ftp_port' => array(
                'type'      => 'char(5)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => 'FTP 端口',
            ),
            'cate_ftp_user' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => 'FTP 用户名',
            ),
            'cate_ftp_pass' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => 'FTP 密码',
            ),
            'cate_ftp_path' => array(
                'type'      => 'varchar(900)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => 'FTP 目录',
            ),
            'cate_ftp_pasv' => array(
                'type'      => 'enum(\'' . $_str_pasv . '\')',
                'not_null'  => true,
                'default'   => $this->arr_pasv[0],
                'comment'   => '是否打开 PASV 模式',
                'update'    => $this->arr_pasv[0],
            ),
            'cate_status' => array(
                'type'      => 'enum(\'' . $_str_status . '\')',
                'not_null'  => true,
                'default'   => $this->arr_status[0],
                'comment'   => '状态',
                'update'    => $this->arr_status[0],
            ),
            'cate_order' => array(
                'type'      => 'smallint(6)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '排序',
            ),
        );
    }


    function createTable() {
        $_num_count  = $this->create($this->create, 'cate_id', '栏目');

        if ($_num_count !== false) {
            $_str_rcode = 'y250105'; //更新成功
            $_str_msg   = 'Create table successfully';
        } else {
            $_str_rcode = 'x250105'; //更新成功
            $_str_msg   = 'Create table failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }


    function createIndex() {
        $_str_rcode       = 'y250109';
        $_str_msg         = 'Create index successfully';

        $_num_count  = $this->index('order')->create(array('cate_order' , 'cate_id'));

        if ($_num_count === false) {
            $_str_rcode = 'x250109';
            $_str_msg   = 'Create index failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }


    function alterTable() {
        $_arr_alter = $this->alterProcess($this->create);

        $_str_rcode = 'y250111';
        $_str_msg   = 'No need to update table';

        if (!Func::isEmpty($_arr_alter)) {
            $_num_count  = $this->alter($_arr_alter);

            if ($_num_count !== false) {
                $_str_rcode = 'y250106';
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
                $_str_rcode = 'x020106';
                $_str_msg   = 'Update table failed';
            }
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }
}
