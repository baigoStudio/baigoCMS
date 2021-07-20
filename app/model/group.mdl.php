<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;
use ginkgo\Arrays;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------群组模型-------------*/
class Group extends Model {

    public $arr_status = array('enable', 'disabled');

    function check($mix_group, $str_by = 'group_id') {
        $_arr_select = array(
            'group_id',
        );

        return $this->readProcess($mix_group, $str_by, $_arr_select);
    }


    /**
     * read function.
     *
     * @access public
     * @param mixed $mix_group
     * @param string $str_by (default: 'group_id')
     * @return void
     */
    function read($mix_group, $str_by = 'group_id', $arr_select = array()) {
        $_arr_groupRow = $this->readProcess($mix_group, $str_by, $arr_select);

        if ($_arr_groupRow['rcode'] != 'y040102') {
            return $_arr_groupRow;
        }

        return $this->rowProcess($_arr_groupRow);
    }


    function readProcess($mix_group, $str_by = 'group_id', $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'group_id',
                'group_name',
                'group_note',
                'group_allow',
                'group_status',
            );
        }

        $_arr_where = $this->readQueryProcess($mix_group, $str_by);

        $_arr_groupRow = $this->where($_arr_where)->find($arr_select);

        if (!$_arr_groupRow) {
            return array(
                'msg'   => 'Group not found',
                'rcode' => 'x040102', //不存在记录
            );
        }

        $_arr_groupRow['rcode'] = 'y040102';
        $_arr_groupRow['msg']   = '';

        //print_r($_arr_groupRow);

        return $_arr_groupRow;
    }


    /**
     * mdl_list function.
     *
     * @access public
     * @param string $str_key (default: '')
     * @return void
     */
    function lists($pagination = 0, $arr_search = array()) {

        $_arr_groupSelect = array(
            'group_id',
            'group_name',
            'group_note',
            'group_status',
        );

        $_arr_where         = $this->queryProcess($arr_search);
        $_arr_pagination    = $this->paginationProcess($pagination);
        $_arr_getData       = $this->where($_arr_where)->order('group_id', 'DESC')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_groupSelect);

        return $_arr_getData;

    }


    /**
     * mdl_count function.
     *
     * @access public
     * @param string $str_key (default: '')
     * @param string $str_status (default: '')
     * @return void
     */
    function count($arr_search = array()) {
        $_arr_where = $this->queryProcess($arr_search);

        $_num_groupCount = $this->where($_arr_where)->count();

        return $_num_groupCount;
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['key']) && !Func::isEmpty($arr_search['key'])) {
            $_arr_where[] = array('group_name|group_note', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
        }

        if (isset($arr_search['status']) && !Func::isEmpty($arr_search['status'])) {
            $_arr_where[] = array('group_status', '=', $arr_search['status']);
        }

        return $_arr_where;
    }


    function readQueryProcess($mix_group, $str_by = 'group_id') {
        $_arr_where[] = array($str_by, '=', $mix_group);

        return $_arr_where;
    }


    protected function rowProcess($arr_groupRow = array()) {
        if (isset($arr_groupRow['group_allow'])) {
            $arr_groupRow['group_allow'] = Arrays::fromJson($arr_groupRow['group_allow']); //json解码
        } else {
            $arr_groupRow['group_allow'] = array();
        }

        return $arr_groupRow;
    }
}
