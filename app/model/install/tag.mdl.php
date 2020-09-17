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

/*-------------TAG 模型-------------*/
class Tag extends Model {

    private $create;

    function m_init() {
        $_mdl_tag = Loader::model('Tag', '', false);
        $this->arr_status = $_mdl_tag->arr_status;

        $_str_status = implode('\',\'', $this->arr_status);

        $this->create = array(
            'tag_id' => array(
                'type'      => 'int(11)',
                'not_null'  => true,
                'ai'        => true,
                'comment'   => 'ID',
            ),
            'tag_name' => array(
                'type'      => 'varchar(30)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '名称',
            ),
            'tag_status' => array(
                'type'      => 'enum(\'' . $_str_status . '\')',
                'not_null'  => true,
                'default'   => $this->arr_status[0],
                'comment'   => '状态',
            ),
            'tag_article_count' => array(
                'type'      => 'int(11)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '文章数',
            ),
            'tag_tpl' => array(
                'type'      => 'varchar(1000)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '模板',
            ),
        );
    }


    function createTable() {
        $_num_count  = $this->create($this->create, 'tag_id', '标签');

        if ($_num_count !== false) {
            $_str_rcode = 'y130105'; //更新成功
            $_str_msg   = 'Create table successfully';
        } else {
            $_str_rcode = 'x130105'; //更新成功
            $_str_msg   = 'Create table failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }


    function createIndex() {
        $_str_rcode     = 'y130109'; //更新成功
        $_str_msg       = 'Create index successfully';

        $_num_count  = $this->index('search')->create(array('tag_article_count', 'tag_id'));

        if ($_num_count === false) {
            $_str_rcode = 'x130109'; //更新成功
            $_str_msg   = 'Create index failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }


    function alterTable() {
        $_arr_alter = $this->alterProcess($this->create);

        $_str_rcode = 'y130111';
        $_str_msg   = 'No need to update table';

        if (!Func::isEmpty($_arr_alter)) {
            $_num_count  = $this->alter($_arr_alter);

            if ($_num_count !== false) {
                $_str_rcode = 'y130106';
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
                $_str_rcode = 'x130106';
                $_str_msg   = 'Update table failed';
            }
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }

}
