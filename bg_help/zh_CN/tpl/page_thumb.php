	<a name="page"></a>
	<h3>分页参数</h3>
	<p>
		在所有需要用到分页的地方，都有该参数，如：栏目、TAG、专题、搜索等。参数的数组名一般为 <code>{$tplData.pageRow}</code>。在模板中需要根据参数来进行分页，详情请参照系统默认模板 <mark>./bg_tpl/pub/default/include/page.tpl</mark>。
	</p>
	<div class="panel panel-default">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th class="nowrap">键名</th>
						<th>说明</th>
						<th>备注</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>page</td>
						<td>当前页码</td>
						<td> </td>
					</tr>
					<tr>
						<td>p</td>
						<td>分组数</td>
						<td>页数过多时，需要将分页按钮分成若干组，系统默认是 10 页一组。</td>
					</tr>
					<tr>
						<td>begin</td>
						<td>分组起始页码</td>
						<td>每一个分组的开始页码。</td>
					</tr>
					<tr>
						<td>end</td>
						<td>分组结束页码</td>
						<td>每一个分组的结束页码。</td>
					</tr>
					<tr>
						<td>total</td>
						<td>总页数</td>
						<td> </td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<hr>

	<a name="thumb"></a>
	<h3>缩略图</h3>
	<p>
		在上传图片时，系统会根据缩略图的设置自动生成缩略图，系统生成缩略图以后，需要在适当的地方给予显示，如：文章列表等处，一般缩略图信息包含在 attachRow 数组中。
	</p>
	<p>
		以栏目主页的文章列表数组为例，缩略图位于 <code>{$tplData.articleRows[0].attachRow}</code>，此数组包含了第一篇文章的所有图片信息，包括原始图片、多个缩略图等，如果我们要显示某一个尺寸的缩略图，我们需要得到调用名，调用名位于 <a href="?lang=zh_CN&mod=help&act=attach#thumb">附件管理</a> 中的缩略图部分，如果我们要显示系统默认的 100x100 的缩略图，代码为 <code>{$tplData.articleRows[0].attachRow.thumb_100_100_cut}</code>。
	</p>
	<p>
		关于缩略图请参照 <a href="?lang=zh_CN&mod=help&act=attach#thumb">附件管理</a> 中的缩略图部分。
	</p>
