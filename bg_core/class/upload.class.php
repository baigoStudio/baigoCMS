<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------上传类-------------*/
class CLASS_UPLOAD {

    private $obj_ftp;
    private $obj_dir;
    private $ftp_status_conn;
    private $ftp_status_login;
    private $uploadSize; //允许上传大小
    private $attachExt; //扩展名
    private $attachPath; //路径
    private $attachName; //文件名
    private $fileTmp;
    public $ext_image = array();
    public $thumbRows  = array();
    public $mimeRows   = array();

    function __construct() { //构造函数
        $this->obj_dir          = new CLASS_DIR();
        $this->obj_dir->perms   = 0755;

        $this->obj_thumb        = new CLASS_THUMB();

        if (BG_MODULE_FTP > 0 && defined('BG_UPLOAD_FTPHOST') && !fn_isEmpty(BG_UPLOAD_FTPHOST)) {
            $this->obj_ftp = new CLASS_FTP(); //设置 FTP 对象
        }
    }


    /** 上传初始化
     * upload_init function.
     *
     * @access public
     * @param mixed $arr_mime 允许上传类型数组
     * @param mixed $arr_thumb 缩略图数组
     * @return void
     */
    function upload_init() {
        switch (BG_UPLOAD_UNIT) { //初始化单位
            case 'B':
                $_num_sizeUnit = 1;
            break;

            case 'KB':
                $_num_sizeUnit = 1024;
            break;

            case 'MB':
                $_num_sizeUnit = 1024 * 1024;
            break;

            case 'GB':
                $_num_sizeUnit = 1024 * 1024 * 1024;
            break;
        }
        $this->uploadSize = BG_UPLOAD_SIZE * $_num_sizeUnit;
        if (BG_MODULE_FTP > 0 && defined('BG_UPLOAD_FTPHOST') && !fn_isEmpty(BG_UPLOAD_FTPHOST)) {
            if (defined('BG_UPLOAD_FTPPASV') && BG_UPLOAD_FTPPASV == 'on') {
                $_bool_isPasv = true;
            } else {
                $_bool_isPasv = false;
            }
            $this->ftp_status_conn   = $this->obj_ftp->ftp_conn(BG_UPLOAD_FTPHOST, BG_UPLOAD_FTPPORT);
            $this->ftp_status_login  = $this->obj_ftp->ftp_login(BG_UPLOAD_FTPUSER, BG_UPLOAD_FTPPASS, $_bool_isPasv);

            if (!$this->ftp_status_conn) {
                return array(
                    'rcode' => 'x030301',
                );
            }
            if (!$this->ftp_status_login) {
                return array(
                    'rcode' => 'x030302',
                );
            }
        }

        return array(
            'rcode' => 'y070403',
        );
    }


    /** 上传预处理
     * upload_pre function.
     *
     * @access public
     * @return void
     */
    function upload_pre($check_size = true, $arr_attachFiles = false) {
        if ($arr_attachFiles) {
            $this->attachFiles = $arr_attachFiles;
        } else {
            $this->attachFiles = $_FILES['attach_files'];

            //是否上传文件校验
            if (!is_uploaded_file($this->attachFiles['tmp_name'])) {
                return array(
                    'rcode' => 'x070206',
                );
            }
        }

        if (isset($this->attachFiles['error'])) {
            switch ($this->attachFiles['error']) { //返回错误
                case 1:
                    return array(
                        'rcode' => 'x100201',
                    );
                break;
                case 2:
                    return array(
                        'rcode' => 'x100202',
                    );
                break;
                case 3:
                    return array(
                        'rcode' => 'x100203',
                    );
                break;
                case 4:
                    return array(
                        'rcode' => 'x100204',
                    );
                break;
                case 6:
                    return array(
                        'rcode' => 'x100206',
                    );
                break;
                case 7:
                    return array(
                        'rcode' => 'x100207',
                    );
                break;
            }
        }

        $_obj_finfo                   = new finfo();
        $this->attachFiles['mime']    = $_obj_finfo->file($this->attachFiles['tmp_name'], FILEINFO_MIME_TYPE);

        if ($this->attachFiles['mime'] == 'CDF V2 Document, corrupt: Can\'t expand summary_info') { //如果无法识别则以浏览器报告的 mime 为准
            if (isset($this->attachFiles['type'])) {
                $this->attachFiles['mime'] = $this->attachFiles['type'];
            }
        }

        $_str_ext = strtolower(pathinfo($this->attachFiles['name'], PATHINFO_EXTENSION)); //取得扩展名

        //扩展名与 MIME 不符的情况下, 反向查找, 如果允许, 则更改扩展名
        if (!isset($this->mimeRows[$_str_ext]) || !in_array($this->attachFiles['mime'], $this->mimeRows[$_str_ext])) {
            foreach ($this->mimeRows as $_key_allow=>$_value_allow) {
                if (in_array($this->attachFiles['mime'], $_value_allow)) {
                    $_str_ext = $_key_allow;
                    break;
                }
            }
        }

        if (!isset($this->mimeRows[$_str_ext])) { //该扩展名的 mime 数组是否存在
            return array(
                'rcode' => 'x070207',
            );
        }

        if (!in_array($this->attachFiles['mime'], $this->mimeRows[$_str_ext])) { //是否允许
            return array(
                'rcode' => 'x070202',
            );
        }

        if ($check_size && $this->attachFiles['size'] > $this->uploadSize) { //是否超过尺寸
            return array(
                'rcode' => 'x070203',
            );
        }

        $this->attachFiles['ext'] = $_str_ext;

        return array(
            'attach_tmp'    => $this->attachFiles['tmp_name'],
            'attach_ext'    => $this->attachFiles['ext'],
            'attach_mime'   => $this->attachFiles['mime'],
            'attach_name'   => $this->attachFiles['name'],
            'attach_size'   => $this->attachFiles['size'],
            'rcode'         => 'y100201',
        );
    }


