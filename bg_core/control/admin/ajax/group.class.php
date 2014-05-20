<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "group.func.php"); //载入 AJAX 基类
include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "group.class.php"); //载入后台用户类

/*-------------用户类-------------*/
class AJAX_GROUP {

	private $adminLogged;
	private $mdl_group;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_ajax       = new CLASS_AJAX(); //获取界面类型
		$this->mdl_group      = new MODEL_GROUP(); //设置管理员对象
		if ($this->adminLogged["str_alert"] != "y020102") { //未登录，抛出错误信息
			$this->obj_ajax->halt_alert($this->adminLogged["str_alert"]);
		}
	}


	/**
	 * ajax_submit function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_submit() {
		$_arr_groupPost = fn_groupPost();
		if ($_arr_groupPost["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_groupPost["str_alert"]);
		}

		if ($_arr_groupPost["group_id"] > 0) {
			if ($this->adminLogged["admin_allow_sys"]["group"]["edit"] != 1) {
				$this->obj_ajax->halt_alert("x040303");
			}
			$_arr_groupRow = $this->mdl_group->mdl_read($_arr_groupPost["group_id"]);
			if ($_arr_groupRow["str_alert"] != "y040102") { //UC 中不存在该用户
				$this->obj_ajax->halt_alert($_arr_groupRow["str_alert"]);
			}
		} else {
			if ($this->adminLogged["admin_allow_sys"]["group"]["add"] != 1) {
				$this->obj_ajax->halt_alert("x040302");
			}
		}

		$_arr_groupRow = $this->mdl_group->mdl_submit($_arr_groupPost["group_id"], $_arr_groupPost["group_name"], $_arr_groupPost["group_type"], $_arr_groupPost["group_note"], $_arr_groupPost["group_allow"]);

		$this->obj_ajax->halt_alert($_arr_groupRow["str_alert"]);
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		if ($this->adminLogged["admin_allow_sys"]["group"]["del"] != 1) {
			$this->obj_ajax->halt_alert("x040304");
		}

		$_arr_groupDo = fn_groupDo();
		if ($_arr_groupDo["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_groupDo["str_alert"]);
		}

		$_arr_groupRow = $this->mdl_group->mdl_del($_arr_groupDo["group_ids"]);

		$this->obj_ajax->halt_alert($_arr_groupRow["str_alert"]);
	}


	/**
	 * ajax_chkGroup function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_chkname() {
		$_str_groupName   = fn_getSafe($_GET["group_name"], "txt", "");
		$_num_groupId     = fn_getSafe($_GET["group_id"], "int", 0);

		$_arr_groupRow = $this->mdl_group->mdl_read($_str_groupName, "group_name", $_num_groupId);

		if ($_arr_groupRow["str_alert"] == "y040102") {
			$this->obj_ajax->halt_re("x040203");
		}

		$arr_re = array(
			"re" => "ok"
		);

		exit(json_encode($arr_re));
	}
}
?>