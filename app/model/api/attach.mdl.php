<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\api;

use app\model\index\Attach as Attach_Index;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------栏目模型-------------*/
class Attach extends Attach_Index {

  protected function m_init() {
    parent::m_init();

    $this->urlPrefix    = $this->obj_request->root(true) . $this->dirAttach;

    if (Func::notEmpty($this->configUpload['ftp_host']) && Func::notEmpty($this->configUpload['url_prefix'])) {
      $this->urlPrefix = Func::fixDs($this->configUpload['url_prefix'], '/');
    }
  }
}
