<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------管理员控制器-------------*/
class CONTROL_CONSOLE_UI_PROFILE {

    function __construct() { //构造函数
        $this->config       = $GLOBALS['obj_base']->config;

        $this->obj_sso      = new CLASS_SSO(); //初始化单点登录
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        $this->mdl_cate     = new MODEL_CATE(); //设置栏目对象

        $this->tplData = array(
            'adminLogged'   => $this->adminLogged,
        );
    }


    function ctrl_mailbox() {
        $_arr_ssoRow    = $this->obj_sso->sso_user_read($this->adminLogged['admin_id']);

        $_arr_tpl = array(
            'ssoRow'    => $_arr_ssoRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('profile_mailbox', $_arr_tplData);
    }


    function ctrl_qa() {
        $_arr_ssoRow    = $this->obj_sso->sso_user_read($this->adminLogged['admin_id']);

        $_arr_tpl = array(
            'ssoRow'    => $_arr_ssoRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('profile_qa', $_arr_tplData);
    }


    /** 修改个人资料表单
     * ctrl_my function.
     *
     * @access public
     */
    function ctrl_info() {
        $_arr_ssoRow    = $this->obj_sso->sso_user_read($this->adminLogged['admin_id']);
        $_arr_cateRows  = $this->mdl_cate->mdl_list(1000);

        $_arr_tpl = array(
            'ssoRow'        => $_arr_ssoRow,
            'cateRows'      => $_arr_cateRows, //栏目信息
            'cateAllow'    => fn_include(BG_PATH_INC . 'cateAllow.inc.php'),
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('profile_info', $_arr_tplData);
    }


    function ctrl_pass() {
        $_arr_ssoRow    = $this->obj_sso->sso_user_read($this->adminLogged['admin_id']);

        $_arr_tpl = array(
            'ssoRow'        => $_arr_ssoRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('profile_pass', $_arr_tplData);
    }


    function ctrl_prefer() {
        $_arr_ssoRow    = $this->obj_sso->sso_user_read($this->adminLogged['admin_id']);
        $_arr_prefer    = fn_include(BG_PATH_INC . 'prefer.inc.php');
        $_arr_prefer['excerpt']['list']['type']['option'] = $this->obj_tpl->opt['base']['list']['BG_SITE_EXCERPT_TYPE']['option'];

        $this->obj_tpl->lang['prefer'] = fn_include(BG_PATH_LANG . $this->config['lang'] . DS . 'prefer.php');

        $_arr_tpl = array(
            'ssoRow'        => $_arr_ssoRow,
            'prefer'        => $_arr_prefer,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('profile_prefer', $_arr_tplData);
    }
}
