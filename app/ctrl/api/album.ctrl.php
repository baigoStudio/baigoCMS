<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\api;

use app\classes\api\Ctrl;
use ginkgo\Loader;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------文章类-------------*/
class Album extends Ctrl {

    protected function c_init($param = array()) { //构造函数
        parent::c_init();

        $this->mdl_attach    = Loader::model('Attach');
        $this->mdl_album     = Loader::model('Album');
    }


    function read() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_albumId   = $this->obj_request->get('album_id', 'int', 0);

        if ($_num_albumId < 1) {
            return $this->fetchJson('Missing ID', 'x060202', 400);
        }

        $_arr_albumRow = $this->mdl_album->read($_num_albumId);

        if ($_arr_albumRow['rcode'] != 'y060102') {
            return $this->fetchJson($_arr_albumRow['msg'], $_arr_albumRow['rcode'], 404);
        }

        if ($_arr_albumRow['album_status'] != 'enable') {
            return $this->fetchJson('Album is invalid', 'x060102');
        }

        $_arr_attachRow = $this->mdl_attach->read($_arr_specRow['spec_attach_id']);

        $_arr_return = array(
            'albumRow'   => $_arr_albumRow,
            'attachRow'  => $_arr_attachRow,
        );

        return $this->json($_arr_return);
    }

}
