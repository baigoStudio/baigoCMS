<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿编辑
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

/*----------后台管理模块----------*/
return array(
    "article" => array(
        "main" => array(
            "title"  => "文章管理",
            "mod"    => "article",
            "icon"   => "duplicate",
        ),
        "sub" => array(
            "list" => array(
                "title"     => "所有文章",
                "mod"       => "article",
                "act"   => "list",
            ),
            "form" => array(
                "title"     => "创建文章",
                "mod"       => "article",
                "act"   => "form",
            ),
            "spec" => array(
                "title"     => "专题",
                "mod"       => "spec",
                "act"   => "list",
            ),
            "tag" => array(
                "title"     => "TAG",
                "mod"       => "tag",
                "act"   => "list",
            ),
            "mark" =>  array(
                "title"     => "标记",
                "mod"       => "mark",
                "act"   => "list",
            ),
            "custom" =>  array(
                "title"     => "自定义字段",
                "mod"       => "custom",
                "act"   => "list",
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
            "custom"     => "自定义字段",
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
                "act"   => "list",
            ),
            "mime" => array(
                "title"     => "附件类型",
                "mod"       => "mime",
                "act"   => "list",
            ),
            "thumb" => array(
                "title"     => "缩略图",
                "mod"       => "thumb",
                "act"   => "list",
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
                "act"   => "list",
            ),
            "form" => array(
                "title"     => "创建栏目",
                "mod"       => "cate",
                "act"   => "form",
            ),
        ),
        "allow" => array(
            "browse" => "浏览",
            "add"    => "创建",
            "edit"   => "编辑",
            "del"    => "删除",
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
                "act"   => "list",
            ),
            "form" => array(
                "title"     => "创建调用",
                "mod"       => "call",
                "act"   => "form",
            ),
        ),
        "allow" => array(
            "browse" => "浏览",
            "add"    => "创建",
            "edit"   => "编辑",
            "del"    => "删除",
        ),
    ),
    /*"user" => array(
        "main" => array(
            "title"  => "用户管理",
            "mod"    => "user",
        ),
        "sub" => array(
            "list" => array(
                "title"     => "所有用户",
                "mod"       => "user",
                "act"   => "list",
            ),
            "form" => array(
                "title"     => "创建用户",
                "mod"       => "user",
                "act"   => "form",
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
                "act"   => "list",
            ),
            "form" => array(
                "title"     => "创建管理员",
                "mod"       => "admin",
                "act"   => "form",
            ),
            "auth" => array(
                "title"     => "授权为管理员",
                "mod"       => "admin",
                "act"   => "auth",
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
                "act"   => "list",
            ),
            "form" => array(
                "title"     => "创建群组",
                "mod"       => "group",
                "act"   => "form",
            ),
        ),
        "allow" => array(
            "browse" => "浏览",
            "add"    => "创建",
            "edit"   => "编辑",
            "del"    => "删除",
        ),
    ),
    "link" => array(
        "main" => array(
            "title"  => "链接",
            "mod"    => "link",
            "icon"   => "link",
        ),
        "sub" => array(
            "list" => array(
                "title"     => "链接管理",
                "mod"       => "link",
                "act"   => "list",
            ),
        ),
        "allow" => array(
            "browse" => "浏览",
            "add"    => "创建",
            "edit"   => "编辑",
            "del"    => "删除",
        ),
    ),
);
