<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

class Index extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->mdl_profile  = Loader::model('Profile');

        $this->mdl_article  = Loader::model('Article');
        $this->mdl_tag      = Loader::model('Tag');
        $this->mdl_spec     = Loader::model('Spec');
        $this->mdl_attach   = Loader::model('Attach');
        $this->mdl_cate     = Loader::model('Cate');
        $this->mdl_admin    = Loader::model('Admin');
        $this->mdl_group    = Loader::model('Group');
        $this->mdl_link     = Loader::model('Link');
        $this->mdl_app      = Loader::model('App');

        $this->generalData['status_article']    = $this->mdl_article->arr_status;
        $this->generalData['status_tag']        = $this->mdl_tag->arr_status;
        $this->generalData['status_spec']       = $this->mdl_spec->arr_status;
        $this->generalData['status_cate']       = $this->mdl_cate->arr_status;
        $this->generalData['status_admin']      = $this->mdl_admin->arr_status;
        $this->generalData['type_admin']        = $this->mdl_admin->arr_type;
        $this->generalData['status_group']      = $this->mdl_group->arr_status;
        $this->generalData['status_link']       = $this->mdl_link->arr_status;
        $this->generalData['type_link']         = $this->mdl_link->arr_type;
        $this->generalData['status_app']        = $this->mdl_app->arr_status;
    }

    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_articleCount['total'] = $this->mdl_article->count();

        foreach ($this->mdl_article->arr_status as $_key=>$_value) {
            $_arr_search = array(
                'status' => $_value,
            );
            $_arr_articleCount[$_value] = $this->mdl_article->count($_arr_search);
        }

        $_arr_tagCount['total'] = $this->mdl_tag->count();

        foreach ($this->mdl_tag->arr_status as $_key=>$_value) {
            $_arr_search = array(
                'status' => $_value,
            );
            $_arr_tagCount[$_value] = $this->mdl_tag->count($_arr_search);
        }

        $_arr_specCount['total'] = $this->mdl_spec->count();

        foreach ($this->mdl_spec->arr_status as $_key=>$_value) {
            $_arr_search = array(
                'status' => $_value,
            );
            $_arr_specCount[$_value] = $this->mdl_spec->count($_arr_search);
        }

        $_arr_search = array(
            'box' => 'normal',
        );
        $_arr_attachCount['total'] = $this->mdl_attach->count($_arr_search);

        $_arr_cateCount['total'] = $this->mdl_cate->count();

        foreach ($this->mdl_cate->arr_status as $_key=>$_value) {
            $_arr_search = array(
                'status' => $_value,
            );
            $_arr_cateCount[$_value] = $this->mdl_cate->count($_arr_search);
        }

        $_arr_adminCount['total'] = $this->mdl_admin->count();

        foreach ($this->mdl_admin->arr_status as $_key=>$_value) {
            $_arr_search = array(
                'status' => $_value,
            );
            $_arr_adminCount[$_value] = $this->mdl_admin->count($_arr_search);
        }

        foreach ($this->mdl_admin->arr_type as $_key=>$_value) {
            $_arr_search = array(
                'type' => $_value,
            );
            $_arr_adminCount[$_value] = $this->mdl_admin->count($_arr_search);
        }

        $_arr_groupCount['total'] = $this->mdl_group->count();

        foreach ($this->mdl_group->arr_status as $_key=>$_value) {
            $_arr_search = array(
                'status' => $_value,
            );
            $_arr_groupCount[$_value] = $this->mdl_group->count($_arr_search);
        }

        $_arr_linkCount['total'] = $this->mdl_link->count();

        foreach ($this->mdl_link->arr_status as $_key=>$_value) {
            $_arr_search = array(
                'status' => $_value,
            );
            $_arr_linkCount[$_value] = $this->mdl_link->count($_arr_search);
        }

        foreach ($this->mdl_link->arr_type as $_key=>$_value) {
            $_arr_search = array(
                'type' => $_value,
            );
            $_arr_linkCount[$_value] = $this->mdl_link->count($_arr_search);
        }

        $_arr_appCount['total'] = $this->mdl_app->count();

        foreach ($this->mdl_app->arr_status as $_key=>$_value) {
            $_arr_search = array(
                'status' => $_value,
            );
            $_arr_appCount[$_value] = $this->mdl_app->count($_arr_search);
        }

        $_arr_tplData = array(
            'article_count' => $_arr_articleCount,
            'tag_count'     => $_arr_tagCount,
            'spec_count'    => $_arr_specCount,
            'attach_count'  => $_arr_attachCount,
            'cate_count'    => $_arr_cateCount,
            'admin_count'   => $_arr_adminCount,
            'group_count'   => $_arr_groupCount,
            'link_count'    => $_arr_linkCount,
            'app_count'     => $_arr_appCount,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function setting() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_tplData = array(
            'token'     => $this->obj_request->token(),
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

        $_arr_inputShortcut = $this->mdl_profile->inputShortcut();

        if ($_arr_inputShortcut['rcode'] != 'y020201') {
            return $this->fetchJson($_arr_inputShortcut['msg'], $_arr_inputShortcut['rcode']);
        }

        $this->mdl_profile->inputShortcut['admin_id'] = $this->adminLogged['admin_id'];

        $_arr_shortcutResult = $this->mdl_profile->shortcut();

        return $this->fetchJson($_arr_shortcutResult['msg'], $_arr_shortcutResult['rcode']);
    }
}
