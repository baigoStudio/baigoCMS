<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Config;
use ginkgo\Http;
use ginkgo\Image;
use ginkgo\Ftp;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

class Gather extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->configConsole = $this->config['console'];

        if ($this->ftpOpen && !$this->ftpInit) {
            $_arr_configFtp = $this->config['var_extra']['upload'];

            $_config_ftp = array(
                'host' => $_arr_configFtp['ftp_host'],
                'port' => $_arr_configFtp['ftp_port'],
                'user' => $_arr_configFtp['ftp_user'],
                'pass' => $_arr_configFtp['ftp_pass'],
                'path' => $_arr_configFtp['ftp_path'],
                'pasv' => $_arr_configFtp['ftp_pasv'],
            );

            if (!Func::isEmpty($_config_ftp['host']) && !Func::isEmpty($_config_ftp['user']) && !Func::isEmpty($_config_ftp['pass'])) {
                $this->obj_ftp = Ftp::instance($_config_ftp);
                $this->ftpInit   = true;
            }
        }

        $this->obj_http         = Http::instance();
        $this->obj_qlist        = Loader::classes('Qlist');
        $this->mdl_cate         = Loader::model('Cate');
        $this->mdl_gsite        = Loader::model('Gsite');
        $this->mdl_article      = Loader::model('Article');

        $this->mdl_gather       = Loader::model('Gather');

        $this->generalData['status'] = $this->mdl_gather->arr_status;
    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['gather']['approve']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x280301');
        }

        $_arr_searchParam = array(
            'key'   => array('str', ''),
            'gsite' => array('int', 0),
            'cate'  => array('int', 0),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        $_arr_cateRow  = array();
        $_arr_gsiteRow = array();

        if ($_arr_search['cate'] > 0) {
            $_arr_cateRow = $this->mdl_cate->read($_arr_search['cate']);
            if (isset($_arr_cateRow['cate_id'])) {
                $_arr_search['cate_id'] = $_arr_cateRow['cate_id'];
            }
        }

        if ($_arr_search['gsite'] > 0) {
            $_arr_gsiteRow = $this->mdl_gsite->read($_arr_search['gsite']);
            if (isset($_arr_gsiteRow['gsite_id'])) {
                $_arr_search['gsite_id'] = $_arr_gsiteRow['gsite_id'];
            }
        }

        $_num_gatherCount   = $this->mdl_gather->count($_arr_search); //统计记录数
        $_arr_pageRow       = $this->obj_request->pagination($_num_gatherCount); //取得分页数据
        $_arr_gatherRows    = $this->mdl_gather->lists($this->config['var_default']['perpage'], $_arr_pageRow['except'], $_arr_search); //列出

        foreach ($_arr_gatherRows as $_key=>$_value) {
            $_arr_gatherRows[$_key]['cateRow']  = $this->mdl_cate->read($_value['gather_cate_id']);
            $_arr_gatherRows[$_key]['gsiteRow'] = $this->mdl_gsite->read($_value['gather_gsite_id']);
        }

        //print_r($_arr_gatherRows);

        $_arr_searchCate = array(
            'parent_id' => 0,
        );
        $_arr_cateRows      = $this->mdl_cate->listsTree(1000, 0, $_arr_searchCate);

        $_arr_gsiteRows     = $this->mdl_gsite->lists(1000);

        $_arr_tplData = array(
            'pageRow'       => $_arr_pageRow,
            'search'        => $_arr_search,
            'gatherRows'    => $_arr_gatherRows,
            'cateRows'      => $_arr_cateRows,
            'cateRow'       => $_arr_cateRow,
            'gsiteRow'      => $_arr_gsiteRow,
            'gsiteRows'     => $_arr_gsiteRows,
            'token'         => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_gsiteRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function show() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['gather']['approve']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x280301');
        }

        $_num_gatherId = 0;

        if (isset($this->param['id'])) {
            $_num_gatherId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        $_arr_gatherRow = $this->mdl_gather->read($_num_gatherId);

        if ($_arr_gatherRow['rcode'] != 'y280102') {
            return $this->error($_arr_gatherRow['msg'], $_arr_gatherRow['rcode']);
        }

        $_arr_cateRow   = $this->mdl_cate->read($_arr_gatherRow['gather_cate_id']);

        $_arr_tplData = array(
            'cateRow'       => $_arr_cateRow,
            'gatherRow'      => $_arr_gatherRow,
            'token'         => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_gatherRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function store() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!isset($this->groupAllow['gather']['approve']) && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x280301');
        }

        $_arr_searchParam = array(
            'enforce'   => array('str', ''),
            'all'       => array('str', ''),
            'ids'       => array('str', ''),
            'page'      => array('int', 0),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        if (Func::isEmpty($_arr_search['ids'])) {
            $_arr_search['gather_ids'] = false;
        } else {
            $_arr_search['gather_ids'] = explode(',', $_arr_search['ids']);
        }

        if ($_arr_search['enforce'] != 'enforce') {
            $_arr_search['wait'] = true;
        }

        if ($_arr_search['all'] == 'all') {
            $_arr_search['gather_ids'] = false;
        }

        $_num_gatherCount   = $this->mdl_gather->count($_arr_search);
        $_arr_pageRow       = $this->obj_request->pagination($_num_gatherCount, $this->configConsole['count_gather']); //取得分页数据

        if ($_arr_search['page'] > $_arr_pageRow['total']) {
            return $this->error('Completed storage', 'y280404');
        }

        $_arr_gatherRows    = $this->mdl_gather->lists($this->configConsole['count_gather'], $_arr_pageRow['except'], $_arr_search, 'ASC');

        $_str_jump = $this->url['route_console'] . 'gathering/store/page/' . ($_arr_pageRow['page'] + 1) . '/view/iframe/';

        if (Func::isEmpty($_arr_search['ids'])) {
            $_str_jump .= 'ids/' . $_arr_search['ids'];
        }

        if (Func::isEmpty($_arr_search['enforce'])) {
            $_str_jump .= 'enforce/' . $_arr_search['enforce'];
        }

        if (Func::isEmpty($_arr_search['all'])) {
            $_str_jump .= 'all/' . $_arr_search['all'];
        }

        $_arr_tplData = array(
            'jump'          => $_str_jump,
            'search'        => $_arr_search,
            'gatherRows'    => $_arr_gatherRows,
            'token'         => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        //print_r($_arr_gatherRows);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function storeSubmit() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['gather']['approve']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x280301');
        }

        $_arr_inputStore = $this->mdl_gather->inputStore();

        if ($_arr_inputStore['rcode'] != 'y280201') {
            return $this->fetchJson($_arr_inputStore['msg'], $_arr_inputStore['rcode']);
        }

        $_arr_gatherRow = $this->mdl_gather->read($_arr_inputStore['gather_id']);

        if ($_arr_gatherRow['rcode'] != 'y280102') {
            return $this->fetchJson($_arr_gatherRow['msg'], $_arr_gatherRow['rcode']);
        }

        if ($_arr_gatherRow['gather_article_id'] > 0 && $_arr_inputStore['enforce'] != 'enforce') {
            return $this->fetchJson('Already stored', 'x280402');
        }

        if (Func::isEmpty($_arr_gatherRow['gather_title'])) {
            return $this->fetchJson('Missing title', 'x280201');
        }

        if (isset($this->groupAllow['article']['approve']) || isset($this->adminLogged['admin_allow_cate'][$_arr_gatherRow['gather_cate_id']]['approve']) || $this->isSuper) {
            $_str_status = 'pub';
        } else {
            $_str_status = 'wait';
        }

        $this->mdl_article->inputSubmit = array(
            'article_title'         => strip_tags($_arr_gatherRow['gather_title']),
            'article_cate_id'       => $_arr_gatherRow['gather_cate_id'],
            'article_time_show'     => $_arr_gatherRow['gather_time_show'],
            'article_source'        => strip_tags($_arr_gatherRow['gather_source']),
            'article_source_url'    => $_arr_gatherRow['gather_source_url'],
            'article_author'        => strip_tags($_arr_gatherRow['gather_author']),
            'article_content'       => $_arr_gatherRow['gather_content'],
            'article_box'           => 'normal',
            'article_status'        => $_str_status,
            'article_time_pub'      => GK_NOW,
            'article_admin_id'      => $this->adminLogged['admin_id'],
        );

        $_arr_submitResult = $this->mdl_article->submit();

        if ($_arr_submitResult['article_id'] < 1) {
            return $this->fetchJson($_arr_submitResult['msg'], $_arr_submitResult['rcode']);
        }

        $_arr_gsiteRow = $this->gsiteProcess($_arr_gatherRow['gather_gsite_id']);

        if ($_arr_gsiteRow['rcode'] != 'y270102') {
            return $this->fetchJson($_arr_gsiteRow['msg'], $_arr_gsiteRow['rcode']);
        }

        $this->gatherImgs($_arr_gatherRow['gather_content'], $_arr_submitResult['article_id']);

        $_mdl_cateBelong = Loader::model('Cate_Belong');
        $_mdl_cateBelong->submit($_arr_submitResult['article_id'], $_arr_gatherRow['gather_cate_id']);

        $this->mdl_gather->inputStore['article_id'] = $_arr_submitResult['article_id'];
        $_arr_storeResult = $this->mdl_gather->store();

        return $this->fetchJson($_arr_storeResult['msg'], $_arr_storeResult['rcode']);
    }


    function delete() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['gather']['approve']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x280304');
        }

        $_arr_inputDelete = $this->mdl_gather->inputDelete();

        if ($_arr_inputDelete['rcode'] != 'y280201') {
            return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
        }

        $_arr_deleteResult = $this->mdl_gather->delete();

        $_arr_langReplace = array(
            'count' => $_arr_deleteResult['count'],
        );

        return $this->fetchJson($_arr_deleteResult['msg'], $_arr_deleteResult['rcode'], '', $_arr_langReplace);
    }


    private function gsiteProcess($gsiteId) {
        $_arr_gsiteRow = $this->mdl_gsite->read($gsiteId);

        if ($_arr_gsiteRow['rcode'] != 'y270102') {
            return $_arr_gsiteRow;
        }

        $_arr_gsiteRow = $this->mdl_gsite->selectorProcess($_arr_gsiteRow);

        $_arr_gsiteKeepTag = $this->mdl_gsite->keepTag;
        if (!Func::isEmpty($_arr_gsiteRow['gsite_keep_tag'])) {
            if (Func::isEmpty($_arr_gsiteKeepTag)) {
                $_arr_gsiteKeepTag = $_arr_gsiteRow['gsite_keep_tag'];
            } else {
                $_arr_gsiteKeepTag = array_merge($_arr_gsiteKeepTag, $_arr_gsiteRow['gsite_keep_tag']);
            }
        }

        $this->gsiteKeepTag = $_arr_gsiteKeepTag;
        $this->gsiteRow     = $_arr_gsiteRow;

        return $_arr_gsiteRow;
    }


    private function imgProcess($attachRow) {
        if ($attachRow['attach_type'] == 'image') {
            $_obj_image = Image::instance();

            //$_obj_image->quality = 99;

            if ($_obj_image->open($attachRow['attach_path'])) {
                $_obj_image->batThumb($this->thumbRows);
            }
        }

        if ($this->ftpInit) {
            if ($this->obj_ftp->init()) {
                if ($this->obj_ftp->fileUpload($attachRow['attach_path'], '/' . $attachRow['attach_url_name'], false, FTP_BINARY)) {
                    if ($attachRow['attach_type'] == 'image') {
                        $_arr_thumbs = $_obj_image->getThumbs();

                        //print_r($_arr_thumbs);

                        foreach ($_arr_thumbs as $_key=>$_value) {
                            $_str_remoteThumb = str_ireplace(GK_PATH_ATTACH, '', $_value);

                            $this->obj_ftp->fileUpload($_value, '/' . $_str_remoteThumb, false, FTP_BINARY);
                        }
                    }
                }
            }
        }
    }


    private function gatherImgs($str_content, $num_articleId) {
        $_num_attachId  = 0;
        $_arr_imgRows   = $this->obj_qlist->getImages($str_content, $this->gsiteRow['gsite_img_filter'], $this->gsiteRow['gsite_img_src']);

        if (!Func::isEmpty($_arr_imgRows)) {
            $_mdl_mime          = Loader::model('Mime');
            $_mdl_thumb         = Loader::model('Thumb');
            $_mdl_attach        = Loader::model('Attach');

            $_arr_mimeRows      = $_mdl_mime->lists(100);
            $_arr_thumbRows     = $_mdl_thumb->lists(1000);

            $_arr_mimes         = array();
            $_arr_allowMimes    = array();

            foreach ($_arr_mimeRows as $_key=>$_value) {
                $_arr_allowExts[] = strtolower($_value['mime_ext']);
                if (is_array($_value['mime_content'])) {
                    if (Func::isEmpty($_arr_allowMimes)) {
                        $_arr_allowMimes  = $_value['mime_content'];
                    } else {
                        $_arr_allowMimes  = array_merge($_arr_allowMimes, $_value['mime_content']);
                    }

                    $_arr_mimes[strtolower($_value['mime_ext'])] = $_value['mime_content'];
                }
            }

            $this->thumbRows = $_arr_thumbRows;
            $this->obj_http->setMime($_arr_mimes);

            foreach ($_arr_imgRows as $_key=>$_value) {
                $_arr_fileInfo = $this->obj_http->getRemote($_value);

                /*print_r($_arr_fileInfo);
                print_r(PHP_EOL);*/

                if ($_arr_fileInfo && isset($_arr_fileInfo['size']) && $_arr_fileInfo['size'] > 0) {
                    $_mdl_attach->inputSubmit = array(
                        'attach_name'       => $_arr_fileInfo['name'],
                        'attach_ext'        => $_arr_fileInfo['ext'],
                        'attach_mime'       => $_arr_fileInfo['mime'],
                        'attach_admin_id'   => $this->adminLogged['admin_id'],
                        'attach_size'       => $_arr_fileInfo['size'],
                        'attach_src_hash'   => md5($_value),
                    );

                    $_arr_attachResult = $_mdl_attach->submit();

                    if ($_arr_attachResult['rcode'] == 'y070101' || $_arr_attachResult['rcode'] == 'y070103') {
                        $_arr_attachPath = pathinfo($_arr_submitResult['attach_path']);

                        if ($this->obj_http->move($_arr_attachPath['dirname'], $_arr_attachPath['basename'])) {
                            $this->imgProcess($_arr_attachResult);
                            if ($_num_attachId < 1) {
                                $_num_attachId = $_arr_attachResult['attach_id'];
                            }
                            $str_content = str_ireplace($_value, $_arr_attachResult['attach_url'], $str_content);  //图片, 用新地址替换老地址
                        } else {
                            $_mdl_attach->inputReserve['attach_id'] = $_arr_attachResult['attach_id'];
                            $_mdl_attach->reserve();
                        }
                    }
                }
            }

            if ($_num_attachId > 0) {
                $this->mdl_article->inputSubmit = array(
                    'article_id'        => $num_articleId,
                    'article_content'   => $str_content,
                    'article_attach_id' => $_num_attachId,
                );

                $_arr_submitResult   = $this->mdl_article->submit();
            }
        }
    }
}
