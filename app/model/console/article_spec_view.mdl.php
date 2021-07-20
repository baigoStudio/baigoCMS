<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use ginkgo\Func;
use ginkgo\Arrays;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------前台文章模型-------------*/
class Article_Spec_View extends Article {


    /**
     * mdl_list function.
     *
     * @access public
     * @param string $str_key (default: '')
     * @param string $str_year (default: '')
     * @param string $str_month (default: '')
     * @param bool $arr_cateIds (default: false)
     * @param bool $arr_markIds (default: false)
     * @param string $str_attachType (default: '')
     * @param string $str_orderType (default: '')
     * @return void
     */
    function lists($pagination = 0, $arr_search = array(), $arr_order = array(), $arr_group = array()) {
        $_arr_articleSelect = array(
            'article_id',
            'article_title',
            'article_cate_id',
            'article_excerpt',
            'article_status',
            'article_box',
            'article_link',
            'article_time',
            'article_time_show',
            'article_is_time_pub',
            'article_time_pub',
            'article_is_time_hide',
            'article_time_hide',
            'article_attach_id',
            'article_is_gen',
            'article_hits_day',
            'article_hits_week',
            'article_hits_month',
            'article_hits_year',
            'article_hits_all',
            'article_top',
        );


        if (Func::isEmpty($arr_order)) {
            $arr_order = array(
                array('article_top', 'DESC'),
                array('article_time_pub', 'DESC'),
                array('article_id', 'DESC'),
            );
        }

        if (Func::isEmpty($arr_group)) {
            $arr_group = array('article_top', 'article_time_pub', 'article_id');
        }

        $_arr_where         = $this->queryProcess($arr_search);
        $_arr_pagination    = $this->paginationProcess($pagination);
        $_arr_getData       = $this->where($_arr_where)->order($arr_order)->group($arr_group)->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'], $_arr_pagination['pageparam'])->select($_arr_articleSelect);

        if (isset($_arr_getData['dataRows'])) {
            $_arr_eachData = &$_arr_getData['dataRows'];
        } else {
            $_arr_eachData = &$_arr_getData;
        }

        if (!Func::isEmpty($_arr_eachData)) {
            foreach ($_arr_eachData as $_key=>&$_value) {
                $_value                     = $this->rowProcess($_value);
                $_value['article_customs']  = $this->mdl_articleCustom->read($_value['article_id']);
            }
        }

        return $_arr_getData;
    }


    /**
     * mdl_count function.
     *
     * @access public
     * @param string $str_key (default: '')
     * @param string $str_year (default: '')
     * @param string $str_month (default: '')
     * @param bool $arr_cateIds (default: false)
     * @param bool $arr_markIds (default: false)
     * @param string $str_attachType (default: '')
     * @param string $str_orderType (default: '')
     * @return void
     */
    function count($arr_search = array(), $arr_group = array()) {
        $_arr_where = $this->queryProcess($arr_search);

        if (Func::isEmpty($arr_group)) {
            $arr_group = array('article_top', 'article_time_pub', 'article_id');
        }

        $_num_articleCount    = $this->where($_arr_where)->group($arr_group)->count();

        return $_num_articleCount;
    }

    protected function queryProcess($arr_search = array()) {
        if (isset($arr_search['key']) && !Func::isEmpty($arr_search['key'])) {
            $_arr_where[] = array('article_title|article_id', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
        }

        if (isset($arr_search['status']) && !Func::isEmpty($arr_search['status'])) {
            $_arr_where[] = array('article_status', '=', $arr_search['status']);
        }

        if (isset($arr_search['year']) && !Func::isEmpty($arr_search['year'])) {
            $_arr_where[] = array('FROM_UNIXTIME(`article_time_pub`, \'%Y\')', '=', $arr_search['year'], 'year');
        }

        if (isset($arr_search['month']) && !Func::isEmpty($arr_search['month'])) {
            $_arr_where[] = array('FROM_UNIXTIME(`article_time_pub`, \'%m\')', '=', $arr_search['month'], 'month');
        }

        if (isset($arr_search['mark_id']) && $arr_search['mark_id'] > 0) {
            $_arr_where[] = array('article_mark_id', '=', $arr_search['mark_id']);
        }

        if (isset($arr_search['cate_ids']) && !Func::isEmpty($arr_search['cate_ids'])) {
            $arr_search['cate_ids'] = Arrays::filter($arr_search['cate_ids']);

            $_arr_where[] = array('belong_cate_id', 'IN', $arr_search['cate_ids'], 'cate_ids');
        }

        if (isset($arr_search['spec_id']) && !Func::isEmpty($arr_search['spec_id'])) {
            $_arr_where[] = array('belong_spec_id', '=', $arr_search['spec_id']);
        }

        if (isset($arr_search['spec_ids']) && !Func::isEmpty($arr_search['spec_ids'])) {
            $arr_search['spec_ids'] = Arrays::filter($arr_search['spec_ids']);

            $_arr_where[] = array('belong_spec_id', 'IN', $arr_search['spec_ids'], 'spec_ids');
        }

        if (isset($arr_search['not_in']) && !Func::isEmpty($arr_search['not_in'])) {
            $_arr_where[] = array('article_id', 'NOT IN', $arr_search['not_in']);
        }

        return $_arr_where;
    }
}
