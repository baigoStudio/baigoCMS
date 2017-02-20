<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

function fn_callAttach($attach_id, $template = false) {
    $attachRows = array();

    if ($template) {
        $attach_id = $attach_id["attach_id"];
    }

    $_mdl_attach  = new MODEL_ATTACH();
    $_mdl_thumb   = new MODEL_THUMB(); //设置上传信息对象

    $_mdl_attach->thumbRows = $_mdl_thumb->mdl_cache();

    $_arr_attachRow = $_mdl_attach->mdl_url($attach_id);

    if ($template) {
        $attachRows[$attach_id] = $_arr_attachRow;
        $template->assign("attachRows", $attachRows);
    } else {
        return $_arr_attachRow;
    }
}