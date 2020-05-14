<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use ginkgo\Model;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------专题模型-------------*/
class Spec_View extends Model {
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
        $_arr_specSelect = array(
            'spec_id',
            'spec_name',
            'spec_status',
        );

        $_arr_where = $this->queryProcess($arr_search);

        $_arr_specRows = $this->where($_arr_where)->order('spec_id', 'DESC')->limit($num_except, $num_no)->select($_arr_specSelect);

        return $_arr_specRows;
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['article_id']) && $arr_search['article_id'] > 0) {
            $_arr_where[] = array('belong_article_id', '=', $arr_search['article_id']);
        }

        return $_arr_where;
    }
}
