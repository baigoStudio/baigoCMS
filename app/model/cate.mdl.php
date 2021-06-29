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
defined('IN_GINKGO') or exit('Access Denied');

/*-------------栏目模型-------------*/
class Cate extends Model {

    public $arr_status = array('show', 'hide');
    public $arr_pasv   = array('off', 'on');

    function m_init() { //构造函数
        parent::m_init();

        $this->configVisit  = Config::get('visit', 'var_extra');
    }


    function ids($mix_search) {
        $_arr_cateIds = array();

        if (is_array($mix_search)) {
            $_arr_cateSelect = array(
                'cate_id',
            );

            $_arr_where    = $this->queryProcess($mix_search);
            $_arr_getData  = $this->where($_arr_where)->select($_arr_cateSelect);

            foreach ($_arr_getData as $_key=>$_value) {
                $_arr_cateIds[]   = $_value['cate_id'];
            }
        } else if (is_numeric($mix_search)) {
            $_arr_search = array(
                'parent_id' => $mix_search,
            );
            $_arr_getData   = $this->listsTree($_arr_search);
            $_arr_cateIds   = $this->idsProcess($_arr_getData);
            $_arr_cateIds[] = $mix_search;
        }

        return Arrays::filter($_arr_cateIds);
    }


    function check($mix_cate, $str_by = 'cate_id', $num_notId = 0, $num_parentId = -1) {
        $_arr_select = array(
            'cate_id',
        );

        return $this->readProcess($mix_cate, $str_by, $num_notId, $num_parentId, $_arr_select);
    }


    function read($mix_cate, $str_by = 'cate_id') {
        $_arr_cateRow = $this->readProcess($mix_cate, $str_by);

        if ($_arr_cateRow['rcode'] != 'y250102') {
            return $_arr_cateRow;
        }

        return $this->rowProcess($_arr_cateRow);
    }


