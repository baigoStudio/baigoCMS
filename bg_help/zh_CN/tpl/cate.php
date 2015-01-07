	<h3>栏目显示</h3>
	<p>文件名：<span class="text-primary">cate_show.tpl</span>、<span class="text-primary">cate_single.tpl</span></p>
	<p>
		用于显示所有隶属于此栏目的文章，以及栏目介绍等信息。
	</p>
	<p>
		<span class="text-primary">cate_single.tpl</span> 为单页栏目，单页是指该栏目没有下属的文章，只显示栏目的具体内容，适合联系方式、单位介绍等，此模板与 栏目设置 有关，只有当栏目设置为单页时，系统才会调用此模板。
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
						<td>cateRow</td>
						<td>当前栏目详细信息</td>
						<td> </td>
					</tr>
					<tr>
						<td>articleRows</td>
						<td>文章列表</td>
						<td>隶属于当前栏目的所有文章。</td>
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
