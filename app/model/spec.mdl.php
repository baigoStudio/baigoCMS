<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;
use ginkgo\Arrays;
use ginkgo\Config;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------专题模型-------------*/
class Spec extends Model {

    public $arr_status = array('show', 'hide');

    function m_init() { //构造函数
        parent::m_init();

        $this->configVisit  = Config::get('visit', 'var_extra');;
        $this->routeSpec    = Config::get('spec', 'index.route');
    }


    function ids($arr_search) {
        $_arr_select = array(
            'spec_id',
        );

        $_arr_where = $this->queryProcess($arr_search);

        $_arr_specRows  = $this->where($_arr_where)->select($_arr_select);

        $_arr_specIds = array();

        foreach ($_arr_specRows as $_key=>$_value) {
            $_arr_specIds[] = $_value['spec_id'];
        }

        return Arrays::filter($_arr_specIds);
    }


    function check($num_specId) {
        $_arr_select = array(
            'spec_id',
        );

        return $this->readProcess($num_specId, $_arr_select);
    }


    /**
     * read function.
     *
     * @access public
     * @param mixed $str_spec
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function read($num_specId, $arr_select = array()) {
        $_arr_specRow = $this->readProcess($num_specId, $arr_select);

        if ($_arr_specRow['rcode'] != 'y180102') {
            return $_arr_specRow;
        }

        return $this->rowProcess($_arr_specRow);
    }


    function readProcess($num_specId, $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'spec_id',
                'spec_name',
                'spec_status',
                'spec_content',
                'spec_tpl',
                'spec_attach_id',
                'spec_time',
                'spec_time_update',
            );
        }

        $_arr_where = $this->readQueryProcess($num_specId);

        $_arr_specRow = $this->where($_arr_where)->find($arr_select);

        if (!$_arr_specRow) {
            return array(
                'msg'   => 'Topic not found',
                'rcode' => 'x180102', //不存在记录
            );
        }

        $_arr_specRow['rcode'] = 'y180102';
        $_arr_specRow['msg']   = '';

        return $_arr_specRow;
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
        $_arr_specSelect = array(
            'spec_id',
            'spec_name',
            'spec_status',
            'spec_attach_id',
            'spec_time',
            'spec_time_update',
        );

        $_arr_where         = $this->queryProcess($arr_search);
        $_arr_pagination    = $this->paginationProcess($pagination);
        $_arr_getData       = $this->where($_arr_where)->order('spec_id', 'DESC')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_specSelect);

        if (isset($_arr_getData['dataRows'])) {
            $_arr_eachData = &$_arr_getData['dataRows'];
        } else {
            $_arr_eachData = &$_arr_getData;
        }

        if (!Func::isEmpty($_arr_eachData)) {
            foreach ($_arr_eachData as $_key=>&$_value) {
                $_value = $this->rowProcess($_value);
            }
        }

        return $_arr_getData;
    }


    function count($arr_search = array()) {

        $_arr_where = $this->queryProcess($arr_search);

        return $this->where($_arr_where)->count();
    }


    function pagination($arr_search = array(), $perpage = 0, $current = 'get', $pageparam = 'page', $pergroup = 0) {

        $_arr_where = $this->queryProcess($arr_search);

        return $this->where($_arr_where)->pagination($perpage, $current, $pageparam, $pergroup);
    }


    function nameProcess($arr_specRow, $ds = '/') {
        $_str_return = date('Y', $arr_specRow['spec_time']) . $ds . date('m', $arr_specRow['spec_time']) . $ds . $arr_specRow['spec_id'] . $ds;

        return $_str_return;
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['key']) && !Func::isEmpty($arr_search['key'])) {
            $_arr_where[] = array('spec_name', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
        }

        if (isset($arr_search['status']) && !Func::isEmpty($arr_search['status'])) {
            $_arr_where[] = array('spec_status', '=', $arr_search['status']);
        }

        if (isset($arr_search['period']) && $arr_search['period'] > 0) {
            $_arr_where[] = array('spec_time_update', '>=', GK_NOW - $arr_search['period']);
        }

        if (isset($arr_search['spec_ids']) && !Func::isEmpty($arr_search['spec_ids'])) {
            $arr_search['spec_ids'] = Arrays::filter($arr_search['spec_ids']);

            $_arr_where[] = array('spec_id', 'IN', $arr_search['spec_ids'], 'spec_ids');
        }

        return $_arr_where;
    }


    function readQueryProcess($num_specId) {
        $_arr_where = array('spec_id', '=', $num_specId);

        return $_arr_where;
    }


    protected function rowProcess($arr_specRow = array()) {
        if (!isset($arr_specRow['spec_time'])) {
            $arr_specRow['spec_time'] = GK_NOW;
        }

        if (!isset($arr_specRow['spec_time_update'])) {
            $arr_specRow['spec_time_update'] = GK_NOW;
        }

        $arr_specRow['spec_url_name']           = $this->nameProcess($arr_specRow);
        $arr_specRow['spec_time_format']        = $this->dateFormat($arr_specRow['spec_time']);
        $arr_specRow['spec_time_update_format'] = $this->dateFormat($arr_specRow['spec_time_update']);

        return $arr_specRow;
    }
}
