<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "article.func.php"); //载入 http
include_once(BG_PATH_CLASS . "ajax.class.php"); //载入 AJAX 基类
include_once(BG_PATH_MODEL . "article.class.php"); //载入文章模型类
include_once(BG_PATH_MODEL . "cateBelong.class.php"); //载入文章模型类
include_once(BG_PATH_MODEL . "tag.class.php"); //载入文章模型类
include_once(BG_PATH_MODEL . "tagBelong.class.php"); //载入文章模型类

/*-------------文章类-------------*/
class AJAX_ARTICLE {

	private $obj_base;
	private $config;
	private $adminLogged;
	private $obj_tpl;
	private $mdl_article;
	private $mdl_cateBelong;
	private $allowCateIds;

	function __construct() { //构造函数
		$this->adminLogged    = $GLOBALS["adminLogged"]; //获取已登录信息
		$this->obj_ajax       = new CLASS_AJAX(); //获取界面类型
		$this->mdl_article    = new MODEL_ARTICLE(); //设置文章对象
		$this->mdl_cateBelong = new MODEL_CATE_BELONG(); //设置文章对象
		$this->mdl_tag        = new MODEL_TAG(); //设置栏目对象
		$this->mdl_tagBelong  = new MODEL_TAG_BELONG(); //设置栏目对象
		if ($this->adminLogged["str_alert"] != "y020102") { //未登录，抛出错误信息
			$this->obj_ajax->halt_alert($this->adminLogged["str_alert"]);
		}
		if (is_array($this->adminLogged["admin_allow_cate"])) {
			foreach ($this->adminLogged["admin_allow_cate"] as $_key=>$_value) {
				if ($_value["add"] == 1) {
					$this->allowCateIds["add"][] = $_key;
				}
				if ($_value["edit"] == 1) {
					$this->allowCateIds["edit"][] = $_key;
				}
				if ($_value["del"] == 1) {
					$this->allowCateIds["del"][] = $_key;
				}
				if ($_value["approve"] == 1) {
					$this->allowCateIds["approve"][] = $_key;
				}
			}
		} else {
			$this->allowCateIds["add"] = array();
			$this->allowCateIds["edit"] = array();
			$this->allowCateIds["del"] = array();
			$this->allowCateIds["approve"] = array();
		}
	}


