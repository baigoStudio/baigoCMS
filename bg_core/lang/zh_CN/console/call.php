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
        'show'  => '查看',
    ),

    /*------链接文字------*/
    'href' => array(
        'add'   => '创建', //创建
        'edit'  => '编辑', //编辑
        'help'  => '帮助',
        'show'  => '查看',
    ),

    /*------说明文字------*/
    'label' => array(
        'id'              => 'ID', //ID
        'all'             => '全部',
        'key'             => '关键词', //关键词

        'status'          => '状态', //状态
        'type'            => '类型', //调用类型
        'except'          => '排除',

        'callName'        => '调用名称', //调用名称
        'callFunc'        => '调用方式', //调用方法
        'callFilter'      => '显示符合以下条件的内容',
        'callFile'        => '生成文件类型', //生成扩展名
        'callTpl'         => '模板', //模板
        'callAmount'      => '显示数量',
        'callAmoutTop'    => '显示前',
        'callAmoutExcept' => '排除前',
        'callTrim'        => '显示字数',
        'callMark'        => '标记（不选则显示所有）',
        'callCate'        => '栏目',
        'callSpec'        => '专题',
        'callAttach'      => '是否带图片',
        'callShow'        => '显示以下项目',
        'callShowImg'     => '图片',

        'allCate'         => '所有栏目', //所有栏目
    ),

    'status' => array(
        'enable'  => '启用', //发布
        'disable' => '禁用', //隐藏
    ),

    'type' => array(
        'article'     => '文章列表', //普通
        'hits_day'    => '日排行',
        'hits_week'   => '周排行',
        'hits_month'  => '月排行',
        'hits_year'   => '年排行',
        'hits_all'    => '总排行',
        'spec'        => '专题列表',
        'cate'        => '栏目列表',
        'tag_list'    => 'TAG 列表',
        'tag_rank'    => 'TAG 排行',
        'link'        => '友情链接列表',
    ),

    'attach' => array(
        'all'     => '全部',
        'attach'  => '仅显示带附件文章',
        'none'    => '仅显示无附件文章',
    ),

    'file' => array(
        'html'      => 'HTML',
        'shtml'     => 'SHTML',
        'js'        => 'JS',
    ),

    'option' => array(
        'allStatus'     => '所有状态', //所有
        'allType'       => '所有类型', //所有
        'pleaseSelect'  => '请选择', //请选择
        'batch'         => '批量操作', //批量操作
        'del'           => '永久删除', //删除
    ),

    /*------按钮------*/
    'btn' => array(
        'submit'    => '提交', //提交
        'save'      => '保存', //提交
        'duplicate' => '克隆',
        'genSingle' => '生成',
    ),

    /*------确认框------*/
    'confirm' => array(
        'del'       => '确认永久删除吗？此操作不可恢复！', //确认清空回收站
    ),
);
