<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

if (!defined("BG_UPLOAD_URL")) {
    define("BG_UPLOAD_URL", "");
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
    public $config;
    public $mime_image = array();
    public $thumbRows  = array();
    public $mimeRows   = array();

    function __construct() { //构造函数
        $this->obj_base           = $GLOBALS["obj_base"]; //获取界面类型
        $this->config             = $this->obj_base->config;
        $this->obj_dir            = new CLASS_DIR();
        if (BG_MODULE_FTP > 0 && defined("BG_UPLOAD_FTPHOST") && !fn_isEmpty(BG_UPLOAD_FTPHOST)) {
            $this->obj_ftp        = new CLASS_FTP(); //设置 FTP 对象
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
            case "B":
                $_num_sizeUnit = 1;
            break;

            case "KB":
                $_num_sizeUnit = 1024;
            break;

            case "MB":
                $_num_sizeUnit = 1024 * 1024;
            break;

            case "GB":
                $_num_sizeUnit = 1024 * 1024 * 1024;
            break;
        }
        $this->uploadSize = BG_UPLOAD_SIZE * $_num_sizeUnit;
        if (BG_MODULE_FTP > 0 && defined("BG_UPLOAD_FTPHOST") && !fn_isEmpty(BG_UPLOAD_FTPHOST)) {
            if (defined("BG_UPLOAD_FTPPASV") && BG_UPLOAD_FTPPASV == "on") {
                $_bool_isPasv = true;
            } else {
                $_bool_isPasv = false;
            }
            $this->ftp_status_conn   = $this->obj_ftp->ftp_conn(BG_UPLOAD_FTPHOST, BG_UPLOAD_FTPPORT);
            $this->ftp_status_login  = $this->obj_ftp->ftp_login(BG_UPLOAD_FTPUSER, BG_UPLOAD_FTPPASS, $_bool_isPasv);

            if (!$this->ftp_status_conn) {
                return array(
                    "rcode" => "x030301",
                );
            }
            if (!$this->ftp_status_login) {
                return array(
                    "rcode" => "x030302",
                );
            }
        }

        return array(
            "rcode" => "y070403",
        );
    }


    /** 上传预处理
     * upload_pre function.
     *
     * @access public
     * @return void
     */
    function upload_pre() {
        $this->attachFiles = $_FILES["attach_files"];

        switch ($this->attachFiles["error"]) { //返回错误
            case 1:
                return array(
                    "rcode" => "x100201",
                );
            break;
            case 2:
                return array(
                    "rcode" => "x100202",
                );
            break;
            case 3:
                return array(
                    "rcode" => "x100203",
                );
            break;
            case 4:
                return array(
                    "rcode" => "x100204",
                );
            break;
            case 6:
                return array(
                    "rcode" => "x100206",
                );
            break;
            case 7:
                return array(
                    "rcode" => "x100207",
                );
            break;
        }


        $_obj_finfo                   = new finfo();
        $this->attachFiles["mime"]    = $_obj_finfo->file($this->attachFiles["tmp_name"], FILEINFO_MIME_TYPE);
        if (isset($this->mimeRows[$this->attachFiles["mime"]])) {
            $_str_ext = $this->mimeRows[$this->attachFiles["mime"]];
        } else {
            $_str_ext = pathinfo($this->attachFiles["name"], PATHINFO_EXTENSION); //取得扩展名
        }
        $this->attachFiles["ext"]     = strtolower($_str_ext); //扩展名

        if (!array_key_exists($this->attachFiles["mime"], $this->mimeRows)) { //是否允许
            return array(
                "rcode" => "x070202",
            );
        }

        if ($this->attachFiles["size"] > $this->uploadSize) { //是否超过尺寸
            return array(
                "rcode" => "x070203",
            );
        }

        return array(
            "attach_tmp"    => $this->attachFiles["tmp_name"],
            "attach_ext"    => $this->attachFiles["ext"],
            "attach_mime"   => $this->attachFiles["mime"],
            "attach_name"   => $this->attachFiles["name"],
            "attach_size"   => $this->attachFiles["size"],
            "rcode"         => "y100201",
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
    function upload_submit($tm_time, $num_attachId) {

        $this->attachPath    = BG_PATH_ATTACH . date("Y", $tm_time) . "/" . date("m", $tm_time) . "/";

        if (BG_MODULE_FTP > 0 && defined("BG_UPLOAD_FTPHOST") && !fn_isEmpty(BG_UPLOAD_FTPHOST) && defined("BG_UPLOAD_URL")) { //如果定义了FTP服务器，则加上 URL 前缀
            $_str_attachPre      = BG_UPLOAD_URL . "/";
        } else {
            $_str_attachPre      = BG_URL_ATTACH;
        }

        $_str_attachUrl   = $_str_attachPre . date("Y", $tm_time) . "/" . date("m", $tm_time) . "/";
        $this->attachFtp  = "/" . date("Y", $tm_time) . "/" . date("m", $tm_time) . "/";

        if (!$this->obj_dir->mk_dir($this->attachPath)) { //建目录失败
            return array(
                "rcode" => "x100101",
            );
        }

        $this->attachName = $num_attachId; //原始文件名

        move_uploaded_file($this->attachFiles["tmp_name"], $this->attachPath . $this->attachName . "." . $this->attachFiles["ext"]); //将上传的文件移到指定路径

        if (BG_MODULE_FTP > 0 && defined("BG_UPLOAD_FTPHOST") && !fn_isEmpty(BG_UPLOAD_FTPHOST)) { //如果定义了FTP服务器，则上传到FTP
            if (!$this->ftp_status_conn) {
                return array(
                    "rcode" => "x030301",
                );
            }
            if (!$this->ftp_status_login) {
                return array(
                    "rcode" => "x030302",
                );
            }
            $_ftp_status = $this->obj_ftp->up_file($this->attachPath . $this->attachName . "." . $this->attachFiles["ext"], BG_UPLOAD_FTPPATH . $this->attachFtp . $this->attachName . "." . $this->attachFiles["ext"]);
            if (!$_ftp_status) {
                return array(
                    "rcode" => "x030303",
                );
            }
        }

        if (array_key_exists($this->attachFiles["mime"], $this->mime_image)) { //如果是图片，则生成缩略图
            foreach ($this->thumbRows as $_key=>$_value) {
                $_arr_thumbRow = $this->thumb_do($_value["thumb_width"], $_value["thumb_height"], $_value["thumb_type"]);
            }
            $_str_attachType = "image";
        } else {
            $_str_attachType = "file";
        }

        /*if (BG_MODULE_FTP > 0 && defined("BG_UPLOAD_FTPHOST") && strlen(BG_UPLOAD_FTPHOST) > 1 && file_exists($this->attachPath . $this->attachName . "." . $this->attachFiles["ext"])) { //如果FTP上传成功，且文件存在，在上传完成后删除
            $this->obj_dir->del_file($this->attachPath . $this->attachName . "." . $this->attachFiles["ext"]);
        }*/

        return array(
            "attach_path"    => $this->attachPath . $this->attachName . "." . $this->attachFiles["ext"],
            "attach_url"     => $_str_attachUrl . $this->attachName . "." . $this->attachFiles["ext"],
            "attach_type"    => $_str_attachType,
            "rcode"          => "y070401",
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
            $_str_filePath = date("Y", $_value["attach_time"]) . "/" . date("m", $_value["attach_time"]) . "/" . $_value["attach_id"] . "." . $_value["attach_ext"];

            //print_r($_str_filePath);
            //exit;

            $this->obj_dir->del_file(BG_PATH_ATTACH . $_str_filePath);

            if (BG_MODULE_FTP > 0 && defined("BG_UPLOAD_FTPHOST") && !fn_isEmpty(BG_UPLOAD_FTPHOST)) { //是否定义FTP服务器
                if (!$this->ftp_status_conn) {
                    return array(
                        "rcode" => "x030301",
                    );
                }
                if (!$this->ftp_status_login) {
                    return array(
                        "rcode" => "x030302",
                    );
                }
                $this->obj_ftp->del_file(BG_UPLOAD_FTPPATH . "/" . $_str_filePath);
            }

            //if (array_key_exists($this->attachFiles["mime"], $this->mime_image)) { //如果是图片，则生成缩略图
                foreach ($this->thumbRows as $_key_thumb=>$_value_thumb) { //删除缩略图
                    $_str_thumbPath = date("Y", $_value["attach_time"]) . "/" . date("m", $_value["attach_time"]) . "/" . $_value["attach_id"] . "_" . $_value_thumb["thumb_width"] . "_" . $_value_thumb["thumb_height"] . "_" . $_value_thumb["thumb_type"] . "." . $_value["attach_ext"];

                    $this->obj_dir->del_file(BG_PATH_ATTACH . $_str_thumbPath);

                    if (BG_MODULE_FTP > 0 && defined("BG_UPLOAD_FTPHOST") && !fn_isEmpty(BG_UPLOAD_FTPHOST)) {
                        if (!$this->ftp_status_conn) {
                            return array(
                                "rcode" => "x030301",
                            );
                                    }
                        if (!$this->ftp_status_login) {
                            return array(
                                "rcode" => "x030302",
                            );
                                    }
                        $this->obj_ftp->del_file(BG_UPLOAD_FTPPATH . "/" . $_str_thumbPath);
                    }
                }
            //}
        }
    }


    /** 生成缩略图
     * thumb_do function.
     *
     * @access public
     * @param mixed $num_width 宽度
     * @param mixed $num_height 高度
     * @param string $str_type (default: "ratio") 类型（默认等比例）
     * @return void
     */
    function thumb_do($num_width, $num_height, $str_type = "ratio", $arr_attachRow = false) {

        if ($arr_attachRow) {
            $this->attachName            = $arr_attachRow["attach_id"];
            $this->attachPath            = BG_PATH_ATTACH . date("Y", $arr_attachRow["attach_time"]) . "/" . date("m", $arr_attachRow["attach_time"]) . "/";
            $this->attachFiles["ext"]    = $arr_attachRow["attach_ext"];
            $this->attachFiles["mime"]   = $arr_attachRow["attach_mime"];
            /*if (BG_MODULE_FTP > 0 && defined("BG_UPLOAD_FTPHOST") && strlen(BG_UPLOAD_FTPHOST) > 1) { //如果定义了FTP服务器，则上传
                $this->attachFtp             = "/" . date("Y", $arr_attachRow["attach_time"]) . "/" . date("m", $arr_attachRow["attach_time"]) . "/";
                $this->ftp_status_conn       = $this->obj_ftp->ftp_conn(BG_UPLOAD_FTPHOST, BG_UPLOAD_FTPPORT);
                $this->ftp_status_login      = $this->obj_ftp->ftp_login(BG_UPLOAD_FTPUSER, BG_UPLOAD_FTPPASS);
            }*/
        }

        $_str_srcPath = $this->attachPath . $this->attachName . "." . $this->attachFiles["ext"]; //源图片
        $_str_dstFile = $this->attachName . "_" . $num_width . "_" . $num_height . "_" . $str_type . "." . $this->attachFiles["ext"]; //目标缩略图
        $_str_dstPath = $this->attachPath . $_str_dstFile; //目标缩略图

        switch ($this->attachFiles["mime"]) { //创建图片对象
            case "image/jpeg":
            case "image/pjpeg":
                $_src_image = imagecreatefromjpeg($_str_srcPath);
            break;

            case "image/gif":
                $_src_image = imagecreatefromgif($_str_srcPath);
            break;

            case "image/png":
            case "image/x-png":
                $_src_image = imagecreatefrompng($_str_srcPath);
            break;

            case "image/bmp":
            case "image/x-ms-bmp":
            case "image/x-windows-bmp":
                $_src_image = imagecreatefromwbmp($_str_srcPath);
            break;
        }

        if (!$_src_image) {
            return array(
                "rcode" => "x070402",
            );
        }

        $_width_src       = imagesx($_src_image); //取得源图片的尺寸
        $_height_src      = imagesy($_src_image);
        $_arr_thumb_size  = $this->size_process($num_width, $num_height, $_width_src, $_height_src, $str_type); //计算缩略图尺寸

        if ($_arr_thumb_size["width_dst"] >= $_width_src && $_arr_thumb_size["height_dst"] >= $_height_src) { //如果源图片小于目标缩略图，则只是拷贝
            copy($_str_srcPath, $_str_dstPath);

            if (BG_MODULE_FTP > 0 && defined("BG_UPLOAD_FTPHOST") && !fn_isEmpty(BG_UPLOAD_FTPHOST)) { //如果定义了FTP服务器，则上传
                if (!$this->ftp_status_conn) {
                    return array(
                        "rcode" => "x030301",
                    );
                }
                if (!$this->ftp_status_login) {
                    return array(
                        "rcode" => "x030302",
                    );
                }
                $_ftp_status = $this->obj_ftp->up_file($_str_dstPath, BG_UPLOAD_FTPPATH . $this->attachFtp . $_str_dstFile);
                if (!$_ftp_status) {
                    return array(
                        "rcode" => "x030303",
                    );
                }
                /*if (file_exists($_str_dstPath)) {
                    $this->obj_dir->del_file($_str_dstPath);
                }*/
            }

            return array(
                "rcode" => "x070402",
            );
        }

        $_dst_image = imagecreatetruecolor($_arr_thumb_size["width_dst"], $_arr_thumb_size["height_dst"]); //根据计算结果生成毛图片
        $_dst_image = $this->transparent_process($_dst_image);

        switch ($str_type) {
            case "cut": //裁切
                $_tmp_image = imagecreatetruecolor($_arr_thumb_size["width_tmp"], $_arr_thumb_size["height_tmp"]);
                $_tmp_image = $this->transparent_process($_tmp_image);

                imagecopyresampled($_tmp_image, $_src_image, 0, 0, 0, 0, $_arr_thumb_size["width_tmp"], $_arr_thumb_size["height_tmp"], $_width_src, $_height_src); //先缩小
                imagecopy($_dst_image, $_tmp_image, 0, 0, $_arr_thumb_size["width_cut"], $_arr_thumb_size["height_cut"], $_arr_thumb_size["width_dst"], $_arr_thumb_size["height_dst"]); //合成
                imagedestroy($_tmp_image);
            break;
            default: //按比例缩小
                imagecopyresampled($_dst_image, $_src_image, 0, 0, 0, 0, $_arr_thumb_size["width_tmp"], $_arr_thumb_size["height_tmp"], $_width_src, $_height_src); //直接缩小
            break;
        }

        switch ($this->attachFiles["mime"]) { //生成最终图片
            case "image/jpeg":
            case "image/pjpeg":
                imagejpeg($_dst_image, $_str_dstPath);
            break;

            case "image/gif":
                imagegif($_dst_image, $_str_dstPath);
            break;

            case "image/png":
            case "image/x-png":
                imagepng($_dst_image, $_str_dstPath);
            break;

            case "image/bmp":
            case "image/x-ms-bmp":
            case "image/x-windows-bmp":
                imagewbmp($_dst_image, $_str_dstPath);
            break;
        }

        imagedestroy($_src_image); //清空对象
        imagedestroy($_dst_image);

        if (BG_MODULE_FTP > 0 && defined("BG_UPLOAD_FTPHOST") && !fn_isEmpty(BG_UPLOAD_FTPHOST)) { //如果定义了FTP服务器，则上传
            if (!$this->ftp_status_conn) {
                return array(
                    "rcode" => "x030301",
                );
            }
            if (!$this->ftp_status_login) {
                return array(
                    "rcode" => "x030302",
                );
            }
            $_ftp_status = $this->obj_ftp->up_file($_str_dstPath, BG_UPLOAD_FTPPATH . $this->attachFtp . $_str_dstFile);
            if (!$_ftp_status) {
                return array(
                    "rcode" => "x030303",
                );
            }
            /*if (file_exists($_str_dstPath)) {
                $this->obj_dir->del_file($_str_dstPath);
            }*/
        }

        return array(
            "rcode" => "y070402",
        );
    }


    /** 计算缩略图尺寸
     * size_process function.
     *
     * @access public
     * @param mixed $num_width 宽度
     * @param mixed $num_height 高度
     * @param mixed $width_src 原始宽度
     * @param mixed $height_src 原始高度
     * @param string $str_type (default: "ratio") 类型（默认等比例）
     * @return void
     */
    private function size_process($num_width, $num_height, $width_src, $height_src, $str_type = "ratio") {

        switch ($str_type) {
            case "cut": //裁切
                if ($width_src > $height_src) { //横向
                    $_height_tmp   = intval($num_height); //缩小高度
                    $_width_tmp    = intval($width_src / $height_src * $_height_tmp); //按比例计算宽度
                    $_height_cut   = 0;
                    $_width_cut    = intval(($_width_tmp - $num_width) / 2); //需裁切的部分
                    if ($_width_tmp < $num_width) { //如缩小后，宽度小于设定的宽度，则按照宽度重新计算
                        $_width_tmp   = intval($num_width);
                        $_height_tmp  = intval($_width_tmp / ($width_src / $height_src));
                        $_width_cut   = 0;
                        $_height_cut  = intval(($_height_tmp - $num_height) / 2);
                    }
                } else { //纵向
                    $_width_tmp    = intval($num_width); //缩小宽度
                    $_height_tmp   = intval($height_src / $width_src * $_width_tmp); //按比例计算高度
                    $_width_cut    = 0;
                    $_height_cut   = intval(($_height_tmp - $num_height) / 2); //需裁切的部分
                    if ($_height_tmp < $num_height) { //如缩小后，高度小于设定的高度，则按照高度重新计算
                        $_height_tmp  = intval($num_height);
                        $_width_tmp   = intval($_height_tmp / ($height_src / $width_src));
                        $_height_cut  = 0;
                        $_width_cut   = intval(($_width_tmp - $num_width) / 2);
                    }
                }

                $_width_dst     = $num_width;
                $_height_dst    = $num_height;
            break;

            default: //按比例缩小
                if ($width_src > $height_src) { //横向
                    $_width_tmp    = intval($num_width); //缩小宽度
                    $_height_tmp   = intval($height_src / $width_src * $_width_tmp); //按比例计算高度
                    if ($_height_tmp > $num_height) { //如缩小后，高度大于设定高度，则按照高度重新计算
                        $_height_tmp  = intval($num_height);
                        $_width_tmp   = intval($_height_tmp / ($height_src / $width_src));
                    }
                } else { //纵向
                    $_height_tmp   = intval($num_height); //缩小高度
                    $_width_tmp    = intval($width_src / $height_src * $_height_tmp); //按比例计算宽度
                    if ($_width_tmp > $num_width) { //如缩小后，宽度大于设定宽度，则按照宽度重新计算
                        $_width_tmp   = intval($num_width);
                        $_height_tmp  = intval($_width_tmp / ($width_src / $height_src));
                    }
                }
                $_width_cut     = 0;
                $_height_cut    = 0;
                $_width_dst     = $_width_tmp;
                $_height_dst    = $_height_tmp;
            break;
        }

        return array(
            "width_tmp"  => $_width_tmp,
            "height_tmp" => $_height_tmp,
            "width_cut"  => $_width_cut,
            "height_cut" => $_height_cut,
            "width_dst"  => $_width_dst,
            "height_dst" => $_height_dst,
        );
    }


    private function transparent_process($_res_image) {
        switch ($this->attachFiles["mime"]) { //创建图片对象

            case "image/gif":
                $_color_bg = imagecolorallocate($_res_image, 255, 255, 255);
                imagefill($_res_image, 0, 0, $_color_bg);
                imagecolortransparent($_res_image, $_color_bg);
            break;

            case "image/png":
            case "image/x-png":
                imagealphablending($_res_image, false);
                $_color_transparent = imagecolorallocatealpha($_res_image, 0, 0, 0, 127);
                imagefill($_res_image, 0, 0, $_color_transparent);
                imagesavealpha($_res_image, true);
            break;
        }

        return $_res_image;
    }

    /**
     * __destruct function.
     *
     * @access public
     * @return void
     */
    function __destruct() { //析构函数
        if (BG_MODULE_FTP > 0 && defined("BG_UPLOAD_FTPHOST") && !fn_isEmpty(BG_UPLOAD_FTPHOST)) {
            $this->obj_ftp->close();
        }
    }
}
