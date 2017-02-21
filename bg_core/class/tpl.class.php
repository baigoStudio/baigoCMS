<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

if (!defined("BG_DEFAULT_TPL")) {
    define("BG_DEFAULT_TPL", "tpl");
}

if (!defined("BG_PATH_LIB")) {
    define("BG_PATH_LIB", BG_PATH_CORE . "/lib/");
}

/*-------------模板类-------------*/
class CLASS_TPL {

    public $common; //通用
    public $obj_base;
    //public $obj_smarty; //Smarty
    public $config; //配置
    public $arr_cfg = array(); //需要载入语言文档的配置

    function __construct($str_pathTpl, $arr_cfg = false) { //构造函数
        $this->arr_cfg  = $arr_cfg;
        $this->obj_base = $GLOBALS["obj_base"];
        $this->config   = $this->obj_base->config;
        $this->pathTpl  = $str_pathTpl;

        $this->lang     = require(BG_PATH_LANG . $this->config["lang"] . "/lang.php"); //载入语言文件
        $this->rcode    = require(BG_PATH_LANG . $this->config["lang"] . "/rcode.php"); //载入返回代码

        if (isset($this->arr_cfg["console"])) {
            $this->mdl_link = new MODEL_LINK();
            $this->linkRows = $this->mdl_link->mdl_cache("console");
        }

        if (isset($this->arr_cfg["console"]) || isset($this->arr_cfg["install"])) {
            $this->status   = require(BG_PATH_LANG . $this->config["lang"] . "/status.php"); //载入状态文件
            $this->type     = require(BG_PATH_LANG . $this->config["lang"] . "/type.php"); //载入类型文件
            $this->install  = require(BG_PATH_LANG . $this->config["lang"] . "/install.php"); //载入安装代码
            $this->opt      = require(BG_PATH_LANG . $this->config["lang"] . "/opt.php"); //载入设置配置
            $this->common["tokenRow"]  = fn_token(); //生成令牌

            $this->opt["base"]["list"]["BG_SITE_EXCERPT_TYPE"]["option"] = $this->type["excerpt"]; //默认截取类型

            if (!defined("BG_MODULE_FTP") || BG_MODULE_FTP < 1) {
                unset($this->opt["upload"]["list"]["BG_UPLOAD_URL"], $this->opt["upload"]["list"]["BG_UPLOAD_FTPHOST"], $this->opt["upload"]["list"]["BG_UPLOAD_FTPPORT"], $this->opt["upload"]["list"]["BG_UPLOAD_FTPUSER"], $this->opt["upload"]["list"]["BG_UPLOAD_FTPPASS"], $this->opt["upload"]["list"]["BG_UPLOAD_FTPPATH"], $this->opt["upload"]["list"]["BG_UPLOAD_FTPPASV"], $this->opt["spec"]);
            }

            if (!defined("BG_MODULE_GEN") || BG_MODULE_GEN < 1) {
                unset($this->opt["visit"]["list"]["BG_VISIT_TYPE"]["option"]["static"], $this->opt["visit"]["list"]["BG_VISIT_FILE"], $this->opt["visit"]["list"]["BG_VISIT_PAGE"], $this->opt["spec"]);
            }

            if (!defined("BG_VISIT_TYPE") || BG_VISIT_TYPE != "static") {
                unset($this->opt["visit"]["list"]["BG_VISIT_FILE"], $this->opt["visit"]["list"]["BG_VISIT_PAGE"], $this->opt["spec"]);
            }

            $this->appMod       = require(BG_PATH_LANG . $this->config["lang"] . "/appMod.php"); //载入权限配置
            $this->consoleMod   = require(BG_PATH_LANG . $this->config["lang"] . "/consoleMod.php"); //载入管理权限配置

            if (BG_MODULE_GEN < 1) {
                unset($this->consoleMod["gen"]);
            }
        }

        if (isset($this->arr_cfg["pub"]) && BG_DEFAULT_TPL == "tpl") {
            require(BG_PATH_LIB . "smarty/smarty.class.php"); //载入 Smarty 类
            $this->obj_smarty               = new Smarty(); //初始化 Smarty 对象
            $this->obj_smarty->template_dir = $str_pathTpl;
            $this->obj_smarty->compile_dir  = BG_PATH_CACHE . "tpl/"; //编译目录
        }
    }


    /** 显示页面
     * tplDisplay function.
     *
     * @access public
     * @param mixed $str_tpl 模版名
     * @param string $arr_tplData (default: "") 模版数据
     * @return void
     */
    function tplDisplay($str_tpl, $arr_tplData = array(), $is_dislay = true) {
        $this->tplData  = $arr_tplData;
        $_str_return = "";

        if (isset($this->arr_cfg["pub"]) && BG_DEFAULT_TPL == "tpl") {
            $this->obj_smarty->assign("config", $this->config);
            $this->obj_smarty->assign("lang", $this->lang);
            $this->obj_smarty->assign("rcode", $this->rcode);

            $this->obj_smarty->registerPlugin("function", "call_display", "fn_callDisplay"); //注册自定义函数
            $this->obj_smarty->registerPlugin("function", "call_attach", "fn_callAttach"); //注册自定义函数
            $this->obj_smarty->registerPlugin("function", "call_cate", "fn_callCate"); //注册自定义函数
            $this->obj_smarty->registerPlugin("modifier", "ubb", "fn_ubb"); //注册自定义修饰器

            $this->obj_smarty->assign("tplData", $arr_tplData);

            if ($is_dislay) {
                $this->obj_smarty->display($str_tpl . ".tpl"); //显示
                exit;
            } else {
                $_str_return = $this->obj_smarty->fetch($str_tpl . ".tpl"); //获取并返回
            }
        } else {
            if ($is_dislay) {
                require($this->pathTpl . "/" . $str_tpl . ".php");
                exit;
            } else {
                ob_start();
                require($this->pathTpl . "/" . $str_tpl . ".php");
                $_str_return = ob_get_contents();
                ob_end_clean();
            }
        }

        return $_str_return;
    }
}
