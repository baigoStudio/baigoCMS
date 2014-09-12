<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

for ($_i = 14; $_i >= -12; $_i--) {
	if ($_i >= 0) {
		$_i_key   = "Etc/GMT+" . $_i;
		$_i_value = "Etc/GMT+" . $_i;
	} else {
		$_i_key   = $_i;
		$_i_value = "Etc/GMT" . $_i;
	}
	$_timezone[$_i_key] = $_i_value;
}

return array(
	"base" => array(
		"BG_SITE_NAME" => array(
			"label"      => "网站名称",
			"type"       => "str",
			"format"     => "text",
			"min"        => 1,
			"default"    => PRD_CMS_NAME,
		),
		"BG_SITE_DOMAIN" => array(
			"label"      => "网站域名",
			"type"       => "str",
			"format"     => "text",
			"min"        => 1,
			"default"    => $_SERVER["SERVER_NAME"],
		),
		"BG_SITE_URL" => array(
			"label"      => "网站 URL",
			"type"       => "str",
			"format"     => "url",
			"min"        => 1,
			"default"    => "http://" . $_SERVER["SERVER_NAME"],
			"note"       => "末尾请勿加 /",
		),
		"BG_SITE_PERPAGE" => array(
			"label"      => "每页显示数",
			"type"       => "str",
			"format"     => "int",
			"min"        => 1,
			"default"    => 30,
		),
		"BG_SITE_TIMEZONE" => array(
			"label"      => "时区",
			"type"       => "select",
			"min"        => 1,
			"option"     => $_timezone,
			"default"    => "Etc/GMT+8",
		),
		"BG_SITE_DATE" => array(
			"label"      => "日期格式",
			"type"       => "select",
			"min"        => 1,
			"default"    => "Y-m-d",
			"option" => array(
				"Y-m-d"         => date("Y-m-d"),
				"Y年m月d日"      => date("Y年m月d日"),
				"y-m-d"         => date("y-m-d"),
				"y年m月d日"      => date("y年m月d日"),
				"M. d, Y"       => date("M. d, Y"),
			),
		),
		"BG_SITE_DATESHORT" => array(
			"label"      => "短日期格式",
			"type"       => "select",
			"min"        => 1,
			"default"    => "m-d",
			"option" => array(
				"m-d"       => date("m-d"),
				"m月d日"     => date("m月d日"),
				"M. d"      => date("M. d"),
			),
		),
		"BG_SITE_TIME" => array(
			"label"      => "时间格式",
			"type"       => "select",
			"min"        => 1,
			"default"    => "H:i:s",
			"option" => array(
				"H:i:s"     => date("H:i:s"),
				"h:i:s A"   => date("h:i:s A"),
			),
		),
		"BG_SITE_TIMESHORT" => array(
			"label"      => "短时间格式",
			"type"       => "select",
			"min"        => 1,
			"default"    => "H:i",
			"option" => array(
				"H:i"   => date("H:i"),
				"h:i A" => date("h:i A"),
			),
		),
	),
	"upload" => array(
		"BG_UPLOAD_SIZE" => array(
			"label"      => "允许上传大小",
			"type"       => "str",
			"format"     => "int",
			"min"        => 1,
			"default"    => 200,
			"note"       => "单位请参考下一项",
		),
		"BG_UPLOAD_UNIT" => array(
			"label"      => "允许上传单位",
			"type"       => "select",
			"format"     => "txt",
			"min"        => 1,
			"default"    => "KB",
			"option" => array(
				"KB"    => "KB",
				"MB"    => "MB",
			),
		),
		"BG_UPLOAD_COUNT" => array(
			"label"      => "允许同时上传数",
			"type"       => "str",
			"format"     => "int",
			"min"        => 1,
			"default"    => 10,
		),
		"BG_UPLOAD_URL" => array(
			"label"      => "绑定 URL ",
			"type"       => "str",
			"format"     => "url",
			"min"        => 0,
			"default"    => "http://" . $_SERVER["SERVER_NAME"],
			"note"       => "末尾请勿加 /",
		),
		"BG_UPLOAD_FTPHOST" => array(
			"label"      => "分发 FTP 地址",
			"type"       => "str",
			"format"     => "text",
			"min"        => 0,
			"default"    => "",
			"note"       => "如上传至本服务器，可为空"
		),
		"BG_UPLOAD_FTPPORT" => array(
			"label"      => "FTP 端口",
			"type"       => "str",
			"format"     => "text",
			"min"        => 0,
			"default"    => "21",
		),
		"BG_UPLOAD_FTPUSER" => array(
			"label"      => "FTP 用户名",
			"type"       => "str",
			"format"     => "text",
			"min"        => 0,
			"default"    => "",
		),
		"BG_UPLOAD_FTPPASS" => array(
			"label"      => "FTP 密码",
			"type"       => "str",
			"format"     => "text",
			"min"        => 0,
			"default"    => "",
		),
		"BG_UPLOAD_FTPPATH" => array(
			"label"      => "FTP 远程路径",
			"type"       => "str",
			"format"     => "text",
			"min"        => 0,
			"default"    => "",
			"note"        => "末尾请勿加 /",
		),
	),
	"sso" => array(
		"BG_SSO_URL" => array(
			"label"      => "API 接口 URL",
			"type"       => "str",
			"format"     => "url",
			"min"        => 1,
			"default"    => "",
			"note"       => "必须以 http:// 开始", //跳转至
		),
		"BG_SSO_APPID" => array(
			"label"      => "APP ID",
			"type"       => "str",
			"format"     => "int",
			"min"        => 1,
			"default"    => "",
		),
		"BG_SSO_APPKEY" => array(
			"label"      => "APP KEY",
			"type"       => "str",
			"format"     => "text",
			"min"        => 1,
			"default"    => "",
		),
		"BG_SSO_SYNLOGON" => array(
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
	"visit" => array(
		"BG_VISIT_TYPE" => array(
			"label"      => "访问方式",
			"type"       => "radio",
			"min"        => 1,
			"default"    => "default",
			"option" => array(
				"default"   => array(
					"value"    => "默认",
					"note"     => "例：" . BG_SITE_URL . "/index.php?mod=article&act_get=show&article_id=123",
				),
				"pstatic"   => array(
					"value"    => "伪静态",
					"note"     => "例：" . BG_SITE_URL . "/article/123 (需服务器支持)",
				),
				"static"    => array(
					"value"    => "纯静态",
					"note"     => "例：" . BG_SITE_URL . "/article/" . date("Y") . "/" . date("m") . "/123." . BG_VISIT_FILE . " (需安装静态页面模块)",
				),
			),
		),
		"BG_VISIT_FILE" => array(
			"label"      => "生成静态文件",
			"type"       => "select",
			"min"        => 1,
			"default"    => "html",
			"option" => array(
				"html"  => "HTML",
				"shtml" => "SHTML",
			),
		),
	),
);
?>