    /** 提交上传
     * upload_submit function.
     *
     * @access public
     * @param mixed $tm_time 上传时间
     * @param mixed $num_attachId 文件ID
     * @return void
     */
    function upload_submit($tm_time, $num_attachId, $is_upload = true) {

        $_str_pathPre    = BG_PATH_ATTACH . date('Y', $tm_time) . DS . date('m', $tm_time) . DS;

        if (BG_MODULE_FTP > 0 && defined('BG_UPLOAD_FTPHOST') && !fn_isEmpty(BG_UPLOAD_FTPHOST) && defined('BG_UPLOAD_URL')) { //如果定义了FTP服务器，则加上 URL 前缀
            $_str_attachPre      = BG_UPLOAD_URL . '/';
        } else {
            $_str_attachPre      = BG_URL_ATTACH;
        }

        $_str_urlPre    = $_str_attachPre . date('Y', $tm_time) . '/' . date('m', $tm_time) . '/';
        $_str_ftpPre    = '/' . date('Y', $tm_time) . '/' . date('m', $tm_time) . '/';

        if (!$this->obj_dir->mk_dir($_str_pathPre)) { //建目录失败
            return array(
                'rcode' => 'x100101',
            );
        }

        $this->attachName = $num_attachId; //原始文件名

        $_arr_attachRow = array(
            'attach_id'     => $num_attachId,
            'attach_time'   => $tm_time,
            'attach_ext'    => $this->attachFiles['ext'],
            'attach_mime'   => $this->attachFiles['mime'],
        );

        if ($is_upload) {
            move_uploaded_file($this->attachFiles['tmp_name'], $_str_pathPre . $this->attachName . '.' . $this->attachFiles['ext']); //将上传的文件移到指定路径
        } else {
            rename($this->attachFiles['tmp_name'], $_str_pathPre . $this->attachName . '.' . $this->attachFiles['ext']);
        }

        if (file_exists($this->attachFiles['tmp_name'])) {
            unlink($this->attachFiles['tmp_name']);
        }

        if (BG_MODULE_FTP > 0 && defined('BG_UPLOAD_FTPHOST') && !fn_isEmpty(BG_UPLOAD_FTPHOST)) { //如果定义了FTP服务器，则上传到FTP
            if (!$this->ftp_status_conn) {
                return array(
                    'rcode' => 'x030301',
                );
            }
            if (!$this->ftp_status_login) {
                return array(
                    'rcode' => 'x030302',
                );
            }
            $_ftp_status = $this->obj_ftp->up_file($_str_pathPre . $this->attachName . '.' . $this->attachFiles['ext'], BG_UPLOAD_FTPPATH . $_str_ftpPre . $this->attachName . '.' . $this->attachFiles['ext']);
            if (!$_ftp_status) {
                return array(
                    'rcode' => 'x030303',
                );
            }
        }

        if (in_array($this->attachFiles['ext'], $this->ext_image)) { //如果是图片，则生成缩略图
            foreach ($this->thumbRows as $_key=>$_value) {
                $_arr_thumbRow = $this->obj_thumb->thumb_do($_value['thumb_width'], $_value['thumb_height'], $_value['thumb_type'], $_arr_attachRow);

                if (BG_MODULE_FTP > 0 && defined('BG_UPLOAD_FTPHOST') && !fn_isEmpty(BG_UPLOAD_FTPHOST)) { //如果定义了FTP服务器，则上传
                    if (!$this->ftp_status_conn) {
                        return array(
                            'rcode' => 'x030301',
                        );
                    }
                    if (!$this->ftp_status_login) {
                        return array(
                            'rcode' => 'x030302',
                        );
                    }
                    $_ftp_status = $this->obj_ftp->up_file($_arr_thumbRow['thumb_path'], BG_UPLOAD_FTPPATH . $_str_ftpPre . $_arr_thumbRow['thumb_name']);
                    if (!$_ftp_status) {
                        return array(
                            'rcode' => 'x030303',
                        );
                    }
                }

            }
            $_str_attachType = 'image';
        } else {
            $_str_attachType = 'file';
        }

        return array(
            'attach_path'    => $_str_pathPre . $this->attachName . '.' . $this->attachFiles['ext'],
            'attach_url'     => $_str_urlPre . $this->attachName . '.' . $this->attachFiles['ext'],
            'attach_type'    => $_str_attachType,
            'rcode'          => 'y070401',
        );
    }


