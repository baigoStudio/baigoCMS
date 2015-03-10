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
	"image/jpg" => array(
		"ext"     => "jpg",
		"note"    => "JPG 图片",
	),
	"image/jpeg" => array(
		"ext"     => "jpg",
		"note"    => "JPG 图片",
	),
	"image/pjpeg" => array(
		"ext"     => "jpg",
		"note"    => "JPG 图片",
	),
	"image/gif" => array(
		"ext"     => "gif",
		"note"    => "GIF 图片",
	),
	"image/png" => array(
		"ext"     => "png",
		"note"    => "PNG 图片",
	),
	"image/x-png" => array(
		"ext"     => "png",
		"note"    => "PNG 图片",
	),
	"image/bmp" => array(
		"ext"     => "bmp",
		"note"    => "BMP 图片",
	),
	"image/x-ms-bmp" => array(
		"ext"     => "bmp",
		"note"    => "BMP 图片",
	),
	"image/x-windows-bmp" => array(
		"ext"     => "bmp",
		"note"    => "BMP 图片",
	),
    "image/tiff" => array(
		"ext"     => "tif",
		"note"    => "TIF 图片",
	),
    "image/vnd.wap.wbmp" => array(
		"ext"     => "wbmp",
		"note"    => "BMP 图片",
	),
    "image/x-icon" => array(
		"ext"     => "ico",
		"note"    => "ICO 图标",
	),
    "image/x-jng" => array(
		"ext"     => "jng",
		"note"    => "JNG 图片",
	),
    "image/svg+xml" => array(
		"ext"     => "svg",
		"note"    => "SVG 图片",
	),
    "image/webp" => array(
		"ext" => "webp",
		"note"    => "WebP 图片",
	),

	"application/msword" => array(
		"ext"     => "doc",
		"note"    => "Word 文档",
	),
	"application/vnd.ms-word" => array(
		"ext"     => "doc",
		"note"    => "Word 文档",
	),
	"application/excel" => array(
		"ext"     => "xls",
		"note"    => "Excel 表格",
	),
	"application/x-excel" => array(
		"ext"     => "xls",
		"note"    => "Excel 表格",
	),
	"application/vnd.ms-excel" => array(
		"ext"     => "xls",
		"note"    => "Excel 表格",
	),
	"application/rtf" => array(
		"ext"     => "rtf",
		"note"    => "RTF 文档",
	),
	"application/x-rtf" => array(
		"ext"     => "rtf",
		"note"    => "RTF 文档",
	),
	"application/pdf" => array(
		"ext"     => "pdf",
		"note"    => "PDF 文档",
	),
	"application/zip" => array(
		"ext"     => "zip",
		"note"    => "ZIP 压缩包",
	),
	"application/x-gzip" => array(
		"ext"     => "gz",
		"note"    => "GZ 压缩包",
	),
);
