<?php
return "<a name=\"tree\"></a>
	<h3>栏目树</h3>
	<p>
		在任何模板内，均可以用遍历 <code>{\$tplData.cateRows}</code> 的方式来显示网站所有栏目的树形结构，详细字段请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=cate#cateRow\">栏目</a>。
	</p>
	<hr>

	<a name=\"call\"></a>
	<h3>调用</h3>
	<p>
		在任何模板内，均可以用函数 <code>{call_display call_id=调用 ID}</code> 的方式来显示调用，执行此函数后，模板会生成一个 <code>{\$callRows}</code> 数组，可以通过遍历 <code>{\$callRows.调用 ID}</code> 的方式来显示调用结果，<code>{\$callRows}</code> 数组会根据不同的调用类型有所不同，详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=article#articleRow\">文章</a>、<a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=cate#cateRow\">栏目</a>、<a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=tag#tagRow\">TAG</a>、<a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=spec#specRow\">专题</a> 等有关信息。关于调用以及调用 ID 请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=call\">调用管理</a>。
	</p>
	<hr>

	<a name=\"callAttach\"></a>
	<h3>调用附件</h3>
	<p>
		在任何模板内，均可以用函数 <code>{call_attach attach_id=附件 ID}</code> 的方式来显示调用，执行此函数后，模板会生成一个 <code>{\$attachRows}</code> 数组，可以通过遍历 <code>{\$attachRows.附件 ID}</code> 的方式来显示调用结果，详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=attach\">附件 / 缩略图</a>。
	</p>
	<hr>

	<a name=\"callCate\"></a>
	<h3>调用栏目</h3>
	<p>
		在任何模板内，均可以用函数 <code>{call_cate cate_id=栏目 ID}</code> 的方式来显示调用，执行此函数后，模板会生成一个 <code>{\$cateRows}</code> 数组，可以通过遍历 <code>{\$cateRows.栏目 ID}</code> 的方式来显示调用结果，详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=cate\">栏目</a>。
	</p>
	<hr>

	<a name=\"include\"></a>
	<h3>包含</h3>
	<p>
		在任何模板内，均可以用 <code>{include \"包含模板路径\"}</code> 的方式来包含并执行文件，您可以在模板目录下，建立一个文件夹，如 <mark>inc</mark>，用来统一存放被包含的模板，如：<code>{include \"inc/head.tpl\"}</code>，关于包含，请查看 Smarty 官方网站 <a href=\"http://www.smarty.net\" target=\"_blank\">http://www.smarty.net</a></a>。
	</p>
	<hr>

	<a name=\"ubb\"></a>
	<h3>部分 UBB 代码支持</h3>
	<p>
		在任何模板内，均可以用 Smarty 修饰符 <code>{\$string|ubb}</code> 的方式来实现部分 UBB 代码，被支持的 UBB 代码请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=common#ubb\">管理后台</a>。
	</p>
	<hr>

	<a name=\"const\"></a>
	<h3>常量</h3>
	<p>
		在任何模板内，均可以用 <code>{\$smarty.const.常量名}</code> 的方式来调用系统内置常量，如果您想得到所有的常量名，请查看 <mark>./bg_config</mark> 目录下的文件。
	</p>
	<div class=\"panel panel-default\">
		<div class=\"panel-heading\">常用常量</div>
		<div class=\"table-responsive\">
			<table class=\"table\">
				<thead>
					<tr>
						<th class=\"nowrap\">常量名</th>
						<th>说明</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"nowrap\">BG_URL_ROOT</td>
						<td>网站根目录</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_URL_HELP</td>
						<td>帮助信息路径</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_URL_ARTICLE</td>
						<td>文章路径</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_URL_ATTACH</td>
						<td>附件路径</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_URL_SSO</td>
						<td>baigo SSO 路径</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_URL_PUB</td>
						<td>前台路径</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_URL_ADMIN</td>
						<td>管理后台路径</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_URL_INSTALL</td>
						<td>安装程序路径</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_URL_STATIC</td>
						<td>静态文件路径</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_URL_STATIC_ADMIN</td>
						<td>管理后台所用的静态文件路径</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_URL_STATIC_INSTALL</td>
						<td>安装程序所用的静态文件路径</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_URL_STATIC_PUB</td>
						<td>前台所用的静态文件路径</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_URL_IMAGE</td>
						<td>通用图片存放路径</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_URL_JS</td>
						<td>JavaScript 文件路径</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_SITE_NAME</td>
						<td>网站名称</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_SITE_DOMAIN</td>
						<td>网站域名</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_SITE_URL</td>
						<td>网站首页 URL</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_SITE_PERPAGE</td>
						<td>每页显示数</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_SITE_TIMEZONE</td>
						<td>所处时区</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_SITE_DATE</td>
						<td>日期格式</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_SITE_DATESHORT</td>
						<td>短日期格式</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_SITE_TIME</td>
						<td>时间格式</td>
					</tr>
					<tr>
						<td class=\"nowrap\">BG_SITE_TIMESHORT</td>
						<td>短时间格式</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<hr>

	<a name=\"lang\"></a>
	<h3>语言资源</h3>
	<p>
		在任何模板内，均可以用 <code>{\$数组名.键名}</code> 的方式来调用系统内置语言资源，如果您想得到所有的语言资源的键名，可以使用 <code>{\$数组名|@debug_print_var}</code> 或者 <code>{\$数组名|@print_r}</code> 来显示数组结构。
	</p>
	<div class=\"panel panel-default\">
		<div class=\"panel-heading\">常用语言资源</div>
		<div class=\"table-responsive\">
			<table class=\"table\">
				<thead>
					<tr>
						<th class=\"nowrap\">数组名</th>
						<th>说明</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"nowrap\">lang</td>
						<td>通用信息，包含系统中常用的语言内容。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">alert</td>
						<td>提示信息</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<hr>

	<a name=\"custom\"></a>
	<h3>自定义字段</h3>
	<p>
		在任何模板内，均可以用遍历 <code>{\$tplData.customRows}</code> 的方式来显示所有有效自定义字段的列表。
	</p>
	<div class=\"panel panel-default\">
		<div class=\"panel-heading\">常用语言资源</div>
		<div class=\"table-responsive\">
			<table class=\"table\">
				<thead>
					<tr>
						<th class=\"nowrap\">键名</th>
						<th class=\"nowrap\">类型</th>
						<th>说明</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"nowrap\">custom_id</td>
						<td class=\"nowrap\">int</td>
						<td>自定义字段 ID</td>
					</tr>
					<tr>
						<td class=\"nowrap\">custom_name</td>
						<td class=\"nowrap\">string</td>
						<td>自定义字段名称</td>
					</tr>
					<tr>
						<td class=\"nowrap\">custom_childs</td>
						<td class=\"nowrap\">array</td>
						<td>子字段数组</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>";