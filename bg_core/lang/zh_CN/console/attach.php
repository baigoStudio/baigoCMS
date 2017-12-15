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
        'attachArticle' => '本文附件管理', //媒体库
    ),

    'href' => array(
        'all'       => '全部',
        'recycle'   => '回收站', //回收站
        'help'      => '帮助',
        'insert'    => '插入',
        'upload'    => '上传',
        'uploadArticle'     => '本文附件',
        'insert'            => '插入附件',
        'insertOriginal'    => '插入原图',
        'browseOriginal'    => '查看原图',
        'attachList'        => '管理附件',
    ),

    /*------说明文字------*/
    'label' => array(
        'id'            => 'ID', //ID
        'all'           => '全部',
        'key'           => '关键词', //关键词
        'thumb'         => '缩略图',
        'title'         => '标题',
        'belongCate'    => '隶属于栏目', //隶属栏目
        'detail'        => '详细信息',
        'status'        => '状态',
        'admin'         => '管理员', //管理员
        'needH5'        => '上传插件需要 HTML 5，请升级您的浏览器！',
        'waiting'       => '等待上传...',
        'uploading'     => '正在上传',
        'uploadSucc'    => '上传成功',
        'returnErr'     => '返回错误，非 JSON',
        'time'          => '时间',
        'mark'          => '标记',
        'none'          => '无',
        'unknown'       => '未知',
    ),

    'status' => array(
        'pub'   => '发布', //发布
        'wait'  => '待审', //等待审核
        'hide'  => '隐藏', //隐藏
        'not'   => '未生成',
        'yes'   => '已生成',
        'top'   => '置顶',
    ),

    'box' => array(
        'normal'    => '正常', //草稿
        'recycle'   => '回收站', //回收站
    ),

    'type' => array(
        'ratio'   => '比例', //按比例
        'cut'     => '裁切', //裁切
    ),

    'option' => array(
        'allYear'   => '所有年份', //所有年份
        'allMonth'  => '所有月份', //所有月份
        'allExt'    => '所有类型', //所有类型
        'batch'     => '批量操作', //批量操作
        'revert'    => '放回原处', //恢复
        'recycle'   => '放入回收站',
        'del'       => '永久删除', //删除
    ),

    'btn' => array(
        'browse'        => '请选择文件 ...',
        'upload'        => '开始上传',
        'attachClear'   => '清理附件',
        'empty'         => '清空回收站', //清空回收站
        'thumb'         => '缩略图',
        'submit'        => '提交', //提交
        'setPrimary'    => '设为主图',
    ),

    'confirm' => array(
        'empty'       => '确认清空回收站吗？此操作不可恢复！', //确认清空回收站
        'del'         => '确认永久删除吗？此操作不可恢复！', //确认清空回收站
        'clear'       => '确认清理附件吗？此操作将耗费较长时间！', //确认清空回收站
    ),
);
