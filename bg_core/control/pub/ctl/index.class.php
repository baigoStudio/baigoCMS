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
		$this->mdl_cate = new MODEL_CATE(); //设置文章对象

		if(defined("BG_SITE_TPL")) {
			$_str_tpl = BG_SITE_TPL;
		} else {
			$_str_tpl = "default";
		}
		$this->obj_tpl = new CLASS_TPL(BG_PATH_TPL_PUB . $_str_tpl); //初始化视图对象
	}


	/**
	 * ctl_index function.
	 *
	 * @access public
	 * @return void
	 */
	function ctl_index() {
		$_arr_cateRows = $this->mdl_cate->mdl_list(1000);

		$_arr_tplData = array(
			"cateRows" => $_arr_cateRows,
		);

		$this->obj_tpl->tplDisplay("index.tpl", $_arr_tplData);
	}
}
?>