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

    /*------页面标题------*/
    'page' => array(
        'gathering'         => '正在采集',
        'storing'           => '正在入库',
        'show'              => '查看',
    ),

    /*------说明文字------*/
    'label' => array(
        'id'            => 'ID', //ID
        'all'           => '全部',
        'key'           => '关键词', //关键词
        'gsite'         => '采集点',
        'status'        => '状态',
        'note'          => '备注',
        'title'         => '标题',
        'time'          => '时间',
        'unknown'       => '未知', //未知
        'belongCate'    => '隶属于栏目', //隶属栏目
        'author'        => '作者',
        'content'       => '内容',
        'source'        => '来源',
        'admin'         => '管理员',
        'gsiteName'     => '采集点名称',
        'gsiteUrl'      => '目标网站 URL',
    ),

    'href' => array(
        'help'  => '帮助',
        'show'  => '查看',
        'edit'  => '编辑并入库',
    ),

    'status' => array(
        'enable'    => '启用', //生效
        'disable'   => '禁用', //禁用
        'wait'      => '待审',
        'store'     => '已入库',
    ),

    'option' => array(
        'allCate'       => '所有栏目', //所有栏目
        'allStatus'     => '所有状态', //所有
        'allGsite'          => '所有采集点', //所有标记
    ),

    'confirm' => array(
        'del'         => '确认永久删除吗？此操作不可恢复！', //确认清空回收站
    ),

    /*------按钮------*/
    'btn' => array(
        'gather1by1'    => '全部采集',
        'gatherStart'   => '开始采集',
        'store'         => '入库',
        'storeAll'      => '全部入库',
        'storeEnforce'  => '强制入库',
        'del'           => '永久删除', //删除
    ),
);
