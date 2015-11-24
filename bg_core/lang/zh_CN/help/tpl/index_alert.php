<?php
return "<a name=\"index\"></a>
	<h3>主页</h3>
	<p>文件名：<span class=\"text-primary\">index.tpl</span></p>
	<p>
		主页是一个网站的起点。是用户打开浏览器时默认打开的一个网页。它主要起着引导用户浏览所需资源的作用。
	</p>
	<hr>

	<a name=\"alert\"></a>
	<h3>提示信息</h3>
	<p>文件名：<span class=\"text-primary\">alert.tpl</span></p>
	<p>
		提示信息用来显示用户操作以后成功与否的信息，主要用来显示出错信息。
	</p>
	<div class=\"panel panel-default\">
		<div class=\"table-responsive\">
			<table class=\"table\">
				<thead>
					<tr>
						<th class=\"text-nowrap\">键名</th>
						<th>说明</th>
						<th>备注</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"text-nowrap\">alert</td>
						<td>返回代码</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">status</td>
						<td>状态</td>
						<td>x 为出错信息，y 为成功信息。</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<hr>";
