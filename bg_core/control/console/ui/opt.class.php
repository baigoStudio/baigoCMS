<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

fn_include(BG_PATH_FUNC . 'http.func.php'); //载入模板类

/*-------------管理员控制器-------------*/
class CONTROL_CONSOLE_UI_OPT {

    private $group_allow    = array();
    private $is_super       = false;

    function __construct() { //构造函数
        $this->config       = $GLOBALS['obj_base']->config;

        $this->obj_dir      = new CLASS_DIR(); //初始化目录对象
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        $this->act          = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', 'base');

        if (!array_key_exists($this->act, $this->obj_tpl->opt)) {
            $this->act = 'base';
        }

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }

        if (isset($this->adminLogged['groupRow']['group_allow'])) {
            $this->group_allow = $this->adminLogged['groupRow']['group_allow'];
        }

        $this->mdl_opt      = new MODEL_OPT();

        $this->tplData = array(
            'adminLogged'   => $this->adminLogged,
            'act'           => $this->act,
        );
    }


    function ctrl_chkver() {
        if (!isset($this->group_allow['opt']['chkver']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x060301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $this->tplData['latest_ver']    = $this->mdl_opt->chk_ver();
        $this->tplData['installed_pub'] = strtotime(PRD_CMS_PUB);

        $this->obj_tpl->tplDisplay('opt_chkver', $this->tplData);
    }


    function ctrl_dbconfig() {
        if (!isset($this->group_allow['opt']['dbconfig']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x060301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $this->obj_tpl->tplDisplay('opt_dbconfig', $this->tplData);
    }


    function ctrl_form() {
        if (!isset($this->group_allow['opt'][$this->act]) && !$this->is_super) {
            $this->tplData['rcode'] = 'x060301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        if ($this->act == 'base') {
            $this->tplData['tplRows']     = $this->obj_dir->list_dir(BG_PATH_TPL . 'pub' . DS);

            $_arr_timezoneRows  = fn_include(BG_PATH_INC . 'timezone.inc.php');

            $this->obj_tpl->lang['timezone']        = fn_include(BG_PATH_LANG . $this->config['lang'] . DS . 'timezone.php');
            $this->obj_tpl->lang['timezoneJson']    = json_encode($this->obj_tpl->lang['timezone']);

            $_arr_timezone[] = '';

            if (stristr(BG_SITE_TIMEZONE, '/')) {
                $_arr_timezone = explode('/', BG_SITE_TIMEZONE);
            }

            $this->tplData['timezoneRows']      = $_arr_timezoneRows;
            $this->tplData['timezoneRowsJson']  = json_encode($_arr_timezoneRows);
            $this->tplData['timezoneType']      = $_arr_timezone[0];
        }

        $this->obj_tpl->tplDisplay('opt_form', $this->tplData);
    }
}
