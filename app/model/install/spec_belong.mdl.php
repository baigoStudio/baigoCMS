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

/*-------------专题归属模型-------------*/
class Spec_Belong extends Model {

    private $create;

    function m_init() {
        $this->create = array(
            'belong_id' => array(
                'type'      => 'int(11)',
                'not_null'  => true,
                'ai'        => true,
                'comment'   => 'ID',
            ),
            'belong_spec_id' => array(
                'type'      => 'smallint(6)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '专题ID',
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
        $_num_count  = $this->create($this->create, 'belong_id', '专题从属');

        if ($_num_count !== false) {
            $_arr_select = array(
                'article_id',
                'article_spec_id',
            );

            $_str_sqlSelect = $this->table('article')->where('article_spec_id', '>', 0)->fetchSql()->select($_arr_select);

            $_str_sql       = 'INSERT INTO ' . $this->getTable() . ' (`belong_spec_id`,`belong_article_id`) ' . $_str_sqlSelect;
            $this->exec($_str_sql);

            $_str_rcode = 'y230105'; //更新成功
            $_str_msg   = 'Create table successfully';
        } else {
            $_str_rcode = 'x230105'; //更新成功
            $_str_msg   = 'Create table failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }


    function createIndex() {
        $_str_rcode       = 'y230109'; //更新成功
        $_str_msg         = 'Create index successfully';

        $_num_count  = $this->index('search_article')->create('belong_article_id');

        if ($_num_count === false) {
            $_str_rcode = 'x230109'; //更新成功
            $_str_msg   = 'Create index failed';
        }

        $_num_count  = $this->index('search_spec')->create('belong_spec_id');

        if ($_num_count === false) {
            $_str_rcode = 'x230109'; //更新成功
            $_str_msg   = 'Create index failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }


    function alterTable() {
        $_arr_alter = $this->alterProcess($this->create);

        $_str_rcode = 'y230111';
        $_str_msg   = 'No need to update table';

        if (!Func::isEmpty($_arr_alter)) {
            $_num_count  = $this->alter($_arr_alter);

            if ($_num_count !== false) {
                $_str_rcode = 'y230106';
                $_str_msg   = 'Update table successfully';
            } else {
                $_str_rcode = 'x230106';
                $_str_msg   = 'Update table failed';
            }
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }
}
