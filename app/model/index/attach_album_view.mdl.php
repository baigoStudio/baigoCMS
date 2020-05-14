<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\index;

use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------附件模型-------------*/
class Attach_Album_View extends Attach {

    function lists($num_no, $num_except = 0, $arr_search = array()) {
        $_arr_attachSelect = array(
            'attach_id',
            'attach_name',
            'attach_time',
            'attach_ext',
            //'attach_box',
        );

        $_arr_where = $this->queryProcess($arr_search);

        $_arr_attachRows     = $this->where($_arr_where)->order('attach_id', 'DESC')->group('attach_id')->limit($num_except, $num_no)->select($_arr_attachSelect);

        foreach ($_arr_attachRows as $_key=>$_value) {
            $_value                                 = $this->rowProcess($_value);

            $_arr_attachRows[$_key]                 = $_value;
            $_arr_attachRows[$_key]['thumbRows']    = $this->thumbProcess($_value);
        }

        return $_arr_attachRows;
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
        $_arr_where[] = array('attach_box', '=', 'normal');

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

        if (isset($arr_search['album_id']) && $arr_search['album_id'] > 0) {
            $_arr_where[] = array('belong_album_id', '=', $arr_search['album_id']);
        }

        return $_arr_where;
    }
}
