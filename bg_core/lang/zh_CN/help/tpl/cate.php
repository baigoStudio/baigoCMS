<?php
return "<h3>栏目显示</h3>
	<p>文件名：<span class=\"text-primary\">cate_show.tpl</span>、<span class=\"text-primary\">cate_single.tpl</span></p>
	<p>
		用于显示所有隶属于此栏目的文章，以及栏目介绍等信息。
	</p>
	<p>
		<span class=\"text-primary\">cate_single.tpl</span> 为单页栏目，单页是指该栏目没有下属的文章，只显示栏目的具体内容，适合联系方式、单位介绍等，此模板与 栏目设置 有关，只有当栏目设置为单页时，系统才会调用此模板。
	</p>

	<div class=\"panel panel-default\">
		<div class=\"table-responsive\">
			<table class=\"table\">
				<thead>
					<tr>
						<th class=\"nowrap\">键名</th>
						<th class=\"nowrap\">类型</th>
						<th class=\"nowrap\">说明</th>
						<th>备注</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"nowrap\">tplData.cateRow</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">当前栏目详细信息</td>
						<td>查看 <a href=\"#cateRow\">tplData.cateRow</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">tplData.articleRows</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">文章列表</td>
						<td>隶属于当前栏目的所有文章。详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=article#articleRow\" target=\"_blank\">文章</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">tplData.search</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">搜索参数</td>
						<td>显示文章列表所需要的搜索参数，查看 <a href=\"#search\">tplData.search</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">tplData.query</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">搜索参数序列化字符串</td>
						<td>搜索参数序列化为字符串以后的结果。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">tplData.pageRow</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">分页参数</td>
						<td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=page\" target=\"_blank\">分页参数</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">tplData.customs</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">自定义字段搜索数组</td>
						<td>多维数组，格式为 <code>\"custom_自定义字段 ID\" => \"关键词\"</code>，多个自定义字段时的例子：<code>array(\"custom_2\" => \"关键词\", \"custom_5\" => \"关键词\")</code></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<p>&nbsp;</p>

	<a name=\"cateRow\"></a>
	<h4><code>{\$tplData.cateRow}</code> 数组</h4>

	<p>当前栏目详细信息</p>

	<div class=\"panel panel-default\">
		<div class=\"table-responsive\">
			<table class=\"table\">
				<thead>
					<tr>
						<th class=\"nowrap\">键名</th>
						<th class=\"nowrap\">类型</th>
						<th class=\"nowrap\">说明</th>
						<th>备注</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"nowrap\">cate_id</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">栏目 ID</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">cate_name</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">栏目名称</td>
						<td>栏目的名称。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">cate_alias</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">别名</td>
						<td>栏目的英文别名。此项一般用户 URL，当 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=opt#visit\">访问方式</a> 设置为伪静态或纯静态，别名会显示在浏览的地址栏，如：http://www.domain.com/cate/<mark>service</mark>/3/，高亮部分既为别名</td>
					</tr>
					<tr>
						<td class=\"nowrap\">cate_type</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">栏目类型</td>
						<td>normal 为普通、single 为单页、link 为链接。单页是指该栏目没有下属的文章，只显示栏目的具体内容，适合联系方式、单位介绍等，链接是指该栏目直接跳转到指定的地址。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">cate_tpl</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">模板名</td>
						<td>栏目所使用的模板，inherit 为“继承上一级”。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">cate_content</td>
						<td class=\"nowrap\">text</td>
						<td class=\"nowrap\">栏目介绍</td>
						<td>栏目的具体介绍。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">cate_link</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">跳转至</td>
						<td>该栏目跳转至相应的地址，不会显示栏目介绍。<mark>当栏目类型为链接时，此项有效</mark>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">cate_parent_id</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">隶属栏目 ID</td>
						<td>栏目所属的上一级栏目，0 为“一级栏目”，无隶属关系。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">cate_trees</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">当前栏目的树形结构</td>
						<td>多维数组，按顺序列出当前栏目隶属的树形结构。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">cate_status</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">栏目状态</td>
						<td>show 为显示，hide 为隐藏。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">urlRow</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">当前栏目 URL 数组</td>
						<td>cate_url 为当前栏目 URL 地址，page_attach 为分页附加参数，主要用于分页。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">alert</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">返回代码</td>
						<td>显示当前栏目的状态，详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=alert\" target=\"_blank\">返回代码</a>。</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<p>&nbsp;</p>

	<a name=\"search\"></a>
	<h4><code>{\$tplData.search}</code> 数组</h4>

	<p>显示文章列表所需要的搜索参数。</p>

	<div class=\"panel panel-default\">
		<div class=\"table-responsive\">
			<table class=\"table\">
				<thead>
					<tr>
						<th class=\"nowrap\">键名</th>
						<th class=\"nowrap\">类型</th>
						<th class=\"nowrap\">说明</th>
						<th>备注</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"nowrap\">cate_id</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">栏目 ID</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">key</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">关键词</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">customs</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">搜索字符串</td>
						<td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=search#customs\" target=\"_blank\">搜索</a></td>
					</tr>
					<tr>
						<td class=\"nowrap\">page_ext</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">扩展名</td>
						<td>仅用于纯静态模式。</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>";