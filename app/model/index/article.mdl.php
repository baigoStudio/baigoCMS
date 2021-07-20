<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\index;

use app\model\Article as Article_Base;
use ginkgo\Func;
use ginkgo\Loader;
use ginkgo\Config;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------前台文章模型-------------*/
class Article extends Article_Base {

    protected $configRoute;

    protected $whereAnd_1 = array(
        array('article_is_time_pub', '<', 1, '', '', 'OR'),
        array('article_time_pub', '<=', GK_NOW, 'now', '', 'OR'),
    );

    protected $whereAnd_2 = array(
        array('article_is_time_hide', '<', 1, '', '', 'OR'),
        array('article_time_hide', '>', GK_NOW, 'now', '', 'OR'),
    );

    protected $whereAnd_3 = array();

    function m_init() { //构造函数
        parent::m_init();

        $this->configRoute  = Config::get('route', 'index');

        if ($this->visitType == 'static') {
            $this->whereAnd_3 = array(
                array('article_is_gen', '=', 'yes', '', '', 'OR'),
                array('LENGTH(`article_link`)', '>', 0, 'article_link_length', '', 'OR'),
            );
        }
    }


    function hits($num_articleId) {
        $_arr_articleRow = $this->read($num_articleId);

        $_str_rcode = 'x020103'; //更新成功
        $_str_msg   = 'Count failed';

        if ($_arr_articleRow['rcode'] == 'y120102') {
            $_arr_update = array(
                'article_hits_all' => $_arr_articleRow['article_hits_all'] + 1,
            );

            if (!isset($_arr_articleRow['article_time_day']) || date('Y-m-d', $_arr_articleRow['article_time_day']) != date('Y-m-d')) {
                $_arr_update['article_hits_day'] = 0;
                $_arr_update['article_time_day'] = GK_NOW;
            } else {
                $_arr_update['article_hits_day'] = $_arr_articleRow['article_hits_day'] + 1;
            }

            if (!isset($_arr_articleRow['article_time_week']) || date('Y-W', $_arr_articleRow['article_time_week']) != date('Y-W')) {
                $_arr_update['article_hits_week'] = 0;
                $_arr_update['article_time_week'] = GK_NOW;
            } else {
                $_arr_update['article_hits_week'] = $_arr_articleRow['article_hits_week'] + 1;
            }

            if (!isset($_arr_articleRow['article_time_month']) || date('Y-m', $_arr_articleRow['article_time_month']) != date('Y-m')) {
                $_arr_update['article_hits_month'] = 0;
                $_arr_update['article_time_month'] = GK_NOW;
            } else {
                $_arr_update['article_hits_month'] = $_arr_articleRow['article_hits_month'] + 1;
            }

            if (!isset($_arr_articleRow['article_time_year']) || date('Y', $_arr_articleRow['article_time_year']) != date('Y')) {
                $_arr_update['article_hits_year'] = 0;
                $_arr_update['article_time_year'] = GK_NOW;
            } else {
                $_arr_update['article_hits_year'] = $_arr_articleRow['article_hits_year'] + 1;
            }

            $_num_count    = $this->where('article_id', '=', $num_articleId)->update($_arr_update);

            if ($_num_count > 0) {
                $_str_rcode = 'y120103'; //更新成功
                $_str_msg   = 'Count successful';
            }
        }

        return array(
            'article_id' => $num_articleId,
            'rcode'      => $_str_rcode,
            'msg'        => $_str_msg,
        );
    }


    public function urlProcess($arr_articleRow = array(), $arr_cateRow = array()) {
        if (Func::isEmpty($arr_articleRow['article_link'])) {
            if (!isset($arr_cateRow['cate_breadcrumb']) || !is_array($arr_cateRow['cate_breadcrumb'])) {
                $arr_cateRow['cate_breadcrumb'][0] = array();
            }

            if (isset($arr_cateRow['cate_breadcrumb'][0]['cate_prefix']) && !Func::isEmpty($arr_cateRow['cate_breadcrumb'][0]['cate_prefix'])) {
                $_str_urlPrefix = Func::fixDs($arr_cateRow['cate_breadcrumb'][0]['cate_prefix'], '/');
            } else {
                $_str_urlPrefix = $this->obj_request->baseUrl(false, $this->routeType);
            }

            $_str_articleUrl = $_str_urlPrefix . $this->configRoute['article'] . '/' . $arr_articleRow['article_url_name'];
        } else {
            $_str_articleUrl = $arr_articleRow['article_link'];
        }

        return $_str_articleUrl;
    }
}
