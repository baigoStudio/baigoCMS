<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\gen;

use app\classes\gen\Ctrl;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Config;
use ginkgo\Html;
use ginkgo\Plugin;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------用户类-------------*/
class Spec extends Ctrl {

    public $isEnforce  = false;

    protected function c_init($param = array()) { //构造函数
        parent::c_init();

        $this->mdl_spec     = Loader::model('Spec');
    }


    function index() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_searchParam = array(
            'overall'   => array('str', ''),
        );

        $_arr_search  = $this->obj_request->param($_arr_searchParam);

        $_arr_search = array(
            'status'    => 'show',
        );
        $_num_specCount = $this->mdl_spec->count($_arr_search);
        $_arr_pageRow   = $this->obj_request->pagination($_num_specCount, $this->configVisit['perpage_in_spec']); //取得分页数据

        $_arr_tplData = array(
            'pageRow'   => $this->pageProcess($_arr_pageRow),
            'search'    => $_arr_search,
            'token'     => $this->obj_request->token(),
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function lists() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->fetchJson($_mix_init['msg'], $_mix_init['rcode']);
        }

        if (!$this->isAjaxPost) {
            $this->obj_console->error('Access denied', '', 405);
        }

        $_arr_inputLists = $this->mdl_spec->inputLists();

        if ($_arr_inputLists['rcode'] != 'y180201') {
            $this->obj_console->error($_arr_inputLists['msg'], $_arr_inputLists['rcode']);
        }

        //print_r($_arr_inputLists);

        $_arr_search = array(
            'status'    => 'show',
        );
        $_num_specCount   = $this->mdl_spec->count($_arr_search);
        $_arr_pageRow     = $this->obj_request->pagination($_num_specCount, $this->configVisit['perpage_spec'], $_arr_inputLists['page']); //取得分页数据
        $_arr_specRows    = $this->mdl_spec->lists($this->configVisit['perpage_spec'], $_arr_pageRow['except'], $_arr_search);

        foreach ($_arr_specRows as $_key=>$_value) {
            $_arr_specRows[$_key]['spec_url'] = $this->mdl_spec->urlProcess($_value);
        }

        $_arr_tplData = array(
            'urlRow'    => $this->mdl_spec->urlLists(),
            'pageRow'   => $this->pageProcess($_arr_pageRow),
            'specRows'  => $_arr_specRows,
        );

        $_arr_pathRow   = $this->mdl_spec->pathLists($_arr_inputLists['page']);

        $_arr_outResult = $this->output($_arr_tplData, $_arr_pathRow);

        //print_r($_arr_outResult);

        if ($_arr_outResult['rcode'] != 'y180405') {
            $this->obj_console->error($_arr_outResult['msg'], $_arr_outResult['rcode']);
        }

        $_arr_outResult['msg'] = $this->obj_lang->get($_arr_outResult['msg']);

        //$this->outputType('json');

        return $this->json($_arr_outResult);
    }


    private function pageProcess($arr_pageRow) {
        $arr_pageRow['total_abs'] = $arr_pageRow['total'];

        if ($arr_pageRow['total'] >= $this->configVisit['visit_pagecount']) {
            $arr_pageRow['total'] = $this->configVisit['visit_pagecount'];
        }

        if ($arr_pageRow['group_end'] >= $this->configVisit['visit_pagecount']) {
            $arr_pageRow['group_end'] = $this->configVisit['visit_pagecount'];
        }

        return $arr_pageRow;
    }



    private function output($arr_tplData, $arr_pathRow) {
        $_str_pathTpl = BG_TPL_INDEX . $this->configBase['site_tpl'] . DS;

        if ($arr_tplData['pageRow']['total_abs'] > $this->configVisit['visit_pagecount']) {
            $arr_tplData['pageRow']['final']    = false;
            $arr_tplData['page_more']           = true;
        }

        $arr_tplData['path_tpl']   = $_str_pathTpl;

        $_arr_tpl = array_replace_recursive($this->generalData, $arr_tplData);

        $_mix_result = Plugin::listen('filter_gen_spec_lists', $_arr_tpl); //编辑文章时触发
        $_arr_tpl    = Plugin::resultProcess($_arr_tpl, $_mix_result);

        if (isset($arr_pathRow['lists_path_index'])) {
            $this->outputProcess($arr_tplData, $arr_pathRow['lists_path_index'], $_str_pathTpl, 'spec' . DS . 'index');
        }

        $_mix_outputResult = $this->outputProcess($arr_tplData, $arr_pathRow['lists_path'], $_str_pathTpl, 'spec' . DS . 'index');

        if (is_array($_mix_outputResult) && isset($_mix_outputResult['rcode'])) {
            return $_mix_outputResult;
        }

        if ($_mix_outputResult > 0) {
            $_arr_return = array(
                'rcode' => 'y180405',
                'msg'   => 'Generate topic successfully',
            );
        } else {
            $_arr_return = array(
                'rcode' => 'x180405',
                'msg'   => 'Generate topic failed',
            );
        }

        return $_arr_return;
    }
}
