<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

if (!function_exists('fn_qlistAttach')) {
    fn_include(BG_PATH_FUNC . 'gather.func.php');
}

/*-------------用户类-------------*/
class CONTROL_CONSOLE_REQUEST_ATTACH {

    private $group_allow    = array();
    private $is_super       = false;
    public $attachMime      = array();

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

        $this->obj_upload   = new CLASS_UPLOAD();
        $this->mdl_attach   = new MODEL_ATTACH();
        $this->mdl_thumb    = new MODEL_THUMB();
        $this->mdl_mime     = new MODEL_MIME();
        $this->mdl_admin    = new MODEL_ADMIN();
        $this->mdl_article  = new MODEL_ARTICLE(); //设置文章对象

        $this->setUpload();

        if (BG_MODULE_FTP > 0 && defined('BG_UPLOAD_FTPHOST') && !fn_isEmpty(BG_UPLOAD_FTPHOST)) {
            $this->obj_ftp = new CLASS_FTP(); //设置 FTP 对象
        }

        $this->obj_thumb   = new CLASS_THUMB();
    }


    function ctrl_gen() {
        if (!isset($this->group_allow['attach']['thumb']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x070304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        if (BG_MODULE_FTP > 0 && defined('BG_UPLOAD_FTPHOST') && !fn_isEmpty(BG_UPLOAD_FTPHOST)) {
            if (defined('BG_UPLOAD_FTPPASV') && BG_UPLOAD_FTPPASV == 'on') {
                $_bool_isPasv = true;
            } else {
                $_bool_isPasv = false;
            }
            $_ftp_status_conn   = $this->obj_ftp->ftp_conn(BG_UPLOAD_FTPHOST, BG_UPLOAD_FTPPORT);
            $_ftp_status_login  = $this->obj_ftp->ftp_login(BG_UPLOAD_FTPUSER, BG_UPLOAD_FTPPASS, $_bool_isPasv);

            if (!$_ftp_status_conn) {
                $_arr_status = array(
                    'rcode' => 'x030301',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_status);
            }
            if (!$_ftp_status_login) {
                $_arr_status = array(
                    'rcode' => 'x030302',
                );
                $this->obj_tpl->tplDisplay('result', $_arr_status);
            }
        }

        $_num_thumbId     = fn_getSafe(fn_post('thumb_id'), 'int', 0);
        $_arr_attachId    = fn_post('attach_range');

        $_arr_search = array(
            'box'       => 'normal',
            'min_id'    => fn_getSafe($_arr_attachId['min_id'], 'int', 0),
            'max_id'    => fn_getSafe($_arr_attachId['max_id'], 'int', 0),
        );

        if ($_num_thumbId < 1) {
            $_arr_tplData = array(
                'rcode' => 'x090207',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_thumbRow = $this->mdl_thumb->mdl_read($_num_thumbId);
        if ($_arr_thumbRow['rcode'] != 'y090102') {
            $this->obj_tpl->tplDisplay('result', $_arr_thumbRow);
        }

        $_arr_attachIds   = array();

        $_arr_order = array(
            array('attach_id', 'ASC'),
        );

        $_num_perPage     = 10;
        $_num_attachCount = $this->mdl_attach->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_attachCount, $_num_perPage, 'post');
        $_arr_attachRows  = $this->mdl_attach->mdl_list($_num_perPage, $_arr_page['except'], $_arr_search, $_arr_order);

        //$_obj_finfo       = new finfo();

        $_str_status = 'complete';
        $_str_msg    = $this->obj_tpl->lang['rcode']['y070409'];

        if ($_arr_page['page'] < $_arr_page['total']) {
            foreach ($_arr_attachRows as $_key=>$_value) {
                if (file_exists($_value['attach_path'])) {
                    if ($_value['attach_type'] == 'image') { //如果是图片，则生成缩略图

                        $_arr_thumbResult = $this->obj_thumb->thumb_do($_arr_thumbRow['thumb_width'], $_arr_thumbRow['thumb_height'], $_arr_thumbRow['thumb_type'], $_value);


                        if (BG_MODULE_FTP > 0 && defined('BG_UPLOAD_FTPHOST') && !fn_isEmpty(BG_UPLOAD_FTPHOST)) { //如果定义了FTP服务器，则上传
                            if (!$_ftp_status_conn) {
                                $_arr_status = array(
                                    'rcode' => 'x030301',
                                );
                                $this->obj_tpl->tplDisplay('result', $_arr_status);
                            }
                            if (!$_ftp_status_login) {
                                $_arr_status = array(
                                    'rcode' => 'x030302',
                                );
                                $this->obj_tpl->tplDisplay('result', $_arr_status);
                            }

                            $_attachFtp  = '/' . date('Y', $_value['attach_time']) . '/' . date('m', $_value['attach_time']) . '/';

                            $_ftp_status = $this->obj_ftp->file_upload($_arr_thumbResult['thumb_path'], BG_UPLOAD_FTPPATH . $_attachFtp . $_arr_thumbResult['thumb_name']);
                            if (!$_ftp_status) {
                                $_arr_status = array(
                                    'rcode' => 'x030303',
                                );
                                $this->obj_tpl->tplDisplay('result', $_arr_status);
                            }
                        }
                    }
                }
            }
            $_str_status = 'loading';
            $_str_msg    = $this->obj_tpl->lang['rcode']['x070409'];
        } else if ($_arr_page['page'] == $_arr_page['total']) {
            foreach ($_arr_attachRows as $_key=>$_value) {
                if (file_exists($_value['attach_path'])) {
                    if ($_value['attach_type'] == 'image') { //如果是图片，则生成缩略图

                        $_arr_thumbResult = $this->obj_thumb->thumb_do($_arr_thumbRow['thumb_width'], $_arr_thumbRow['thumb_height'], $_arr_thumbRow['thumb_type'], $_value);

                        if (BG_MODULE_FTP > 0 && defined('BG_UPLOAD_FTPHOST') && !fn_isEmpty(BG_UPLOAD_FTPHOST)) { //如果定义了FTP服务器，则上传
                            if (!$_ftp_status_conn) {
                                $_arr_status = array(
                                    'rcode' => 'x030301',
                                );
                                $this->obj_tpl->tplDisplay('result', $_arr_status);
                            }
                            if (!$_ftp_status_login) {
                                $_arr_status = array(
                                    'rcode' => 'x030302',
                                );
                                $this->obj_tpl->tplDisplay('result', $_arr_status);
                            }

                            $_attachFtp  = '/' . date('Y', $_value['attach_time']) . '/' . date('m', $_value['attach_time']) . '/';

                            $_ftp_status = $this->obj_ftp->file_upload($_arr_thumbResult['thumb_path'], BG_UPLOAD_FTPPATH . $_attachFtp . $_arr_thumbResult['thumb_name']);
                            if (!$_ftp_status) {
                                $_arr_status = array(
                                    'rcode' => 'x030303',
                                );
                                $this->obj_tpl->tplDisplay('result', $_arr_status);
                            }
                        }
                    }
                }
            }
        }

        $_arr_re = array(
            'page'      => $_arr_page['page'],
            'msg'       => $_str_msg,
            'count'     => $_arr_page['total'],
            'status'    => $_str_status,
            'attach_id' => $_value['attach_id'],
        );

        $this->obj_tpl->tplDisplay('result', $_arr_re);
    }


    function ctrl_empty() {
        if (!isset($this->group_allow['attach']['del']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x070304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        if (!fn_token('chk')) { //令牌
            $_arr_tplData = array(
                'rcode' => 'x030206',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_status = $this->obj_upload->upload_init();
        if ($_arr_status['rcode'] != 'y070403') {
            $this->obj_tpl->tplDisplay('result', $_arr_status);
        }

        $_arr_search = array(
            'box' => 'recycle',
        );

        $_arr_attachIds   = array();
        $_num_perPage     = 10;
        $_num_attachCount = $this->mdl_attach->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_attachCount, $_num_perPage, 'post');
        $_arr_attachRows  = $this->mdl_attach->mdl_list(1000, 0, $_arr_search);

        if ($_num_attachCount > 0) {
            foreach ($_arr_attachRows as $_key=>$_value) {
                $_arr_attachIds[] = $_value['attach_id'];
            }

            $_arr_search = array(
                'box'       => 'recycle',
                'attach_ids' => $_arr_attachIds,
            ); //搜索设置
            $_arr_attachRows  = $this->mdl_attach->mdl_list(1000, 0, $_arr_search);
            $this->obj_upload->upload_del($_arr_attachRows);
            //exit;

            $_arr_attachDel  = $this->mdl_attach->mdl_del(0, $_arr_attachIds);
            $_str_status     = 'loading';
            $_str_msg        = $this->obj_tpl->lang['rcode']['x070408'];
        } else {
            $_str_status = 'complete';
            $_str_msg    = $this->obj_tpl->lang['rcode']['y070408'];
        }

        $_arr_re = array(
            'msg'    => $_str_msg,
            'count'  => $_arr_page['total'],
            'status' => $_str_status,
        );

        $this->obj_tpl->tplDisplay('result', $_arr_re);
    }


    function ctrl_clear() {
        if (!isset($this->group_allow['attach']['del']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x070304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_num_maxId = fn_getSafe(fn_post('max_id'), 'int', 0);

        $_arr_searchCount = array(
            'box'   => 'normal',
        );

        $_arr_searchList = array(
            'box'       => 'normal',
            'max_id'    => $_num_maxId,
        );

        $_num_perPage     = 10;
        $_num_attachCount = $this->mdl_attach->mdl_count($_arr_searchCount);
        $_arr_page        = fn_page($_num_attachCount, $_num_perPage, 'post');
        $_arr_attachRows  = $this->mdl_attach->mdl_list($_num_perPage, 0, $_arr_searchList);

        if (fn_isEmpty($_arr_attachRows)) {
            $_str_status    = 'complete';
            $_str_msg       = $this->obj_tpl->lang['rcode']['y070407'];
        } else {
            foreach ($_arr_attachRows as $_key=>$_value) {
                $_arr_attachRow = $this->mdl_attach->mdl_chkAttach($_value['attach_id'], $_value['attach_ext'], $_value['attach_time']);
                //print_r($_arr_attachRow);
                if ($_arr_attachRow['rcode'] == 'x070406') {
                    $this->mdl_attach->mdl_box('recycle', array($_value['attach_id']));
                }
            }
            $_str_status    = 'loading';
            $_str_msg       = $this->obj_tpl->lang['rcode']['x070407'];
            $_num_maxId     = $_value['attach_id'];
        }

        $_arr_re = array(
            'msg'       => $_str_msg,
            'count'     => $_arr_page['total'],
            'max_id'    => $_num_maxId,
            'status'    => $_str_status,
        );

        $this->obj_tpl->tplDisplay('result', $_arr_re);
    }


    function ctrl_box() {
        if (!isset($this->group_allow['attach']['del']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x170303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_attachIds = $this->mdl_attach->input_ids();
        if ($_arr_attachIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_attachIds);
        }

        $_str_attachStatus = fn_getSafe($GLOBALS['route']['bg_act'], 'txt', '');

        $_arr_attachRow = $this->mdl_attach->mdl_box($_str_attachStatus);

        $this->obj_tpl->tplDisplay('result', $_arr_attachRow);
    }

    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        if (!isset($this->group_allow['attach']['upload']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x070302',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        if (!fn_token('chk')) { //令牌
            $_arr_tplData = array(
                'rcode' => 'x030206',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        if (fn_isEmpty($this->attachMime)) {
            $_arr_tplData = array(
                'rcode' => 'x070405',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_status = $this->obj_upload->upload_init();
        if ($_arr_status['rcode'] != 'y070403') {
            $this->obj_tpl->tplDisplay('result', $_arr_status);
        }

        $_arr_uploadRow = $this->obj_upload->upload_pre();

        if ($_arr_uploadRow['rcode'] != 'y100201') {
            if ($_arr_uploadRow['rcode'] == 'x070203') {
                $_arr_uploadRow['msg'] = $this->obj_tpl->lang['rcode'][$_arr_uploadRow['rcode']] . ' ' . BG_UPLOAD_SIZE . ' ' . BG_UPLOAD_UNIT;
            }
            $this->obj_tpl->tplDisplay('result', $_arr_uploadRow);
        }

        $_arr_attachRow = $this->mdl_attach->mdl_submit(0, $_arr_uploadRow['attach_name'], $_arr_uploadRow['attach_ext'], $_arr_uploadRow['attach_mime'], $_arr_uploadRow['attach_size'], $this->adminLogged['admin_id']);

        if ($_arr_attachRow['rcode'] != 'y070101') {
            $this->obj_tpl->tplDisplay('result', $_arr_attachRow);
        }

        $_arr_uploadRowInput = $this->obj_upload->upload_submit($_arr_attachRow['attach_time'], $_arr_attachRow['attach_id']);
        if ($_arr_uploadRowInput['rcode'] != 'y070401') {
            $this->obj_tpl->tplDisplay('result', $_arr_uploadRowInput);
        }
        $_arr_uploadRowInput['attach_id']    = $_arr_attachRow['attach_id'];
        $_arr_uploadRowInput['attach_ext']   = $_arr_uploadRow['attach_ext'];
        $_arr_uploadRowInput['attach_name']  = $_arr_uploadRow['attach_name'];

        $this->obj_tpl->tplDisplay('result', $_arr_uploadRowInput);
    }


    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        $_arr_status = $this->obj_upload->upload_init();
        if ($_arr_status['rcode'] != 'y070403') {
            $this->obj_tpl->tplDisplay('result', $_arr_status);
        }

        if (isset($this->group_allow['attach']['del']) || $this->is_super) {
            $_num_adminId = 0;
        } else {
            $_num_adminId = $this->adminLogged['admin_id'];
        }

        $_arr_attachIds = $this->mdl_attach->input_ids();
        if ($_arr_attachIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_attachIds);
        }

        $_arr_search = array(
            'admin_id'      => $_num_adminId,
            'attach_ids'    => $_arr_attachIds['attach_ids'],
        );

        $_arr_attachRows = $this->mdl_attach->mdl_list(1000, 0, $_arr_search);
        $this->obj_upload->upload_del($_arr_attachRows);

        $_arr_attachDel = $this->mdl_attach->mdl_del($_num_adminId);

        $this->obj_tpl->tplDisplay('result', $_arr_attachDel);
    }


    /**
     * ajax_list function.
     *
     * @access public
     * @return void
     */
    function ctrl_list() {
        if (!isset($this->group_allow['attach']['browse']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x070301',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_search = array(
            'key'   => fn_getSafe(fn_get('key'), 'txt', ''),
            'year'  => fn_getSafe(fn_get('year'), 'txt', ''),
            'month' => fn_getSafe(fn_get('month'), 'txt', ''),
            'ext'   => fn_getSafe(fn_get('ext'), 'txt', ''),
            'box'   => 'normal',
        );

        $_num_perPage     = 8;
        $_num_attachCount = $this->mdl_attach->mdl_count($_arr_search);
        $_arr_page        = fn_page($_num_attachCount, $_num_perPage);
        $_arr_attachRows  = $this->mdl_attach->mdl_list($_num_perPage, $_arr_page['except'], $_arr_search);

        foreach ($_arr_attachRows as $_key=>$_value) {
            if ($_value['attach_type'] == 'image') {
                $_arr_attachRows[$_key]['attach_thumb'] = $this->mdl_attach->thumb_process($_value['attach_id'], $_value['attach_time'], $_value['attach_ext']);
            }
            $_arr_attachRows[$_key]['adminRow']  = $this->mdl_admin->mdl_read($_value['attach_admin_id']);
        }

        //print_r($_arr_page);

        $_arr_tpl = array(
            'pageRow'    => $_arr_page,
            'attachRows' => $_arr_attachRows, //上传信息
        );

        $this->obj_tpl->tplDisplay('result', $_arr_tpl);
    }


    function ctrl_article() {
        if (!isset($this->group_allow['attach']['browse']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x070301',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_num_articleId = fn_getSafe(fn_get('article_id'), 'int', 0);
        if ($_num_articleId < 1) {
            $_arr_tplData = array(
                'rcode' => 'x120212',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_articleRow = $this->mdl_article->mdl_read($_num_articleId); //读取文章
        if ($_arr_articleRow['rcode'] != 'y120102') {
            $this->obj_tpl->tplDisplay('result', $_arr_articleRow);
        }

        $_num_perPage     = 8;

        $_arr_attachIds = fn_qlistAttach($_arr_articleRow['article_content']);

        $_arr_attachRows  = array();

        $_arr_search = array(
            'attach_ids'    => $_arr_attachIds,
            'box'           => 'normal',
        );

        if (!fn_isEmpty($_arr_attachIds)) {
            $_num_attachCount = $this->mdl_attach->mdl_count($_arr_search);
            $_arr_page        = fn_page($_num_attachCount, $_num_perPage);
            $_arr_attachRows  = $this->mdl_attach->mdl_list($_num_perPage, $_arr_page['except'], $_arr_search);

            foreach ($_arr_attachRows as $_key=>$_value) {
                if ($_value['attach_type'] == 'image') {
                    $_arr_attachRows[$_key]['attach_thumb'] = $this->mdl_attach->thumb_process($_value['attach_id'], $_value['attach_time'], $_value['attach_ext']);
                }
                $_arr_attachRows[$_key]['adminRow']  = $this->mdl_admin->mdl_read($_value['attach_admin_id']);
            }
        }

        //print_r($_arr_page);

        $_arr_tpl = array(
            'pageRow'    => $_arr_page,
            'attachRows' => $_arr_attachRows, //上传信息
        );

        $this->obj_tpl->tplDisplay('result', $_arr_tpl);
    }



    /**
     * setUpload function.
     *
     * @access private
     * @return void
     */
    private function setUpload() {
        $_arr_mimeRows = $this->mdl_mime->mdl_list(100);
        foreach ($_arr_mimeRows as $_key=>$_value) {
            $this->attachMime[strtolower($_value['mime_ext'])] = $_value['mime_content'];
        }

        $this->mdl_attach->thumbRows  = $this->mdl_thumb->mdl_list(100);
        $this->obj_upload->thumbRows  = $this->mdl_attach->thumbRows;
        $this->obj_upload->mimeRows   = $this->attachMime;
        $this->obj_upload->ext_image = $this->mdl_attach->ext_image;
    }
}
