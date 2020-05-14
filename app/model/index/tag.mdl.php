<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\index;

use app\model\Tag as Tag_Base;
use ginkgo\Config;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------栏目模型-------------*/
class Tag extends Tag_Base {

    function urlProcess($arr_tagRow) {
        $_configRoute  = Config::get('route', 'index');

        $_str_urlPrefix = $this->obj_request->baseUrl() . $_configRoute['tag'] . '/';

        $_arr_urlRow = array(
            'url'           => $_str_urlPrefix,
            'url_more'      => '',
            'param'         => 'page/',
            'param_more'    => 'page/',
            'suffix'        => '',
        );

        $_arr_urlRow['url'] = $_str_urlPrefix . urlencode($arr_tagRow['tag_name']) . '/id/' . $arr_tagRow['tag_id'] . '/';

        return $_arr_urlRow;
    }
}
