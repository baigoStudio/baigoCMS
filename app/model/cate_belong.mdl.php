<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Arrays;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------栏目归属模型-------------*/
class Cate_Belong extends Model {

    function ids($arr_search) {
        $_arr_belongSelect = array(
            'belong_cate_id',
        );

        $_arr_where = $this->queryProcess($arr_search);

        $_arr_belongRows = $this->where($_arr_where)->select($_arr_belongSelect);

        $_arr_cateIds = array();

        foreach ($_arr_belongRows as $_key=>$_value) {
            $_arr_cateIds[]   = $_value['belong_cate_id'];
        }

        return Arrays::filter($_arr_cateIds);
    }


    /**
     * read function.
     *
     * @access public
     * @param mixed $str_belong
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function read($num_cateId = 0, $num_articleId = 0) {
        $_arr_belongSelect = array(
            'belong_id',
            'belong_cate_id',
            'belong_article_id',
        );

        $_arr_where = $this->readQueryProcess($num_cateId, $num_articleId);

        $_arr_belongRow = $this->where($_arr_where)->find($_arr_belongSelect);

        if (!$_arr_belongRow) {
            return array(
                'rcode' => 'x220102', //不存在记录
            );
        }

        $_arr_belongRow['rcode'] = 'y220102';

        return $_arr_belongRow;
    }


    function count($arr_search = array()) {
        $_arr_where = $this->queryProcess($arr_search);

        $_num_belongCount = $this->where($_arr_where)->count();

        /*print_r($_arr_userRow);
        exit;*/

        return $_num_belongCount;
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['cate_id']) && $arr_search['cate_id'] > 0) {
            $_arr_where[] = array('belong_cate_id', '=', $arr_search['cate_id']);
        }

        if (isset($arr_search['article_id']) && $arr_search['article_id'] > 0) {
            $_arr_where[] = array('belong_article_id', '=', $arr_search['article_id']);
        }

        if (isset($arr_search['min_id']) && $arr_search['min_id'] > 0) {
            $_arr_where[] = array('belong_id', '>', $arr_search['min_id'], 'min_id');
        }

        if (isset($arr_search['max_id']) && $arr_search['max_id'] > 0) {
            $_arr_where[] = array('belong_id', '<', $arr_search['max_id'], 'max_id');
        }

        return $_arr_where;
    }


    function readQueryProcess($num_cateId = 0, $num_articleId = 0) {
        $_arr_where[] = array('belong_cate_id', '=', $num_cateId);

        if ($num_articleId > 0) {
            $_arr_where[] = array('belong_article_id', '=', $num_articleId);
        }

        return $_arr_where;
    }
}
