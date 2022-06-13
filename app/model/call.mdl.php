<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;
use ginkgo\Arrays;
use ginkgo\Config;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------调用模型-------------*/
class Call extends Model {

  public $arr_status = array('enable', 'disabled');
  public $arr_type   = array('article', 'hits_day', 'hits_week', 'hits_month', 'hits_year', 'hits_all', 'cate', 'spec', 'tag_list', 'tag_rank', 'link');
  public $arr_attach = array('all', 'attach', 'none');
  public $arr_file   = array('html', 'shtml', 'js', 'json');

  protected $configRoute= array();

  protected function m_init() { //构造函数
    parent::m_init();

    $this->configRoute  = Config::get('route', 'index');
  }


  public function check($num_callId) {
    $_arr_select = array(
      'call_id',
    );

    return $this->readProcess($num_callId, $_arr_select);
  }

  /**
   * read function.
   *
   * @access public
   * @param mixed $str_call
   * @return void
   */
  public function read($num_callId, $arr_select = array()) {
    $_arr_callRow = $this->readProcess($num_callId, $arr_select);

    return $this->rowProcess($_arr_callRow);
  }


  public function readProcess($num_callId, $arr_select = array()) {
    if (Func::isEmpty($arr_select)) {
      $arr_select = array(
        'call_id',
        'call_name',
        'call_type',
        'call_file',
        'call_tpl',
        'call_status',
        'call_amount',
        'call_cate_ids',
        'call_cate_excepts',
        'call_cate_id',
        'call_spec_ids',
        'call_mark_ids',
        'call_attach',
        'call_period',
      );
    }

    $_arr_where = $this->readQueryProcess($num_callId);

    $_arr_callRow = $this->where($_arr_where)->find($arr_select);

    if ($_arr_callRow === false) {
      $_arr_callRow          = $this->obj_request->fillParam(array(), $arr_select);
      $_arr_callRow['msg']   = 'Call not found';
      $_arr_callRow['rcode'] = 'x170102';
    } else {
      $_arr_callRow['rcode'] = 'y170102';
      $_arr_callRow['msg']   = '';
    }



    return $_arr_callRow;
  }


  /**
   * mdl_list function.
   *
   * @access public
   * @param string $str_key (default: '')
   * @param string $str_type (default: '')
   * @return void
   */
  public function lists($pagination = 0, $arr_search = array(), $current = 'get') {
    $_arr_callSelect = array(
      'call_id',
      'call_name',
      'call_type',
      'call_file',
      'call_tpl',
      'call_status',
      'call_amount',
      'call_cate_ids',
      'call_cate_excepts',
      'call_cate_id',
      'call_spec_ids',
      'call_mark_ids',
      'call_attach',
      'call_period',
    );

    $_arr_where         = $this->queryProcess($arr_search);
    $_arr_pagination    = $this->paginationProcess($pagination);
    $_arr_getData       = $this->where($_arr_where)->order('call_id', 'DESC')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_callSelect);

    if (isset($_arr_getData['dataRows'])) {
      $_arr_eachData = &$_arr_getData['dataRows'];
    } else {
      $_arr_eachData = &$_arr_getData;
    }

    if (Func::notEmpty($_arr_eachData)) {
      foreach ($_arr_eachData as $_key=>&$_value) {
        $_value = $this->rowProcess($_value);
      }
    }

