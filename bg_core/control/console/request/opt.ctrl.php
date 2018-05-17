<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

if (!function_exists('fn_http')) {
    fn_include(BG_PATH_FUNC . 'http.func.php'); //载入 http
}

/*-------------管理员控制器-------------*/
class CONTROL_CONSOLE_REQUEST_OPT {

    private $group_allow    = array();
    private $is_super       = false;

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->dspType = 'result';
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }

        if (isset($this->adminLogged['groupRow']['group_allow'])) {
            $this->group_allow = $this->adminLogged['groupRow']['group_allow'];
        }

        $this->obj_file      = new CLASS_FILE();
        $this->mdl_opt      = new MODEL_OPT();
        $this->mdl_cate     = new MODEL_CATE();
    }


    function ctrl_chkver() {
        if (!isset($this->group_allow['opt']['chkver']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x060301',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $this->mdl_opt->chk_ver(true, 'manual');

        $_arr_tplData = array(
            'rcode' => 'y060402',
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }


    function ctrl_dbconfig() {
        if (!isset($this->group_allow['opt']['dbconfig']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x060301',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_dbconfigInput = $this->mdl_opt->input_dbconfig();

        if ($_arr_dbconfigInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_dbconfigInput);
        }

        $_arr_return = $this->mdl_opt->mdl_dbconfig();

        $this->obj_tpl->tplDisplay('result', $_arr_return);
    }


    function ctrl_submit() {
        $_act = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', 'base');

        if (!isset($this->group_allow['opt'][$_act]) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x060301',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_num_countSrc = 0;

        foreach ($this->obj_tpl->opt[$_act]['list'] as $_key=>$_value) {
            if ($_value['min'] > 0) {
                $_num_countSrc++;
            }
        }

        $_arr_const = $this->mdl_opt->input_const($_act);

        $_num_countInput = count(array_filter($_arr_const));

        if ($_num_countInput < $_num_countSrc) {
            $_arr_tplData = array(
                'rcode' => 'x030204',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_return = $this->mdl_opt->mdl_const($_act);

        if ($_arr_return['rcode'] != 'y060101') {
            $this->obj_tpl->tplDisplay('result', $_arr_return);
        }

        if ($_act == 'base') {
            $this->mdl_cate->mdl_cache(0, true);
        }

        if ($_act == 'visit') {
            switch ($_arr_const['BG_VISIT_TYPE']) {
                case 'static':
                case 'pstatic':
                    $_arr_return = $this->mdl_opt->mdl_htaccess();

                    if ($_arr_return['rcode'] != 'y060101') {
                        $this->obj_tpl->tplDisplay('result', $_arr_return);
                    }
                break;

                default:
                    $this->obj_file->file_del(BG_PATH_ROOT . '.htaccess');
                break;
            }
        }

        $_arr_tplData = array(
            'rcode' => 'y060401',
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }
}