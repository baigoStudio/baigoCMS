<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
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
    $string    = str_ireplace("[b]",     "<b>",     $string);
    $string    = str_ireplace("[/b]",    "</b>",    $string);
    $string    = str_ireplace("[code]",  "<code>",  $string);
    $string    = str_ireplace("[/code]", "</code>", $string);
    $string    = str_ireplace("[del]",   "<del>",   $string);
    $string    = str_ireplace("[/del]",  "</del>",  $string);
    $string    = str_ireplace("[em]",    "<i>",     $string);
    $string    = str_ireplace("[/em]",   "</i>",    $string);
    $string    = str_ireplace("[i]",     "<i>",     $string);
    $string    = str_ireplace("[/i]",    "</i>",    $string);
    $string    = str_ireplace("[kbd]",   "<kbd>",   $string);
    $string    = str_ireplace("[/kbd]",  "</kbd>",  $string);
    $string    = str_ireplace("[s]",     "<u>",     $string);
    $string    = str_ireplace("[/s]",    "</u>",    $string);
    $string    = str_ireplace("[u]",     "<u>",     $string);
    $string    = str_ireplace("[/u]",    "</u>",    $string);
    $string    = str_ireplace("[br]",    "<br>",    $string);
    $string    = str_ireplace("[hr]",    "<hr>",    $string);

    return $string;
}
