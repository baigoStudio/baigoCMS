<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\ctrl\console;

use app\classes\console\Ctrl;
use ginkgo\Loader;
use ginkgo\Config;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

class Gsite_Help extends Ctrl {

    protected function c_init($param = array()) {
        parent::c_init();

        $_str_configCharset    = BG_PATH_CONFIG . 'console' . DS . 'charset' . GK_EXT_INC;
        $this->charsetRows     = Config::load($_str_configCharset, 'charset', 'console');

        $_str_current          = $this->obj_lang->getCurrent();
        $_str_langCharset      = GK_APP_LANG . $_str_current . DS . 'console' . DS . 'charset' . GK_EXT_LANG;
        $this->obj_lang->load($_str_langCharset, 'console.charset');
    }


    function charset() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_tplData = array(
            'charsetRows'   => $this->charsetRows,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function attrQlist() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_attrQlist         = Config::get('attr_qlist', 'console.gsite_help');

        $_arr_tplData = array(
            'attrQlist'     => $_arr_attrQlist,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function filter() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_filterRows = Config::get('filter', 'console.gsite_help');

        $_arr_tplData = array(
            'filterRows'    => $_arr_filterRows,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }


    function selector() {
        $_mix_init = $this->init();

        if ($_mix_init !== true) {
            return $this->error($_mix_init['msg'], $_mix_init['rcode']);
        }

        $_arr_selectorRows      = Config::get('selector', 'console.gsite_help');

        $_arr_tplData = array(
            'selectorRows'   => $_arr_selectorRows,
        );

        $_arr_tpl = array_replace_recursive($this->generalData, $_arr_tplData);

        $this->assign($_arr_tpl);

        return $this->fetch();
    }
}
