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

	public $obj_base;
	private $obj_smarty; //Smarty
	public $config; //配置
	public $lang; //语言 通用
	public $alert; //语言 返回代码
	public $opt; //语言 设置

	function __construct($str_pathTpl) { //构造函数
		$this->obj_base                   = $GLOBALS["obj_base"];
		$this->config                     = $this->obj_base->config;

		$this->obj_smarty                 = new Smarty(); //初始化 Smarty 对象
		$this->obj_smarty->template_dir   = $str_pathTpl;
		$this->obj_smarty->compile_dir    = BG_PATH_TPL_COMPILE;
		$this->obj_smarty->debugging      = BG_SWITCH_SMARTY_DEBUG; //调试模式

		$this->lang       = include_once(BG_PATH_LANG . $this->config["lang"] . "/common.php"); //载入语言文件
		$this->alert      = include_once(BG_PATH_LANG . $this->config["lang"] . "/alert.php"); //载入返回代码
	}


	/** 显示页面
	 * tplDisplay function.
	 *
	 * @access public
	 * @param mixed $str_tpl 模版名
	 * @param string $arr_tplData (default: "") 模版数据
	 * @return void
	 */
	function tplDisplay($str_tpl, $arr_tplData = "") {
		$this->obj_smarty->assign("config", $this->config);
		$this->obj_smarty->assign("lang", $this->lang);
		$this->obj_smarty->assign("alert", $this->alert);
		$this->obj_smarty->assign("tplData", $arr_tplData);

		$this->obj_smarty->display($str_tpl); //显示
	}
}
