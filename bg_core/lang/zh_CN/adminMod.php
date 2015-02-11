<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿编辑
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*----------后台管理模块----------*/
return array(
	"article" => array(
		"main" => array(
			"title"  => "文章管理",
			"mod"    => "article",
			"icon"   => "file",
		),
		"sub" => array(
			"list" => array(
				"title"     => "所有文章",
				"mod"       => "article",
				"act_get"   => "list",
			),
			"form" => array(
				"title"     => "创建文章",
				"mod"       => "article",
				"act_get"   => "form",
			),
			"spec" => array(
				"title"     => "专题",
				"mod"       => "spec",
				"act_get"   => "list",
			),
			"tag" => array(
				"title"     => "TAG",
				"mod"       => "tag",
				"act_get"   => "list",
			),
			"mark" =>  array(
				"title"     => "标记",
				"mod"       => "mark",
				"act_get"   => "list",
			),
		),
		"allow" => array(
			"browse"     => "浏览",
			"add"        => "创建",
			"edit"       => "编辑",
			"del"        => "删除",
			"approve"    => "审核",
			"spec"       => "专题",
			"tag"        => "TAG",
			"mark"       => "标记",
		),
	),
	"cate" => array(
		"main" => array(
			"title"  => "栏目管理",
			"mod"    => "cate",
			"icon"   => "th-large",
		),
		"sub" => array(
			"list" => array(
				"title"     => "所有栏目",
				"mod"       => "cate",
				"act_get"   => "list",
			),
			"form" => array(
				"title"     => "创建栏目",
				"mod"       => "cate",
				"act_get"   => "form",
			),
		),
		"allow" => array(
			"browse" => "浏览",
			"add"    => "创建",
			"edit"   => "编辑",
			"del"    => "删除",
		),
	),
	"attach" => array(
		"main" => array(
			"title"  => "附件管理",
			"mod"    => "attach",
			"icon"   => "paperclip",
		),
		"sub" => array(
			"list" => array(
				"title"     => "所有附件",
				"mod"       => "attach",
				"act_get"   => "list",
			),
			"mime" => array(
				"title"     => "附件类型",
				"mod"       => "mime",
				"act_get"   => "list",
			),
			"thumb" => array(
				"title"     => "缩略图",
				"mod"       => "thumb",
				"act_get"   => "list",
			),
		),
		"allow" => array(
			"browse" => "浏览",
			"del"    => "删除",
			"upload" => "上传",
			"mime"   => "附件类型",
			"thumb"  => "缩略图",
		),
	),
	"call" => array(
		"main" => array(
			"title"  => "调用管理",
			"mod"    => "call",
			"icon"   => "list",
		),
		"sub" => array(
			"list" => array(
				"title"     => "所有调用",
				"mod"       => "call",
				"act_get"   => "list",
			),
			"form" => array(
				"title"     => "创建调用",
				"mod"       => "call",
				"act_get"   => "form",
			),
			/*"gen" => array(
				"title"     => "生成调用",
				"mod"       => "call",
				"act_get"   => "gen",
			),*/
		),
		"allow" => array(
			"browse" => "浏览",
			"add"    => "创建",
			"edit"   => "编辑",
			"del"    => "删除",
			//"gen"    => "生成",
		),
	),
	/*"gen" => array(
		"main" => array(
			"title"  => "生成管理",
			"mod"    => "gen",
		),
		"sub" => array(
			"gen" => array(
				"title"     => "生成文件",
				"mod"       => "gen",
				"act_get"   => "gen",
			),
			"all" => array(
				"title"     => "全面生成",
				"mod"       => "gen",
				"act_get"   => "all",
			),
		),
		"allow" => array(
			"gen"    => "生成",
			"all"    => "全面生成",
		),
	),
	"user" => array(
		"main" => array(
			"title"  => "用户管理",
			"mod"    => "user",
		),
		"sub" => array(
			"list" => array(
				"title"     => "所有用户",
				"mod"       => "user",
				"act_get"   => "list",
			),
			"form" => array(
				"title"     => "创建用户",
				"mod"       => "user",
				"act_get"   => "form",
			),
		),
		"allow" => array(
			"browse" => "浏览",
			"add"    => "创建",
			"edit"   => "编辑",
			"del"    => "删除",
		),
	),*/
	"admin" => array(
		"main" => array(
			"title"  => "管理员",
			"mod"    => "admin",
			"icon"   => "user",
		),
		"sub" => array(
			"list" => array(
				"title"     => "所有管理员",
				"mod"       => "admin",
				"act_get"   => "list",
			),
			"form" => array(
				"title"     => "创建管理员",
				"mod"       => "admin",
				"act_get"   => "form",
			),
			"auth" => array(
				"title"     => "授权为管理员",
				"mod"       => "admin",
				"act_get"   => "auth",
			),
		),
		"allow" => array(
			"browse"     => "浏览",
			"add"        => "创建",
			"edit"       => "编辑",
			"del"        => "删除",
			"toGroup"    => "加入组",
		),
	),
	"group" => array(
		"main" => array(
			"title"  => "群组管理",
			"mod"    => "group",
			"icon"   => "bookmark",
		),
		"sub" => array(
			"list" => array(
				"title"     => "所有群组",
				"mod"       => "group",
				"act_get"   => "list",
			),
			"form" => array(
				"title"     => "创建群组",
				"mod"       => "group",
				"act_get"   => "form",
			),
		),
		"allow" => array(
			"browse" => "浏览",
			"add"    => "创建",
			"edit"   => "编辑",
			"del"    => "删除",
		),
	),
	"opt" => array(
		"main" => array(
			"title"  => "系统设置",
			"mod"    => "opt",
			"icon"   => "cog",
		),
		"sub" => array(
			"base" => array(
				"title"     => "基本设置",
				"mod"       => "opt",
				"act_get"   => "base",
			),
			"db" => array(
				"title"     => "数据库设置",
				"mod"       => "opt",
				"act_get"   => "db",
			),
			"visit" => array(
				"title"     => "访问方式",
				"mod"       => "opt",
				"act_get"   => "visit",
			),
			"upload" => array(
				"title"     => "上传设置",
				"mod"       => "opt",
				"act_get"   => "upload",
			),
			"sso" => array(
				"title"     => "SSO 设置",
				"mod"       => "opt",
				"act_get"   => "sso",
			),
		),
		"allow" => array(
			"base"   => "基本",
			"db"     => "数据库",
			"visit"  => "访问方式",
			"upload" => "上传设置",
			"sso"    => "SSO 设置",
		),
	),
);
?>