    function readProcess($mix_cate, $str_by = 'cate_id', $num_notId = 0, $num_parentId = -1, $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'cate_id',
                'cate_name',
                'cate_alias',
                'cate_tpl',
                'cate_content',
                'cate_link',
                'cate_parent_id',
                'cate_attach_id',
                'cate_prefix',
                'cate_status',
                'cate_perpage',
            );
        }

        $_arr_where = $this->readQueryProcess($mix_cate, $str_by, $num_notId, $num_parentId);

        $_arr_cateRow = $this->where($_arr_where)->find($arr_select);

        if (!$_arr_cateRow) {
            return array(
                'msg'   => 'Category not found',
                'rcode' => 'x250102', //不存在记录
            );
        }

        $_arr_cateRow['rcode'] = 'y250102';
        $_arr_cateRow['msg']   = '';

        return $_arr_cateRow;
    }


    function lists($pagination = 0, $arr_search = array(), $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'cate_id',
                'cate_name',
                'cate_link',
                'cate_alias',
                'cate_status',
                'cate_parent_id',
                'cate_attach_id',
                'cate_prefix',
                'cate_perpage',
            );
        }

        $_arr_order = array(
            array('cate_order', 'ASC'),
            array('cate_id', 'ASC'),
        );

        $_arr_where         = $this->queryProcess($arr_search);
        $_arr_pagination    = $this->paginationProcess($pagination);
        $_arr_getData       = $this->where($_arr_where)->order($_arr_order)->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($arr_select);

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


    function listsTree($arr_search = array(), $num_level = 1) {
        $_arr_cates = array();

        $_arr_getData  = $this->lists(array(1000, 'limit'), $arr_search);

        foreach ($_arr_getData as $_key=>$_value) {
            $_arr_cates[$_value['cate_id']]                 = $_value;

            $_arr_cates[$_value['cate_id']]['cate_level']   = $num_level;
            unset($_arr_cates[$_value['cate_id']]['cate_breadcrumb']);
            $arr_search['parent_id']                        = $_value['cate_id'];
            $_arr_cates[$_value['cate_id']]['cate_childs']  = $this->listsTree($arr_search, $num_level + 1);
        }

        return $_arr_cates;
    }


    function count($arr_search = array()) {

        $_arr_where    = $this->queryProcess($arr_search);

        $_num_cateCount = $this->where($_arr_where)->count();

        return $_num_cateCount;
    }


    function nameProcess($arr_cateRow, $ds = '/') {
        $_str_cateUrlParent = '';
        foreach ($arr_cateRow['cate_breadcrumb'] as $_key_breadcrumb=>$_value_breadcrumb) {
            if (Func::isEmpty($_value_breadcrumb['cate_alias'])) {
                $_str_cateUrlParent .= $_value_breadcrumb['cate_id'] . $ds;
            } else {
                $_str_cateUrlParent .= $_value_breadcrumb['cate_alias'] . $ds;
            }
        }

        return $_str_cateUrlParent;
    }


    function rowProcess($arr_cateRow = array()) {
        if (isset($arr_cateRow['cate_id'])) {
            $arr_cateRow['cate_breadcrumb'] = $this->breadcrumbProcess($arr_cateRow['cate_id']);
            $arr_cateRow['cate_breadcrumb'] = $this->breadcrumbSort($arr_cateRow['cate_breadcrumb']);
            $arr_cateRow['cate_url_name']   = $this->nameProcess($arr_cateRow);
            $arr_cateRow['cate_tpl_do']     = $this->tplProcess($arr_cateRow['cate_id']);

            //print_r($arr_cateRow);

            if ($arr_cateRow['cate_perpage'] < 1) {
                $arr_cateRow['cate_perpage'] = $this->configVisit['perpage_in_cate'];
            }
        }

        return $arr_cateRow;
    }


    function tplProcess($num_cateId) {
        $_str_tpl     = $this->configBase['site_tpl'];

        $_arr_cateRow = $this->readProcess($num_cateId);
        if ($_arr_cateRow['rcode'] == 'y250102' && $_arr_cateRow['cate_status'] == 'show') {
            $_str_cateTpl = $_arr_cateRow['cate_tpl'];

            if ($_str_cateTpl == '-1' && $_arr_cateRow['cate_parent_id'] > 0) {
                $_str_cateTpl = $this->tplProcess($_arr_cateRow['cate_parent_id']);
            }
        } else {
            $_str_cateTpl = $_str_tpl;
        }

        if ($_str_cateTpl == '-1') {
            $_str_cateTpl = $_str_tpl;
        } else {
            $_str_cateTpl = $_str_cateTpl;
        }
        if (Func::isEmpty($_str_cateTpl)) {
            $_str_cateTpl = $_str_tpl;
        }

        return $_str_cateTpl;
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['parent_id'])) {
            $_arr_where[] = array('cate_parent_id', '=', $arr_search['parent_id']);
        }

        if (isset($arr_search['key']) && !Func::isEmpty($arr_search['key'])) {
            $_arr_where[] = array('cate_name', 'LIKE', $arr_search['key'], 'key');
        }

        if (isset($arr_search['status']) && !Func::isEmpty($arr_search['status'])) {
            $_arr_where[] = array('cate_status', '=', $arr_search['status'], 'status');
        }

        if (isset($arr_search['not_ids']) && !Func::isEmpty($arr_search['not_ids'])) {
            $arr_search['not_ids'] = Arrays::filter($arr_search['not_ids']);

            $_arr_where[] = array('cate_id', 'NOT IN', $arr_search['not_ids'], 'not_ids');
        }

        if (isset($arr_search['cate_ids']) && !Func::isEmpty($arr_search['cate_ids'])) {
            $arr_search['cate_ids'] = Arrays::filter($arr_search['cate_ids']);

            $_arr_where[] = array('cate_id', 'IN', $arr_search['cate_ids'], 'cate_ids');
        }

        return $_arr_where;
    }


    function readQueryProcess($mix_cate, $str_by = 'cate_id', $num_notId = 0, $num_parentId = -1) {
        $_arr_where[] = array($str_by, '=', $mix_cate);

        if ($num_notId > 0) {
            $_arr_where[] = array('cate_id', '<>', $num_notId);
        }

        if ($num_parentId >= 0) {
            $_arr_where[] = array('cate_parent_id', '=', $num_parentId);
        }

        return $_arr_where;
    }


    private function breadcrumbProcess($num_cateId) {
        $_arr_cateBeadcrumb = array();
        $_arr_cateRow       = $this->readProcess($num_cateId);
        if ($_arr_cateRow['rcode'] == 'y250102' && $_arr_cateRow['cate_status'] == 'show') {
            $_arr_cateBeadcrumb[]   = $_arr_cateRow;

            if ($_arr_cateRow['cate_parent_id'] > 0) {
                $_arr_cate           = $this->breadcrumbProcess($_arr_cateRow['cate_parent_id']);

                if (Func::isEmpty($_arr_cateBeadcrumb)) {
                    $_arr_cateBeadcrumb  = $_arr_cate;
                } else {
                    $_arr_cateBeadcrumb  = array_merge($_arr_cateBeadcrumb, $_arr_cate);
                }
            }
        }

        return $_arr_cateBeadcrumb;
    }


    private function breadcrumbSort($arr_cateBeadcrumb) {
        $_arr_return = array();

        krsort($arr_cateBeadcrumb);

        foreach ($arr_cateBeadcrumb as $_key=>$_value) {
            $_arr_return[] = $_value;
        }

        return $_arr_return;
    }


    private function idsProcess($arr_cateRows) {
        $_arr_ids = array();
        foreach ($arr_cateRows as $_key=>$_value) {
            if ($_value['cate_id'] > 0) {
                $_arr_ids[] = $_value['cate_id'];
            }
            if (!Func::isEmpty($_value['cate_childs'])) {
                $_arr_cate  = $this->idsProcess($_value['cate_childs']);
                $_arr_ids   = array_replace_recursive($_arr_cate, $_arr_ids);
            }
        }

        return $_arr_ids;
    }
}
