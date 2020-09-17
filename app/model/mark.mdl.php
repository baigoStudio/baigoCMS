<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------标记模型-------------*/
class Mark extends Model {

    function check($mix_mark, $str_by = 'mark_id', $num_notId = 0) {
        $_arr_select = array(
            'mark_id',
        );

        return $this->read($mix_mark, $str_by, $num_notId, $_arr_select);
    }


    /**
     * read function.
     *
     * @access public
     * @param mixed $mix_mark
     * @param string $str_by (default: 'mark_id')
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function read($mix_mark, $str_by = 'mark_id', $num_notId = 0, $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'mark_id',
                'mark_name',
            );
        }

        $_arr_where = $this->readQueryProcess($mix_mark, $str_by, $num_notId);

        $_arr_markRow = $this->where($_arr_where)->find($arr_select);

        if (!$_arr_markRow) {
            return array(
                'msg'   => 'Mark not found',
                'rcode' => 'x140102', //不存在记录
            );
        }

        $_arr_markRow['rcode'] = 'y140102';
        $_arr_markRow['msg']   = '';

        return $_arr_markRow;
    }


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
        $_arr_markSelect = array(
            'mark_id',
            'mark_name',
        );

        $_arr_where         = $this->queryProcess($arr_search);
        $_arr_pagination    = $this->paginationProcess($pagination);
        $_arr_getData       = $this->where($_arr_where)->order('mark_id', 'DESC')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_markSelect);

        return $_arr_getData;
    }


    function count($arr_search = array()) {

        $_arr_where = $this->queryProcess($arr_search);

        $_num_markCount = $this->where($_arr_where)->count();

        return $_num_markCount;
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['key']) && !Func::isEmpty($arr_search['key'])) {
            $_arr_where[] = array('mark_name', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
        }

        return $_arr_where;
    }


    function readQueryProcess($mix_mark, $str_by = 'mark_id', $num_notId = 0) {
        $_arr_where[] = array($str_by, '=', $mix_mark);

        if ($num_notId > 0) {
            $_arr_where[] = array('mark_id', '<>', $num_notId);
        }

        return $_arr_where;
    }
}