	/**
	 * ajax_submit function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_submit() {
		//从表单获取数据
		$_arr_articlePost = fn_articlePost();
		if ($_arr_articlePost["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_articlePost["str_alert"]);
		}

		if ($_arr_articlePost["article_id"] > 0) {
			//判断权限
			if ($this->adminLogged["admin_allow_sys"]["article"]["edit"] != 1 && $this->adminLogged["admin_allow_cate"][$_arr_articlePost["article_cate_id"]]["edit"]) {
				$this->obj_ajax->halt_alert("x120303");
			}
			$_arr_articleRow = $this->mdl_article->mdl_read($_arr_articlePost["article_id"]);
			if ($_arr_articleRow["str_alert"] != "y120102") {
				$this->obj_ajax->halt_alert($_arr_articleRow["str_alert"]);
			}
			foreach ($_arr_articlePost["cate_ids"] as $_value) {
				if (in_array($_value, $this->allowCateIds["edit"]) || $this->adminLogged["admin_allow_sys"]["article"]["edit"] == 1) {
					$_arr_cateIds[] = $_value;
				}
			}
		} else {
			if ($this->adminLogged["admin_allow_sys"]["article"]["add"] != 1 && $this->adminLogged["admin_allow_cate"][$_arr_articlePost["article_cate_id"]]["add"]) {
				$this->obj_ajax->halt_alert("x120302");
			}
			foreach ($_arr_articlePost["cate_ids"] as $_value) {
				if (in_array($_value, $this->allowCateIds["add"]) || $this->adminLogged["admin_allow_sys"]["article"]["add"] == 1) {
					$_arr_cateIds[] = $_value;
				}
			}
		}

		if ($this->adminLogged["admin_allow_sys"]["article"]["approve"] == 1 || $this->adminLogged["admin_allow_cate"][$_arr_articlePost["article_cate_id"]]["approve"] == 1) {
			$_str_status = $_arr_articlePost["article_status"];
		} else {
			$_str_status = "wait";
		}

		//print_r($_arr_articlePost);

		$_arr_articleRow = $this->mdl_article->mdl_submit($_arr_articlePost["article_id"], $_arr_articlePost["article_title"], $_arr_articlePost["article_content"], $_arr_articlePost["article_excerpt"], $_arr_articlePost["article_cate_id"], $_arr_articlePost["article_mark_id"], $_str_status, $_arr_articlePost["article_box"], $_arr_articlePost["article_link"], $_arr_articlePost["article_tag"], $_arr_articlePost["article_time_pub"], $this->adminLogged["admin_id"], $_arr_articlePost["article_upfile_id"]);

		$_arr_tagUpdate = explode(",", $_arr_articlePost["article_tag"]);
		foreach ($_arr_tagUpdate as $_value) {
			$_value = trim($_value);
			$_arr_tagRow = $this->mdl_tag->mdl_read($_value, "tag_name");
			if ($_arr_tagRow["str_alert"] == "y130102") {
				if ($_arr_tagRow["tag_status"] == "show") {
					$_arr_tagIds[] = $_arr_tagRow["tag_id"];
				}
			} else {
				$this->mdl_tag->mdl_submit(0, $_value);
			}
		}

		$this->mdl_cateBelong->mdl_del(0, $_arr_articleRow["article_id"]);
		if (is_array($_arr_cateIds)) {
			foreach ($_arr_cateIds as $_value) {
				if ($_value > 0 && $_arr_articleRow["article_id"] > 0) {
					$_arr_belongRow = $this->mdl_cateBelong->mdl_submit($_value, $_arr_articleRow["article_id"]);
				}
			}
		}

		$this->mdl_tagBelong->mdl_del(0, $_arr_articleRow["article_id"]);
		if (is_array($_arr_tagIds)) {
			foreach ($_arr_tagIds as $_value) {
				if ($_value > 0 && $_arr_articleRow["article_id"] > 0) {
					$this->mdl_tagBelong->mdl_submit($_value, $_arr_articleRow["article_id"]);
					$num_articleCount = $this->mdl_tagBelong->mdl_count($_value); //统计
					$this->mdl_tag->mdl_countDo($_value, $num_articleCount);
				}
			}
		}

		if ($_arr_articleRow["str_alert"] == "x120103" && $_arr_belongRow["str_alert"] == "y150101") {
			$_arr_articleRow["str_alert"] = "y120103";
		}

		$this->obj_ajax->halt_alert($_arr_articleRow["str_alert"]);
	}


	/**
	 * ajax_top function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_top() {
		$_arr_articleDo = fn_articleDo();
		if ($_arr_articleDo["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_articleDo["str_alert"]);
		}

		$_str_articleStatus = fn_getSafe($_POST["act_post"], "txt", "");
		if (!$_str_articleStatus) {
			$this->obj_ajax->halt_alert("x120208");
		}

		switch ($_str_articleStatus) {
			case "top":
				$_num_articleTop = 1;
			break;

			default:
				$_num_articleTop = 0;
			break;
		}

		if ($this->adminLogged["admin_allow_sys"]["article"]["approve"] == 1) {
			$_arr_cateId = false;
		} else {
			foreach ($this->adminLogged["admin_allow_cate"] as $_key=>$_value) {
				if ($_value["approve"] == 1) {
					$_arr_cateId[] = $_key;
				}
			}
		}

		$_arr_articleRow = $this->mdl_article->mdl_top($_arr_articleDo["article_ids"], $_num_articleTop, $_arr_cateId);

		$this->obj_ajax->halt_alert($_arr_articleRow["str_alert"]);
	}


	/**
	 * ajax_status function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_status() {
		$_arr_articleDo = fn_articleDo();
		if ($_arr_articleDo["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_articleDo["str_alert"]);
		}

		$_str_articleStatus = fn_getSafe($_POST["act_post"], "txt", "");
		if (!$_str_articleStatus) {
			$this->obj_ajax->halt_alert("x120208");
		}

		if ($this->adminLogged["admin_allow_sys"]["article"]["approve"] == 1) {
			$_arr_cateId = false;
			$_num_adminId = 0;
		} else {
			foreach ($this->adminLogged["admin_allow_cate"] as $_key=>$_value) {
				if ($_value["approve"] == 1) {
					$_arr_cateId[] = $_key;
				}
			}
			$_num_adminId = $this->adminLogged["admin_id"];
		}

		$_arr_articleRow = $this->mdl_article->mdl_status($_arr_articleDo["article_ids"], $_str_articleStatus, $_arr_cateId, $_num_adminId);

		$this->obj_ajax->halt_alert($_arr_articleRow["str_alert"]);
	}


	/**
	 * ajax_box function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_box() {
		$_arr_articleDo = fn_articleDo();
		if ($_arr_articleDo["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_articleDo["str_alert"]);
		}

		$_str_articleBox = fn_getSafe($_POST["act_post"], "txt", "");
		if (!$_str_articleBox) {
			$this->obj_ajax->halt_alert("x120208");
		}

		if ($this->adminLogged["admin_allow_sys"]["article"]["edit"] == 1) {
			$_arr_cateId     = false;
			$_num_adminId    = 0;
		} else {
			foreach ($this->adminLogged["admin_allow_cate"] as $_key=>$_value) {
				if ($_value["edit"] == 1) {
					$_arr_cateId[] = $_key;
				}
			}
			$_num_adminId = $this->adminLogged["admin_id"];
		}

		$_arr_articleRow = $this->mdl_article->mdl_box($_arr_articleDo["article_ids"], $_str_articleBox, $_arr_cateId, $_num_adminId);

		$this->obj_ajax->halt_alert($_arr_articleRow["str_alert"]);
	}


	/**
	 * ajax_del function.
	 *
	 * @access public
	 * @return void
	 */
	function ajax_del() {
		$_arr_articleDo = fn_articleDo();
		if ($_arr_articleDo["str_alert"] != "ok") {
			$this->obj_ajax->halt_alert($_arr_articleDo["str_alert"]);
		}

		if ($this->adminLogged["admin_allow_sys"]["article"]["del"] == 1) {
			$_arr_cateId = false;
			$_num_adminId = 0;
		} else {
			foreach ($this->adminLogged["admin_allow_cate"] as $_key=>$_value) {
				if ($_value["del"] == 1) {
					$_arr_cateId[] = $_key;
				}
			}
			$_num_adminId = $this->adminLogged["admin_id"];
		}

		$_arr_articleRow = $this->mdl_article->mdl_Del($_arr_articleDo["article_ids"], $_arr_cateId, $_num_adminId);

		$this->mdl_cateBelong->mdl_del(0, 0, 0, $_arr_articleDo["article_ids"]);
		$this->mdl_tagBelong->mdl_del(0, 0, 0, $_arr_articleDo["article_ids"]);

		$this->obj_ajax->halt_alert($_arr_articleRow["str_alert"]);
	}

	/*============轻松回收站============
	返回提示
	*/
	function ajax_empty() {
		$_arr_articleRow = $this->mdl_article->mdl_empty($this->adminLogged["admin_id"]);

		return $_arr_articleRow;
	}
}
?>