<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------------------文章-------------------------*/
return array(

    'page' => array(
        'add'           => '写文章',
        'edit'          => '编辑',
        'show'          => '查看',
        'editGather'    => '从采集创建',
    ),

    'label' => array(
        'id'            => 'ID',
        'all'           => '全部',
        'title'         => '标题',
        'content'       => '文章内容',
        'cate'          => '栏目',
        'mark'          => '标记',
        'status'        => '状态',
        'admin'         => '管理员',
        'time'          => '时间',
        'tag'           => 'TAG', //TAG
        'box'           => '保存至',
        'key'           => '关键词',
        'none'          => '无',
        'enforce'       => '警告！此操作将耗费较长时间！',

        'belongCate'    => '隶属于栏目', //隶属栏目
        'attachCate'    => '附加至栏目', //附加栏目

        'excerpt'       => '摘要',
        'excerptType'   => '摘要类型',

        'noMark'        => '无标记',
        'noTitle'       => '无标题',

        'unCate'        => '未知栏目',
        'unAdmin'       => '未知管理员',

        'timeShow'      => '显示时间',
        'timePub'       => '定时上线',
        'timeHide'      => '定时下线',
        'timeNote'      => '格式 ' . date('Y-m-d H:i'),

        'hits'          => '点击数',
        'hitsDay'       => '日点击',
        'hitsWeek'      => '周点击',
        'hitsMonth'     => '月点击',
        'hitsYear'      => '年点击',
        'hitsAll'       => '总点击',

        'link'     => '跳转至', //跳转至
        'linkNote' => '必须以 http:// 开始', //跳转至

        'source'            => '文章来源',
        'sourceName'        => '来源名称',
        'sourceUrl'         => '来源 URL',
        'author'            => '作者',
        'sourceOften'       => '常用来源',

        'articleUrl'      => '文章地址',
        'articlePath'     => '文章路径',
        'staticFile'      => '静态文件',
    ),

    /*------链接文字------*/
    'href' => array(
        'all'           => '全部文章', //全部
        'add'           => '写文章', //创建
        'edit'          => '编辑', //编辑
        'draft'         => '草稿箱', //草稿
        'recycle'       => '回收站', //回收站
        'show'          => '查看',

        'help'          => '帮助',
        'uploadList'    => '上传或插入', //上传或插入
        'attachArticle' => '本文附件管理', //媒体库
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
        'draft'     => '草稿箱', //草稿
        'recycle'   => '回收站', //回收站
    ),

    'option' => array(
        'allCate'       => '所有栏目', //所有栏目
        'allYear'       => '所有年份', //所有年份
        'allMonth'      => '所有月份', //所有月份
        'allMark'       => '所有标记', //所有标记
        'allStatus'     => '所有状态', //所有
        'batch'         => '批量操作', //批量操作
        'del'           => '永久删除', //删除
        'pleaseSelect'  => '请选择', //请选择

        'noMark'        => '无标记',

        'unCate'        => '未知栏目', //未知
        'top'           => '置顶',
        'untop'         => '取消置顶',
        'revert'        => '放回原处', //恢复
        'draft'         => '存为草稿',
        'recycle'       => '放入回收站',
        'moveToCate'    => '移至新栏目',
    ),

    'confirm' => array(
        'del'         => '确认永久删除吗？此操作不可恢复！', //确认清空回收站
        'empty'       => '确认清空回收站吗？此操作不可恢复！', //确认清空回收站
    ),

    'btn' => array(
        'save'      => '保存', //提交
        'submit'    => '提交', //提交
        'emptyMy'   => '清空我的回收站',
        'genSingle'  => '生成',
    ),
);
