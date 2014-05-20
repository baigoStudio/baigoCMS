<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}


/**
 * fn_upfileUrl function.
 *
 * @access public
 * @param mixed $num_upfileId
 * @param mixed $tm_upfileTime
 * @param mixed $num_upfileExt
 * @param mixed $arr_thumbRow
 * @return void
 */
function fn_upfileUrl($num_upfileId, $tm_upfileTime, $num_upfileExt, $arr_thumbRow) {

	$str_upfileUrl = BG_UPFILE_URL . BG_URL_UPFILE . date("Y", $tm_upfileTime) . "/" . date("m", $tm_upfileTime) . "/" . $num_upfileId . "." . $num_upfileExt;

	foreach ($arr_thumbRow as $_key=>$_value) {
		$_arr_upfileThumb[$_key] = array(
			"thumb_url"      => BG_UPFILE_URL . BG_URL_UPFILE . date("Y", $tm_upfileTime) . "/" . date("m", $tm_upfileTime) . "/" . $num_upfileId . "_" . $_value["thumb_width"] . "_" . $_value["thumb_height"] . "_" .$_value["thumb_type"] . "." . $num_upfileExt,
			"thumb_width"    => $_value["thumb_width"],
			"thumb_height"   => $_value["thumb_height"],
			"thumb_type"     => $_value["thumb_type"],
		);
	}

	return array(
		"upfile_url"      => $str_upfileUrl,
		"upfile_thumb"    => $_arr_upfileThumb,
	);
}

function fn_upfileUrlPub($num_upfileId, $tm_upfileTime, $num_upfileExt, $arr_thumbRow) {

	$str_upfileUrl = BG_UPFILE_URL . BG_URL_UPFILE . date("Y", $tm_upfileTime) . "/" . date("m", $tm_upfileTime) . "/" . $num_upfileId . "." . $num_upfileExt;

	foreach ($arr_thumbRow as $_key=>$_value) {
		$_arr_upfile["thumb_" . $_value["thumb_width"] . "_" . $_value["thumb_height"] . "_" . $_value["thumb_type"]] = BG_UPFILE_URL . BG_URL_UPFILE . date("Y", $tm_upfileTime) . "/" . date("m", $tm_upfileTime) . "/" . $num_upfileId . "_" . $_value["thumb_width"] . "_" . $_value["thumb_height"] . "_" .$_value["thumb_type"] . "." . $num_upfileExt;
	}

	$_arr_upfile["upfile_url"] = $str_upfileUrl;

	return $_arr_upfile;
}

/**
 * fn_thumbDo function.
 *
 * @access public
 * @return void
 */
function fn_upfileDo() {
	if (!fn_token("chk")) { //令牌
		return array(
			"str_alert" => "x030102",
		);
		exit;
	}

	$_arr_upfileIds = $_POST["upfile_id"];

	if ($_arr_upfileIds) {
		foreach ($_arr_upfileIds as $_key=>$_value) {
			$_arr_upfileIds[$_key] = fn_getSafe($_value, "int", 0);
		}
		$_str_alert = "ok";
	} else {
		$_str_alert = "none";
	}

	$_arr_upfileDo = array(
		"str_alert"   => $_str_alert,
		"upfile_ids"   => $_arr_upfileIds
	);

	return $_arr_upfileDo;
}
?>