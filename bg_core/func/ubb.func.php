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
 * fn_rand function.
 *
 * @access public
 * @param int $num_rand (default: 32)
 * @return void
 */
function fn_ubb($string) {
    $string    = str_replace("[b]",     "<b>",     $string);
    $string    = str_replace("[/b]",    "</b>",    $string);
    $string    = str_replace("[code]",  "<code>",  $string);
    $string    = str_replace("[/code]", "</code>", $string);
    $string    = str_replace("[del]",   "<del>",   $string);
    $string    = str_replace("[/del]",  "</del>",  $string);
    $string    = str_replace("[em]",    "<i>",     $string);
    $string    = str_replace("[/em]",   "</i>",    $string);
    $string    = str_replace("[i]",     "<i>",     $string);
    $string    = str_replace("[/i]",    "</i>",    $string);
    $string    = str_replace("[kbd]",   "<kbd>",   $string);
    $string    = str_replace("[/kbd]",  "</kbd>",  $string);
    $string    = str_replace("[s]",     "<u>",     $string);
    $string    = str_replace("[/s]",    "</u>",    $string);
    $string    = str_replace("[u]",     "<u>",     $string);
    $string    = str_replace("[/u]",    "</u>",    $string);
    $string    = str_replace("[br]",    "<br>",    $string);
    $string    = str_replace("[hr]",    "<hr>",    $string);

    return $string;
}