    return $_arr_getData;
  }


  /**
   * mdl_count function.
   *
   * @access public
   * @param string $str_key (default: '')
   * @param string $str_status (default: '')
   * @return void
   */
  public function counts($arr_search = array()) {
    $_arr_where = $this->queryProcess($arr_search);

    return $this->where($_arr_where)->count();
  }

  public function pagination($arr_search = array(), $perpage = 0, $current = 'get', $pageparam = 'page', $pergroup = 0) {
    $_arr_where = $this->queryProcess($arr_search);

    return $this->where($_arr_where)->pagination($perpage, $current, $pageparam, $pergroup);
  }

  public function pathProcess($arr_callRow = array()) {
    $_str_callPathName = $arr_callRow['call_id'] . '.' . $arr_callRow['call_file'];

    $arr_callRow['call_path_name'] = $_str_callPathName;
    $arr_callRow['call_path']      = GK_PATH_PUBLIC . $this->configRoute['call'] . DS . $_str_callPathName;
    $arr_callRow['call_url']       = $this->configRoute['call'] . '/' . $_str_callPathName;

    return $arr_callRow;
  }

  protected function queryProcess($arr_search = array()) {
    $_arr_where = array();

    if (isset($arr_search['key']) && Func::notEmpty($arr_search['key'])) {
      $_arr_where[] = array('call_name', 'LIKE', '%' . $arr_search['key'] . '%');
    }

    if (isset($arr_search['type']) && Func::notEmpty($arr_search['type'])) {
      $_arr_where[] = array('call_type', '=', $arr_search['type']);
    }

    if (isset($arr_search['status']) && Func::notEmpty($arr_search['status'])) {
      $_arr_where[] = array('call_status', '=', $arr_search['status']);
    }

    return $_arr_where;
  }


  protected function readQueryProcess($num_callId) {
    $_arr_where = array('call_id', '=', $num_callId);

    return $_arr_where;
  }


  protected function rowProcess($arr_callRow = array()) {
    if (isset($arr_callRow['call_amount'])) {
      $arr_callRow['call_amount']      = Arrays::fromJson($arr_callRow['call_amount']); //json解码
    } else {
      $arr_callRow['call_amount']      = array();
    }

    if (!isset($arr_callRow['call_amount']['top']) || Func::isEmpty($arr_callRow['call_amount']['top'])) {
      $arr_callRow['call_amount']['top'] = 10;
    }

    if (!isset($arr_callRow['call_amount']['except']) || Func::isEmpty($arr_callRow['call_amount']['except'])) {
      $arr_callRow['call_amount']['except'] = 0;
    }

    if (!isset($arr_callRow['call_file'])) {
      $arr_callRow['call_file'] = 'html';
    }

    if (isset($arr_callRow['call_cate_ids'])) {
      $arr_callRow['call_cate_ids'] = Arrays::fromJson($arr_callRow['call_cate_ids']); //json解码
    } else {
      $arr_callRow['call_cate_ids'] = array();
    }

    if (isset($arr_callRow['call_cate_excepts'])) {
      $arr_callRow['call_cate_excepts'] = Arrays::fromJson($arr_callRow['call_cate_excepts']); //json解码
    } else {
      $arr_callRow['call_cate_excepts'] = array();
    }

    if (isset($arr_callRow['call_mark_ids'])) {
      $arr_callRow['call_mark_ids'] = Arrays::fromJson($arr_callRow['call_mark_ids']); //json解码
    } else {
      $arr_callRow['call_mark_ids'] = array();
    }

    if (isset($arr_callRow['call_spec_ids'])) {
      $arr_callRow['call_spec_ids'] = Arrays::fromJson($arr_callRow['call_spec_ids']); //json解码
    } else {
      $arr_callRow['call_spec_ids'] = array();
    }

    if (isset($arr_callRow['call_tpl'])) {
      $arr_callRow['call_tpl'] = basename($arr_callRow['call_tpl'], GK_EXT_TPL);
    } else {
      $arr_callRow['call_tpl'] = '';
    }

    if (isset($arr_callRow['call_period_time'])) {
      $arr_callRow['call_period_time'] = $arr_callRow['call_period'] * GK_DAY;
    } else {
      $arr_callRow['call_period_time'] = 0;
    }

    if (!isset($arr_callRow['call_type'])) {
      $arr_callRow['call_type'] = '';
    }

    if (Func::isEmpty($arr_callRow['call_tpl'])) {
      switch ($arr_callRow['call_type']) {
        case 'spec':
          $arr_callRow['call_tpl'] = 'spec';
        break;

        //栏目列表
        case 'cate':
          $arr_callRow['call_tpl'] = 'cate';
        break;

        //TAG 列表
        case 'tag_list':
        case 'tag_rank':
          $arr_callRow['call_tpl'] = 'tag';
        break;

        case 'link':
          $arr_callRow['call_tpl'] = 'link';
        break;

        //文章列表
        default:
          $arr_callRow['call_tpl'] = 'article';
        break;
      }
    }

    if (Func::isEmpty($arr_callRow['call_file'])) {
      $arr_callRow['call_file'] = 'html';
    }

    return $arr_callRow;
  }
}
