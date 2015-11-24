<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------文章类-------------*/
class CONTROL_INDEX {

	private $obj_tpl;

	function __construct() { //构造函数
		if(defined("BG_SITE_TPL")) {
			$_str_tpl = BG_SITE_TPL;
		} else {
			$_str_tpl = "default";
		}

		$this->mdl_cate   = new MODEL_CATE(); //设置文章对象
		$this->mdl_custom = new MODEL_CUSTOM();
		$_arr_cfg["pub"]  = true;
		$this->obj_tpl    = new CLASS_TPL(BG_PATH_TPLPUB . $_str_tpl, $_arr_cfg); //初始化视图对象
	}


	/**
	 * ctl_index function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_index() {
		if (!file_exists(BG_PATH_CACHE . "sys/cate_trees.php")) {
			$this->mdl_cate->mdl_cache();
		}
		$_arr_cateRows = include(BG_PATH_CACHE . "sys/cate_trees.php");

		if (!file_exists(BG_PATH_CACHE . "sys/custom_list.php")) {
			$this->mdl_custom->mdl_cache();
		}
		$_arr_customRows = include(BG_PATH_CACHE . "sys/custom_list.php");

		$_arr_tplData = array(
			"cateRows"   => $_arr_cateRows,
			"customRows" => $_arr_customRows["custom_list"],
		);

		$this->obj_tpl->tplDisplay("index.tpl", $_arr_tplData);
	}
}
