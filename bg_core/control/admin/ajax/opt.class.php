<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "opt.class.php");
include_once(BG_PATH_MODEL . "cate.class.php"); //载入栏目类

/*-------------管理员控制器-------------*/
class AJAX_OPT {

	private $adminLogged;
	private $obj_ajax;
	private $mdl_opt;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //已登录商家信息
		$this->obj_ajax       = new CLASS_AJAX(); //初始化 AJAX 基对象
		$this->obj_ajax->chk_install();
		$this->mdl_opt        = new MODEL_OPT();
		$this->mdl_cate       = new MODEL_CATE();

		if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
			$this->obj_ajax->halt_alert($this->adminLogged["alert"]);
		}
	}


	function ajax_dbconfig() {
		if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"]["dbconfig"])) {
			$this->obj_ajax->halt_alert("x060306");
		}

		$_arr_dbconfigSubmit = $this->mdl_opt->input_dbconfig();

		if ($_arr_dbconfigSubmit["alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_dbconfigSubmit["alert"]);
		}

		$_arr_return = $this->mdl_opt->mdl_dbconfig();

		$this->obj_ajax->halt_alert($_arr_return["alert"]);
    }


	function ajax_submit() {
		$_act_post = fn_getSafe($GLOBALS["act_post"], "txt", "base");

		if (!isset($this->adminLogged["groupRow"]["group_allow"]["opt"][$_act_post])) {
			$this->obj_ajax->halt_alert("x060301");
		}

		$_num_countSrc = 0;

		foreach ($this->obj_ajax->opt[$_act_post]["list"] as $_key=>$_value) {
			if ($_value["min"] > 0) {
				$_num_countSrc++;
			}
		}

		$_arr_const = $this->mdl_opt->input_const($_act_post);

		$_num_countInput = count(array_filter($_arr_const));

		if ($_num_countInput < $_num_countSrc) {
			$this->obj_ajax->halt_alert("x030212");
		}

		$_arr_return = $this->mdl_opt->mdl_const($_act_post);

		if ($_arr_return["alert"] != "y060101") {
			$this->obj_ajax->halt_alert($_arr_return["alert"]);
		}

		if ($_act_post == "base") {
    		$_arr_cache = $this->mdl_cate->mdl_cache();
		}

		if ($_act_post == "visit") {
    		if ($_arr_const["BG_VISIT_TYPE"] == "pstatic") {

    			$_arr_return = $this->mdl_opt->mdl_htaccess();

    			if ($_arr_return["alert"] != "y060101") {
    				$this->obj_ajax->halt_alert($_arr_return["alert"]);
    			}

    		} else {
    			if (file_exists(BG_PATH_ROOT . ".htaccess")) {
    				unlink(BG_PATH_ROOT . ".htaccess");
    			}
    		}
		}

		$this->obj_ajax->halt_alert("y060401");
	}
}