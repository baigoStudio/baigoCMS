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
        'order' => '排序',
    ),

    'href' => array(
        'add'   => '创建',
        'help'  => '帮助',
        'edit'  => '编辑',
        'order' => '排序',
    ),

    /*------说明文字------*/
    'label' => array(
        'id'            => 'ID',
        'all'           => '全部',
        'key'           => '关键词',
        'status'        => '状态',
        'type'          => '类型',
        'format'        => '格式',
        'custom'        => '字段名称',
        'customParent'  => '隶属于字段',
        'belongCate'    => '隶属于栏目', //隶属栏目
        'noname'        => '未命名', //未命名
        'require'       => '必填项',
        'order'         => '排序',
        'orderFirst'    => '移到最前',
        'orderLast'     => '移到最后',
        'orderAfter'    => '该 ID 之后',
    ),

    'option' => array(
        'allStatus'     => '所有状态', //所有
        'allCate'       => '所有栏目',
        'batch'         => '批量操作', //批量操作
        'del'           => '永久删除', //删除
        'cache'         => '更新缓存',
        'pleaseSelect'  => '请选择', //请选择
        'asParent'      => '作为一级字段'
    ),

    'status' => array(
        'enable'  => '启用', //发布
        'disable' => '禁用', //隐藏
    ),

    'type' => array(
        'str' => array(
            'label'   => '输入框',
        ),
        'radio' => array(
            'label'   => '单选框',
            'option'  => array('选项一', '选项二', '选项三'),
        ),
        'select' => array(
            'label'   => '下拉菜单',
            'option'  => array('选项一', '选项二', '选项三'),
        ),
    ),

    'format' => array(
        'text'     => '文本',
        'date'     => '日期',
        'datetime' => '日期时间',
        'int'      => '整数',
        'digit'    => '数字（含小数点）',
        'url'      => 'URL',
        'email'    => '电子邮箱',
    ),

    'btn' => array(
        'save'          => '保存', //提交
        'submit'        => '提交', //提交
    ),

    'confirm' => array(
        'del' => '确认永久删除吗？此操作不可恢复！', //确认清空回收站
    ),
);
