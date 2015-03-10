<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------------------通用-------------------------*/
return array(

	/*------页面标题------*/
	"page" => array(
		"admin"           => "管理后台", //管理后台
		"login"           => "用户登录", //用户登录
		"adminLogin"      => "后台登录", //用户登录
		"alert"           => "提示信息", //提示信息
		"tplBrowse"       => "浏览模板", //浏览模板
		"add"             => "创建", //创建
		"edit"            => "编辑", //编辑
		"auth"            => "授权", //授权
		"upload"          => "上传", //上传
		"order"           => "排序",
		"show"            => "查看",
		"profile"         => "管理员个人信息",
		"pass"            => "修改密码",
		"search"          => "搜索", //搜索
		"spec"            => "专题",

		"upgrade"         => "baigo CMS 升级程序",
		"upgradeTable"    => "升级数据库",
		"upgradeOver"     => "完成升级",

		"install"         => "baigo CMS 安装程序",
		"installDb"       => "数据库设置",
		"installTable"    => "创建数据表",
		"installBase"     => "基本设置",
		"installVisit"    => "访问方式设置",
		"installUpload"   => "上传设置",
		"installSso"      => "SSO 设置",
		"installSsoAuto"  => "SSO 自动部署",
		"installAdmin"    => "创建管理员",
		"installOver"     => "完成安装",
	),

	/*------链接文字------*/
	"href" => array(
		"agree"           => "同意", //同意
		"logout"          => "退出", //退出
		"back"            => "返回", //返回
		"reg"             => "注册", //注册
		"passModi"        => "修改密码", //修改密码
		"add"             => "创建", //创建
		"edit"            => "编辑", //编辑
		"auth"            => "授权", //授权
		"all"             => "全部", //全部
		"pub"             => "已发布", //已发布
		"wait"            => "待审", //待审
		"draft"           => "草稿箱", //草稿
		"recycle"         => "回收站", //回收站
		"recycleMy"       => "我的回收站", //我的回收站
		"browse"          => "浏览", //浏览
		"order"           => "排序",
		"browseOriginal"  => "查看原图",
		"show"            => "查看",
		"help"            => "帮助",

		"toGroup"         => "加入组", //加入组

		"specSelect"      => "选择文章",

		"pageFirst"       => "首页", //首页
		"pagePrevList"    => "上十页", //上十页
		"pagePrev"        => "上页", //上一页
		"pageNext"        => "下页", //下一页
		"pageNextList"    => "下十页", //下十页
		"pageLast"        => "末页", //尾页

		"adminAuth"       => "授权为管理员", //授权
		"ssoAuto"         => "SSO 自动部署", //尾页
		"ssoUpgrade"      => "SSO 升级", //尾页

		"insert"          => "插入附件",
		"insertOriginal"  => "插入原始文档",
		"insertThumb"     => "插入",
		"upload"          => "上传附件",
		"uploadList"      => "上传或插入", //上传或插入

		"attachList"      => "媒体库", //媒体库
		"articleList"     => "浏览文章", //浏览文章
	),

	/*------说明文字------*/
	"label" => array(
		"top"             => "置顶",
		"id"              => "ID", //ID
		"seccode"         => "验证码", //验证码
		"all"             => "全部",
		"key"             => "关键词", //关键词
		"alert"           => "返回代码", //提示信息
		"noname"          => "未命名", //未命名
		"unknow"          => "未知", //未知
		"normal"          => "正常", //草稿
		"draft"           => "草稿箱", //草稿
		"recycle"         => "回收站", //回收站
		"box"             => "保存至",
		"status"          => "状态", //状态
		"none"            => "无",
		"type"            => "类型", //栏目类型

		"appName"         => "应用名称",
		"appId"           => "APP ID",
		"appKey"          => "APP KEY",
		"appKeyNote"      => "如果 APP KEY 泄露，可以通过重置更换，原 APP KEY 将作废。",
		"appNotice"       => "通知接口 URL",
		"appAllow"        => "权限", //系统权限
		"apiUrl"          => "API 接口 URL",

		"ipAllow"         => "允许通信 IP",
		"ipBad"           => "禁止通信 IP",
		"ipNote"          => "每行一个 IP，可使用通配符 <strong>*</strong> （如 192.168.1.*）",

		"admin"           => "管理员", //管理员
		"adminGroup"      => "隶属群组", //管理组
		"adminUnknow"     => "未知管理员，建议删除",
		"nick"            => "昵称",

		"spec"            => "专题",
		"specName"        => "专题名称",
		"specContent"     => "专题内容",

		"profileAllow"    => "个人权限",
		"profileInfo"     => "禁止修改个人信息",
		"profilePass"     => "禁止修改密码",

		"belongArticle"   => "已选文章",
		"selectArticle"   => "待选文章",

		"username"        => "用户名", //用户名
		"password"        => "密码", //密码
		"passOld"         => "旧密码", //密码
		"passNew"         => "新密码", //密码
		"passConfirm"     => "确认密码", //密码
		"upgrade"         => "正在进行升级安装",
		"to"              => "至",
		"complete"        => "升级安装无法创建管理员，点完成完成安装",

		"mail"            => "E-mail",

		"loading"         => "正在载入……",
		"uploading"       => "正在上传",

		"upgradeTable"    => "即将升级数据库",
		"upgradeOver"     => "还差最后一步，完成升级",

		"installOver"     => "还差最后一步，完成安装",
		"installTable"    => "即将创建数据表",
		"installSso"      => "即将执行自动部署第一步",

		"modOnly"         => "（需要修改时输入）", //需要修改时输入
		"time"            => "时间", //时间
		"datetime"        => "日期 / 时间", //时间
		"note"            => "备注", //备注
		"timePub"         => "发布时间",
		"deadline"        => "定时",
		"timeNote"        => "格式 " . date("Y-m-d H:i"),

		"tpl"             => "模板", //模板

		"order"           => "排序",
		"orderFirst"      => "移到最前",
		"orderLast"       => "移到最后",
		"orderAfter"      => "该 ID 之后",

		"group"           => "群组", //组名
		"groupName"       => "组名", //组名
		"groupNote"       => "备注", //备注
		"groupAllow"      => "系统权限", //系统权限
		"groupType"       => "类型",

		"articleTitle"    => "文章标题", //文章标题
		"articleContent"  => "文章内容", //文章标题
		"articleLink"     => "跳转至", //跳转至
		"articleLinkNote" => "必须以 http:// 开始", //跳转至
		"articleCate"     => "隶属于栏目", //隶属栏目
		"articleBelong"   => "附加至栏目", //附加栏目
		"articleMark"     => "标记", //标记
		"articleTag"      => "TAG", //TAG
		"articleExcerpt"  => "摘要", //摘要
		"more"            => "显示更多选项", //显示高级选项
		"articleCount"    => "文章数",
		"articleSpec"     => "专题",

		"cate"            => "栏目", //栏目
		"cateAllow"       => "栏目管理权限", //栏目权限
		"cateName"        => "栏目名称", //栏目名称
		"cateAlias"       => "别名（用于 URL）", //别名
		"cateParent"      => "隶属于栏目", //父栏目
		"cateType"        => "栏目类型", //栏目类型
		"cateStatus"      => "栏目状态", //栏目状态
		"cateLink"        => "跳转至", //跳转至
		"cateDomain"      => "URL 前缀", //URL 前缀
		"cateContent"     => "内容", //栏目简介
		"cateFtpServ"     => "FTP 服务器", //FTP 服务器
		"cateFtpPort"     => "FTP 服务器端口", //FTP 服务器端口
		"cateFtpUser"     => "FTP 用户名", //FTP 用户名
		"cateFtpPass"     => "FTP 密码", //FTP 密码
		"cateFtpPath"     => "FTP 远程路径", //FTP 远程路径
		"cateAll"         => "所有栏目", //作为一级栏目

		"callName"        => "调用名称", //调用类型
		"callFilter"      => "显示符合以下条件的内容",
		"callType"        => "调用类型", //调用类型
		"callFile"        => "生成文件类型", //生成扩展名
		"callAmount"      => "显示数量",
		"callAmoutTop"    => "显示前",
		"callAmoutExcept" => "排除前",
		"callTrim"        => "显示字数",
		"callMark"        => "标记（不选则显示所有）",
		"callCate"        => "栏目",
		"callSpec"        => "专题",
		"callAttach"      => "是否带图片",
		"callShow"        => "显示以下项目",
		"callShowImg"     => "图片",
		"callCss"         => "应用 CSS 类名",
		"showBase"        => "基本项目",

		"tagName"         => "TAG", //TAG
		"markName"        => "标记", //标记

		"attachName"      => "文件名", //文件名
		"attachPath"      => "保存路径", //保存路径
		"attachSize"      => "允许上传大小", //允许文件大小
		"attachThumb"     => "缩略图", //缩略图
		"attachMime"      => "允许下列扩展名",
		"uploadSucc"      => "上传成功",
		"attachInfo"      => "详细信息",

		"thumbWidth"      => "最大宽度", //缩略图宽度
		"thumbHeight"     => "最大高度", //缩略图高度
		"thumbType"       => "缩略图类型", //裁切类型
		"thumbCall"       => "调用键名", //调用名

		"dbHost"          => "数据库服务器",
		"dbName"          => "数据库名称",
		"dbUser"          => "数据库用户名",
		"dbPass"          => "数据库密码",
		"dbCharset"       => "数据库字符编码",
		"dbTable"         => "数据表名前缀",
		"dbDebug"         => "数据库调试模式",

		"on"              => "开",
		"off"             => "关",

		"mimeName"        => "允许上传的 MIME", //允许上传类型的 MIME
		"mimeOften"       => "常用 MIME", //常用 MIME
		"ext"             => "扩展名",

		"year"            => "年", //年
		"month"           => "月", //月
		"day"             => "日", //日
		"hour"            => "时", //时
		"minute"          => "分", //分
	),

	"allow" => array(
		"add"     => "添加",
		"edit"    => "编辑",
		"del"     => "删除",
		"approve" => "审核",
	),

	"option" => array(
		"allStatus"       => "所有状态", //所有
		"allType"         => "所有类型", //所有
		"allExt"          => "所有类型", //所有类型
		"allGroup"        => "所有组", //所有组
		"allCate"         => "所有栏目", //所有栏目
		"allMark"         => "所有标记", //所有标记

		"allYear"         => "所有年份", //所有年份
		"allMonth"        => "所有月份", //所有月份

		"pleaseSelect"    => "请选择", //请选择
		"asParent"        => "作为一级栏目", //作为一级栏目
		"noGroup"         => "不加入组",
		"noImg"           => "不显示",
		"noTime"          => "不显示",
		"noMark"          => "无标记",
		"noSpec"          => "不加入专题",
		"original"        => "原图",
		"tplInherit"      => "继承上一级", //继承上一级模板

		"top"             => "置顶",
		"untop"           => "取消置顶",
		"batch"           => "批量操作", //批量操作
		"del"             => "永久删除", //删除
		"normal"          => "正常", //正常
		"revert"          => "放回原处", //恢复
		"draft"           => "存为草稿",
		"recycle"         => "放入回收站",
		"unknow"          => "未知", //未知
	),

	/*------长篇文字------*/
	"text" => array(
		"installSso"      => "baigo CMS 的用户以及后台登录需要 baigo SSO 支持，baigo SSO 的部署方式，请查看 <a href=\"" . PRD_SSO_URL . "\" target=\"_blank\">baigo SSO 官方网站</a>。如果您的网站没有部署 baigo SSO，请点击 <mark>SSO 自动部署</mark>。",
		"upgradeSso"      => "baigo CMS 的用户以及后台登录需要 baigo SSO 支持，baigo SSO 的部署方式，请查看 <a href=\"" . PRD_SSO_URL . "\" target=\"_blank\">baigo SSO 官方网站</a>。baigo SSO 的升级与 baigo CMS 的升级并无直接关联，如果您要检查 baigo SSO 是否可升级，请点击 <mark>SSO 升级</mark>。",
		"installAdmin"    => "本操作将向 SSO 注册新用户，并自动将新注册的用户授权为超级管理员，拥有所有的管理权限。如果您之前已经部署有 baigo SSO，并且不想注册新用户，只希望使用原有的 SSO 用户作为管理员，请点击 <mark>授权为管理员</mark>。",
		"installSsoAdmin" => "本操作将同时为 CMS 与 SSO 创建管理员，拥有所有的管理权限。请牢记用户名与密码。",
		"installAuth"     => "本操作将用您输入的 SSO 用户作为管理员，拥有所有的管理权限。您必须输入该用户的用户名和密码才能进行授权。",
		"x070405"         => "尚未设置允许上传的文件类型，<a href=\"" . BG_URL_ADMIN . "ctl.php?mod=mime&act_get=list\" target=\"_top\">点击立刻设置</>",
		"x110401"         => "尚未创建栏目，<a href=\"" . BG_URL_ADMIN . "ctl.php?mod=cate&act_get=form\" target=\"_top\">点击立刻创建</a>",
	),

	"digit"    => array("日", "一", "二", "三", "四", "五", "六", "七", "八", "九", "十"),

	/*------按钮------*/
	"btn" => array(
		"add"         => "创建", //创建
		"ok"          => "确定", //确定
		"login"       => "登录", //登录
		"submit"      => "提交", //提交
		"close"       => "关闭", //提交
		"save"        => "保存", //提交
		"cancel"      => "取消",
		"del"         => "永久删除", //删除
		"complete"    => "完成",
		"search"      => "搜索", //搜索
		"searchSpec"  => "搜索",
		"filter"      => "筛选", //筛选
		"thumb"       => "缩略图",
		"upload"      => "上传附件",
		"recycle"     => "移至回收站", //移至回收站
		"empty"       => "清空我的回收站", //清空回收站
		"browse"      => "请选择文件 ...",
		"skip"        => "跳过",
		"jump"        => "跳转至",
		"over"        => "完成",
		"menu"        => "菜单",
		"belongAdd"   => "选择",
		"belongDel"   => "移除",
		"reloadSpec"  => "重载专题",
		"stepNext"    => "下一步",
		"resetKey"    => "重置 APP KEY",
	),

	/*------确认框------*/
	"confirm" => array(
		"del"         => "确认永久删除吗？此操作不可恢复！", //确认清空回收站
		"empty"       => "确认清空回收站吗？此操作不可恢复！", //确认清空回收站
		"resetKey"    => "确认重置吗？此操作不可恢复！",
	),

	/*------图片说明------*/
	"alt" => array(
		"seccode" => "看不清", //验证码
	),
);
