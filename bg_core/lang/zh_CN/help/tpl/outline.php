<?php
return "<h3>模板概述</h3>
	<p>
		baigo CMS 采用 Smarty 作为模板引擎，关于模板的详情请查看 Smarty 官方网站 <a href=\"http://www.smarty.net\" target=\"_blank\">http://www.smarty.net</a>。前台模板位于 <mark>./bg_tpl/pub</mark> 目录下，一套模板单独一个目录，如默认模板 <mark>./bg_tpl/pub/default</mark>，以下教程全部以此为基础。注：模板目录必须使用 <mark>英文</mark> 与 <mark>数字</mark>，不能使用中文、符号等。
	</p>

	<div class=\"panel panel-default\">
		<div class=\"panel-heading\">模板目录结构说明</div>
		<div class=\"table-responsive\">
			<table class=\"table\">
				<thead>
					<tr>
						<th class=\"text-nowrap\">文件名</th>
						<th class=\"text-nowrap\">说明</th>
						<th>备注</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"text-nowrap\">index.tpl</td>
						<td class=\"text-nowrap\">网站主页</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">alert.tpl</td>
						<td class=\"text-nowrap\">提示信息</td>
						<td>一般用于出错信息的显示。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">cate_show.tpl</td>
						<td class=\"text-nowrap\">栏目主页</td>
						<td>用于显示所有隶属于此栏目的文章，以及栏目介绍等信息。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">cate_single.tpl</td>
						<td class=\"text-nowrap\">单页栏目</td>
						<td>单页是指该栏目没有下属的文章，只显示栏目的具体内容，适合联系方式、单位介绍等，此模板与 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=cate\">栏目设置</a> 有关，只有当栏目设置为单页时，系统才会调用此模板。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">article_show.tpl</td>
						<td class=\"text-nowrap\">文章显示</td>
						<td> </td>
					</tr>
					<!--<tr>
						<td class=\"text-nowrap\">tag_list.tpl</td>
						<td class=\"text-nowrap\">TAG 列表</td>
						<td>显示网站内所有的 TAG。</td>
					</tr>-->
					<tr>
						<td class=\"text-nowrap\">tag_show.tpl</td>
						<td class=\"text-nowrap\">TAG 显示</td>
						<td>用于显示所有与此 TAG 关联的文章。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">spec_list.tpl</td>
						<td class=\"text-nowrap\">专题列表</td>
						<td>显示网站内所有的专题。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">spec_show.tpl</td>
						<td class=\"text-nowrap\">专题显示</td>
						<td>用于显示所有隶属于此专题的文章，以及专题介绍等信息。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">search_key.tpl</td>
						<td class=\"text-nowrap\">搜索显示</td>
						<td>用于显示搜索结果。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">include</td>
						<td class=\"text-nowrap\">包含文件目录</td>
						<td>此目录用来存放被包含的文件，可自定义名称，也可删除此目录，与具体的模板写法有关，关于包含，请查看 Smarty 官方网站 <a href=\"http://www.smarty.net\" target=\"_blank\">http://www.smarty.net</a>。</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>";
