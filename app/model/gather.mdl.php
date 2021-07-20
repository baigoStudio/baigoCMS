<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;
use ginkgo\Arrays;
use ginkgo\Html;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------文章模型-------------*/
class Gather extends Model {

    public $arr_status  = array('wait', 'store');

    function check($mix_gather, $str_by = 'gather_id') {
        $_arr_select = array(
            'gather_id',
        );

        return $this->readProcess($mix_gather, $str_by, $_arr_select);
    }


    /** 读取
     * read function.
     *
     * @access public
     * @param mixed $num_gatherId
     * @return void
     */
    function read($mix_gather, $str_by = 'gather_id', $arr_select = array()) {
        $_arr_gatherRow = $this->readProcess($mix_gather, $str_by, $arr_select);

        if ($_arr_gatherRow['rcode'] != 'y280102') {
            return $_arr_gatherRow;
        }

        return $this->rowProcess($_arr_gatherRow);
    }


    function readProcess($mix_gather, $str_by = 'gather_id', $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'gather_id',
                'gather_title',
                'gather_time',
                'gather_time_show',
                'gather_content',
                'gather_source',
                'gather_source_url',
                'gather_author',
                'gather_admin_id',
                'gather_article_id',
                'gather_cate_id',
                'gather_gsite_id',
            );
        }

        $_arr_where = $this->readQueryProcess($mix_gather, $str_by);

        $_arr_gatherRow = $this->where($_arr_where)->find($arr_select);

        if (!$_arr_gatherRow) {
            return array(
                'msg'   => 'Data not found',
                'rcode' => 'x280102',
            );
        }

        $_arr_gatherRow['rcode']    = 'y280102';
        $_arr_gatherRow['msg']      = '';

        return $_arr_gatherRow;
    }


    /** 列出
     * mdl_list function.
     *
     * @access public
     * @param array $arr_search (default: array())
     * @return void
     */
    function lists($pagination = 0, $arr_search = array()) {
        $_arr_gatherSelect = array(
            'gather_id',
            'gather_title',
            'gather_time',
            'gather_time_show',
            'gather_source',
            'gather_source_url',
            'gather_admin_id',
            'gather_article_id',
            'gather_cate_id',
            'gather_gsite_id',
        );

        $_arr_where         = $this->queryProcess($arr_search);
        $_arr_pagination    = $this->paginationProcess($pagination);
        $_arr_getData       = $this->where($_arr_where)->order('gather_id', 'DESC')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_gatherSelect);

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


    /** 统计
     * mdl_count function.
     *
     * @access public
     * @param array $arr_search (default: array())
     * @return void
     */
    function count($arr_search = array()) {
        $_arr_where = $this->queryProcess($arr_search);

        return $this->where($_arr_where)->count();
    }


    function pagination($arr_search = array(), $perpage = 0, $current = 'get', $pageparam = 'page', $pergroup = 0) {

        $_arr_where = $this->queryProcess($arr_search);

        return $this->where($_arr_where)->pagination($perpage, $current, $pageparam, $pergroup);
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
            $_arr_where[] = array('gather_title|gather_source', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
        }

        if (isset($arr_search['year']) && !Func::isEmpty($arr_search['year'])) {
            $_arr_where[] = array('FROM_UNIXTIME(`gather_time_show`, \'%Y\')', '=', $arr_search['year'], 'year');
        }

        if (isset($arr_search['month']) && !Func::isEmpty($arr_search['month'])) {
            $_arr_where[] = array('FROM_UNIXTIME(`gather_time_show`, \'%m\')', '=', $arr_search['month'], 'month');
        }

        if (isset($arr_search['cate_id']) && $arr_search['cate_id'] > 0) {
            $_arr_where[] = array('gather_cate_id', '=', $arr_search['cate_id']);
        }

        if (isset($arr_search['gsite_id']) && $arr_search['gsite_id'] > 0) {
            $_arr_where[] = array('gather_gsite_id', '=', $arr_search['gsite_id']);
        }

        if (isset($arr_search['wait'])) {
            $_arr_where[] = array('gather_article_id', '=', 0);
        }

        if (isset($arr_search['admin_id']) && $arr_search['admin_id'] > 0) {
            $_arr_where[] = array('gather_admin_id', '=', $arr_search['admin_id']);
        }

        if (isset($arr_search['gather_ids']) && !Func::isEmpty($arr_search['gather_ids'])) {
            $arr_search['gather_ids'] = Arrays::filter($arr_search['gather_ids']);

            $_arr_where[] = array('gather_id', 'IN', $arr_search['gather_ids'], 'gather_ids');
        }

        if (isset($arr_search['not_ids']) && !Func::isEmpty($arr_search['not_ids'])) {
            $arr_search['not_ids'] = Arrays::filter($arr_search['not_ids']);

            $_arr_where[] = array('gather_id', 'NOT IN', $arr_search['not_ids'], 'not_ids');
        }

        return $_arr_where;
    }


    function readQueryProcess($mix_gather, $str_by = 'gather_id') {
        $_arr_where = array($str_by, '=', $mix_gather);

        return $_arr_where;
    }


    protected function rowProcess($arr_gatherRow = array()) {
        if (!isset($arr_gatherRow['gather_source_url'])) {
            $arr_gatherRow['gather_source_url'] = '';
        }

        if (!isset($arr_gatherRow['gather_time_show'])) {
            $arr_gatherRow['gather_time_show'] = GK_NOW;
        }

        if (!isset($arr_gatherRow['gather_article_id'])) {
            $arr_gatherRow['gather_article_id'] = 0;
        }

        $arr_gatherRow['gather_source_url']    = Func::safe($arr_gatherRow['gather_source_url']);

        $arr_gatherRow['gather_time_show_format'] = $this->dateFormat($arr_gatherRow['gather_time_show']);

        if ($arr_gatherRow['gather_article_id'] > 0) {
            $arr_gatherRow['gather_status'] = 'store';
        } else {
            $arr_gatherRow['gather_status'] = 'wait';
        }

        return $arr_gatherRow;
    }
}
