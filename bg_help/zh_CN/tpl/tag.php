	<a name="list"></a>
	<h3>TAG 列表</h3>
	<p>文件名：<span class="text-primary">tag_list.tpl</span></p>
	<p>
		显示网站内所有的 TAG。
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
						<td>tagRows</td>
						<td>TAG 列表</td>
						<td> </td>
					</tr>
					<tr>
						<td>search</td>
						<td>搜索数组</td>
						<td>显示栏目所需要的搜索参数。</td>
					</tr>
					<tr>
						<td>query</td>
						<td>查询串</td>
						<td>此数组将上一项的数组序列化为查询串。</td>
					</tr>
					<tr>
						<td>pageRow</td>
						<td>分页参数</td>
						<td>详情请参照 <a href="??lang=zh_CN&mod=help&act=page">分页参数</a></td>
					</tr>
					<tr>
						<td>cateRows</td>
						<td>栏目列表</td>
						<td>多维数组，网站所有栏目的结构信息。</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<hr>

	<a name="show"></a>
	<h3>TAG 显示</h3>
	<p>文件名：<span class="text-primary">tag_show.tpl</span></p>
	<p>
		用于显示所有与此 TAG 关联的文章。
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
						<td>tagRow</td>
						<td>当前 TAG 详细信息</td>
						<td> </td>
					</tr>
					<tr>
						<td>articleRows</td>
						<td>文章列表</td>
						<td>所有与此 TAG 关联的文章。</td>
					</tr>
					<tr>
						<td>search</td>
						<td>搜索数组</td>
						<td>显示栏目所需要的搜索参数。</td>
					</tr>
					<tr>
						<td>query</td>
						<td>查询串</td>
						<td>此数组将上一项的数组序列化为查询串。</td>
					</tr>
					<tr>
						<td>pageRow</td>
						<td>分页参数</td>
						<td>详情请参照 <a href="??lang=zh_CN&mod=help&act=page">分页参数</a></td>
					</tr>
					<tr>
						<td>cateRows</td>
						<td>栏目列表</td>
						<td>多维数组，网站所有栏目的结构信息。</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
