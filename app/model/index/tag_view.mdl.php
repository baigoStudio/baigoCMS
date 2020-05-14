<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\index;

use ginkgo\Config;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------栏目模型-------------*/
class Tag_View extends Tag {

    /**
     * mdl_list function.
     *
     * @access public
     * @param string $str_status (default: '')
     * @param string $str_type (default: '')
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function lists($num_no, $num_except = 0, $arr_search = array()) {
        $_arr_tagSelect = array(
            'tag_id',
            'tag_name',
            'tag_article_count',
            'tag_status',
        );

        $_arr_where = $this->queryProcess($arr_search);

        $_arr_group = array('tag_id');

        if (isset($arr_search['type']) && $arr_search['type'] == 'tag_rank') {
            $_arr_order = array(
                array('tag_article_count', 'DESC'),
                array('tag_id', 'DESC'),
            );
        } else {
            $_arr_order = array(
                array('tag_id', 'DESC'),
            );
        }

        $_arr_tagRows = $this->where($_arr_where)->order($_arr_order)->group($_arr_group)->limit($num_except, $num_no)->select($_arr_tagSelect);

        return $_arr_tagRows;
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['article_id']) && $arr_search['article_id'] > 0) {
            $_arr_where[] = array('belong_article_id', '=', $arr_search['article_id']);
        }

        return $_arr_where;
    }
}
