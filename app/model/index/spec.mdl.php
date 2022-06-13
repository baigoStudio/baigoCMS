<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\index;

use app\model\Spec as Spec_Base;
use ginkgo\Config;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------栏目模型-------------*/
class Spec extends Spec_Base {

  protected function m_init() { //构造函数
    parent::m_init();

    $this->urlPrefix        = $this->obj_request->baseUrl(false, $this->routeType) . $this->routeSpec . '/';
    $this->urlPrefixMore    = $this->urlPrefix;
  }


  public function urlLists() {
    $_arr_urlRow = array(
      'url'           => '',
      'url_more'      => '',
      'param'         => 'page/',
      'param_more'    => 'page/',
      'suffix'        => '',
    );

    switch ($this->configVisit['visit_type']) {
      case 'static':
        $_arr_urlRow['url']         = $this->urlPrefix;
        $_arr_urlRow['url_more']    = $this->urlPrefixMore;
        $_arr_urlRow['param']       = 'page-';
        $_arr_urlRow['suffix']      = '.' . $this->configVisit['visit_file'];
      break;

      default:
        $_arr_urlRow['url'] = $this->urlPrefix;
      break;
    }

    return $_arr_urlRow;
  }


  public function urlProcess($arr_specRow) {
    $_arr_urlRow = array(
      'url'           => $this->urlPrefix . $arr_specRow['spec_url_name'],
      'url_more'      => '',
      'param'         => 'page/',
      'param_more'    => 'page/',
      'suffix'        => '',
    );

    return $_arr_urlRow;
  }
}
