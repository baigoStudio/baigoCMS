<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Arrays;
use ginkgo\Ftp;
use ginkgo\Http;
use ginkgo\Image;
use ginkgo\Plugin;
use ginkgo\File;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

class Article extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->configPrefer     = $this->config['console']['var_prefer'];

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
        $this->obj_index        = Loader::classes('Index', '', false);

        $this->mdl_admin        = Loader::model('Admin');
        $this->mdl_mark         = Loader::model('Mark');
        $this->mdl_source       = Loader::model('Source');
        $this->mdl_custom       = Loader::model('Custom');
        $this->mdl_cate         = Loader::model('Cate');
        $this->mdl_attach       = Loader::model('Attach');

        $this->mdl_tag          = Loader::model('Tag');
        $this->mdl_tagView      = Loader::model('Tag_View');

        $this->mdl_spec         = Loader::model('Spec');
        $this->mdl_specView     = Loader::model('Spec_View');

        $this->mdl_cateBelong   = Loader::model('Cate_Belong');
        $this->mdl_tagBelong    = Loader::model('Tag_Belong');
        $this->mdl_specBelong   = Loader::model('Spec_Belong');
        $this->mdl_gather       = Loader::model('Gather');

        $this->mdl_article      = Loader::model('Article');

        $this->generalData['status']        = $this->mdl_article->arr_status;
        $this->generalData['box']           = $this->mdl_article->arr_box;
        $this->generalData['status_gen']    = $this->mdl_article->arr_gen;

    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_searchParam = array(
            'key'       => array('str', ''),
            'box'       => array('str', 'normal'),
            'status'    => array('str', ''),
            'year'      => array('str', ''),
            'month'     => array('str', ''),
            'admin'     => array('int', 0),
            'mark'      => array('int', 0),
            'cate'      => array('int', 0),
        );

        $_arr_search = $this->obj_request->param($_arr_searchParam);

        if ($this->isSuper || isset($this->groupAllow['article']['browse'])) {
            $_arr_search['admin_id'] = $_arr_search['admin'];
        } else {
            $_arr_search['admin_id'] = $this->adminLogged['admin_id'];
        }

        $_arr_cateRow = array();

        if ($_arr_search['cate'] > 0) {
            $_arr_cateRow            = $this->mdl_cate->read($_arr_search['cate']);
            if (isset($_arr_cateRow['cate_id'])) {
                $_arr_search['cate_ids'] = $this->mdl_cate->ids($_arr_cateRow['cate_id']);
            }
        } else if ($_arr_search['cate'] < 0) {
            $_arr_search['cate_id']  = $_arr_search['cate'];
        } else {
            $_arr_search['cate_ids'] = false;
        }

        $_arr_adminRow = array();

        if ($_arr_search['admin'] > 0) {
            $_arr_adminRow           = $this->mdl_admin->read($_arr_search['admin']);
            if (isset($_arr_adminRow['admin_id'])) {
                $_arr_search['admin_id'] = $_arr_adminRow['admin_id'];
            }
        }

        $_arr_markRow = array();

        if ($_arr_search['mark'] > 0) {
            $_arr_markRow           = $this->mdl_mark->read($_arr_search['mark']);
            if (isset($_arr_markRow['mark_id'])) {
                $_arr_search['mark_id'] = $_arr_markRow['mark_id'];
            }
        }

        $_arr_getData       = $this->mdl_article->lists($this->config['var_default']['perpage'], $_arr_search); //列出

        foreach ($_arr_getData['dataRows'] as $_key=>&$_value) {
            $_value['cateRow']     = $this->mdl_cate->read($_value['article_cate_id']);
            $_value['markRow']     = $this->mdl_mark->read($_value['article_mark_id']);
            $_value['adminRow']    = $this->mdl_admin->read($_value['article_admin_id']);
        }

        $_arr_articleCount['all']  = $this->mdl_article->count();

        $_arr_searchDraft = array(
            'box'       => 'draft',
            'admin_id'  => $_arr_search['admin_id'],
        );
        $_arr_searchRecycle = array(
            'box'       => 'recycle',
            'admin_id'  => $_arr_search['admin_id'],
        );
        $_arr_articleCount['draft']     = $this->mdl_article->count($_arr_searchDraft);
        $_arr_articleCount['recycle']   = $this->mdl_article->count($_arr_searchRecycle);

        $_arr_searchCate = array(
            'status'    => 'show',
            'parent_id' => 0,
        );

        $_arr_articleYear   = $this->mdl_article->year();
        $_arr_cateRows      = $this->mdl_cate->listsTree($_arr_searchCate);
        $_arr_markRows      = $this->mdl_mark->lists(array(1000, 'limit'));

        $_arr_tplData = array(
            'pageRow'       => $_arr_getData['pageRow'],
            'articleRows'   => $_arr_getData['dataRows'],
            'search'        => $_arr_search,
            'cateRow'       => $_arr_cateRow,
            'markRow'       => $_arr_markRow,
            'adminRow'      => $_arr_adminRow,
            'cateRows'      => $_arr_cateRows,
            'markRows'      => $_arr_markRows, //标记列表
            'articleCount'  => $_arr_articleCount,
            'articleYear'   => $_arr_articleYear,
            'token'         => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function simple() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_articleId = 0;

        if (isset($this->param['id'])) {
            $_num_articleId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_articleId < 1) {
            return $this->error('Missing ID', 'x120202');
        }

        $_arr_articleRow = $this->mdl_article->read($_num_articleId);

        if ($_arr_articleRow['rcode'] != 'y120102') {
            return $this->error($_arr_articleRow['msg'], $_arr_articleRow['rcode']);
        }

        if (!isset($this->groupAllow['article']['browse']) && !isset($this->adminLogged['admin_allow_cate'][$_arr_articleRow['article_cate_id']]['browse']) && $_arr_articleRow['article_admin_id'] != $this->adminLogged['admin_id'] && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x120301');
        }

        $_arr_search['parent_id']  = 0;

        $_arr_cateRows      = $this->mdl_cate->listsTree($_arr_search); //列出
        $_arr_markRows      = $this->mdl_mark->lists(array(1000, 'limit'));

        $_arr_tplData = array(
            'articleRow'    => $_arr_articleRow,
            'markRows'      => $_arr_markRows,
            'cateRows'      => $_arr_cateRows,
            'token'         => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function simpleSubmit() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_arr_inputSimple = $this->mdl_article->inputSimple();

        if ($_arr_inputSimple['rcode'] != 'y120201') {
            return $this->fetchJson($_arr_inputSimple['msg'], $_arr_inputSimple['rcode']);
        }

        //验证文章
        $_arr_articleRow = $this->mdl_article->read($_arr_inputSimple['article_id']);

        if ($_arr_articleRow['rcode'] != 'y120102') {
            return $this->fetchJson($_arr_articleRow['msg'], $_arr_articleRow['rcode']);
        }

        //验证栏目
        if ($_arr_inputSimple['article_cate_id'] > 0) {
            $_arr_cateRow = $this->mdl_cate->check($_arr_inputSimple['article_cate_id']);

            if ($_arr_cateRow['rcode'] != 'y250102') {
                return $this->fetchJson($_arr_cateRow['msg'], $_arr_cateRow['rcode']);
            }
        }

        if (!isset($this->groupAllow['article']['edit']) && !isset($this->adminLogged['admin_allow_cate'][$_arr_inputSimple['article_cate_id']]['edit']) && !$this->isSuper) {
            return $this->fetchJson('You do not have permission', 'x120303');
        }

        //根据权限设定文章状态
        if (!isset($this->groupAllow['article']['approve']) && !isset($this->adminLogged['admin_allow_cate'][$_arr_inputSimple['article_cate_id']]['approve']) && !$this->isSuper) {
            $this->mdl_article->inputSimple['article_status'] = 'wait';
        }

        $_is_move = false;

        if ($_arr_articleRow['article_cate_id'] != $_arr_inputSimple['article_cate_id']) {
            $_arr_moveBelongResult = $this->mdl_cateBelong->move($_arr_inputSimple['article_id'], $_arr_articleRow['article_cate_id'], $_arr_inputSimple['article_cate_id']);

            if ($_arr_moveBelongResult['rcode'] == 'y220103') {
                $_is_move = true;
            }
        }

        //提交数据
        $_arr_simpleResult   = $this->mdl_article->simple();

        if ($_arr_simpleResult['rcode'] == 'x120103') {
            if ($_is_move) {
                $_arr_simpleResult['rcode']   = 'y120103';
                $_arr_simpleResult['msg']     = 'Update article successfully';
            }
        }

        return $this->fetchJson($_arr_simpleResult['msg'], $_arr_simpleResult['rcode']);
    }


    function show() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_articleId = 0;

        if (isset($this->param['id'])) {
            $_num_articleId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_articleId < 1) {
            return $this->error('Missing ID', 'x120202');
        }

        $_arr_articleRow = $this->mdl_article->read($_num_articleId);

        if ($_arr_articleRow['rcode'] != 'y120102') {
            return $this->error($_arr_articleRow['msg'], $_arr_articleRow['rcode']);
        }

        if (!isset($this->groupAllow['article']['browse']) && !isset($this->adminLogged['admin_allow_cate'][$_arr_articleRow['article_cate_id']]['browse']) && $_arr_articleRow['article_admin_id'] != $this->adminLogged['admin_id'] && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x120301');
        }

        $_arr_searchCate['article_id']          = $_arr_articleRow['article_id'];
        $_arr_articleRow['article_cate_ids']    = $this->mdl_cateBelong->ids($_arr_searchCate);
        $_arr_articleRow['article_cate_ids'][]  = $_arr_articleRow['article_cate_id'];

        $_arr_articleRow['article_cate_ids'] = Arrays::filter($_arr_articleRow['article_cate_ids']);

        if (count($_arr_articleRow['article_cate_ids']) > 1) {
            $_arr_articleRow['cate_ids_check'] = 1;
        } else {
            $_arr_articleRow['cate_ids_check'] = 0;
        }

        $_arr_cateRow   = $this->mdl_cate->read( $_arr_articleRow['article_cate_id']);
        $_arr_markRow   = $this->mdl_mark->read( $_arr_articleRow['article_mark_id']);
        $_arr_attachRow = $this->mdl_attach->read($_arr_articleRow['article_attach_id']);

        $_arr_searchTag = array(
            'status'        => 'show',
            'article_id'    => $_arr_articleRow['article_id'],
        );
        $_arr_tagRows = $this->mdl_tagView->lists(array(10, 'limit'), $_arr_searchTag);

        $_arr_articleRow['article_tags'] = array();

        foreach ($_arr_tagRows as $_key=>$_value) {
            $_arr_articleRow['article_tags'][]  = $_value['tag_name'];
        }

        $_arr_searchSpec = array(
            'article_id'    => $_arr_articleRow['article_id'],
        );
        $_arr_specRows = $this->mdl_specView->lists(array(1000, 'limit'), $_arr_searchSpec);

        $_arr_search['parent_id']  = 0;

        $_arr_customRows    = $this->mdl_custom->listsTree($_arr_search);
        $_arr_cateRows      = $this->mdl_cate->listsTree($_arr_search); //列出

        $_arr_tplData = array(
            'articleRow'    => $_arr_articleRow,
            'attachRow'     => $_arr_attachRow,
            'cateRow'       => $_arr_cateRow,
            'markRow'       => $_arr_markRow,
            'specRows'      => $_arr_specRows,
            'customRows'    => $_arr_customRows,
            'cateRows'      => $_arr_cateRows,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function form() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_articleId = 0;
        $_num_gatherId  = 0;

        if (isset($this->param['id'])) {
            $_num_articleId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if (isset($this->param['gather'])) {
            $_num_gatherId = $this->obj_request->input($this->param['gather'], 'int', 0);
        }

        $_arr_search['parent_id']  = 0;

        $_arr_cateRows      = $this->mdl_cate->listsTree($_arr_search); //列出
        if (Func::isEmpty($_arr_cateRows)) {
            return $this->error('Category has not created', 'x250401');
        }

        $_arr_specRows = array();

        if ($_num_articleId > 0) {
            $_arr_articleRow = $this->mdl_article->read($_num_articleId);

            if ($_arr_articleRow['rcode'] != 'y120102') {
                return $this->error($_arr_articleRow['msg'], $_arr_articleRow['rcode']);
            }

            if (!isset($this->groupAllow['article']['edit']) && !isset($this->adminLogged['admin_allow_cate'][$_arr_articleRow['article_cate_id']]['edit']) && $_arr_articleRow['article_admin_id'] != $this->adminLogged['admin_id'] && !$this->isSuper) { //判断权限
                return $this->error('You do not have permission', 'x1203013');
            }

            $_arr_searchCate['article_id']          = $_arr_articleRow['article_id'];
            $_arr_articleRow['article_cate_ids']    = $this->mdl_cateBelong->ids($_arr_searchCate);
            $_arr_articleRow['article_cate_ids'][]  = $_arr_articleRow['article_cate_id'];

            $_arr_searchTag = array(
                'status'        => 'show',
                'article_id'    => $_arr_articleRow['article_id'],
            );
            $_arr_tagRows = $this->mdl_tagView->lists(array(10, 'limit'), $_arr_searchTag);

            $_arr_articleRow['article_tags'] = array();

            foreach ($_arr_tagRows as $_key=>$_value) {
                $_arr_articleRow['article_tags'][]  = $_value['tag_name'];
            }

            $_arr_searchSpec = array(
                'article_id'    => $_arr_articleRow['article_id'],
            );
            $_arr_specRows = $this->mdl_specView->lists(array(1000, 'limit'), $_arr_searchSpec);

            $_arr_attachRow = $this->mdl_attach->read($_arr_articleRow['article_attach_id']);
        } else {
            if (isset($this->groupAllow['article']['approve']) || $this->isSuper) {
                $_str_status = 'pub';
            } else {
                $_str_status = 'wait';
            }

            $_arr_articleRow = array(
                'article_id'                => 0,
                'article_title'             => '',
                'article_status'            => $_str_status,
                'article_box'               => $this->mdl_article->arr_box[0],
                'article_content'           => '',
                'article_excerpt'           => '',
                'article_cate_id'           => -1,
                'article_mark_id'           => -1,
                'article_attach_id'         => 0,
                'article_is_time_pub'       => 0,
                'article_is_time_hide'      => 0,
                'article_time_show_format'  => $this->mdl_article->dateFormat(),
                'article_time_pub_format'   => $this->mdl_article->dateFormat(),
                'article_time_hide_format'  => $this->mdl_article->dateFormat(),
                'article_source'            => '',
                'article_source_url'        => '',
                'article_author'            => '',
                'article_link'              => '',
                'article_tpl'               => '',
                'article_tags'              => array(),
                'article_customs'           => array(),
                'article_cate_ids'          => array(),
                'article_is_gen'            => $this->mdl_article->arr_gen[0],
                'article_top'               => 0,
            );

            if ($_num_gatherId > 0) {
                $_arr_gatherRow = $this->mdl_gather->read($_num_gatherId);

                if ($_arr_gatherRow['rcode'] == 'y280102') {
                    $_arr_articleRow['article_title']       = $_arr_gatherRow['gather_title'];
                    $_arr_articleRow['article_content']     = $_arr_gatherRow['gather_content'];
                    $_arr_articleRow['article_cate_id']     = $_arr_gatherRow['gather_cate_id'];
                    $_arr_articleRow['article_time_show']   = $_arr_gatherRow['gather_time_show'];
                    $_arr_articleRow['article_source']      = $_arr_gatherRow['gather_source'];
                    $_arr_articleRow['article_source_url']  = $_arr_gatherRow['gather_source_url'];
                    $_arr_articleRow['article_author']      = $_arr_gatherRow['gather_author'];
                }
            }

            $_arr_attachRow = array(
                'attach_thumb' => '',
            );
        }

        if (Func::isEmpty($_arr_articleRow['article_excerpt'])) {
            if (isset($this->adminLogged['admin_prefer']['excerpt']['type']) && !Func::isEmpty($this->adminLogged['admin_prefer']['excerpt']['type'])) {
                $_arr_articleRow['article_excerpt_type'] = $this->adminLogged['admin_prefer']['excerpt']['type'];
            } else {
                $_arr_articleRow['article_excerpt_type'] = $this->configPrefer['excerpt']['type'];
            }
        } else {
            $_arr_articleRow['article_excerpt_type'] = 'manual';
        }

        $_arr_articleRow['article_cate_ids'] = Arrays::filter($_arr_articleRow['article_cate_ids']);

        if (count($_arr_articleRow['article_cate_ids']) > 1) {
            $_arr_articleRow['cate_ids_check'] = 1;
        } else {
            $_arr_articleRow['cate_ids_check'] = 0;
        }

        $_arr_markRows      = $this->mdl_mark->lists(array(1000, 'limit'));
        $_arr_sourceRows    = $this->mdl_source->lists(array(1000, 'limit'));
        $_arr_customRows    = $this->mdl_custom->listsTree($_arr_search);

        $_arr_sourceJson = array();

        foreach ($_arr_sourceRows as $_key=>$_value) {
            $_arr_sourceJson[$_value['source_id']] = $_value;
        }

        $_arr_articleRow['article_tags_json'] = Arrays::toJson($_arr_articleRow['article_tags']);

        $_arr_tplRows  = File::instance()->dirList(BG_TPL_ARTICLE);

        foreach ($_arr_tplRows as $_key=>$_value) {
            $_arr_tplRows[$_key]['name_s'] = basename($_value['name'], GK_EXT_TPL);
        }

        $_arr_tplData = array(
            'tplRows'       => $_arr_tplRows,
            'attachRow'     => $_arr_attachRow,
            'articleRow'    => $_arr_articleRow,
            'specRows'      => $_arr_specRows,
            'cateRows'      => $_arr_cateRows,
            'markRows'      => $_arr_markRows,
            'customRows'    => $_arr_customRows,
            'sourceRows'    => $_arr_sourceRows,
            'sourceJson'    => Arrays::toJson($_arr_sourceJson),
            'token'         => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function submit() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if ($this->obj_request->checkDuplicate()) {
            return $this->fetchJson('Do not submit again', 'x120201');
        }

        $_arr_inputSubmit = $this->mdl_article->inputSubmit();

        if ($_arr_inputSubmit['rcode'] != 'y120201') {
            return $this->fetchJson($_arr_inputSubmit['msg'], $_arr_inputSubmit['rcode']);
        }

        //验证 tag 数量
        if (count($_arr_inputSubmit['article_tags']) > $this->configVisit['count_tag']) {
            return $this->fetchJson('Up to {:tag_count} tags', 'x120201');
        }

        //验证栏目
        if ($_arr_inputSubmit['article_cate_id'] > 0) {
            $_arr_cateRow = $this->mdl_cate->check($_arr_inputSubmit['article_cate_id']);

            if ($_arr_cateRow['rcode'] != 'y250102') {
                return $this->fetchJson($_arr_cateRow['msg'], $_arr_cateRow['rcode']);
            }
        }

        $_arr_cateIds = array();
        $_arr_tagIds  = array();
        $_arr_specIds = array();

        //栏目 ID 预处理
        $_arr_searchCate = array(
            'cate_ids' => $_arr_inputSubmit['article_cate_ids'],
        );
        $_arr_inputSubmit['article_cate_ids'] = $this->mdl_cate->ids($_arr_searchCate);

        //专题 ID 预处理
        if (!Func::isEmpty($_arr_inputSubmit['article_spec_ids'])) {
            $_arr_searchSpec = array(
                'spec_ids' => $_arr_inputSubmit['article_spec_ids'],
            );

            $_arr_specIds = $this->mdl_spec->ids($_arr_searchSpec);
        }

        if ($_arr_inputSubmit['article_id'] > 0) {
            if (!isset($this->groupAllow['article']['edit']) && !isset($this->adminLogged['admin_allow_cate'][$_arr_inputSubmit['article_cate_id']]['edit']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x120303');
            }

            //验证栏目权限
            foreach ($_arr_inputSubmit['article_cate_ids'] as $_key=>$_value) {
                if (isset($this->adminLogged['admin_allow_cate'][$_value]['edit']) || isset($this->groupAllow['article']['edit']) || $this->isSuper) {
                    $_arr_cateIds[] = $_value;
                }
            }
        } else {
            //print_r($_arr_inputSubmit);

            if (!isset($this->groupAllow['article']['add']) && !isset($this->adminLogged['admin_allow_cate'][$_arr_inputSubmit['article_cate_id']]['add']) && !$this->isSuper) {
                return $this->fetchJson('You do not have permission', 'x120302');
            }

            //验证栏目权限
            foreach ($_arr_inputSubmit['article_cate_ids'] as $_key=>$_value) {
                if (isset($this->adminLogged['admin_allow_cate'][$_value]['add']) || isset($this->groupAllow['article']['add']) || $this->isSuper) {
                    $_arr_cateIds[] = $_value;
                }
            }
        }

        //摘要截取字数
        if (isset($this->adminLogged['admin_prefer']['excerpt']['count']) && !Func::isEmpty($this->adminLogged['admin_prefer']['excerpt']['count'])) {
            $_num_excerptCount = $this->adminLogged['admin_prefer']['excerpt']['count'];
        } else {
            $_num_excerptCount = $this->configPrefer['excerpt']['count'];
        }

        //截取摘要
        switch ($_arr_inputSubmit['article_excerpt_type']) {
            case 'auto':
                $_str_articleExcerpt = strip_tags($_arr_inputSubmit['article_content']);
                $this->mdl_article->inputSubmit['article_excerpt'] = mb_substr($_str_articleExcerpt, 0, $_num_excerptCount);
            break;

            case 'none':
                $this->mdl_article->inputSubmit['article_excerpt'] = '';
            break;
        }

        //根据权限设定文章状态
        if (!isset($this->groupAllow['article']['approve']) && !isset($this->adminLogged['admin_allow_cate'][$_arr_inputSubmit['article_cate_id']]['approve']) && !$this->isSuper) {
            $this->mdl_article->inputSubmit['article_status'] = 'wait';
        }

        if ($_arr_inputSubmit['article_attach_id'] < 1) {
            //解析图片
            $_arr_attachIds = $this->obj_qlist->getAttachIds($_arr_inputSubmit['article_content']);

            if ($_arr_attachIds[0] > 0) {
                $this->mdl_article->inputSubmit['article_attach_id'] = $_arr_attachIds[0];
                $_arr_inputSubmit['article_attach_id'] = $_arr_attachIds[0]; // 供后续远程抓取图片用
            }
        }

        //提交数据
        $this->mdl_article->inputSubmit['article_admin_id'] = $this->adminLogged['admin_id'];

        $_arr_submitResult   = $this->mdl_article->submit();

        if ($_arr_submitResult['article_id'] < 1) {
            return $this->fetchJson($_arr_submitResult['msg'], $_arr_submitResult['rcode']);
        }

        $this->gatherImgs($_arr_inputSubmit['article_content'], $_arr_submitResult['article_id'], $_arr_inputSubmit['article_attach_id']);

        //提交成功，处理关联数据
        foreach ($_arr_inputSubmit['article_tags'] as $_key=>$_value) { //处理 tag
            $_arr_tagRow = $this->mdl_tag->read($_value, 'tag_name');

            if ($_arr_tagRow['rcode'] == 'y130102') {
                $_arr_tagIds[]      = $_arr_tagRow['tag_id'];
            } else {
                $this->mdl_tag->inputSubmit = array(
                    'tag_name'      => $_value,
                    'tag_status'    => 'show',
                );
                $_arr_tagResult = $this->mdl_tag->submit();
                if ($_arr_tagResult['rcode'] == 'y130101') {
                    $_arr_tagIds[]  = $_arr_tagResult['tag_id'];
                }
            }
        }

        $_is_submit = $this->belongProcess($_arr_submitResult['article_id'], $_arr_cateIds, $_arr_tagIds, $_arr_specIds, $_arr_inputSubmit['article_id']);

        if ($_arr_submitResult['rcode'] != 'y120101' && $_arr_submitResult['rcode'] != 'y120103') {
            if ($_is_submit) {
                $_arr_submitResult['rcode'] = 'y120103';
                $_arr_submitResult['msg']   = 'Update article successfully';
            }
        }

        $this->obj_request->setDuplicate();

        $_arr_submitResult['msg'] = $this->obj_lang->get($_arr_submitResult['msg']);

        return $this->json($_arr_submitResult);
    }


    function attach() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_num_articleId = 0;

        if (isset($this->param['id'])) {
            $_num_articleId = $this->obj_request->input($this->param['id'], 'int', 0);
        }

        if ($_num_articleId < 1) {
            return $this->error('Missing ID', 'x120202');
        }

        $_arr_articleRow = $this->mdl_article->read($_num_articleId);

        if ($_arr_articleRow['rcode'] != 'y120102') {
            return $this->error($_arr_articleRow['msg'], $_arr_articleRow['rcode']);
        }

        if (!isset($this->groupAllow['article']['edit']) && !isset($this->adminLogged['admin_allow_cate'][$_arr_articleRow['article_cate_id']]['edit']) && $_arr_articleRow['article_admin_id'] != $this->adminLogged['admin_id'] && !$this->isSuper) { //判断权限
            return $this->error('You do not have permission', 'x120301');
        }

        $_arr_search = array(
            'box'           => 'normal',
            'attach_ids'    => $this->obj_qlist->getAttachIds($_arr_articleRow['article_content']),
        );

        if ($_arr_articleRow['article_attach_id'] > 0) {
            $_arr_search['attach_ids'][] = $_arr_articleRow['article_attach_id'];
        }

        $_arr_attachRows   = $this->mdl_attach->lists(array(1000, 'limit'), $_arr_search); //列出

        foreach ($_arr_attachRows as $_key=>&$_value) {
            $_value['adminRow'] = $this->mdl_admin->read($_value['attach_admin_id']);
        }

        $_arr_cateRow   = $this->mdl_cate->read($_arr_articleRow['article_cate_id']);
        $_arr_markRow   = $this->mdl_mark->read($_arr_articleRow['article_mark_id']);
        $_arr_attachRow = $this->mdl_attach->read($_arr_articleRow['article_attach_id']);

        $_arr_tplData = array(
            'ids'           => implode(',', $_arr_search['attach_ids']),
            'cateRow'       => $_arr_cateRow,
            'markRow'       => $_arr_markRow,
            'articleRow'    => $_arr_articleRow,
            'attachRows'    => $_arr_attachRows,
            'attachRow'     => $_arr_attachRow,
            'token'         => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function cover() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_arr_inputCover = $this->mdl_article->inputCover();

        if ($_arr_inputCover['rcode'] != 'y120201') {
            return $this->fetchJson($_arr_inputCover['msg'], $_arr_inputCover['rcode']);
        }

        if (!isset($this->groupAllow['article']['edit']) && !isset($this->adminLogged['admin_allow_cate'][$_arr_articleRow['article_cate_id']]['edit']) && !$this->isSuper) {
            return $this->fetchJson('You do not have permission', 'x120303');
        }

        $_arr_attachRow = $this->mdl_attach->check($_arr_inputCover['attach_id']);

        if ($_arr_attachRow['rcode'] != 'y070102') {
            return $this->fetchJson($_arr_attachRow['msg'], $_arr_attachRow['rcode']);
        }

        $_arr_coverResult   = $this->mdl_article->cover();

        return $this->fetchJson($_arr_coverResult['msg'], $_arr_coverResult['rcode']);
    }


    function move() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_arr_inputMove = $this->mdl_article->inputMove();

        if ($_arr_inputMove['rcode'] != 'y120201') {
            return $this->fetchJson($_arr_inputMove['msg'], $_arr_inputMove['rcode']);
        }

        $_arr_cateRow = $this->mdl_cate->check($_arr_inputMove['cate_id']);

        if ($_arr_cateRow['rcode'] != 'y250102') {
            return $this->fetchJson($_arr_cateRow['msg'], $_arr_cateRow['rcode']);
        }

        $_arr_allowIds     = $this->allowIdsProcess('edit');

        $_is_move   = false;
        $_num_count = 0;

        if (!Func::isEmpty($_arr_inputMove['article_ids'])) {
            foreach ($_arr_inputMove['article_ids'] as $_key=>$_value) {
                $_arr_articleRow = $this->mdl_article->read($_num_articleId);

                if ($_arr_articleRow['rcode'] == 'y120102') {
                    $_arr_moveBelongResult = $this->mdl_cateBelong->move($_value, $_arr_articleRow['article_cate_id'], $_arr_inputMove['cate_id'], $_arr_allowIds['cate_ids']);

                    if ($_arr_moveBelongResult['rcode'] == 'y220103') {
                        $_is_move = true;
                        ++$_num_count;
                    }
                }
            }
        }

        $_arr_moveResult   = $this->mdl_article->move($_arr_allowIds['cate_ids'], $_arr_allowIds['admin_id']);

        if ($_arr_moveResult['rcode'] == 'x120103') {
            if ($_is_move) {
                $_arr_moveResult['rcode']   = 'y120103';
                $_arr_moveResult['count']   = $_num_count;
                $_arr_moveResult['msg']     = 'Successfully updated {:count} articles';
            }
        }

        $_arr_langReplace = array(
            'count' => $_arr_moveResult['count'],
        );

        return $this->fetchJson($_arr_moveResult['msg'], $_arr_moveResult['rcode'], '', $_arr_langReplace);
    }


    function box() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_arr_inputBox = $this->mdl_article->inputStatus();

        if ($_arr_inputBox['rcode'] != 'y120201') {
            return $this->fetchJson($_arr_inputBox['msg'], $_arr_inputBox['rcode']);
        }

        $_arr_allowIds   = $this->allowIdsProcess('edit');

        $_arr_return = array(
            'article_ids'      => $_arr_inputBox['article_ids'],
            'article_status'   => $_arr_inputBox['act'],
        );

        Plugin::listen('action_console_article_box', $_arr_return);

        $_arr_boxResult = $this->mdl_article->box($_arr_allowIds['cate_ids'], $_arr_allowIds['admin_id']);

        $_arr_langReplace = array(
            'count' => $_arr_boxResult['count'],
        );

        return $this->fetchJson($_arr_boxResult['msg'], $_arr_boxResult['rcode'], '', $_arr_langReplace);
    }


    function status() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_arr_inputStatus = $this->mdl_article->inputStatus();

        if ($_arr_inputStatus['rcode'] != 'y120201') {
            return $this->fetchJson($_arr_inputStatus['msg'], $_arr_inputStatus['rcode']);
        }

        $_arr_allowIds   = $this->allowIdsProcess('approve');

        $_arr_return = array(
            'article_ids'      => $_arr_inputStatus['article_ids'],
            'article_status'   => $_arr_inputStatus['act'],
        );

        Plugin::listen('action_console_article_status', $_arr_return); //删除链接时触发

        $_arr_statusResult = $this->mdl_article->status($_arr_allowIds['cate_ids'], $_arr_allowIds['admin_id']);

        $_arr_langReplace = array(
            'count' => $_arr_statusResult['count'],
        );

        return $this->fetchJson($_arr_statusResult['msg'], $_arr_statusResult['rcode'], '', $_arr_langReplace);
    }


    function emptyRecycle() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if ($this->isSuper) {
            $_num_adminId = 0;
        } else {
            $_num_adminId = $this->adminLogged['admin_id'];
        }

        $_arr_search = array(
            'box'       => 'recycle',
            'admin_id'  => $_num_adminId,
        );

        $_arr_attachRows       = $this->mdl_article->lists(array(1000, 'limit'), $_arr_search);

        $_arr_articleIds    = array();

        foreach ($_arr_attachRows as $_key=>$_value) {
            $this->mdl_cateBelong->delete(0, $_value['article_id']);
            $this->mdl_tagBelong->delete(0, $_value['article_id']);
            $this->mdl_specBelong->delete(0, $_value['article_id']);
            $_arr_articleIds[] = $_value['article_id'];
        }

        $this->mdl_article->inputDelete['article_ids'] = Arrays::filter($_arr_articleIds);

        $_arr_emptyResult = $this->mdl_article->delete(false, $_num_adminId, 'recycle');

        $_arr_langReplace = array(
            'count' => $_arr_emptyResult['count'],
        );

        return $this->fetchJson($_arr_emptyResult['msg'], $_arr_emptyResult['rcode'], '', $_arr_langReplace);
    }


    function delete() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        $_arr_inputDelete = $this->mdl_article->inputDelete();

        if ($_arr_inputDelete['rcode'] != 'y120201') {
            return $this->fetchJson($_arr_inputDelete['msg'], $_arr_inputDelete['rcode']);
        }

        $_arr_allowIds   = $this->allowIdsProcess('delete');

        $_arr_return = array(
            'article_ids'      => $_arr_inputDelete['article_ids'],
        );

        Plugin::listen('action_console_article_delete', $_arr_return); //删除链接时触发

        $_arr_deleteResult = $this->mdl_article->delete($_arr_allowIds['cate_ids'], $_arr_allowIds['admin_id']);

        $_arr_langReplace = array(
            'count' => $_arr_deleteResult['count'],
        );

        return $this->fetchJson($_arr_deleteResult['msg'], $_arr_deleteResult['rcode'], '', $_arr_langReplace);
    }


    function clear() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            return $this->fetchJson('Access denied', '', 405);
        }

        if (!isset($this->groupAllow['article']['edit']) && !$this->isSuper) { //判断权限
            return $this->fetchJson('You do not have permission', 'x120303');
        }

        $_arr_inputClear = $this->mdl_article->inputClear();

        if ($_arr_inputClear['rcode'] != 'y120201') {
            return $this->fetchJson($_arr_inputClear['msg'], $_arr_inputClear['rcode']);
        }

        $_num_maxId = $_arr_inputClear['max_id'];

        $_arr_search = array(
            'max_id' => $_arr_inputClear['max_id'],
        );

        $_arr_getData   = $this->mdl_article->clear(array(10, 'post'), $_arr_search);

        if (Func::isEmpty($_arr_getData['dataRows'])) {
            $_str_status    = 'complete';
            $_str_msg       = 'Complete';
        } else {
            $_arr_articleRow = end($_arr_getData['dataRows']);
            $_str_status    = 'loading';
            $_str_msg       = 'Submitting';
            $_num_maxId     = $_arr_articleRow['article_id'];
        }

        $_arr_return = array(
            'msg'       => $this->obj_lang->get($_str_msg),
            'count'     => $_arr_getData['pageRow']['total'],
            'max_id'    => $_num_maxId,
            'status'    => $_str_status,
        );

        return $this->json($_arr_return);
    }


    private function belongProcess($num_articleId = 0, $arr_cateIds = array(), $arr_tagIds = array(), $arr_specIds = array(), $is_edit = 0) {
        $_is_submit = false;

        $arr_cateIds    = Arrays::filter($arr_cateIds);
        $arr_tagIds     = Arrays::filter($arr_tagIds);
        $arr_specIds    = Arrays::filter($arr_specIds);

        if ($is_edit > 0) {
            if (Func::isEmpty($arr_cateIds)) {
                $_num_count = $this->mdl_cateBelong->delete(0, $num_articleId);
            } else {
                $_num_count = $this->mdl_cateBelong->delete(0, $num_articleId, false, false, $arr_cateIds);
            }
            if ($_num_count > 0) {
                $_is_submit = true;
            }
            if (Func::isEmpty($arr_tagIds)) {
                $_num_count  = $this->mdl_tagBelong->delete(0, $num_articleId);
            } else {
                $_num_count  = $this->mdl_tagBelong->delete(0, $num_articleId, false, false, $arr_tagIds);
            }
            if ($_num_count > 0) {
                $_is_submit = true;
            }
            if (Func::isEmpty($arr_specIds)) {
                $_num_count = $this->mdl_specBelong->delete(0, $num_articleId);
            } else {
                $_num_count = $this->mdl_specBelong->delete(0, $num_articleId, false, false, $arr_specIds);
            }
            if ($_num_count > 0) {
                $_is_submit = true;
            }
        }

        //print_r($arr_cateIds);

        if (!Func::isEmpty($arr_cateIds)) {
            foreach ($arr_cateIds as $_key=>$_value) {
                if (!Func::isEmpty($_value)) {
                    $_arr_cateBelongRow = $this->mdl_cateBelong->submit($num_articleId, $_value);
                    if ($_arr_cateBelongRow['rcode'] == 'y220101' || $_arr_cateBelongRow['rcode'] == 'y220103') {
                        $_is_submit = true;
                    }
                }
            }
        }

        if (!Func::isEmpty($arr_tagIds)) {
            foreach ($arr_tagIds as $_key=>$_value) {
                if (!Func::isEmpty($_value)) {
                    $_arr_tagBelongRow = $this->mdl_tagBelong->submit($num_articleId, $_value);
                    if ($_arr_tagBelongRow['rcode'] == 'y160101' || $_arr_tagBelongRow['rcode'] == 'y160103') {
                        $_is_submit = true;
                    }
                }
            }
        }

        //print_r($arr_specIds);

        if (!Func::isEmpty($arr_specIds)) {
            foreach ($arr_specIds as $_key=>$_value) {
                if (!Func::isEmpty($_value)) {
                    $_arr_specBelongRow = $this->mdl_specBelong->submit($num_articleId, $_value);
                    if ($_arr_specBelongRow['rcode'] == 'y230101' || $_arr_specBelongRow['rcode'] == 'y230103') {
                        $_is_submit = true;
                    }
                }
            }
        }

        return $_is_submit;
    }


    private function allowIdsProcess($type = 'approve') {
        if (isset($this->groupAllow['article'][$type]) || $this->isSuper) {
            $_allowIds = array(
                'cate_ids'  => false,
                'admin_id'  => 0,
            );
        } else {
            if (!Func::isEmpty($this->adminLogged['admin_allow_cate'])) {
                foreach ($this->adminLogged['admin_allow_cate'] as $_key=>$_value) {
                    if (isset($_value[$type])) {
                        $_allowIds[] = $_key;
                    }
                }
            }

            $_allowIds = array(
                'cate_ids'  => $_allowIds,
                'admin_id'  => $this->adminLogged['admin_id'],
            );
        }

        return $_allowIds;
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
            if ($this->obj_ftp->fileUpload($attachRow['attach_path'], '/' . $attachRow['attach_url_name'], false)) {
                if ($attachRow['attach_type'] == 'image') {
                    $_arr_thumbs = $_obj_image->getThumbs();

                    //print_r($_arr_thumbs);

                    foreach ($_arr_thumbs as $_key=>$_value) {
                        $_str_remoteThumb = str_ireplace(GK_PATH_ATTACH, '', $_value);

                        $this->obj_ftp->fileUpload($_value, '/' . $_str_remoteThumb, false);
                    }
                }
            }
        }
    }


    private function gatherImgs($str_content, $num_articleId, $num_attachId = 0) {
        $_arr_imgRows   = $this->obj_qlist->getImages($str_content);

        if (!Func::isEmpty($_arr_imgRows) && $num_articleId > 0) {
            $_mdl_mime          = Loader::model('Mime');

            $_arr_mimeRows      = $_mdl_mime->cache();
            $this->obj_http->setMime($_arr_mimeRows);

            $this->thumbRows = $this->mdl_attach->thumbRows;;

            foreach ($_arr_imgRows as $_key=>$_value) {
                $_arr_fileInfo = $this->obj_http->getRemote($_value);

                /*print_r($_arr_fileInfo);
                print_r(PHP_EOL);*/

                if ($_arr_fileInfo && isset($_arr_fileInfo['size']) && $_arr_fileInfo['size'] > 0) {
                    $this->mdl_attach->inputSubmit = array(
                        'attach_name'       => $_arr_fileInfo['name'],
                        'attach_note'       => $_arr_fileInfo['name'],
                        'attach_ext'        => $_arr_fileInfo['ext'],
                        'attach_mime'       => $_arr_fileInfo['mime'],
                        'attach_size'       => $_arr_fileInfo['size'],
                        'attach_box'        => 'normal',
                        'attach_admin_id'   => $this->adminLogged['admin_id'],
                    );

                    $_arr_attachResult = $this->mdl_attach->submit();

                    if ($_arr_attachResult['rcode'] == 'y070101') {
                        $_arr_attachPath = pathinfo($_arr_attachResult['attach_path']);

                        if ($this->obj_http->move($_arr_attachPath['dirname'], $_arr_attachPath['basename'])) {
                            $this->imgProcess($_arr_attachResult);
                            if ($num_attachId < 1) {
                                $num_attachId = $_arr_attachResult['attach_id'];
                            }

                            $str_content = str_ireplace($_value, $_arr_attachResult['attach_url'], $str_content);  //图片, 用新地址替换老地址
                        } else {
                            $this->mdl_attach->inputReserve['attach_id'] = $_arr_attachResult['attach_id'];
                            $this->mdl_attach->reserve();
                        }
                    }
                }
            }

            if ($num_attachId > 0 && !Func::isEmpty($str_content)) {
                $this->mdl_article->inputSubmit = array(
                    'article_id'        => $num_articleId,
                    'article_content'   => $str_content,
                );

                $_arr_contentResult  = $this->mdl_article->submitContent($num_articleId);
                $_arr_attachResult   = $this->mdl_article->submitAttach($num_articleId, $num_attachId);
            }
        }
    }
}
