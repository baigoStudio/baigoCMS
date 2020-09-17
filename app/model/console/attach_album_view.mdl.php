<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------附件模型-------------*/
class Attach_Album_View extends Attach {

    function lists($pagination = 0, $arr_search = array(), $arr_order = array(), $arr_select = array()) {
        $_arr_attachSelect = array(
            'attach_id',
            'attach_name',
            'attach_time',
            'attach_ext',
            'attach_box',
        );

        $_arr_where         = $this->queryProcess($arr_search);
        $_arr_pagination    = $this->paginationProcess($pagination);
        $_arr_getData       = $this->where($_arr_where)->order('attach_id', 'DESC')->group('attach_id')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_attachSelect);

        if (isset($_arr_getData['dataRows'])) {
            $_arr_eachData = &$_arr_getData['dataRows'];
        } else {
            $_arr_eachData = &$_arr_getData;
        }

        if (!Func::isEmpty($_arr_eachData)) {
            foreach ($_arr_eachData as $_key=>&$_value) {
                $_value                 = $this->rowProcess($_value);
                $_value['thumbRows']    = $this->thumbProcess($_value);
            }
        }

        return $_arr_getData;
    }


    function count($arr_search = array()) {
        $_arr_where = $this->queryProcess($arr_search);

        $_num_attachCount     = $this->where($_arr_where)->group('attach_id')->count();

        return $_num_attachCount;
    }


    /** 列出及统计 SQL 处理
     * sqlProcess function.
     *
     * @access private
     * @param array $arr_search (default: array())
     * @return void
     */
    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['key']) && !Func::isEmpty($arr_search['key'])) {
            $_arr_where[] = array('attach_name|attach_id', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
        }

        if (isset($arr_search['year']) && !Func::isEmpty($arr_search['year'])) {
            $_arr_where[] = array('FROM_UNIXTIME(`attach_time`, \'%Y\')', '=', $arr_search['year'], 'year');
        }

        if (isset($arr_search['month']) && !Func::isEmpty($arr_search['month'])) {
            $_arr_where[] = array('FROM_UNIXTIME(`attach_time`, \'%m\')', '=', $arr_search['month'], 'month');
        }

        if (isset($arr_search['ext']) && !Func::isEmpty($arr_search['ext'])) {
            $_arr_where[] = array('attach_ext', '=', $arr_search['ext']);
        }

        if (isset($arr_search['box']) && !Func::isEmpty($arr_search['box'])) {
            $_arr_where[] = array('attach_box', '=', $arr_search['box']);
        }

        if (isset($arr_search['album_id']) && $arr_search['album_id'] > 0) {
            $_arr_where[] = array('belong_album_id', '=', $arr_search['album_id']);
        }

        if (isset($arr_search['not_in']) && !Func::isEmpty($arr_search['not_in'])) {
            $_arr_where[] = array('attach_id', 'NOT IN', $arr_search['not_in']);
        }

        return $_arr_where;
    }
}
