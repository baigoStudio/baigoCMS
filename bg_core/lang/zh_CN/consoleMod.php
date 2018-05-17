<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿编辑
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*----------后台管理模块----------*/
return array(
    'article' => array(
        'main' => array(
            'title' => '文章管理',
            'icon'  => 'document',
        ),
        'sub' => array(
            'list'      => '所有文章',
            'form'      => '写文章',
            'tag'       => 'TAG',
            'mark'      => '标记',
            'custom'    => '自定义字段',
            'source'    => '文章来源',
        ),
        'allow' => array(
            'browse'    => '浏览',
            'add'       => '创建',
            'edit'      => '编辑',
            'del'       => '删除',
            'approve'   => '审核',
            'tag'       => 'TAG',
            'mark'      => '标记',
            'custom'    => '自定义字段',
            'source'    => '文章来源',
        ),
    ),
    'spec' => array(
        'main' => array(
            'title' => '专题管理',
            'icon'  => 'clipboard',
        ),
        'sub' => array(
            'list'  => '所有专题',
            'form'  => '创建专题',
        ),
        'allow' => array(
            'browse'    => '浏览',
            'add'       => '创建',
            'edit'      => '编辑',
            'del'       => '删除',
        ),
    ),
    'gather' => array(
        'main' => array(
            'title' => '内容采集',
            'icon'  => 'cloud-download',
        ),
        'sub' => array(
            'gather'    => '数据采集',
            'approve'   => '采集审核',
            'gsite'     => '采集点管理',
        ),
        'allow' => array(
            'browse'    => '浏览',
            'gather'    => '采集',
            'approve'   => '审核',
            'gsite'     => '采集点',
        ),
    ),
    'attach' => array(
        'main' => array(
            'title'  => '附件管理',
            'icon'   => 'paperclip',
        ),
        'sub' => array(
            'list'  => '所有附件',
            'mime'  => '附件类型',
            'thumb' => '缩略图',
        ),
        'allow' => array(
            'browse' => '浏览',
            'del'    => '删除',
            'upload' => '上传',
            'mime'   => '附件类型',
            'thumb'  => '缩略图',
        ),
    ),
    'cate' => array(
        'main' => array(
            'title'  => '栏目管理',
            'icon'   => 'layers',
        ),
        'sub' => array(
            'list' => '所有栏目',
            'form' => '创建栏目',
        ),
        'allow' => array(
            'browse' => '浏览',
            'add'    => '创建',
            'edit'   => '编辑',
            'del'    => '删除',
        ),
    ),
    'call' => array(
        'main' => array(
            'title'  => '调用管理',
            'icon'   => 'list-rich',
        ),
        'sub' => array(
            'list' => '所有调用',
            'form' => '创建调用',
        ),
        'allow' => array(
            'browse' => '浏览',
            'add'    => '创建',
            'edit'   => '编辑',
            'del'    => '删除',
        ),
    ),
    'admin' => array(
        'main' => array(
            'title'  => '管理员',
            'icon'   => 'person',
        ),
        'sub' => array(
            'list' => '所有管理员',
            'form' => '创建管理员',
            'auth' => '授权为管理员',
        ),
        'allow' => array(
            'browse'     => '浏览',
            'add'        => '创建',
            'edit'       => '编辑',
            'del'        => '删除',
            'toGroup'    => '加入组',
        ),
    ),
    'group' => array(
        'main' => array(
            'title'  => '群组管理',
            'icon'   => 'people',
        ),
        'sub' => array(
            'list' => '所有群组',
            'form' => '创建群组',
        ),
        'allow' => array(
            'browse' => '浏览',
            'add'    => '创建',
            'edit'   => '编辑',
            'del'    => '删除',
        ),
    ),
    'link' => array(
        'main' => array(
            'title'  => '链接',
            'icon'   => 'link-intact',
        ),
        'sub' => array(
            'list' => '链接管理',
        ),
        'allow' => array(
            'browse' => '浏览',
            'add'    => '创建',
            'edit'   => '编辑',
            'del'    => '删除',
        ),
    ),
    'plugin' => array(
        'main' => array(
            'title'  => '插件',
            'icon'   => 'puzzle-piece',
        ),
        'sub' => array(
            'list' => '插件管理',
        ),
        'allow' => array(
            'browse'    => '浏览',
            'edit'      => '编辑',
            'install'   => '安装',
            'uninstall' => '卸载',
        ),
    ),
);
