<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}


fn_include(BG_PATH_LIB . 'QueryList' . DS . 'autoload.php');
use QL\QueryList;


/**
 * fn_getPic function.
 *
 * @access public
 * @param mixed $str_html
 * @return void
 */
function fn_qlistAttach($str_html = '') {
    $_arr_attachIds = array();

    if (!fn_isEmpty($str_html)) {
        if (BG_MODULE_FTP > 0 && defined('BG_UPLOAD_FTPHOST') && !fn_isEmpty(BG_UPLOAD_FTPHOST) && defined('BG_UPLOAD_URL')) {
            $_attachPre = BG_UPLOAD_URL . '/';
        } else {
            $_attachPre = BG_URL_ATTACH;
        }

        $_arr_rule = array(
            'img_src'   => array('img[src*=\'' . $_attachPre . '\']', 'src'),
        );

        $_arr_data = QueryList::Query($str_html, $_arr_rule)->getData(
            function($_item){
                return $_item;
            }
        );

        foreach ($_arr_data as $_key=>$_value) {
            $_arr_attach    = explode('/', $_value['img_src']); //将路径转换成数组
            $_str_name      = end($_arr_attach); //得到文件名

            if (stristr($_str_name, '_')) {
                $_arr_name  = explode('_', $_str_name); //将文件名转换成数组
            } else {
                $_arr_name  = explode('.', $_str_name); //将文件名转换成数组
            }

            $_arr_attachIds[] = $_arr_name[0]; //得到文件id
        }
    }

    if (fn_isEmpty($_arr_attachIds)) {
        $_arr_attachIds = array(0);
    }

    return $_arr_attachIds;
}


function fn_qlistImg($str_html = '', $arr_filter = array()) {
    if (BG_MODULE_FTP > 0 && defined('BG_UPLOAD_FTPHOST') && !fn_isEmpty(BG_UPLOAD_FTPHOST) && defined('BG_UPLOAD_URL')) {
        $_attachPre = BG_UPLOAD_URL . '/';
    } else {
        $_attachPre = BG_URL_ATTACH;
    }

    $_arr_data      = array();
    $_arr_return    = array();

    if (!fn_isEmpty($str_html)) {
        $_arr_rule = array(
            'img_src'   => array('img', 'src'),
            //'img_html'  => array('img', 'html'),
        );

        $_arr_data = QueryList::Query($str_html, $_arr_rule)->getData(
            function($_item){
                return $_item;
            }
        );
    }

    if (!fn_isEmpty($_arr_data)) {
        foreach ($_arr_data as $_key=>$_value) {
            if (isset($_value['img_src']) && !stristr($_value['img_src'], $_attachPre)) { //有值且 URL 不属于本站
                if (fn_isEmpty($arr_filter)) {
                    $_arr_return[] = $_value;
                } else {
                    foreach ($arr_filter as $_key_filter=>$_value_filter) {
                        if (!stristr($_value_filter, $_value)) {
                            $_arr_return[] = $_value;
                        }
                    }
                }
            }
        }
    }

    return $_arr_return;
}


function fn_qlistDom($str_url, $arr_rule, $str_charset = 'UTF-8') {
    $str_charset = strtoupper($str_charset);

    $_arr_data = QueryList::Query($str_url, $arr_rule, null, 'UTF-8', $str_charset)->getData(
        function($_item){
            return $_item;
        }
    );

    return $_arr_data;
}


function fn_gatherImg($arr_qlistImgs = array(), $num_adminId = 0) {
    $_arr_uploadSubmits = array();

    $_obj_upload        = new CLASS_UPLOAD();
    $_obj_file          = new CLASS_FILE();
    $_mdl_attach        = new MODEL_ATTACH();
    $_mdl_thumb         = new MODEL_THUMB();
    $_mdl_mime          = new MODEL_MIME();

    $_arr_mimeRows = $_mdl_mime->mdl_list(100);
    foreach ($_arr_mimeRows as $_key=>$_value) {
        $attachMime[strtolower($_value['mime_ext'])] = $_value['mime_content'];
    }

    $_mdl_attach->thumbRows  = $_mdl_thumb->mdl_list(100);
    $_obj_upload->thumbRows  = $_mdl_attach->thumbRows;
    $_obj_upload->mimeRows   = $attachMime;
    $_obj_upload->ext_image  = $_mdl_attach->ext_image;

    if (!fn_isEmpty($attachMime)) {
        $_arr_status = $_obj_upload->upload_init();
        if ($_arr_status['rcode'] == 'y070403') {
            //$arr_qlistImgs = array();
            foreach ($arr_qlistImgs as $_key=>$_value) {
                $_str_tmpMd5        = md5($_value['img_src']);
                $_arr_attachRow     = $_mdl_attach->mdl_read($_str_tmpMd5, 'attach_urlcheck', 'normal');

                if ($_arr_attachRow['rcode'] != 'y070102') {
                    $_arr_remoteFile    = fn_http($_value['img_src']);

                    if (!$_arr_remoteFile['errno']) {
                        $_str_tmpName   = BG_PATH_CACHE . 'ssin' . DS . $_str_tmpMd5;
                        $_arr_name      = explode('/', $_value['img_src']);
                        $_str_name      = end($_arr_name);
                        $_num_size      = $_obj_file->file_put($_str_tmpName, $_arr_remoteFile['ret']);

                        $_arr_attachFiles = array(
                            'tmp_name'  => $_str_tmpName,
                            'name'      => $_str_name,
                            'size'      => $_num_size,
                        );

                        $_arr_uploadRow = $_obj_upload->upload_pre(false, $_arr_attachFiles);

                        if ($_arr_uploadRow['rcode'] == 'y100201') {
                            $_arr_attachSubmit = $_mdl_attach->mdl_submit(0, $_arr_uploadRow['attach_name'], $_arr_uploadRow['attach_ext'], $_arr_uploadRow['attach_mime'], $_arr_uploadRow['attach_size'], $num_adminId, $_str_tmpMd5);

                            if ($_arr_attachSubmit['rcode'] == 'y070101') {
                                $_arr_uploadSubmit = $_obj_upload->upload_submit($_arr_attachSubmit['attach_time'], $_arr_attachSubmit['attach_id'], false);
                                if ($_arr_uploadSubmit['rcode'] == 'y070401') {
                                    /*$_arr_attachRows[]      = $_arr_attachRow;
                                    $_arr_attachSubmits[]   = $_arr_attachSubmit;*/
                                    $_arr_uploadSubmit['attach_id']     = $_arr_attachSubmit['attach_id'];
                                    $_arr_uploadSubmit['attach_time']   = $_arr_attachSubmit['attach_time'];
                                    $_arr_uploadSubmit['img_src']       = $_value['img_src'];
                                    $_arr_uploadSubmits[]               = $_arr_uploadSubmit;
                                }
                            }
                        } else {
                            $_obj_file->file_del($_str_tmpName);
                        }
                    }
                }
            }
        }
    }

    return $_arr_uploadSubmits;
}
