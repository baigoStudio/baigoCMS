<?php
return "<h3>图片、附件</h3>
	<p>
		在发布文章时，插入到文章的第一张图片或附件会被系统记录，在需要时，可以调用相关信息，图片、附件信息一般命名为 <code>{\$tplData.articleRow.attachRow}</code>，在文章列表等处，也可能是多维数组的某一个键，如 <code>{\$tplData.articleRows[0].attachRow}</code>，详细结构如下。
	</p>

	<p>&nbsp;</p>

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
						<td class=\"nowrap\">attach_id</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">附件 ID</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">attach_name</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">原始文件名</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">attach_time</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">上传时间戳</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">attach_ext</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">扩展名</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">attach_size</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">附件大小</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">attach_url</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">附件 URL 地址</td>
						<td> </td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<hr>

	<a name=\"thumb\"></a>
	<h3>缩略图</h3>
	<p>
		在上传图片时，系统会根据缩略图的设置自动生成缩略图，系统生成缩略图以后，需要在适当的地方给予显示，如：文章列表等处，一般缩略图信息包含在 <code>attachRow</code> 数组中。
	</p>
	<p>
		以栏目主页的文章列表数组为例，缩略图位于 <code>{\$tplData.articleRows[0].attachRow}</code>，此数组包含了第一篇文章的所有图片信息，包括原始图片、多个缩略图等，如果我们要显示某一个尺寸的缩略图，我们需要得到调用键名，调用键名位于 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=attach#thumb\">附件管理</a> 中的缩略图部分，如果我们要显示系统默认的 100x100 的缩略图，代码为 <code>{\$tplData.articleRows[0].attachRow.thumb_100_100_cut}</code>。
	</p>";