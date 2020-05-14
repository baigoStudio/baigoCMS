<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿编辑
-----------------------------------------------------------------*/

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

return array(
    'title'  => array(
        'title'     => 'Title',
        'require'   => true,
        'show'      => true,
    ),
    'content'  => array(
        'title'     => 'Content',
        'require'   => true,
    ),
    'time'  => array(
        'title'     => 'Time',
    ),
    'source'  => array(
        'title'     => 'Source',
    ),
    'author'  => array(
        'title'     => 'Author',
    ),
);
