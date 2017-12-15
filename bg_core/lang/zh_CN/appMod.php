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
        'title' => '栏目',
        'allow' => array(
            'read'  => '读取',
            'list'  => '列表',
        ),
    ),

    /*------文章------*/
    'article' => array(
        'title' => '文章',
        'allow' => array(
            'read'  => '读取',
            'list'  => '列表',
        ),
    ),

    /*------tag------*/
    'tag' => array(
        'title' => 'TAG',
        'allow' => array(
            'read'  => '读取',
        ),
    ),

    /*------专题------*/
    'spec' => array(
        'title' => '专题',
        'allow' => array(
            'read'  => '读取',
            'list'  => '列表',
        ),
    ),

    /*------自定义字段------*/
    'custom' => array(
        'title' => '自定义字段',
        'allow' => array(
            'list'  => '列表',
        ),
    ),

    /*------标记------*/
    'mark' => array(
        'title' => '标记',
        'allow' => array(
            'list'  => '列表',
        ),
    ),

    /*------调用------*/
    'call' => array(
        'title' => '调用',
        'allow' => array(
            'read'  => '读取',
        ),
    ),

    /*------附件------*/
    'attach' => array(
        'title' => '附件',
        'allow' => array(
            'read'  => '读取',
        ),
    ),
);
