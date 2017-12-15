<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------模板类-------------*/
class CLASS_TPL {

    public $common      = array();
    public $lang        = array();
    public $opt         = array();
    public $ext         = array();
    public $help        = array();
    public $linkRows    = array();

    function __construct($str_pathTpl) { //构造函数
        $this->config               = $GLOBALS['obj_base']->config;
        $this->pathTpl              = $str_pathTpl;
        $this->common['tokenRow']   = fn_token(); //生成令牌
    }

    function setModule() {
        unset($this->opt['base']['list']['BG_SITE_SSIN']);

        if (!defined('BG_MODULE_FTP') || BG_MODULE_FTP < 1) {
            unset($this->opt['upload']['list']['BG_UPLOAD_URL'], $this->opt['upload']['list']['BG_UPLOAD_FTPHOST'], $this->opt['upload']['list']['BG_UPLOAD_FTPPORT'], $this->opt['upload']['list']['BG_UPLOAD_FTPUSER'], $this->opt['upload']['list']['BG_UPLOAD_FTPPASS'], $this->opt['upload']['list']['BG_UPLOAD_FTPPATH'], $this->opt['upload']['list']['BG_UPLOAD_FTPPASV'], $this->opt['spec']);
        }

        if (!defined('BG_MODULE_GEN') || BG_MODULE_GEN < 1) {
            unset($this->opt['visit']['list']['BG_VISIT_TYPE']['option']['static'], $this->opt['visit']['list']['BG_VISIT_FILE'], $this->opt['visit']['list']['BG_VISIT_PAGE'], $this->opt['spec']);
        }

        if (!defined('BG_MODULE_GATHER') || BG_MODULE_GATHER < 1) {
            unset($this->consoleMod['gather']);
        }

        if (!defined('BG_VISIT_TYPE') || BG_VISIT_TYPE != 'static') {
            unset($this->opt['visit']['list']['BG_VISIT_FILE'], $this->opt['visit']['list']['BG_VISIT_PAGE'], $this->opt['spec']);
        }
    }

    /** 显示页面
     * tplDisplay function.
     *
     * @access public
     * @param mixed $str_tpl 模版名
     * @param string $arr_tplData (default: '') 模版数据
     * @return void
     */
    function tplDisplay($str_tpl, $arr_tplData = array(), $is_dislay = true) {
        $this->tplData  = $arr_tplData;
        $_str_return = '';

        if ($is_dislay) {
            if (file_exists($this->pathTpl . DS . $str_tpl . '.php')) {
                require($this->pathTpl . DS . $str_tpl . '.php');
                exit;
            } else {
                if (defined('BG_DEBUG_SYS') && BG_DEBUG_SYS > 0) {
                    $_str_msg = 'Template &quot;' . $this->pathTpl . DS . $str_tpl . '.php&quot; not exists';
                } else {
                    $_str_msg = 'Template not exists';
                }

                exit('{"rcode":"x","msg":"Fatal Error: ' . $_str_msg . '!"}');
            }
        } else {
            if (file_exists($this->pathTpl . DS . $str_tpl . '.php')) {
                ob_start();
                require($this->pathTpl . DS . $str_tpl . '.php');
                $_str_return = ob_get_contents();
                ob_end_clean();
            } else {
                if (defined('BG_DEBUG_SYS') && BG_DEBUG_SYS > 0) {
                    $_str_msg = 'Template &quot;' . $this->pathTpl . DS . $str_tpl . '.php&quot; not exists';
                } else {
                    $_str_msg = 'Template not exists';
                }

                exit('{"rcode":"x","msg":"Fatal Error: ' . $_str_msg . '!"}');
            }
        }

        return $_str_return;
    }
}
