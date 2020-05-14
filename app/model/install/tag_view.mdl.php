<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\install;

use app\classes\install\Model;
use ginkgo\Loader;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------TAG 归属模型-------------*/
class Tag_View extends Model {

    function createView() {
        $_arr_viewCreate = array(
            array('tag.tag_id'),
            array('tag.tag_name'),
            array('tag.tag_status'),
            array('tag.tag_article_count'),
            array('tag_belong.belong_article_id'),
        );

        $_arr_join = array(
            'tag_belong',
            array('tag.tag_id', '=', 'tag_belong.belong_tag_id'),
            'LEFT',
        );

        $_num_count  = $this->viewFrom('tag')->viewJoin($_arr_join)->create($_arr_viewCreate);

        if ($_num_count !== false) {
            $_str_rcode = 'y160108'; //更新成功
            $_str_msg   = 'Create view successfully';
        } else {
            $_str_rcode = 'x160108'; //更新成功
            $_str_msg   = 'Create view failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }
}
