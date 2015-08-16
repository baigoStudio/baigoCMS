<?php
return "<a name=\"list\"></a>
	<h3>专题列表</h3>
	<p class=\"text-info\">接口说明</p>
	<p>用于显示网站内所有的专题。</p>

	<p class=\"text-info\">URL</p>
	<p><span class=\"text-primary\">http://www.domain.com/bg_api/api.php?mod=spec</span></p>

	<p class=\"text-info\">HTTP 请求方式</p>
	<p>GET</p>

	<p class=\"text-info\">返回格式</p>
	<p>JSON</p>

	<div class=\"panel panel-default\">
		<div class=\"panel-heading\">接口参数</div>
		<div class=\"table-responsive\">
			<table class=\"table\">
				<thead>
					<tr>
						<th class=\"nowrap\">名称</th>
						<th class=\"nowrap\">类型</th>
						<th class=\"nowrap\">必须</th>
						<th>具体描述</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"nowrap\">act_get</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">true</td>
						<td>接口调用动作，值只能为 get。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">app_id</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">true</td>
						<td>应用的 APP ID，后台创建应用时生成的 ID。详情查看 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=app#show\">查看应用</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">app_key</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">true</td>
						<td>应用的 APP KEY，后台创建应用时生成的 KEY。详情查看 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=app#show\">查看应用</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">key</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">false</td>
						<td>搜索关键词</td>
					</tr>
					<tr>
						<td class=\"nowrap\">per_page</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">false</td>
						<td>每页显示专题数</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<p>&nbsp;</p>

	<h4>返回结果</h4>
	<div class=\"panel panel-default\">
		<div class=\"table-responsive\">
			<table class=\"table\">
				<thead>
					<tr>
						<th class=\"nowrap\">名称</th>
						<th class=\"nowrap\">类型</th>
						<th class=\"nowrap\">说明</th>
						<th>备注</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"nowrap\">specRows</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">专题列表</td>
						<td>详情请查看 <a href=\"#result\">专题显示返回结果</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">pageRow</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">分页参数</td>
						<td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=page\">分页参数</a></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<hr>

	<a name=\"show\"></a>
	<h3>专题显示</h3>
	<p class=\"text-info\">接口说明</p>
	<p>用于显示当前专题的详细信息。</p>

	<p class=\"text-info\">URL</p>
	<p><span class=\"text-primary\">http://www.domain.com/bg_api/api.php?mod=spec</span></p>

	<p class=\"text-info\">HTTP 请求方式</p>
	<p>GET</p>

	<p class=\"text-info\">返回格式</p>
	<p>JSON</p>
	<div class=\"panel panel-default\">
		<div class=\"panel-heading\">接口参数</div>
		<div class=\"table-responsive\">
			<table class=\"table\">
				<thead>
					<tr>
						<th class=\"nowrap\">名称</th>
						<th class=\"nowrap\">类型</th>
						<th class=\"nowrap\">必须</th>
						<th>具体描述</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"nowrap\">act_get</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">true</td>
						<td>接口调用动作，值只能为 list。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">app_id</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">true</td>
						<td>应用的 APP ID，后台创建应用时生成的 ID。详情查看 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=app#show\">查看应用</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">app_key</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">true</td>
						<td>应用的 APP KEY，后台创建应用时生成的 KEY。详情查看 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=app#show\">查看应用</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">spec_id</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">true</td>
						<td>专题 ID</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<p>&nbsp;</p>

	<a name=\"result\"></a>
	<h4>返回结果</h4>
	<div class=\"panel panel-default\">
		<div class=\"table-responsive\">
			<table class=\"table\">
				<thead>
					<tr>
						<th class=\"nowrap\">名称</th>
						<th class=\"nowrap\">类型</th>
						<th class=\"nowrap\">说明</th>
						<th>备注</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"nowrap\">spec_id</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">专题 ID</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">spec_name</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">专题名称</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">spec_content</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">专题内容</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">spec_status</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">专题状态</td>
						<td>pub 为发布，hide 为隐藏。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">alert</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">返回代码</td>
						<td>显示当前专题的状态，详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=alert\" target=\"_blank\">返回代码</a>。</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>";
