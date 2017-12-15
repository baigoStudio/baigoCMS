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
class CLASS_THUMB {

	public $jpeg_quality = 90;

    /** 生成缩略图
     * thumb_do function.
     *
     * @access public
     * @param mixed $num_width 宽度
     * @param mixed $num_height 高度
     * @param string $str_type (default: 'ratio') 类型（默认等比例）
     * @return void
     */
    function thumb_do($num_width, $num_height, $str_type = 'ratio', $arr_attachRow = array()) {

        $this->attachName            = $arr_attachRow['attach_id'];
        $this->attachPath            = BG_PATH_ATTACH . date('Y', $arr_attachRow['attach_time']) . DS . date('m', $arr_attachRow['attach_time']) . DS;
        $this->attachFiles['ext']    = $arr_attachRow['attach_ext'];
        $this->attachFiles['mime']   = $arr_attachRow['attach_mime'];

        $_str_srcPath   = $this->attachPath . $this->attachName . '.' . $this->attachFiles['ext']; //源图片
        $_str_thumbName = $this->attachName . '_' . $num_width . '_' . $num_height . '_' . $str_type . '.' . $this->attachFiles['ext']; //目标缩略图
        $_str_thumbPath = $this->attachPath . $_str_thumbName; //目标缩略图

        switch ($this->attachFiles['mime']) { //创建图片对象
            case 'image/jpeg':
            case 'image/pjpeg':
                $_src_image = imagecreatefromjpeg($_str_srcPath);
            break;

            case 'image/gif':
                $_src_image = imagecreatefromgif($_str_srcPath);
            break;

            case 'image/png':
            case 'image/x-png':
                $_src_image = imagecreatefrompng($_str_srcPath);
            break;

            case 'image/bmp':
            case 'image/x-ms-bmp':
            case 'image/x-windows-bmp':
                $_src_image = imagecreatefromwbmp($_str_srcPath);
            break;
        }
        
        if (!$_src_image) {
            return array(
                'thumb_name'    => $_str_thumbName,
                'thumb_path'    => $_str_thumbPath,
                'rcode'         => 'x070402',
            );
        }

        $_width_src       = imagesx($_src_image); //取得源图片的尺寸
        $_height_src      = imagesy($_src_image);
        $_arr_thumb_size  = $this->size_process($num_width, $num_height, $_width_src, $_height_src, $str_type); //计算缩略图尺寸

        if ($_arr_thumb_size['width_dst'] >= $_width_src && $_arr_thumb_size['height_dst'] >= $_height_src) { //如果源图片小于目标缩略图，则只是拷贝
            copy($_str_srcPath, $_str_thumbPath);

            return array(
                'thumb_name'    => $_str_thumbName,
                'thumb_path'    => $_str_thumbPath,
                'rcode'         => 'x070402',
            );
        }

        $_dst_image = imagecreatetruecolor($_arr_thumb_size['width_dst'], $_arr_thumb_size['height_dst']); //根据计算结果生成毛图片
        $_dst_image = $this->transparent_process($_dst_image);

        switch ($str_type) {
            case 'cut': //裁切
                $_tmp_image = imagecreatetruecolor($_arr_thumb_size['width_tmp'], $_arr_thumb_size['height_tmp']);
                $_tmp_image = $this->transparent_process($_tmp_image);

                imagecopyresampled($_tmp_image, $_src_image, 0, 0, 0, 0, $_arr_thumb_size['width_tmp'], $_arr_thumb_size['height_tmp'], $_width_src, $_height_src); //先缩小
                imagecopy($_dst_image, $_tmp_image, 0, 0, $_arr_thumb_size['width_cut'], $_arr_thumb_size['height_cut'], $_arr_thumb_size['width_dst'], $_arr_thumb_size['height_dst']); //合成
                imagedestroy($_tmp_image);
            break;
            default: //按比例缩小
                imagecopyresampled($_dst_image, $_src_image, 0, 0, 0, 0, $_arr_thumb_size['width_tmp'], $_arr_thumb_size['height_tmp'], $_width_src, $_height_src); //直接缩小
            break;
        }

        switch ($this->attachFiles['mime']) { //生成最终图片
            case 'image/jpeg':
            case 'image/pjpeg':
                imagejpeg($_dst_image, $_str_thumbPath, $this->jpeg_quality);
            break;

            case 'image/gif':
                imagegif($_dst_image, $_str_thumbPath);
            break;

            case 'image/png':
            case 'image/x-png':
                imagepng($_dst_image, $_str_thumbPath);
            break;

            case 'image/bmp':
            case 'image/x-ms-bmp':
            case 'image/x-windows-bmp':
                imagewbmp($_dst_image, $_str_thumbPath);
            break;
        }

        imagedestroy($_src_image); //清空对象
        imagedestroy($_dst_image);


        return array(
            'thumb_name'    => $_str_thumbName,
            'thumb_path'    => $_str_thumbPath,
            'rcode'         => 'y070402',
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
     * @param string $str_type (default: 'ratio') 类型（默认等比例）
     * @return void
     */
    private function size_process($num_width, $num_height, $width_src, $height_src, $str_type = 'ratio') {

        switch ($str_type) {
            case 'cut': //裁切
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
            'width_tmp'  => $_width_tmp,
            'height_tmp' => $_height_tmp,
            'width_cut'  => $_width_cut,
            'height_cut' => $_height_cut,
            'width_dst'  => $_width_dst,
            'height_dst' => $_height_dst,
        );
    }


    private function transparent_process($_res_image) {
        switch ($this->attachFiles['mime']) { //创建图片对象
            case 'image/gif':
                $_color_bg = imagecolorallocate($_res_image, 255, 255, 255);
                imagefill($_res_image, 0, 0, $_color_bg);
                imagecolortransparent($_res_image, $_color_bg);
            break;

            case 'image/png':
            case 'image/x-png':
                imagealphablending($_res_image, false);
                $_color_transparent = imagecolorallocatealpha($_res_image, 0, 0, 0, 127);
                imagefill($_res_image, 0, 0, $_color_transparent);
                imagesavealpha($_res_image, true);
            break;
        }

        return $_res_image;
    }
}
