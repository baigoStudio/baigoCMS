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
//use ginkgo\Http;
use ginkgo\Html;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

class Grab extends Ctrl {

  protected function c_init($param = array()) {
    parent::c_init();

    //$this->obj_http         = Http::instance();
    $this->obj_html         = Html::instance();
    $this->obj_qlist        = Loader::classes('Qlist');

    $this->mdl_gsite        = Loader::model('Gsite');

    $this->mdl_gather       = Loader::model('Gather');

    $this->configConsole    = Config::get('console');

    $_str_hrefBase = $this->hrefBase . 'grab/';

    $_arr_hrefRow = array(
      'index'        => $_str_hrefBase . 'index/',
      'show'         => $_str_hrefBase . 'show/id/',
      'grab'         => $_str_hrefBase . 'grab/id/{:id}/all/{:all}/',
      'submit'       => $_str_hrefBase . 'submit/',
      'grab-index'   => $_str_hrefBase . 'grab/',
      'gather-index' => $this->url['route_console'] . 'gather/',
    );

    $this->generalData['status']  = $this->mdl_gsite->arr_status;
    $this->generalData['hrefRow'] = array_replace_recursive($this->generalData['hrefRow'], $_arr_hrefRow);
  }


  public function index() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->groupAllow['gather']['gather']) && !$this->isSuper) { //判断权限
      return $this->error('You do not have permission', 'x280301');
    }

    $_arr_searchParam = array(
      'key'       => array('str', ''),
      'status'    => array('str', ''),
    );

    $_arr_search = $this->obj_request->param($_arr_searchParam);

    $_arr_gsiteRows   = $this->mdl_gsite->lists(array(1000, 'limit')); //列出

    $_arr_tplData = array(
      'search'    => $_arr_search,
      'gsiteRows' => $_arr_gsiteRows,
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_gsiteRows);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function grab() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->error($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!isset($this->groupAllow['gather']['gather']) && !$this->isSuper) { //判断权限
      return $this->error('You do not have permission', 'x280301');
    }

    $_arr_searchParam = array(
      'id'    => array('int', 0),
      'min'   => array('int', 0),
    );

    $_arr_search = $this->obj_request->param($_arr_searchParam);

    $_num_siteId = 0;
    $_is_min     = true;

    if ($_arr_search['id'] > 0) {
      $_num_siteId = $_arr_search['id'];
      $_is_min     = false;
    } else {
      if ($_arr_search['min'] > 0) {
        $_num_siteId = $_arr_search['min'];
      }
    }

    $_arr_gatherRows    = array();
    $_str_jump          = '';
    $_count             = 1;

    $_arr_gsiteRow = $this->mdl_gsite->read($_num_siteId, 'gsite_id', $_is_min);
    if ($_arr_gsiteRow['rcode'] != 'y270102') {
      return $this->error('Completed gather', 'y280401');
    }

    $_arr_gsiteRow = $this->mdl_gsite->selectorProcess($_arr_gsiteRow);

    $_str_jump = $this->url['route_console'] . 'grab/grab/min/' . $_arr_gsiteRow['gsite_id'] . '/view/iframe/';

    if (Func::notEmpty($_arr_gsiteRow['gsite_list_selector']) && Func::notEmpty($_arr_gsiteRow['gsite_title_selector'])) {
      $_arr_rule = array(
        'url'       => array($_arr_gsiteRow['gsite_list_selector'], 'href'),
        'content'   => array($_arr_gsiteRow['gsite_list_selector'], 'html', $_arr_gsiteRow['gsite_page_content_filter']),
      );

      $_obj_dom = $this->obj_qlist->getRemote($_arr_gsiteRow['gsite_url'], $_arr_rule, $_arr_gsiteRow['gsite_charset']);

      if (Func::notEmpty($_obj_dom)) {
        foreach ($_obj_dom as $_key=>$_value) {
          if ($_count < $this->configConsole['count_gather']) {
            $_str_md5 = md5(Func::fillUrl($_value['url'], $_arr_gsiteRow['gsite_url']));
            $_arr_gatherRows[$_str_md5] = array(
              'url'       => Func::fillUrl($_value['url'], $_arr_gsiteRow['gsite_url']),
              'content'   => $_value['content'],
            );
          }

          ++$_count;
        }
      }
    }

    $_arr_tplData = array(
      'jump'          => $_str_jump,
      'gsiteRow'      => $_arr_gsiteRow,
      'gatherRows'    => $_arr_gatherRows,
      'token'         => $this->obj_request->token(),
    );

    $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

    //print_r($_arr_gatherRows);

    $this->assign($_arr_tpl);

    return $this->fetch();
  }


  public function submit() {
    $_mix_init = $this->init();

    if ($_mix_init !== true) {
      return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
    }

    if (!$this->isAjaxPost) {
      return $this->fetchJson('Access denied', '', 405);
    }

    if (!isset($this->groupAllow['gather']['gather']) && !$this->isSuper) { //判断权限
      return $this->fetchJson('You do not have permission', 'x280301');
    }

    $_arr_inputGrab = $this->mdl_gather->inputGrab();

    if ($_arr_inputGrab['rcode'] != 'y280201') {
      return $this->fetchJson($_arr_inputGrab['msg'], $_arr_inputGrab['rcode']);
    }

    $_arr_gsiteRow = $this->gsiteProcess($_arr_inputGrab['gsite_id']);

    if ($_arr_gsiteRow['rcode'] != 'y270102') {
      return $this->fetchJson($_arr_gsiteRow['msg'], $_arr_gsiteRow['rcode']);
    }

    $_arr_gatherRow = $this->mdl_gather->check($_arr_inputGrab['url'], 'gather_source_url');

    if ($_arr_gatherRow['rcode'] == 'y280102') {
      return $this->fetchJson('Data already exists', $_arr_gatherRow['rcode']);
    }

    $_str_configContent = BG_PATH_CONFIG . 'console' . DS . 'gsite_step_content' . GK_EXT_INC;
    $_arr_configContent = Config::load($_str_configContent, 'gsite_step_content', 'console');
    $_arr_contentKeys   = array_keys($_arr_configContent);

    $_arr_contentRule   = $this->ruleProcess($_arr_contentKeys);

    $_obj_domContent    = $this->obj_qlist->getRemote($_arr_inputGrab['url'], $_arr_contentRule, $_arr_gsiteRow['gsite_charset']);

    $_arr_gatherResult = array(
      'rcode' => 'x280101',
      'msg'   => 'Gather failed',
    );

    if (isset($_obj_domContent[0]['gather_title']) && Func::notEmpty($_obj_domContent[0]['gather_title'])) {
      $_arr_gatherSubmit  = array(
        'gather_title'      => '',
        'gather_content'    => '',
        //'gather_time_show'  => GK_NOW,
        'gather_source'     => '',
        'gather_source_url' => $_arr_inputGrab['url'],
        'gather_author'     => '',
        'gather_gsite_id'   => $_arr_gsiteRow['gsite_id'],
        'gather_cate_id'    => $_arr_gsiteRow['gsite_cate_id'],
        'gather_admin_id'   => $this->adminLogged['admin_id'],
      );

      foreach ($_arr_contentKeys as $_key=>$_value) {
        if (isset($_obj_domContent[0]['gather_' . $_value])) {
          $_arr_gatherSubmit['gather_' . $_value] = $this->replaceProcess($_obj_domContent[0]['gather_' . $_value], $_arr_gsiteRow['gsite_' . $_value . '_replace']);
        }
      }

      if (isset($_obj_domContent[0]['page_url'])) {
        $_str_pageContentDo = '';
        foreach ($_obj_domContent as $_key=>$_value) {
          $_str_pageUrl = Func::fillUrl($_value['page_url'], $_arr_inputGrab['url']);

          $_arr_pageRule = array(
            'gather_content' => array($_arr_gsiteRow['gsite_page_content_selector'], $_arr_gsiteRow['gsite_page_content_attr'], $_arr_gsiteRow['gsite_page_content_filter']),
          );

          $_obj_domPageContent = $this->obj_qlist->getRemote($_str_pageUrl, $_arr_pageRule, $_arr_gsiteRow['gsite_charset']);

          if (isset($_obj_domPageContent[0]['gather_content']) && Func::notEmpty($_obj_domPageContent[0]['gather_content'])) {
            $_str_pageContentDo .= $_obj_domPageContent[0]['gather_content'];
          }
        }

        $_arr_gatherSubmit['gather_content'] .= $_str_pageContentDo;

        if (Func::notEmpty($_arr_gsiteRow['gsite_page_content_replace'])) {
          foreach ($_arr_gsiteRow['gsite_page_content_replace'] as $_key=>$_value) {
            if (isset($_value['search'])) {
              if (isset($_value['replace']) && Func::notEmpty($_value['replace'])) {
                $_str_replace = $_value['replace'];
              } else {
                $_str_replace = '';
              }
              $_arr_gatherSubmit['gather_content'] = str_ireplace($_value['search'], $_str_replace, $_arr_gatherSubmit['gather_content']);
            }
          }
        }
      }

      if (isset($_arr_gatherSubmit['gather_title'])) {
        $_arr_gatherSubmit['gather_title'] = strip_tags($_arr_gatherSubmit['gather_title']);
      }

      if (isset($_arr_gatherSubmit['gather_content'])) {
        $_arr_gatherSubmit['gather_content'] = $this->contentProcess($_arr_gatherSubmit['gather_content'], $_arr_inputGrab['url']);
      }

      if (isset($_arr_gatherSubmit['gather_time'])) {
        $_arr_gatherSubmit['gather_time_show'] = $_arr_gatherSubmit['gather_time'];
      } else {
        $_arr_gatherSubmit['gather_time_show'] = GK_NOW;
      }

      //print_r($_arr_gatherSubmit);

      $_arr_gatherResult = $this->mdl_gather->submit($_arr_gatherSubmit);
    }

    $_arr_gatherResult['msg'] = $this->obj_lang->get($_arr_gatherResult['msg']);

    return $this->json($_arr_gatherResult);
  }


  private function gsiteProcess($gsiteId) {
    $_arr_gsiteRow = $this->mdl_gsite->read($gsiteId);

    if ($_arr_gsiteRow['rcode'] != 'y270102') {
      return $_arr_gsiteRow;
    }

    $_arr_gsiteRow = $this->mdl_gsite->selectorProcess($_arr_gsiteRow);

    if (Func::isEmpty($_arr_gsiteRow['gsite_list_selector'])) {
      return array(
        'msg'   => 'List selector not defined',
        'rcode' => 'x280203',
      );
    }

    if (Func::isEmpty($_arr_gsiteRow['gsite_title_selector'])) {
      return array(
        'msg'   => 'Title selector not defined',
        'rcode' => 'x280204',
      );
    }

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
    //print_r($_arr_gsiteRow);
    $_arr_contentRule = array();

    foreach ($contentKeys as $_key=>$_value) {
      if (Func::notEmpty($_arr_gsiteRow['gsite_' . $_value . '_selector'])) {
        $_arr_contentRule['gather_' . $_value] = array(
          $_arr_gsiteRow['gsite_' . $_value . '_selector'],
          $_arr_gsiteRow['gsite_' . $_value . '_attr'],
          $_arr_gsiteRow['gsite_' . $_value . '_filter']
        );
      }
    }

    if (Func::notEmpty($_arr_gsiteRow['gsite_page_list_selector']) && Func::notEmpty($_arr_gsiteRow['gsite_page_content_selector'])) {
      $_arr_contentRule['page_url'] = array($_arr_gsiteRow['gsite_page_list_selector'], 'href');
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
    //print_r($content);
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
      //print_r($_arr_gsiteRow['gsite_attr_except']);
      $this->obj_html->setAttrExcept($_arr_gsiteRow['gsite_attr_except']);
    }

    if (Func::notEmpty($_arr_gsiteRow['gsite_attr_allow']) || Func::notEmpty($_arr_gsiteRow['gsite_ignore_tag']) || Func::notEmpty($_arr_gsiteRow['gsite_attr_except'])) {
      $content = $this->obj_html->stripAttr($content);
    }

    $content = Html::fillImg($content, $contentUrl); //补全 URL

    return $content;
  }
}
