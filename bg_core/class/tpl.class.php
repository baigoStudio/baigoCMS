<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_SMARTY . "smarty.class.php"); //载入 Smarty 类

/*-------------模板类-------------*/
class CLASS_TPL {

    public $common; //通用
    public $obj_base;
    private $obj_smarty; //Smarty
    public $config; //配置
    public $arr_cfg = array(); //需要载入语言文档的配置

    function __construct($str_pathTpl, $_arr_cfg = false) { //构造函数
        $this->arr_cfg  = $_arr_cfg;
        $this->obj_base = $GLOBALS["obj_base"];
        $this->config   = $this->obj_base->config;

        $this->obj_smarty               = new Smarty(); //初始化 Smarty 对象
        $this->obj_smarty->template_dir = $str_pathTpl;
        $this->obj_smarty->compile_dir  = BG_PATH_CACHE . "tpl/";
        $this->obj_smarty->debugging    = BG_SWITCH_SMARTY_DEBUG; //调试模式

        $this->lang     = include_once(BG_PATH_LANG . $this->config["lang"] . "/common.php"); //载入语言文件
        $this->alert    = include_once(BG_PATH_LANG . $this->config["lang"] . "/alert.php"); //载入返回代码

        if (isset($this->arr_cfg["admin"])) {
            $this->status   = include_once(BG_PATH_LANG . $this->config["lang"] . "/status.php"); //载入状态文件
            $this->type     = include_once(BG_PATH_LANG . $this->config["lang"] . "/type.php"); //载入类型文件
            $this->install  = include_once(BG_PATH_LANG . $this->config["lang"] . "/install.php"); //载入安装代码
            $this->opt      = include_once(BG_PATH_LANG . $this->config["lang"] . "/opt.php"); //载入设置配置

            if(!defined("BG_MODULE_FTP") || BG_MODULE_FTP < 1) {
                unset($this->opt["upload"]["list"]["BG_UPLOAD_URL"], $this->opt["upload"]["list"]["BG_UPLOAD_FTPHOST"], $this->opt["upload"]["list"]["BG_UPLOAD_FTPPORT"], $this->opt["upload"]["list"]["BG_UPLOAD_FTPUSER"], $this->opt["upload"]["list"]["BG_UPLOAD_FTPPASS"], $this->opt["upload"]["list"]["BG_UPLOAD_FTPPATH"], $this->opt["upload"]["list"]["BG_UPLOAD_FTPPASV"]);
            }

            if(!defined("BG_MODULE_GEN") || BG_MODULE_GEN < 1) {
                unset($this->opt["visit"]["list"]["BG_VISIT_TYPE"]["option"]["static"], $this->opt["visit"]["list"]["BG_VISIT_FILE"]);
            }

            $this->appMod   = include_once(BG_PATH_LANG . $this->config["lang"] . "/appMod.php"); //载入权限配置
            $this->adminMod = include_once(BG_PATH_LANG . $this->config["lang"] . "/adminMod.php"); //载入管理权限配置

            if (BG_MODULE_GEN < 1) {
                unset($this->adminMod["gen"]);
            }
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
    function tplDisplay($str_tpl, $arr_tplData = "", $is_dislay = true) {
        $this->obj_smarty->assign("config", $this->config);
        $this->obj_smarty->assign("lang", $this->lang);
        $this->obj_smarty->assign("alert", $this->alert);

        if (isset($this->arr_cfg["admin"])) {
            $this->common["token_session"]  = fn_token(); //生成令牌
            $this->obj_smarty->assign("common", $this->common);
            $this->obj_smarty->assign("status", $this->status);
            $this->obj_smarty->assign("type", $this->type);
            $this->obj_smarty->assign("install", $this->install);
            $this->obj_smarty->assign("opt", $this->opt);
            $this->obj_smarty->assign("appMod", $this->appMod);
            $this->obj_smarty->assign("adminMod", $this->adminMod);
        }

        if (isset($this->arr_cfg["pub"])) {
            $this->obj_smarty->registerPlugin("function", "call_display", "fn_callDisplay"); //注册自定义函数
            $this->obj_smarty->registerPlugin("function", "call_attach", "fn_callAttach"); //注册自定义函数
            $this->obj_smarty->registerPlugin("function", "call_cate", "fn_callCate"); //注册自定义函数
            $this->obj_smarty->registerPlugin("modifier","ubb","fn_ubb");
        }

        $this->obj_smarty->assign("tplData", $arr_tplData);

        if ($is_dislay) {
            $this->obj_smarty->display($str_tpl); //显示
        } else {
            return $this->obj_smarty->fetch($str_tpl); //获取并返回
        }
    }
}
