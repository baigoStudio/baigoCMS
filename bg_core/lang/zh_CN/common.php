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
		"adminMy"         => "管理员个人信息",
		"install"         => "baigo CMS 安装程序",
		"installStep"     => "安装",
		"installDb"       => "数据库设置",
		"installTable"    => "创建数据表",
		"installBase"     => "基本设置",
		"installVisit"    => "访问方式设置",
		"installUpfile"   => "上传设置",
		"installSso"      => "SSO 设置",
		"installSsoauto"  => "SSO 自动部署",
		"installAdmin"    => "创建管理员",
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

		"toGroup"         => "加入组", //加入组

		"pageFirst"       => "首页", //首页
		"pagePreList"     => "上十页", //上十页
		"pagePre"         => "上一页", //上一页
		"pageNext"        => "下一页", //下一页
		"pageNextList"    => "下十页", //下十页
		"pageLast"        => "末页", //尾页

		"ssoauto"         => "SSO 自动部署", //尾页

		"insert"          => "插入", //插入
		"insertOriginal"  => "插入原图", //插入原图

		"upload"          => "上传", //上传
		"uploadList"      => "上传或插入", //上传或插入

		"upfileList"      => "媒体库", //媒体库
		"articleList"     => "浏览文章", //浏览文章
	),

	/*------说明文字------*/
	"label" => array(
		"id"              => "ID", //ID
		"seccode"         => "验证码", //验证码
		"all"             => "全部",
		"key"             => "关键词", //关键词
		"alert"           => "提示代码", //提示信息
		"noname"          => "未命名", //未命名
		"unknow"          => "未知", //未知
		"normal"          => "正常", //草稿
		"draft"           => "草稿箱", //草稿
		"recycle"         => "回收站", //回收站
		"box"             => "保存至",
		"status"          => "状态", //状态
		"none"            => "无",

		"admin"           => "管理员", //管理员
		"adminGroup"      => "隶属群组", //管理组
		"adminUnknow"     => "未知管理员，建议删除",

		"username"        => "用户名", //用户名
		"password"        => "密码", //密码
		"passwordOld"     => "旧密码", //密码
		"passwordNew"     => "新密码", //密码
		"passwordConfirm" => "确认密码", //密码

		"mail"            => "E-mail",

		"installTable"    => "即将创建数据表",
		"installSso"      => "即将自动部署 SSO",

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
		"orderBefore"     => "该 ID 之前",
		"orderAfter"      => "该 ID 之后",

		"group"           => "群组", //组名
		"groupName"       => "组名", //组名
		"groupNote"       => "备注", //备注
		"groupAllow"      => "系统权限", //系统权限
		"groupType"       => "类型",

		"articleTitle"    => "文章标题", //文章标题
		"articleContent"  => "文章内容", //文章标题
		"articleLink"     => "跳转至", //跳转至
		"articleLinkNote" => "（必须以 http:// 开始）", //跳转至
		"articleCate"     => "所属栏目", //所属栏目
		"articleBelong"   => "附加至栏目", //附加栏目
		"articleMark"     => "标记", //标记
		"articleTag"      => "TAG", //TAG
		"articleTagNote"  => "（多个 TAG 请用半角逗号 , 隔开）", //TAG
		"articleExcerpt"  => "摘要", //摘要
		"articleMore"     => "显示更多选项", //显示高级选项
		"articleCount"    => "文章数",

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
		"cateAll"         => "全部栏目", //作为一级栏目

		"callName"        => "调用名称", //调用类型
		"callFilter"      => "显示符合以下条件的内容",
		"callType"        => "调用类型", //调用类型
		"callFile"        => "生成文件类型", //生成扩展名
		"callAmount"      => "显示数量",
		"callAmoutTop"    => "显示前",
		"callAmoutExcept" => "排除前",
		"callTrim"        => "显示字数",
		"callMark"        => "标记（不选则显示全部）",
		"callCate"        => "栏目",
		"callUpfile"      => "是否带图片",
		"callShow"        => "显示以下项目",
		"callShowImg"     => "图片",
		"callCss"         => "应用 CSS 类名",

		"tagName"         => "TAG", //TAG
		"markName"        => "标记", //标记

		"upfileName"      => "文件名", //文件名
		"upfilePath"      => "保存路径", //保存路径
		"upfileSize"      => "允许上传大小", //允许文件大小
		"upfileThumb"     => "缩略图", //缩略图
		"upfileMime"      => "允许下列扩展名",
		"uploadSucc"      => "个文件上传成功",

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
		"allStatus"       => "全部状态", //全部
		"allType"         => "全部类型", //全部
		"allExt"          => "全部类型", //全部类型
		"allGroup"        => "全部组", //全部组
		"allCate"         => "全部栏目", //全部栏目
		"allMark"         => "全部标记", //全部标记

		"allYear"         => "全部年份", //全部年份
		"allMonth"        => "全部月份", //全部月份

		"pleaseSelect"    => "请选择", //请选择
		"asParent"        => "作为一级栏目", //作为一级栏目
		"noGroup"         => "不加入组",
		"noImg"           => "不显示",
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
		"installSso"  => "baigo CMS 的用户以及后台登录需要 baigo SSO 支持，baigo SSO 的部署方式，请参考 <a href=\"" . PRD_SSO_URL . "\" target=\"_blank\">baigo SSO 官方网站</a>。如果您的网站没有部署 baigo SSO，请点击 SSO 自动部署。",
		"x070405"     => "尚未设置允许上传的文件类型，<a href=\"" . BG_URL_ADMIN . "admin.php?mod=mime&act_get=list\" target=\"_top\">点击立刻设置</>",
		"x110401"     => "尚未创建栏目，<a href=\"" . BG_URL_ADMIN . "admin.php?mod=cate&act_get=form\" target=\"_top\">点击立刻创建</>",
	),

	/*------按钮------*/
	"btn" => array(
		"add"         => "创建", //创建
		"ok"          => "确定", //确定
		"login"       => "登录", //登录
		"submit"      => "提交", //提交
		"del"         => "永久删除", //删除
		"search"      => "搜索", //搜索
		"filter"      => "筛选", //筛选
		"recycle"     => "移至回收站", //移至回收站
		"empty"       => "清空我的回收站", //清空回收站
		"browse"      => "请选择文件 ...",
		"skip"        => "跳过",
		"installPre"  => "上一步",
		"installNext" => "下一步",
	),

	/*------确认框------*/
	"confirm" => array(
		"del"     => "确认永久删除吗？此操作不可恢复！", //确认清空回收站
		"empty"   => "确认清空回收站吗？此操作不可恢复！", //确认清空回收站
	),

	/*------图片说明------*/
	"alt" => array(
		"seccode" => "看不清", //验证码
	),
);
?>