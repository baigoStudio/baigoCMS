<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------------------权限-------------------------*/
return array(
    /*------栏目------*/
    'cate' => array(
        'title' => 'Category',
        'allow' => array(
            'read'  => 'Read',
            'list'  => 'List',
        ),
    ),

    /*------文章------*/
    'article' => array(
        'title' => 'Article',
        'allow' => array(
            'read'  => 'Read',
            'list'  => 'List',
        ),
    ),

    /*------tag------*/
    'tag' => array(
        'title' => 'TAG',
        'allow' => array(
            'read'  => 'Read',
        ),
    ),

    /*------专题------*/
    'spec' => array(
        'title' => 'Special Topic',
        'allow' => array(
            'read'  => 'Read',
            'list'  => 'List',
        ),
    ),

    /*------自定义字段------*/
    'custom' => array(
        'title' => 'Custom Fields',
        'allow' => array(
            'list'  => 'List',
        ),
    ),

    /*------标记------*/
    'mark' => array(
        'title' => 'Mark',
        'allow' => array(
            'list'  => 'List',
        ),
    ),

    /*------调用------*/
    'call' => array(
        'title' => 'Call',
        'allow' => array(
            'read'  => 'Read',
        ),
    ),

    /*------附件------*/
    'attach' => array(
        'title' => 'Attachment',
        'allow' => array(
            'read'  => 'Read',
        ),
    ),
);
