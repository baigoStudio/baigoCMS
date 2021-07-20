<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\misc;

use ginkgo\Image;
use ginkgo\Smtp;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

class Misc {

    public function image() {
        $this->obj_image = Image::instance();

        $this->obj_image->open(GK_PATH_PUBLIC . GK_NAME_STATIC . DS . 'cms' . DS . 'image' . DS . 'index_slide_1.jpg');

        $_mix_content = $this->obj_image->stamp(GK_PATH_PUBLIC . GK_NAME_STATIC . DS . 'cms' . DS . 'image' . DS . 'logo.png')->output();

        //print_r($this->obj_image->error);

        return $_mix_content;
    }


    public function smtp() {
        $this->obj_smtp = Smtp::instance();

        $this->obj_smtp->addRcpt('baigo@baigo.net');
        $this->obj_smtp->setSubject('test Subject');
        $this->obj_smtp->setContent('<div>test content!</div><div><a href="#test">link</a></div>');
        $this->obj_smtp->send();

        //print_r($this->obj_smtp->error);
    }
}
