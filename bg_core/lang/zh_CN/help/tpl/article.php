<?php
return "<h3>文章显示</h3>
	<p>文件名：<span class=\"text-primary\">article_show.tpl</span></p>
	<p>
		用于显示当前文章的详细信息。
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
						<td class=\"nowrap\"><a href=\"#articleRow\">articleRow</a></td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">当前文章的详细信息</td>
						<td> </td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<p>&nbsp;</p>

	<a name=\"articleRow\"></a>
	<h4><code>{\$tplData.articleRow}</code> 数组</h4>

	<p>当前文章的详细信息</p>

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
						<td class=\"nowrap\">article_id</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">文章 ID</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">article_title</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">文章标题</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">article_content</td>
						<td class=\"nowrap\">text</td>
						<td class=\"nowrap\">文章内容</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">article_cate_id</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">隶属栏目 ID</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">article_mark_id</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">隶属标记 ID</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">article_spec_id</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">文章隶属专题 ID</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">article_excerpt</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">文章摘要</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">article_link</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">跳转至</td>
						<td>如填写了跳转地址，该文章将直接跳转至相应的地址，不会显示文章内容。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">article_hits_day</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">一天点击数</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">article_hits_week</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">一周点击数</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">article_hits_month</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">一月点击数</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">article_hits_year</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">一年点击数</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">article_hits_all</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">总点击数</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">article_time</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">文章添加时间</td>
						<td>指文章添加到数据库的时间。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">article_time_pub</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">文章发布时间</td>
						<td>指文章发布时间。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">article_url</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">当前文章 URL</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">tagRows</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">当前文章关联的 TAG</td>
						<td>所有与此文章关联的 TAG。详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=tag#tagRow\" target=\"_blank\">TAG</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">cateRow</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">当前文章所属栏目的详细信息</td>
						<td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=cate#cateRow\" target=\"_blank\">栏目</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">attachRow</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">当前文章附件的详细信息</td>
						<td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=attach\" target=\"_blank\">图片 / 缩略图</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">article_status</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">文章状态</td>
						<td>pub 为发布，wait 为待审，hide 为隐藏。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">str_alert</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">返回代码</td>
						<td>显示当前文章的状态，详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=alert\" target=\"_blank\">返回代码</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">article_custom</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">自定义表单</td>
						<td>自定义表单的内容。用 <code>{\$tplData.articleRow.article_custom.自定义表单 ID}</code> 的方法便可显示自定义表单的内容。详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=custom\" target=\"_blank\">自定义表单</a>。</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>";