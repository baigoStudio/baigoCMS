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
	"int"     => array(
		"note" => "int 整数",
		"opt"  => "11",
	),
	"decimal" => array(
		"note" => "decimal 数字（含小数）",
		"opt"  => "10,2",
	),
	"varchar" => array(
		"note" => "varchar 字符",
		"opt"  => "90",
	),
	"text"    => array(
		"note" => "text 文本",
		"opt"  => "",
	),
	"enum"    => array(
		"note" => "enum 单项选择",
		"opt"  => "option-1,option-2",
	),
);
