<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

function fn_callCate($cate_id, $template = false) {
    $cateRows = array();

    if ($template) {
        $cate_id = $cate_id["cate_id"];
    }

    $_mdl_cate  = new MODEL_CATE(); //设置上传信息对象
    $cateRow    = $_mdl_cate->mdl_cache(false, $cate_id);

    if ($template) {
        $cateRows[$cate_id] = $cateRow;
        $template->assign("cateRows", $cateRows);
    } else {
        return $cateRow;
    }
}