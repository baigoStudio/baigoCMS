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
	"text" => array(
		"label"   => "文本输入",
	),
	"textarea" => array(
		"label"   => "多行文本",
	),
	"radio" => array(
		"label"   => "单选框",
		"option"  => array("选项一", "选项二", "选项三"),
	),
	"select" => array(
		"label"   => "下拉菜单",
		"option"  => array("选项一", "选项二", "选项三"),
	),
	"date" => array(
		"label"   => "日期",
	),
	"datetime" => array(
		"label"   => "日期时间",
	),
	"digit" => array(
		"label"   => "数字",
	),
);
