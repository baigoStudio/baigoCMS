<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\classes\Model;

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
    function lists($pagination = 0, $arr_search = array()) {
        $_arr_specSelect = array(
            'spec_id',
            'spec_name',
            'spec_status',
        );

        $_arr_where         = $this->queryProcess($arr_search);
        $_arr_pagination    = $this->paginationProcess($pagination);
        $_arr_getData       = $this->where($_arr_where)->order('spec_id', 'DESC')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_specSelect);

        return $_arr_getData;
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['article_id']) && $arr_search['article_id'] > 0) {
            $_arr_where[] = array('belong_article_id', '=', $arr_search['article_id']);
        }

        return $_arr_where;
    }
}
