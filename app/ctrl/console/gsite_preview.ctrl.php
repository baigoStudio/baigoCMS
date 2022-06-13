<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Config;
use ginkgo\Html;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Gsite_Preview extends Ctrl {

  protected function c_init($param = array()) {
    parent::c_init();

    $this->obj_qlist        = Loader::classes('Qlist');
    $this->obj_html         = Html::instance();

    $this->mdl_gsite        = Loader::model('Gsite');
  }


  public function lists() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_gsiteRow = $this->gsiteProcess();

    if ($_arr_gsiteRow['rcode'] != 'y270102') {
      return $this->error($_arr_gsiteRow['msg'], $_arr_gsiteRow['rcode'], 404);
    }

    $_arr_gsiteRow  = $this->gsiteRow;
    $_arr_listRows  = array();

    if (Func::notEmpty($_arr_gsiteRow['gsite_list_selector'])) {
      $_arr_rule = array(
        'url'       => array($_arr_gsiteRow['gsite_list_selector'], 'href'),
        'content'   => array($_arr_gsiteRow['gsite_list_selector'], 'html'),
      );

      $_obj_dom = $this->obj_qlist->getRemote($_arr_gsiteRow['gsite_url'], $_arr_rule, $_arr_gsiteRow['gsite_charset']);

      if (Func::notEmpty($_obj_dom)) {
        foreach($_obj_dom as $_key=>$_value) {
          $_arr_listRows[] = array(
              'url'       => Func::fillUrl($_value['url'], $_arr_gsiteRow['gsite_url']),
              'content'   => $_value['content'],
          );
        }
      }
    }

    $_arr_tplData = array(
      'listRows'  => $_arr_listRows,
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

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
      return $this->error($_arr_gsiteRow['msg'], $_arr_gsiteRow['rcode'], 404);
    }

    $_arr_gsiteRow      = $this->gsiteRow;

    $_str_configContent = BG_PATH_CONFIG . 'console' . DS . 'gsite_step_content' . GK_EXT_INC;
    $_arr_configContent = Config::load($_str_configContent, 'gsite_step_content', 'console');
    $_arr_contentKeys   = array_keys($_arr_configContent);

    $_arr_contentRow    = array();

    foreach ($_arr_contentKeys as $_key=>$_value) {
      $_arr_contentRow[$_value] = '';
    }

    if (Func::notEmpty($_arr_gsiteRow['gsite_list_selector'])) {
      $_arr_rule = array(
        'url'   => array($_arr_gsiteRow['gsite_list_selector'], 'href'),
      );

      $_obj_dom = $this->obj_qlist->getRemote($_arr_gsiteRow['gsite_url'], $_arr_rule, $_arr_gsiteRow['gsite_charset']);

      if (isset($_obj_dom[0]['url']) && Func::notEmpty($_obj_dom[0]['url']) && Func::notEmpty($_arr_gsiteRow['gsite_title_selector'])) {
        $_str_contentUrl    = Func::fillUrl($_obj_dom[0]['url'], $_arr_gsiteRow['gsite_url']);

        $_arr_contentRule   = $this->ruleProcess($_arr_contentKeys);

        $_obj_domContent    = $this->obj_qlist->getRemote($_str_contentUrl, $_arr_contentRule, $_arr_gsiteRow['gsite_charset']);

        $_arr_contentRow['url'] = $_str_contentUrl;

        foreach ($_arr_contentKeys as $_key=>$_value) {
          if (isset($_obj_domContent[0][$_value])) {
            $_arr_contentRow[$_value] = $this->replaceProcess($_obj_domContent[0][$_value], $_arr_gsiteRow['gsite_' . $_value . '_replace']);
          }
        }

        if (isset($_arr_contentRow['content'])) {
          $_arr_contentRow['content'] = $this->contentProcess($_arr_contentRow['content'], $_str_contentUrl);
        }
      }
    }

    if (!isset($_arr_contentRow['url'])) {
      $_arr_contentRow['url'] = '';
    }

    $_arr_tplData = array(
      'contentRow'    => $_arr_contentRow,
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function pageLists() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }


    $_arr_gsiteRow = $this->gsiteProcess();

    if ($_arr_gsiteRow['rcode'] != 'y270102') {
      return $this->error($_arr_gsiteRow['msg'], $_arr_gsiteRow['rcode'], 404);
    }

    $_arr_gsiteRow  = $this->gsiteRow;
    $_arr_listRows  = array();

    if (Func::notEmpty($_arr_gsiteRow['gsite_page_list_selector'])) {
      $_arr_rule = array(
        'url'   => array($_arr_gsiteRow['gsite_list_selector'], 'href'),
      );

      $_obj_dom = $this->obj_qlist->getRemote($_arr_gsiteRow['gsite_url'], $_arr_rule, $_arr_gsiteRow['gsite_charset']);

      if (isset($_obj_dom[0]['url']) && Func::notEmpty($_obj_dom[0]['url'])) {
        $_str_pageUrl = Func::fillUrl($_obj_dom[0]['url'], $_arr_gsiteRow['gsite_url']);

        $_arr_pageRule = array(
          'url'       => array($_arr_gsiteRow['gsite_page_list_selector'], 'href'),
          'content'   => array($_arr_gsiteRow['gsite_page_list_selector'], 'html'),
        );

        $_obj_domPage = $this->obj_qlist->getRemote($_str_pageUrl, $_arr_pageRule, $_arr_gsiteRow['gsite_charset']);

        if (Func::notEmpty($_obj_domPage)) {
          foreach ($_obj_domPage as $_key=>$_value) {
            $_arr_listRows[] = array(
              'url'       => Func::fillUrl($_value['url'], $_arr_gsiteRow['gsite_url']),
              'content'   => $_value['content'],
            );
          }
        }
      }
    }

    $_arr_tplData = array(
      'listRows'      => $_arr_listRows,
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch('gsite_preview' . DS . 'lists');
  }

  public function pageContent() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    $_arr_gsiteRow = $this->gsiteProcess();

    if ($_arr_gsiteRow['rcode'] != 'y270102') {
      return $this->error($_arr_gsiteRow['msg'], $_arr_gsiteRow['rcode'], 404);
    }

    $_arr_gsiteRow  = $this->gsiteRow;

    $_arr_contentRow  = array(
      'url'       => '',
      'content'   => '',
    );

    if (Func::notEmpty($_arr_gsiteRow['gsite_page_list_selector'])) {
      $_arr_rule = array(
        'url'   => array($_arr_gsiteRow['gsite_list_selector'], 'href'),
      );

      $_obj_dom = $this->obj_qlist->getRemote($_arr_gsiteRow['gsite_url'], $_arr_rule, $_arr_gsiteRow['gsite_charset']);

      if (isset($_obj_dom[0]['url']) && Func::notEmpty($_obj_dom[0]['url'])) {
        $_str_pageUrl = Func::fillUrl($_obj_dom[0]['url'], $_arr_gsiteRow['gsite_url']);

        $_arr_pageRule = array(
          'url'   => array($_arr_gsiteRow['gsite_page_list_selector'], 'href'),
        );

        $_obj_domPage = $this->obj_qlist->getRemote($_str_pageUrl, $_arr_pageRule, $_arr_gsiteRow['gsite_charset']);

        if (isset($_obj_domPage[0]['url']) && Func::notEmpty($_arr_gsiteRow['gsite_page_content_selector'])) {
          $_str_contentUrl = Func::fillUrl($_obj_domPage[0]['url'], $_arr_gsiteRow['gsite_url']);

          $_arr_contentRule = array(
            'content'   => array($_arr_gsiteRow['gsite_page_content_selector'], $_arr_gsiteRow['gsite_page_content_attr'], $_arr_gsiteRow['gsite_page_content_filter']),
          );

          $_obj_domContent = $this->obj_qlist->getRemote($_str_contentUrl, $_arr_contentRule, $_arr_gsiteRow['gsite_charset']);

          $_arr_contentRow['url'] = $_str_contentUrl;

          if (isset($_obj_domContent[0]['content'])) {
            $_arr_contentRow['content'] = $_obj_domContent[0]['content'];
            if (Func::notEmpty($_arr_gsiteRow['gsite_page_content_replace'])) {
              $_arr_contentRow['content'] = $this->replaceProcess($_arr_contentRow['content'], $_arr_gsiteRow['gsite_page_content_replace']);
            }

            if (isset($_arr_contentRow['content'])) {
              $_arr_contentRow['content'] = $this->contentProcess($_arr_contentRow['content'], $_str_contentUrl);
            }
          }
        }
      }
    }

    $_arr_tplData = array(
      'contentRow' => $_arr_contentRow,
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    $this->assign($_arr_tpl);

    return $this->fetch('gsite_preview' . DS . 'content');
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

    $_arr_gsiteKeepTag = $this->mdl_gsite->keepTag;

    if (Func::notEmpty($_arr_gsiteRow['gsite_keep_tag'])) {
      if (Func::isEmpty($_arr_gsiteKeepTag)) {
        $_arr_gsiteKeepTag = $_arr_gsiteRow['gsite_keep_tag'];
      } else {
        $_arr_gsiteKeepTag = array_merge($_arr_gsiteKeepTag, $_arr_gsiteRow['gsite_keep_tag']);
      }
    }

    $this->gsiteKeepTag = $_arr_gsiteKeepTag;
    $this->gsiteRow     = $_arr_gsiteRow;

    return $_arr_gsiteRow;
  }


  private function ruleProcess($contentKeys) {
    $_arr_gsiteRow    = $this->gsiteRow;
    $_arr_contentRule = array();

    foreach ($contentKeys as $_key=>$_value) {
      if (Func::notEmpty($_arr_gsiteRow['gsite_' . $_value . '_selector'])) {
        $_arr_contentRule[$_value] = array(
          $_arr_gsiteRow['gsite_' . $_value . '_selector'],
          $_arr_gsiteRow['gsite_' . $_value . '_attr'],
          $_arr_gsiteRow['gsite_' . $_value . '_filter']
        );
      }
    }

    return $_arr_contentRule;
  }


  private function replaceProcess($str, $arr_replace = array()) {
    if (Func::notEmpty($arr_replace)) {
      foreach ($arr_replace as $_key=>$_value) {
        if (isset($_value['search'])) {
          if (isset($_value['replace']) && Func::notEmpty($_value['replace'])) {
            $_str_replace = $_value['replace'];
          } else {
            $_str_replace = '';
          }
          $str = str_ireplace($_value['search'], $_str_replace, $str);
        }
      }
    }

    return $str;
  }


  private function contentProcess($content, $contentUrl) {
    $_arr_gsiteRow    = $this->gsiteRow;
    $this->obj_html->setTagAllow($this->gsiteKeepTag);
    $content = $this->obj_html->stripTag($content); //去除标签

    if (Func::notEmpty($_arr_gsiteRow['gsite_attr_allow'])) {
      $this->obj_html->setAttrAllow($_arr_gsiteRow['gsite_attr_allow']);
    }
    if (Func::notEmpty($_arr_gsiteRow['gsite_ignore_tag'])) {
      $this->obj_html->setTagIgnore($_arr_gsiteRow['gsite_ignore_tag']);
    }
    if (Func::notEmpty($_arr_gsiteRow['gsite_attr_except'])) {
      $this->obj_html->setAttrExcept($_arr_gsiteRow['gsite_attr_except']);
    }

    if (Func::notEmpty($_arr_gsiteRow['gsite_attr_allow']) || Func::notEmpty($_arr_gsiteRow['gsite_ignore_tag']) || Func::notEmpty($_arr_gsiteRow['gsite_attr_except'])) {
      $content = $this->obj_html->stripAttr($content);
    }

    $content = Html::fillImg($content, $contentUrl); //补全 URL

    return $content;
  }
}
