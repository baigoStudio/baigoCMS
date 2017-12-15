<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿编辑
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

return array(
    'page' => array(
        'help'      => 'baigo CMS 帮助',
        'intro'     => '简介',
        'install'   => '安装 / 升级',
        'setup'     => '安装',
        'upgrade'   => '升级',
        'manual'    => '手动安装 / 升级',
        'deploy'    => '高级部署',
        'console'   => '管理后台',
        'doc'       => '开发文档',
        'tpl'       => '模板文档',
        'api'       => 'API 接口文档',
    ),

    'label' => array(
        'desc'  => '描述',
    ),

    'intro'     => array(
        'outline'   => '简介',
        'faq'       => '常见问题',
    ),

    'setup'     => array(
        'outline'     => '安装概述',
        'phplib'      => '服务器环境检查',
        'dbconfig'    => '数据库设置',
        'dbtable'     => '创建数据表',
        'base'        => '基本设置',
        'visit'       => '访问方式设置',
        'spec'        => '专题分发设置',
        'upload'      => '上传设置',
        'sso'         => 'SSO 设置',
        'admin'       => '创建管理员',
        'over'        => '完成安装',
    ),

    'upgrade'     => array(
        'outline'     => '升级概述',
        'phplib'      => '服务器环境检查',
        'dbconfig'    => '数据库设置',
        'dbtable'     => '升级数据库',
        'base'        => '基本设置',
        'visit'       => '访问方式设置',
        'spec'        => '专题分发设置',
        'upload'      => '上传设置',
        'sso'         => 'SSO 设置',
        'admin'       => '创建管理员',
        'over'        => '完成升级',
    ),

    'manual'     => array(
        'outline'   => '安装 / 升级概述',
        'dbconfig'  => '数据库配置',
        'base'      => '基本配置',
        'visit'     => '访问方式配置',
        'spec'      => '专题分发配置',
        'upload'    => '上传配置',
        'sso'       => 'SSO 配置',
    ),

    'deploy'     => array(
        'outline'     => '高级部署',
    ),

    'console'     => array(
        'outline'     => '后台概述',
        'common'      => '通用资源',
        'article'     => '文章管理',
        'tag'         => 'TAG / 标记',
        'source'      => '文章来源',
        'spec'        => '专题',
        'cate'        => '栏目管理',
        'attach'      => '附件管理',
        'call'        => '调用管理',
        'admin'       => '管理员',
        'group'       => '群组管理',
        'link'        => '链接',
        'opt'         => '系统设置',
        'custom'      => '自定义字段',
        'app'         => 'API 授权设置',
    ),

    'tpl'     => array(
        'outline'     => '模板概述',
        'common'      => '通用资源',
        'index_error' => '主页 / 提示信息',
        'page'        => '分页',
        'cate'        => '栏目',
        'article'     => '文章',
        'tag'         => 'TAG',
        'spec'        => '专题',
        'attach'      => '附件 / 缩略图',
        'call'        => '调用',
        'search'      => '搜索',
    ),

    'api'     => array(
        'outline' => 'API 概述',
        'page'    => '分页',
        'cate'    => '栏目',
        'article' => '文章',
        'custom'  => '自定义字段',
        'tag'     => 'TAG',
        'mark'    => '标记',
        'spec'    => '专题',
        'call'    => '调用',
        'attach'  => '附件 / 缩略图',
        'rcode'   => '返回代码',
    ),
);
