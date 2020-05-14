<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;
use ginkgo\Config;
use ginkgo\Loader;
use ginkgo\Html;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------文章模型-------------*/
class Article extends Model {

    protected $mdl_articleContent;
    protected $mdl_articleCustom;

    public $arr_status  = array('pub', 'wait', 'hide');
    public $arr_box     = array('normal', 'draft', 'recycle');
    public $arr_gen     = array('not', 'yes');

    function m_init() { //构造函数
        $this->mdl_articleContent   = Loader::model('Article_Content', '', false);
        $this->mdl_articleCustom    = Loader::model('Article_Custom', '', false);
    }


    function check($num_articleId) {
        $_arr_select = array(
            'article_id',
            'article_cate_id',
        );

        $_arr_articleRow = $this->readProcess($num_articleId, $_arr_select);

        if (!$_arr_articleRow) {
            return array(
                'msg'   => 'Article not found',
                'rcode' => 'x120102',
            );
        }

        $_arr_articleRow['rcode']   = 'y120102';
        $_arr_articleRow['msg']     = '';

        return $_arr_articleRow;
    }


    function read($num_articleId) {
        $_arr_articleRow = $this->readProcess($num_articleId);

        if (!$_arr_articleRow) {
            return array(
                'msg'   => 'Article not found',
                'rcode' => 'x120102',
            );
        }

        $_arr_contentRow       = $this->mdl_articleContent->read($num_articleId);

        $_arr_articleRow = array_replace_recursive($_arr_articleRow, $_arr_contentRow);
        $_arr_articleRow['article_customs'] = $this->mdl_articleCustom->read($num_articleId);

        $_arr_articleRow['rcode']   = 'y120102';
        $_arr_articleRow['msg']     = '';

        return $this->rowProcess($_arr_articleRow);
    }


