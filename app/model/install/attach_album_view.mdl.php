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

/*-------------附件模型-------------*/
class Attach_Album_View extends Model {

    function createView() {
        $_arr_viewCreate = array(
            array('attach.attach_id'),
            array('attach.attach_ext'),
            array('attach.attach_name'),
            array('attach.attach_time'),
            array('attach.attach_box'),
            array('album_belong.belong_album_id'),
        );

        $_arr_join = array(
            'album_belong',
            array('attach.attach_id', '=', 'album_belong.belong_attach_id'),
            'LEFT',
        );

        $_num_count  = $this->viewFrom('attach')->viewJoin($_arr_join)->create($_arr_viewCreate);

        if ($_num_count !== false) {
            $_str_rcode = 'y070108'; //更新成功
            $_str_msg   = 'Create view successfully';
        } else {
            $_str_rcode = 'x070108'; //更新成功
            $_str_msg   = 'Create view failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }
}
