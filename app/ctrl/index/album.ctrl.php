<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\index;

use app\classes\index\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

class Album extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_album            = Loader::model('Album');
        $this->mdl_attachAlbumView  = Loader::model('Attach_Album_View');
    }


    function index() {
        $_mix_init = $this->indexInit();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_searchParam = array(
            'key' => array('str', ''),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        $_arr_search['status'] = 'enable';

        $_num_albumCount = $this->mdl_album->count($_arr_search); //统计记录数
        $_arr_pageRow    = $this->obj_request->pagination($_num_albumCount, $this->configVisit['perpage_album']); //取得分页数据
        $_arr_albumRows  = $this->mdl_album->lists($this->configVisit['perpage_album'], $_arr_pageRow['except'], $_arr_search); //列出

        $_mdl_attach  = Loader::model('Attach');

        foreach ($_arr_albumRows as $_key=>$_value) {
            $_arr_attachRow = $_mdl_attach->read($_value['album_attach_id']);

            if ($_arr_attachRow['rcode'] == 'y070102') {
                if (!isset($_arr_attachRow['thumb_default'])) {
                    $_arr_albumRows[$_key]['thumb_default'] = $this->url['dir_static'] . 'image/file_' . $_arr_attachRow['attach_ext'] . '.png';
                }
            } else {
                $_arr_albumRows[$_key]['thumb_default'] = '';
            }

            $_arr_albumRows[$_key]['attachRow'] = $_arr_attachRow;
            $_arr_albumRows[$_key]['album_url'] = $this->mdl_album->urlProcess($_value);
        }

        //print_r($_arr_albumRows);

        $_arr_tplData = array(
            'urlRow'     => $this->mdl_album->urlLists(),
            'pageRow'    => $_arr_pageRow,
            'search'     => $_arr_search,
            'albumRows'  => $_arr_albumRows,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function show() {
        $_mix_init = $this->indexInit();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_albumId = 0;

        //print_r($this->param);

        if (isset($this->param['id'])) {
            $_num_albumId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_albumId < 1) {
            return $this->error('Missing ID', 'x060202', 400);
        }

        $_arr_albumRow = $this->mdl_album->read($_num_albumId);

        if ($_arr_albumRow['rcode'] != 'y060102') {
            return $this->error($_arr_albumRow['msg'], $_arr_albumRow['rcode'], 404);
        }

        if ($_arr_albumRow['album_status'] != 'enable') {
            return $this->error('Album is invalid', 'x060102');
        }

        $_arr_search['album_id'] = $_num_albumId;

        $_num_attachCount  = $this->mdl_attachAlbumView->count($_arr_search); //统计记录数
        $_arr_pageRow      = $this->obj_request->pagination($_num_attachCount, $this->configVisit['perpage_in_album']); //取得分页数据
        $_arr_attachRows   = $this->mdl_attachAlbumView->lists($this->configVisit['perpage_in_album'], $_arr_pageRow['except'], $_arr_search); //列出

        foreach ($_arr_attachRows as $_key=>$_value) {
            if (!isset($_value['thumb_default'])) {
                $_arr_attachRows[$_key]['thumb_default'] = $this->url['dir_static'] . 'image/file_' . $_value['attach_ext'] . '.png';
            }
        }

        $_arr_tplData = array(
            'urlRow'        => $this->mdl_album->urlProcess($_arr_albumRow),
            'pageRow'       => $_arr_pageRow,
            'search'        => $_arr_search,
            'attachRows'    => $_arr_attachRows,
            'albumRow'      => $_arr_albumRow,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        $this->obj_view->setPath(BG_TPL_INDEX . $this->configBase['site_tpl']);

        return $this->fetch();
    }
}
