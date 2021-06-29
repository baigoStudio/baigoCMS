<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes\console;

use ginkgo\Func;
use ginkgo\Config;
use ginkgo\Request;
use ginkgo\Html;
use QL\QueryList;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

class Qlist {

    function __construct() { //构造函数
        $_arr_configUpload = Config::get('upload', 'var_extra');

        $this->obj_request  = Request::instance();

        $this->urlPrefix    = $this->obj_request->root() . GK_NAME_ATTACH . '/';

        if (!Func::isEmpty($_arr_configUpload['ftp_host']) && !Func::isEmpty($_arr_configUpload['url_prefix'])) {
            $this->urlPrefix = Func::fixDs($_arr_configUpload['url_prefix'], '/');
        }
    }


    /**
     * Func::getPic function.
     *
     * @access public
     * @param mixed $str_html
     * @return void
     */
    function getAttachIds($str_html = '') {
        $_arr_attachIds = array();

        if (!Func::isEmpty($str_html)) {
            $str_html  = Html::decode($str_html);
            $_arr_rule = array(
                'img_src'   => array('img[src*="' . $this->urlPrefix . '"]', 'src'),
            );

            $_arr_data = QueryList::Query($str_html, $_arr_rule)->getData(
                function($_item){
                    return $_item;
                }
            );

            foreach ($_arr_data as $_key=>$_value) {
                $_arr_attach    = explode('/', $_value['img_src']); //将路径转换成数组
                $_str_name      = end($_arr_attach); //得到文件名

                if (strpos($_str_name, '_')) {
                    $_arr_name  = explode('_', $_str_name); //将文件名转换成数组
                } else {
                    $_arr_name  = explode('.', $_str_name); //将文件名转换成数组
                }

                $_arr_attachIds[] = (int)$_arr_name[0]; //得到文件id
            }
        }

        if (Func::isEmpty($_arr_attachIds)) {
            $_arr_attachIds = array(0);
        }

        if (!isset($_arr_attachIds[0])) {
            $_arr_attachIds[0] = 0;
        }

        return $_arr_attachIds;
    }


    function getImages($str_html = '', $arr_filter = array(), $str_src = 'src') {
        $_arr_data      = array();
        $_arr_return    = array();

        if (!Func::isEmpty($str_html)) {
            $_arr_rule = array(
                'img_src'   => array('img', $str_src),
                //'img_html'  => array('img', 'html'),
            );

            $_arr_data = QueryList::Query($str_html, $_arr_rule)->getData(
                function($_item){
                    return $_item;
                }
            );
        }

        if (!Func::isEmpty($_arr_data)) {
            foreach ($_arr_data as $_key=>$_value) {
                if (isset($_value['img_src']) && !stristr($_value['img_src'], $this->urlPrefix)) { //有值且 URL 不属于本站
                    if (Func::isEmpty($arr_filter)) {
                        $_arr_return[] = $_value['img_src'];
                    } else {
                        foreach ($arr_filter as $_key_filter=>$_value_filter) {
                            /*print_r($_value['img_src']);
                            print_r(PHP_EOL);
                            print_r($_value_filter);
                            print_r(PHP_EOL);*/
                            if (!stristr($_value['img_src'], $_value_filter)) {
                                $_arr_return[] = $_value['img_src'];
                            }
                        }
                    }
                }
            }
        }

        return $_arr_return;
    }


    function getRemote($str_url, $arr_rule, $str_charset = 'UTF-8') {
        $_arr_data = array();

        $str_url      = Html::decode($str_url, 'url');
        $str_charset  = strtoupper(Html::decode($str_charset, 'url'));

        $_arr_data = QueryList::Query($str_url, $arr_rule, null, 'UTF-8', $str_charset)->getData(
            function($_item){
                return $_item;
            }
        );

        return $_arr_data;
    }
}
