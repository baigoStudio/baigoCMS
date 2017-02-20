<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

return array(
    "editor" => array(
        "title" => "可视化编辑器",
        "list"  => array(
            "resize" => array(
                "label"      => "调整尺寸",
                "type"       => "radio",
                "min"        => 1,
                "default"    => "on",
                "option" => array(
                    "on"    => array(
                        "value"    => "允许"
                    ),
                    "off"   => array(
                        "value"    => "禁止"
                    ),
                ),
            ),
            "autosize" => array(
                "label"      => "自动调整",
                "type"       => "radio",
                "min"        => 1,
                "default"    => "on",
                "option" => array(
                    "on"    => array(
                        "value"    => "开启"
                    ),
                    "off"   => array(
                        "value"    => "关闭"
                    ),
                ),
            ),
        ),
    ),
    "excerpt" => array(
        "title" => "文章摘要",
        "list"  => array(
            "type" => array(
                "label"      => "默认截取方式",
                "type"       => "select",
                "min"        => 1,
                "default"    => 100,
                "option" => array(),
            ),
            "count" => array(
                "label"      => "截取字数",
                "type"       => "str",
                "format"     => "int",
                "min"        => 1,
                "default"    => 100,
            ),
        ),
    ),
    "sync" => array(
        "title" => "同步登录",
        "list"  => array(
            "sync" => array(
                "label"      => "同步登录",
                "type"       => "radio",
                "min"        => 1,
                "default"    => "off",
                "option" => array(
                    "on"    => array(
                        "value"    => "开启"
                    ),
                    "off"   => array(
                        "value"    => "关闭"
                    ),
                ),
            ),
        ),
    ),
);