    /** 删除
     * upload_del function.
     *
     * @access public
     * @param mixed $arr_attach 预删除的文件数组
     * @return void
     */
    function upload_del($arr_attach) {
        foreach ($arr_attach as $_key=>$_value) {
            $_str_filePath = date('Y', $_value['attach_time']) . DS . date('m', $_value['attach_time']) . DS . $_value['attach_id'] . '.' . $_value['attach_ext'];

            //print_r($_str_filePath);
            //exit;

            $this->obj_dir->del_file(BG_PATH_ATTACH . $_str_filePath);

            if (BG_MODULE_FTP > 0 && defined('BG_UPLOAD_FTPHOST') && !fn_isEmpty(BG_UPLOAD_FTPHOST)) { //是否定义FTP服务器
                if (!$this->ftp_status_conn) {
                    return array(
                        'rcode' => 'x030301',
                    );
                }
                if (!$this->ftp_status_login) {
                    return array(
                        'rcode' => 'x030302',
                    );
                }
                $this->obj_ftp->del_file(BG_UPLOAD_FTPPATH . DS . $_str_filePath);
            }

            //if (in_array($this->attachFiles['ext'], $this->ext_image)) { //如果是图片，则生成缩略图
                foreach ($this->thumbRows as $_key_thumb=>$_value_thumb) { //删除缩略图
                    $_str_thumbPath = date('Y', $_value['attach_time']) . DS . date('m', $_value['attach_time']) . DS . $_value['attach_id'] . '_' . $_value_thumb['thumb_width'] . '_' . $_value_thumb['thumb_height'] . '_' . $_value_thumb['thumb_type'] . '.' . $_value['attach_ext'];

                    $this->obj_dir->del_file(BG_PATH_ATTACH . $_str_thumbPath);

                    if (BG_MODULE_FTP > 0 && defined('BG_UPLOAD_FTPHOST') && !fn_isEmpty(BG_UPLOAD_FTPHOST)) {
                        if (!$this->ftp_status_conn) {
                            return array(
                                'rcode' => 'x030301',
                            );
                                    }
                        if (!$this->ftp_status_login) {
                            return array(
                                'rcode' => 'x030302',
                            );
                                    }
                        $this->obj_ftp->del_file(BG_UPLOAD_FTPPATH . DS . $_str_thumbPath);
                    }
                }
            //}
        }
    }


    /**
     * __destruct function.
     *
     * @access public
     * @return void
     */
    function __destruct() { //析构函数
        if (BG_MODULE_FTP > 0 && defined('BG_UPLOAD_FTPHOST') && !fn_isEmpty(BG_UPLOAD_FTPHOST)) {
            $this->obj_ftp->close();
        }
    }
}
