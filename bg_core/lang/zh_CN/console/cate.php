<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------------------通用-------------------------*/
return array(

    'page' => array(
        'add'   => '创建', //创建
        'edit'  => '编辑', //编辑
        'order' => '排序',
    ),

    /*------链接文字------*/
    'href' => array(
        'add'           => '创建', //创建
        'edit'          => '编辑', //编辑
        'help'          => '帮助',
        'order'         => '排序',
        'articleList'   => '浏览文章', //浏览文章
        'uploadList'    => '上传或插入', //上传或插入
    ),

    /*------说明文字------*/
    'label' => array(
        'id'                => 'ID', //ID
        'all'               => '全部',
        'key'               => '关键词', //关键词
        'more'              => '显示更多选项', //显示高级选项

        'type'              => '类型', //栏目类型
        'status'            => '状态', //栏目状态
        'tpl'               => '模板',

        'cate'              => '栏目', //栏目
        'cateName'          => '栏目名称', //栏目名称
        'cateAlias'         => '别名（用于 URL）', //别名
        'cateLink'          => '跳转至', //跳转至
        'cateDomain'        => 'URL 前缀', //URL 前缀
        'cateDomainNote'    => '末尾请勿加 <kbd>/</kbd>',
        'cateContent'       => '栏目介绍', //栏目简介
        'catePerpage'       => '每页显示数', //每页显示数
        'ftpServ'       => '分发 FTP 地址', //分发 FTP 地址
        'ftpPort'       => 'FTP 端口', //FTP 端口
        'ftpUser'       => 'FTP 用户名', //FTP 用户名
        'ftpPass'       => 'FTP 密码', //FTP 密码
        'ftpPath'       => 'FTP 远程路径', //FTP 远程路径
        'ftpPathNote'   => '末尾请勿加 <kbd>/</kbd>',
        'ftpPasv'       => 'FTP 被动模式', //FTP 远程路径

        'belongCate'        => '隶属于栏目', //隶属栏目

        'order'         => '排序',
        'orderFirst'    => '移到最前',
        'orderLast'     => '移到最后',
        'orderAfter'    => '该 ID 之后',
    ),

    'type' => array(
        'normal'  => '普通', //普通
        'single'  => '单页', //单页
        'link'    => '跳转', //跳转至
    ),

    'status' => array(
        'show'  => '显示', //正常
        'hide'  => '隐藏', //隐藏
        'off'   => '关闭',
        'on'    => '开启',
    ),

    'btn' => array(
        'genSingle' => '生成',
        'submit'    => '提交', //提交
        'save'      => '保存', //提交
        'duplicate' => '克隆',
    ),

    /*------确认框------*/
    'confirm' => array(
        'del'         => '确认永久删除吗？此操作不可恢复！', //确认清空回收站
    ),

    'option' => array(
        'allStatus'     => '所有状态', //所有
        'allType'       => '所有类型', //所有

        'pleaseSelect'  => '请选择', //请选择

        'asParent'      => '作为一级栏目', //作为一级栏目
        'tplInherit'    => '继承上一级', //继承上一级模板

        'batch'         => '批量操作', //批量操作
        'cache'         => '更新缓存',
        'batch'         => '批量操作', //批量操作
        'del'           => '永久删除', //删除
    ),
);
