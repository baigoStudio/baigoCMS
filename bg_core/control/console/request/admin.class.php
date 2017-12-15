<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}


/*-------------UC 类-------------*/
class CONTROL_CONSOLE_REQUEST_ADMIN {

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

        $this->obj_sso      = new CLASS_SSO();
        $this->mdl_admin    = new MODEL_ADMIN();
        $this->mdl_group    = new MODEL_GROUP();
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        $_arr_adminInput = $this->mdl_admin->input_submit();

        if ($_arr_adminInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_adminInput);
        }

        $_str_adminPass = fn_getSafe(fn_post('admin_pass'), 'txt', '');

        if ($_arr_adminInput['admin_id'] > 0) {
            if (!isset($this->group_allow['admin']['edit']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x020303',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }

            if ($_arr_adminInput['admin_id'] == $this->adminLogged['admin_id'] && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x020306',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }

            $_arr_adminSubmit = array(
                'user_pass'     => $_str_adminPass,
                'user_mail_new' => $_arr_adminInput['admin_mail'],
                'user_nick'     => $_arr_adminInput['admin_nick'],
            );
            $_arr_ssoRow    = $this->obj_sso->sso_user_edit($_arr_adminInput['admin_name'], 'user_name', $_arr_adminSubmit);
            $_num_adminId   = $_arr_adminInput['admin_id'];
        } else {
            if (!isset($this->group_allow['admin']['add']) && !$this->is_super) {
                $_arr_tplData = array(
                    'rcode' => 'x020302',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }

            if (fn_isEmpty($_str_adminPass)) {
                $_arr_tplData = array(
                    'rcode' => 'x010212',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }

            $_arr_userSubmit = array(
                'user_name' => $_arr_adminInput['admin_name'],
                'user_pass' => $_str_adminPass,
                'user_mail' => $_arr_adminInput['admin_mail'],
                'user_nick' => $_arr_adminInput['admin_nick'],
            );
            $_arr_ssoRow = $this->obj_sso->sso_user_reg($_arr_userSubmit);
            if ($_arr_ssoRow['rcode'] != 'y010101') {
                $this->obj_tpl->tplDisplay('result', $_arr_ssoRow);
            }
            $_num_adminId = $_arr_ssoRow['user_id'];
        }

        $_arr_adminRow = $this->mdl_admin->mdl_submit($_num_adminId);

        if ($_arr_ssoRow['rcode'] == 'y010103' || $_arr_adminRow['rcode'] == 'y020103') {
            $_str_rcode = 'y020103';
        } else {
            $_str_rcode = $_arr_adminRow['rcode'];
        }

        $_arr_tplData = array(
            'rcode' => $_str_rcode,
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }


    /**
     * ajax_auth function.
     *
     * @access public
     * @return void
     */
    function ctrl_auth() {
        $_arr_adminInput = $this->mdl_admin->input_submit();

        if ($_arr_adminInput['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_adminInput);
        }

        if (!isset($this->group_allow['admin']['add']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x020302',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_ssoGet = $this->obj_sso->sso_user_read($_arr_adminInput['admin_name'], 'user_name');
        if ($_arr_ssoGet['rcode'] != 'y010102') {
            if ($_arr_ssoGet['rcode'] == 'x010102') {
                $_arr_tplData = array(
                    'rcode' => 'x020205',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            } else {
                $this->obj_tpl->tplDisplay('result', $_arr_ssoGet);
            }
        } else {
            //检验用户是否存在
            $_arr_adminRow = $this->mdl_admin->mdl_read($_arr_ssoGet['user_id']);
            if ($_arr_adminRow['rcode'] == 'y020102') {
                $_arr_tplData = array(
                    'rcode' => 'x020218',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        }

        $_arr_adminRow = $this->mdl_admin->mdl_submit($_arr_ssoGet['user_id']);
        if ($_arr_adminRow['rcode'] == 'x020101') {
            $_str_rcode = 'y020101';
        } else {
            $_str_rcode = $_arr_adminRow['rcode'];
        }

        $_arr_tplData = array(
            'rcode' => $_str_rcode,
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }


    /**
     * ajax_toGroup function.
     *
     * @access public
     * @return void
     */
    function ctrl_toGroup() {
        if (!isset($this->group_allow['admin']['toGroup']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x020305',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_num_adminId = fn_getSafe(fn_post('admin_id'), 'int', 0);

        if ($_num_adminId == $this->adminLogged['admin_id'] && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x020306',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_num_groupId = fn_getSafe(fn_post('group_id'), 'int', 0);

        //检验用户是否存在
        $_arr_adminRow = $this->mdl_admin->mdl_read($_num_adminId);
        if ($_arr_adminRow['rcode'] != 'y020102') {
            $this->obj_tpl->tplDisplay('result', $_arr_adminRow);
        }

        if ($_num_groupId > 0) {
            $_arr_groupRow = $this->mdl_group->mdl_read($_num_groupId);
            if ($_arr_groupRow['rcode'] != 'y040102') {
                $this->obj_tpl->tplDisplay('result', $_arr_groupRow);
            }
        } else {
            $_num_groupId = 0;
        }

        $_arr_adminRow = $this->mdl_admin->mdl_toGroup($_num_adminId, $_num_groupId);

        $this->obj_tpl->tplDisplay('result', $_arr_adminRow);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->group_allow['admin']['del']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x020304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_adminIds = $this->mdl_admin->input_ids();
        if ($_arr_adminIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_adminIds);
        }

        $_arr_adminRow = $this->mdl_admin->mdl_del();

        $this->obj_tpl->tplDisplay('result', $_arr_adminRow);
    }


    /**
     * ajax_status function.
     *
     * @access public
     * @return void
     */
    function ctrl_status() {
        if (!isset($this->group_allow['admin']['edit']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x020303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_adminIds = $this->mdl_admin->input_ids();
        if ($_arr_adminIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_adminIds);
        }

        $_str_status = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', '');

        $_arr_adminRow = $this->mdl_admin->mdl_status($_str_status);

        $this->obj_tpl->tplDisplay('result', $_arr_adminRow);
    }

    /**
     * ajax_chkname function.
     *
     * @access public
     * @return void
     */
    function ctrl_chkname() {
        $_str_adminName   = fn_getSafe(fn_get('admin_name'), 'txt', '');

        if (!fn_isEmpty($_str_adminName)) {
            $_arr_ssoChk      = $this->obj_sso->sso_user_chkname($_str_adminName);

            if ($_arr_ssoChk['rcode'] != 'y010205') {
                if ($_arr_ssoChk['rcode'] == 'x010205') {
                    $_arr_ssoGet = $this->obj_sso->sso_user_read($_str_adminName, 'user_name');
                    //检验用户是否存在
                    $_arr_adminRow = $this->mdl_admin->mdl_read($_arr_ssoGet['user_id']);
                    if ($_arr_adminRow['rcode'] == 'y020102') {
                        $_str_rcode = 'x020218';
                    } else {
                        $_str_rcode = 'x020204';
                    }
                    $_arr_tplData = array(
                        'rcode' => $_str_rcode,
                    );
                    $this->obj_tpl->tplDisplay('result', $_arr_tplData);
                } else {
                    $this->obj_tpl->tplDisplay('result', $_arr_ssoChk);
                }
            }
        }

        $_arr_tplData = array(
            'msg' => 'ok'
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }


    function ctrl_chkauth() {
        $_str_adminName   = fn_getSafe(fn_get('admin_name'), 'txt', '');

        if (!fn_isEmpty($_str_adminName)) {
            $_arr_ssoGet = $this->obj_sso->sso_user_read($_str_adminName, 'user_name');

            if ($_arr_ssoGet['rcode'] == 'y010102') {
                //检验用户是否存在
                $_arr_adminRow = $this->mdl_admin->mdl_read($_arr_ssoGet['user_id']);
                if ($_arr_adminRow['rcode'] == 'y020102') {
                    $_arr_tplData = array(
                        'rcode' => 'x020218',
                    );
                    $this->obj_tpl->tplDisplay('result', $_arr_tplData);
                }
            } else {
                if ($_arr_ssoGet['rcode'] == 'x010102') {
                    $_str_rcode = 'x020205';
                } else {
                    $_str_rcode = $_arr_ssoGet['rcode'];
                }
                $_arr_tplData = array(
                    'rcode' => $_str_rcode,
                );
                $this->obj_tpl->tplDisplay('result', $_arr_tplData);
            }
        }

        $_arr_tplData = array(
            'msg' => 'ok'
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }


    /**
     * ajax_chkmail function.
     *
     * @access public
     * @return void
     */
    function ctrl_chkmail() {
        $_str_adminMail   = fn_getSafe(fn_get('admin_mail'), 'txt', '');

        if (!fn_isEmpty($_str_adminMail)) {
            $_num_adminId     = fn_getSafe(fn_get('admin_id'), 'int', 0);
            $_arr_ssoChk      = $this->obj_sso->sso_user_chkmail($_str_adminMail, $_num_adminId);
            //print_r($_arr_ssoChk);

            if ($_arr_ssoChk['rcode'] != 'y010211') {
                $this->obj_tpl->tplDisplay('result', $_arr_ssoChk);
            }
        }

        $_arr_tplData = array(
            'msg' => 'ok'
        );
        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }
}
