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
defined('IN_GINKGO') or exit('Access Denied');

/*-------------链接模型-------------*/
class Link extends Model {

    public $arr_status = array('enable', 'disabled');
    public $arr_type   = array('console', 'friend', 'auto');


    function check($mix_link, $str_by = 'link_id', $num_notId = 0, $num_cateId = false, $str_type = '') {
        $_arr_select = array(
            'link_id',
        );

        return $this->read($mix_link, $str_by, $num_notId, $num_cateId, $str_type, $_arr_select);
    }


    /**
     * read function.
     *
     * @access public
     * @param mixed $str_link
     * @return void
     */
    function read($mix_link, $str_by = 'link_id', $num_notId = 0, $num_cateId = false, $str_type = '', $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'link_id',
                'link_name',
                'link_url',
                'link_type',
                'link_status',
                'link_cate_id',
                'link_blank',
                'link_order',
            );
        }

        $_arr_where = $this->readQueryProcess($mix_link, $str_by, $num_notId, $num_cateId, $str_type);

        $_arr_linkRow = $this->where($_arr_where)->find($arr_select);

        if (!$_arr_linkRow) {
            return array(
                'msg'   => 'Link not found',
                'rcode' => 'x240102', //不存在记录
            );
        }

        $_arr_linkRow['rcode'] = 'y240102';
        $_arr_linkRow['msg']   = '';

        return $_arr_linkRow;
    }


    /**
     * mdl_list function.
     *
     * @access public
     * @param string $str_status (default: '')
     * @param string $str_type (default: '')
     * @return void
     */
    function lists($pagination = 0, $arr_search = array()) {
        $_arr_linkSelect = array(
            'link_id',
            'link_name',
            'link_type',
            'link_status',
            'link_url',
            'link_cate_id',
            'link_blank',
            'link_order',
        );

        $_arr_order = array(
            array('link_order', 'ASC'),
            array('link_id', 'ASC'),
        );

        $_arr_where         = $this->queryProcess($arr_search);
        $_arr_pagination    = $this->paginationProcess($pagination);
        $_arr_getData       = $this->where($_arr_where)->order($_arr_order)->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_linkSelect);

        return $_arr_getData;
    }


    function count($arr_search = array()) {

        $_arr_where = $this->queryProcess($arr_search);

        $_num_linkCount = $this->where($_arr_where)->count();

        return $_num_linkCount;
    }


    function readQueryProcess($mix_link, $str_by = 'link_id', $num_notId = 0, $num_cateId = false, $str_type = '') {
        $_arr_where[] = array($str_by, '=', $mix_link);

        if ($num_notId > 0) {
            $_arr_where[] = array('link_id', '<>', $num_notId);
        }

        if ($num_cateId !== false) {
            $_arr_where[] = array('link_cate_id', '=', $num_cateId);
        }

        if (!Func::isEmpty($str_type)) {
            $_arr_where[] = array('link_type', '=', $str_type);
        }

        return $_arr_where;
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['key']) && !Func::isEmpty($arr_search['key'])) {
            $_arr_where[] = array('link_name', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
        }

        if (isset($arr_search['type']) && !Func::isEmpty($arr_search['type'])) {
            $_arr_where[] = array('link_type', '=', $arr_search['type']);
        }

        if (isset($arr_search['status']) && !Func::isEmpty($arr_search['status'])) {
            $_arr_where[] = array('link_status', '=', $arr_search['status']);
        }

        if (isset($arr_search['cate_id'])) {
            $_arr_where[] = array('link_cate_id', '=', $arr_search['cate_id']);
        }

        if (isset($arr_search['cate_ids']) && !Func::isEmpty($arr_search['cate_ids'])) {
            $arr_search['cate_ids'] = Arrays::filter($arr_search['cate_ids']);

            $_arr_where[] = array('link_cate_id', 'IN', $arr_search['cate_ids'], 'cate_ids');
        }

        return $_arr_where;
    }
}
