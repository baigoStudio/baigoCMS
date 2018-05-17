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

    /*------说明文字------*/
    'label' => array(
        'id'                => 'ID', //ID
        'all'               => '全部',
        'key'               => '关键词', //关键词
        'status'            => '状态',
        'note'              => '备注',
        'belongCate'      => '隶属于栏目', //隶属栏目

        'name'         => '名称',

        'gsite'             => '采集点',
        'gsiteName'         => '采集点名称',
        'gsiteUrl'          => '目标网站 URL',
        'gsiteCharset'      => '目标网站编码',
        'gsiteLimit'        => '单次采集数',
        'gsiteKeepTag'      => '保留标签',
        'gsiteKeepTagNote'  => '系统将会剔除文章内容中除系统保留标签以外的所有标签，请在此输入其他需要保留的标签，多个标签请用 <kbd>|</kbd> 分隔。',
        'gsiteSource'       => '目标源代码',

        'previewList'       => '列表预览',
        'previewContent'    => '内容预览',
        'previewPage'       => '分页链接预览',

        'charset'           => '字符编码',
        'charsetOften'      => '常用编码',

        'select'                => '选取',

        'selector'              => '选择器',
        'selectorExample'       => '示例',
        'selectorOften'         => '常用选择器',
        'selectorList'          => '列表选择器',
        'selectorPageList'      => '分页链接选择器',
        'selectorNote'          => '请使用 jQuery 选择器',
        'selectorListNote'      => '请使用 jQuery 选择器，必须以标签选择器 <code>a</code> 结尾，系统将自动读取 <code>href</code> 属性。',

        'keepTag'               => '系统保留标签',
        'keepTagNote'           => '系统会自动保留这些 HTML 标签，如果您有额外需要保留的标签，请在 <mark>保留标签</mark> 中输入（如：<code>a|footer|div</code>）。',

        'filter'                => '过滤器',
        'filterNote'            => '过滤器可以过滤掉不需要的元素，多个值请用 <kbd>|</kbd> 分隔。',

        'search'                => '查找',
        'replace'               => '替换',
        'replaceNote'           => '替换器可以将“查找”字符更换为“替换”字符（为空则删除“查找”字符），用法与 Word、WPS 的查找替换类似。',

        'imgAttr'               => '图片地址属性',
        'imgAttrNote'           => '默认为 src 属性',
        'imgFilter'             => '图片过滤关键词',
        'imgFilterNote'         => '此参数可以将路径中包含这些关键词的图片过滤掉，多个关键词请用 <kbd>|</kbd> 分隔。',


        'tagIgnore'             => '忽略标签',
        'tagIgnoreNote'         => '这些标签的属性全部保留，多个标签请用 <kbd>|</kbd> 分隔。',

        'parseTitle'            => '标题解析',
        'parseContent'          => '内容解析',
        'parseTime'             => '时间解析',
        'parseSource'           => '文章来源解析',
        'parseAuthor'           => '作者解析',
        'parseImg'              => '图片解析',
        'parsePageContent'      => '分页内容解析',

        'attrGather'            => '采集属性',
        'attrOften'             => '常用属性',
        'attrNote'              => '默认为 html',
        'attrOftenNote'         => '可选以下 3 类',
        'attrFilter'            => '属性过滤',
        'attrFilterNote'        => '以下参数只针对文章内容，默认将剔除所有属性。',
        'attrAllow'             => '允许的属性',
        'attrAllowNote'         => '这些属性将被全部保留，多个属性请用 <kbd>|</kbd> 分隔。',
        'attrExcept'            => '例外',
        'attrExceptNote'        => '这些标签的特定属性将被保留，同一标签下的多个属性请用 <kbd>|</kbd> 分隔。',
        'attrExceptNoteSys'     => '系统默认保留如下标签的特定属性',

        'attrExceptTag'         => '标签',
        'attrExceptAttr'        => '属性',
    ),

    'attrQList' => array(
        'html'  => array(
            'label' => 'html',
            'note'  => '采集 HTML 代码',
        ),
        'text'  => array(
            'label' => 'text',
            'note'  => '采集纯文本',
        ),
        'attr'  => array(
            'label' => 'HTML 属性',
            'note'  => '采集 HTML 属性（如 src、href、name、data-src 等）<br>示例：&lt;a <code>href=&quot;http://www.domail.com&quot;</code>&gt;链接&lt;/a&gt;，红色部分为属性（名称=&quot;值&quot;）。',
        ),
    ),

    'attrOften' => array(
        'html'  => 'HTML 代码',
        'text'  => '纯文本',
        'href'  => '链接',
        'src'   => '源 URL',
        'class' => '类',
        'id'    => 'ID',
        'title' => '标题',
    ),

    'filter' => array(
        'minus'  => array(
            'label' => '带 <code>-</code> 符号',
            'note'  => '移除该标签以及标签内容（此时可以为任意的 jQuery 选择器，如：<code>-p|-.title</code>）。',
        ),
        'none'  => array(
            'label' => '无符号',
            'note'  => '当 [采集属性] 值为 html 时，表示要过滤掉的 HTML 标签。<br>当 [采集属性] 值为 text 时，表示要保留的 HTML 标签（此时可以为 HTML 标签，如：<code>div|strong</code>）。',
        ),
    ),

    /*------链接文字------*/
    'href' => array(
        'add'   => '创建',
        'edit'  => '编辑',
        'help'  => '帮助',
        'show'  => '查看',

        'helpSelector'     => '选择器帮助',

        'stepList'         => '解析列表',
        'stepContent'      => '解析内容',
        'stepPageList'     => '解析分页列表',
        'stepPageContent'  => '解析分页内容',

        'parseMain'       => '主要内容解析',
        'parseAttach'     => '附加内容解析',
        'other'           => '其他',
    ),

    'status' => array(
        'enable'  => '启用', //生效
        'disable' => '禁用', //禁用
    ),

    'btn' => array(
        'save'      => '保存',
        'submit'    => '提交', //提交
        'duplicate' => '克隆',
        'next'      => '下一步',
    ),

    'option' =>  array(
        'pleaseSelect'  => '请选择', //请选择
        'allStatus'     => '所有状态', //所有
        'batch'         => '批量操作', //批量操作
        'del'           => '永久删除', //删除
    ),

    'confirm' => array(
        'del'         => '确认永久删除吗？此操作不可恢复！', //确认清空回收站
    ),
);
