<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Html;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Gsite_Source extends Ctrl {

  protected function c_init($param = array()) {
    parent::c_init();

    $this->obj_qlist        = Loader::classes('Qlist');

    $this->mdl_gsite        = Loader::model('Gsite');
  }


  public function index() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_gsiteRow = $this->gsiteProcess();

    if ($_arr_gsiteRow['rcode'] != 'y270102') {
      return $this->error($_arr_gsiteRow['msg'], $_arr_gsiteRow['rcode']);
    }

    $_arr_sourceRow = array(
      'url'       => $this->gsiteRow['gsite_url'],
      'content'   => '',
    );

    switch ($this->routeOrig['act']) {
      case 'form':
        $_str_selector = 'head';
      break;

      default:
        $_str_selector = 'body';
      break;
    }

    $_arr_rule = array(
      'content' => array($_str_selector, 'html'),
    );

    $_obj_dom = $this->obj_qlist->getRemote($this->gsiteRow['gsite_url'], $_arr_rule, $this->gsiteRow['gsite_charset']);

    if (isset($_obj_dom[0]['content'])) {
      $_arr_sourceRow['content'] = Html::encode($_obj_dom[0]['content']);
    }

    $_arr_tplData = array(
      'sourceRow' => $_arr_sourceRow,
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_gsiteRows);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function content() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_gsiteRow = $this->gsiteProcess();

    if ($_arr_gsiteRow['rcode'] != 'y270102') {
      return $this->error($_arr_gsiteRow['msg'], $_arr_gsiteRow['rcode']);
    }

    $_arr_sourceRow  = array(
      'url'       => '',
      'content'   => '',
    );

    if (Func::notEmpty($this->gsiteRow['gsite_list_selector'])) {
      $_arr_rule = array(
        'url' => array($this->gsiteRow['gsite_list_selector'], 'href'),
      );

      $_obj_dom = $this->obj_qlist->getRemote($this->gsiteRow['gsite_url'], $_arr_rule, $this->gsiteRow['gsite_charset']);

      if (isset($_obj_dom[0]['url']) && Func::notEmpty($_obj_dom[0]['url'])) {
        $_str_contentUrl    = Func::fillUrl($_obj_dom[0]['url'], $this->gsiteRow['gsite_url']);

        $_arr_contentRule = array(
          'content' => array('', 'html'),
        );

        $_obj_domContent    = $this->obj_qlist->getRemote($_str_contentUrl, $_arr_contentRule, $this->gsiteRow['gsite_charset']);

        $_arr_sourceRow['url'] = $_str_contentUrl;

        if (isset($_obj_domContent[0]['content'])) {
          $_arr_sourceRow['content'] = Html::encode($_obj_domContent[0]['content']);
        }
      }
    }

    $_arr_tplData = array(
      'sourceRow' => $_arr_sourceRow,
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_gsiteRows);

    $this->assign($_arr_tpl);

    return $this->fetch('index');
  }


  public function pageContent() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_gsiteRow = $this->gsiteProcess();

    if ($_arr_gsiteRow['rcode'] != 'y270102') {
      return $this->error($_arr_gsiteRow['msg'], $_arr_gsiteRow['rcode']);
    }

    $_arr_sourceRow  = array(
      'url'       => '',
      'content'   => '',
    );

    if (Func::notEmpty($this->gsiteRow['gsite_list_selector']) && Func::notEmpty($this->gsiteRow['gsite_page_list_selector'])) {
      $_arr_rule = array(
          'url' => array($this->gsiteRow['gsite_list_selector'], 'href'),
      );

      $_obj_dom = $this->obj_qlist->getRemote($this->gsiteRow['gsite_url'], $_arr_rule, $this->gsiteRow['gsite_charset']);

      if (isset($_obj_dom[0]['url']) && Func::notEmpty($_obj_dom[0]['url'])) {
        $_str_pageUrl    = Func::fillUrl($_obj_dom[0]['url'], $this->gsiteRow['gsite_url']);

        $_arr_pageRule = array(
          'url' => array($this->gsiteRow['gsite_page_list_selector'], 'href'),
        );

        $_obj_domPage    = $this->obj_qlist->getRemote($_str_pageUrl, $_arr_pageRule, $this->gsiteRow['gsite_charset']);

        if (isset($_obj_domPage[0]['url']) && Func::notEmpty($_obj_domPage[0]['url'])) {
          $_str_contentUrl    = Func::fillUrl($_obj_domPage[0]['url'], $this->gsiteRow['gsite_url']);

          $_arr_contentRule = array(
            'content' => array('', 'html'),
          );

          $_obj_domContent    = $this->obj_qlist->getRemote($_str_contentUrl, $_arr_contentRule, $this->gsiteRow['gsite_charset']);

          $_arr_sourceRow['url'] = $_str_contentUrl;

          if (isset($_obj_domContent[0]['content'])) {
            $_arr_sourceRow['content'] = Html::encode($_obj_domContent[0]['content']);
          }
        }
      }
    }

    $_arr_tplData = array(
      'sourceRow' => $_arr_sourceRow,
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_gsiteRows);

    $this->assign($_arr_tpl);

    return $this->fetch('index');
  }


  private function gsiteProcess() {
    if (!isset($this->groupAllow['gather']['gsite']) && !$this->isSuper) {
      return array(
        'msg'   => 'You do not have permission',
        'rcode' => 'x270303',
      );
    }

    $_num_gsiteId = 0;

    if (isset($this->param['id'])) {
      $_num_gsiteId = $this->obj_request->input($this->param['id'], 'int', 0);
    }

    if ($_num_gsiteId < 1) {
      return array(
        'msg'   => 'Missing ID',
        'rcode' => 'x270202',
      );
    }

    $_arr_gsiteRow = $this->mdl_gsite->read($_num_gsiteId);

    if ($_arr_gsiteRow['rcode'] != 'y270102') {
      return $_arr_gsiteRow;
    }

    $_arr_gsiteRow = $this->mdl_gsite->selectorProcess($_arr_gsiteRow);

    $this->gsiteRow = $_arr_gsiteRow;

    return $_arr_gsiteRow;
  }
}
