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

/*-------------专题归属模型-------------*/
class Spec_View extends Model {

    private $create;

    function createView() {
        $_arr_viewCreate = array(
            array('spec.spec_id'),
            array('spec.spec_name'),
            array('spec.spec_status'),
            array('spec.spec_attach_id'),
            array('spec_belong.belong_article_id'),
        );

        $_arr_join = array(
            array(
                'spec_belong',
                array('spec.spec_id', '=', 'spec_belong.belong_spec_id'),
                'LEFT',
            ),
        );

        $_num_count  = $this->viewFrom('spec')->viewJoin($_arr_join)->create($_arr_viewCreate);

        if ($_num_count !== false) {
            $_str_rcode = 'y230108'; //更新成功
            $_str_msg   = 'Create view successfully';
        } else {
            $_str_rcode = 'x230108'; //更新成功
            $_str_msg   = 'Create view failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }

}