    /** 读取
     * read function.
     *
     * @access public
     * @param mixed $num_articleId
     * @return void
     */
    function readProcess($num_articleId, $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'article_id',
                'article_cate_id',
                'article_mark_id',
                'article_title',
                'article_excerpt',
                'article_status',
                'article_box',
                'article_link',
                'article_admin_id',
                'article_attach_id',
                'article_is_gen',
                'article_hits_day',
                'article_hits_week',
                'article_hits_month',
                'article_hits_year',
                'article_hits_all',
                'article_time_day',
                'article_time_week',
                'article_time_month',
                'article_time_year',
                'article_time',
                'article_time_show',
                'article_is_time_pub',
                'article_time_pub',
                'article_is_time_hide',
                'article_time_hide',
                'article_top',
            );
        }

        $_arr_articleRow = $this->where('article_id', '=', $num_articleId)->find($arr_select);

        return $_arr_articleRow;
    }


    /** 列出
     * mdl_list function.
     *
     * @access public
     * @param mixed $num_no
     * @param int $num_except (default: 0)
     * @param array $arr_search (default: array())
     * @return void
     */
    function lists($num_no, $num_except = 0, $arr_search = array(), $arr_order = array()) {
        $_arr_articleSelect = array(
            'article_id',
            'article_title',
            'article_cate_id',
            'article_excerpt',
            'article_status',
            'article_box',
            'article_link',
            'article_admin_id',
            'article_mark_id',
            'article_is_gen',
            'article_hits_day',
            'article_hits_week',
            'article_hits_month',
            'article_hits_year',
            'article_hits_all',
            'article_time',
            'article_time_show',
            'article_is_time_pub',
            'article_time_pub',
            'article_is_time_hide',
            'article_time_hide',
            'article_top',
        );

        $_arr_where = $this->queryProcess($arr_search);

        if (Func::isEmpty($arr_order)) {
            $arr_order = array(
                array('article_top', 'DESC'),
                array('article_time_pub', 'DESC'),
            );
        }

        //print_r($_arr_where);

        $_arr_articleRows = $this->where($_arr_where)->order($arr_order)->limit($num_except, $num_no)->select($_arr_articleSelect);

        foreach ($_arr_articleRows as $_key=>$_value) {
            $_arr_articleRows[$_key] = $this->rowProcess($_value);
        }

        return $_arr_articleRows;
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

        $_num_articleCount = $this->where($_arr_where)->count();

        return $_num_articleCount;
    }


    function nameProcess($arr_articleRow, $ds = '/') {
        $_arr_configVisit  = Config::get('visit', 'var_extra');

        $_str_return = date('Y', $arr_articleRow['article_time']) . $ds . date('m', $arr_articleRow['article_time']) . $ds . $arr_articleRow['article_id'];

        if ($_arr_configVisit['visit_type'] == 'static') {
            $_str_return .= '.' . $_arr_configVisit['visit_file'];
        }

        return $_str_return;
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
            $_arr_where[] = array('article_title|article_id', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
        }

        if (isset($arr_search['year']) && !Func::isEmpty($arr_search['year'])) {
            $_arr_where[] = array('FROM_UNIXTIME(`article_time_pub`, \'%Y\')', '=', $arr_search['year'], 'year');
        }

        if (isset($arr_search['month']) && !Func::isEmpty($arr_search['month'])) {
            $_arr_where[] = array('FROM_UNIXTIME(`article_time_pub`, \'%m\')', '=', $arr_search['month'], 'month');
        }

        if (isset($arr_search['status']) && !Func::isEmpty($arr_search['status'])) {
            $_arr_where[] = array('article_status', '=', $arr_search['status']);
        }

        if (isset($arr_search['box']) && !Func::isEmpty($arr_search['box'])) {
            $_arr_where[] = array('article_box', '=', $arr_search['box']);
        }

        if (isset($arr_search['mark_id']) && $arr_search['mark_id'] > 0) {
            $_arr_where[] = array('article_mark_id', '=', $arr_search['mark_id']);
        }

        if (isset($arr_search['admin_id']) && $arr_search['admin_id'] > 0) {
            $_arr_where[] = array('article_admin_id', '=', $arr_search['admin_id']);
        }

        if (isset($arr_search['article_ids']) && !Func::isEmpty($arr_search['article_ids'])) {
            $arr_search['article_ids'] = Func::arrayFilter($arr_search['article_ids']);

            $_arr_where[] = array('article_id', 'IN', $arr_search['article_ids'], 'article_ids');
        }

        if (isset($arr_search['not_ids']) && !Func::isEmpty($arr_search['not_ids'])) {
            $arr_search['not_ids'] = Func::arrayFilter($arr_search['not_ids']);

            $_arr_where[] = array('article_id', 'NOT IN', $arr_search['not_ids'], 'not_ids');
        }

        if (isset($arr_search['cate_ids']) && !Func::isEmpty($arr_search['cate_ids'])) {
            $arr_search['cate_ids'] = Func::arrayFilter($arr_search['cate_ids']);

            $_arr_where[] = array('article_cate_id', 'IN', $arr_search['cate_ids'], 'cate_ids');
        } else if (isset($arr_search['cate_id'])) {
            $_arr_where[] = array('article_cate_id', '=', $arr_search['cate_id']);
        }

        return $_arr_where;
    }


    protected function rowProcess($arr_articleRow = array()) {
        $arr_articleRow['article_url_name'] = $this->nameProcess($arr_articleRow);

        if (!isset($arr_articleRow['article_time_show'])) {
            $arr_articleRow['article_time_show'] = GK_NOW;
        }

        if (!isset($arr_articleRow['article_time_pub'])) {
            $arr_articleRow['article_time_pub'] = GK_NOW;
        }

        if (!isset($arr_articleRow['article_time_hide'])) {
            $arr_articleRow['article_time_hide'] = GK_NOW;
        }

        if (isset($arr_articleRow['article_excerpt'])) {
            $arr_articleRow['article_excerpt'] = strip_tags($arr_articleRow['article_excerpt']);
        }

        $arr_articleRow['article_time_show_format'] = $this->dateFormat($arr_articleRow['article_time_show']);

        $arr_articleRow['article_time_pub_format'] = $this->dateFormat($arr_articleRow['article_time_pub']);

        $arr_articleRow['article_time_hide_format'] = $this->dateFormat($arr_articleRow['article_time_hide']);

        return $arr_articleRow;
    }
}
