<?php
return "<a name=\"list\"></a>
	<h3>栏目列表</h3>
	<p class=\"text-info\">接口说明</p>
	<p>用于显示栏目树形结构。</p>

	<p class=\"text-info\">URL</p>
	<p><span class=\"text-primary\">http://www.domain.com/bg_api/api.php?mod=cate</span></p>

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
						<th class=\"text-nowrap\">名称</th>
						<th class=\"text-nowrap\">类型</th>
						<th class=\"text-nowrap\">必须</th>
						<th>具体描述</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"text-nowrap\">act_get</td>
						<td class=\"text-nowrap\">string</td>
						<td class=\"text-nowrap\">true</td>
						<td>接口调用动作，值只能为 list。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">app_id</td>
						<td class=\"text-nowrap\">int</td>
						<td class=\"text-nowrap\">true</td>
						<td>应用的 APP ID，后台创建应用时生成的 ID。详情查看 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=app#show\">查看应用</a>。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">app_key</td>
						<td class=\"text-nowrap\">string</td>
						<td class=\"text-nowrap\">true</td>
						<td>应用的 APP KEY，后台创建应用时生成的 KEY。详情查看 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=app#show\">查看应用</a>。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">type</td>
						<td class=\"text-nowrap\">string</td>
						<td class=\"text-nowrap\">false</td>
						<td>栏目类型，可选 normal、single、link</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">parent_id</td>
						<td class=\"text-nowrap\">int</td>
						<td class=\"text-nowrap\">false</td>
						<td>所隶属栏目 ID</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<p>返回多维数组，详情请查看 <a href=\"#result\">栏目显示返回结果</a>。</p>

	<hr>

	<a name=\"get\"></a>
	<h3>栏目显示</h3>
	<p class=\"text-info\">接口说明</p>
	<p>用于显示单个栏目详细信息。</p>

	<p class=\"text-info\">URL</p>
	<p><span class=\"text-primary\">http://www.domain.com/bg_api/api.php?mod=cate</span></p>

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
						<th class=\"text-nowrap\">名称</th>
						<th class=\"text-nowrap\">类型</th>
						<th class=\"text-nowrap\">必须</th>
						<th>具体描述</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"text-nowrap\">act_get</td>
						<td class=\"text-nowrap\">string</td>
						<td class=\"text-nowrap\">true</td>
						<td>接口调用动作，值只能为 get。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">app_id</td>
						<td class=\"text-nowrap\">int</td>
						<td class=\"text-nowrap\">true</td>
						<td>应用的 APP ID，后台创建应用时生成的 ID。详情查看 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=app#show\">查看应用</a>。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">app_key</td>
						<td class=\"text-nowrap\">string</td>
						<td class=\"text-nowrap\">true</td>
						<td>应用的 APP KEY，后台创建应用时生成的 KEY。详情查看 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=app#show\">查看应用</a>。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">cate_id</td>
						<td class=\"text-nowrap\">int</td>
						<td class=\"text-nowrap\">true</td>
						<td>栏目 ID</td>
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
						<th class=\"text-nowrap\">名称</th>
						<th class=\"text-nowrap\">类型</th>
						<th class=\"text-nowrap\">说明</th>
						<th>备注</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"text-nowrap\">cate_id</td>
						<td class=\"text-nowrap\">int</td>
						<td class=\"text-nowrap\">栏目 ID</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">cate_name</td>
						<td class=\"text-nowrap\">string</td>
						<td class=\"text-nowrap\">栏目名称</td>
						<td>栏目的名称。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">cate_alias</td>
						<td class=\"text-nowrap\">string</td>
						<td class=\"text-nowrap\">别名</td>
						<td>栏目的英文别名。此项一般用户 URL，当 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=opt#visit\">访问方式</a> 设置为伪静态或纯静态，别名会显示在浏览的地址栏，如：http://www.domain.com/cate/<mark>service</mark>/3/，高亮部分既为别名</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">cate_type</td>
						<td class=\"text-nowrap\">string</td>
						<td class=\"text-nowrap\">栏目类型</td>
						<td>normal 为普通、single 为单页、link 为链接。单页是指该栏目没有下属的文章，只显示栏目的具体内容，适合联系方式、单位介绍等，链接是指该栏目直接跳转到指定的地址。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">cate_content</td>
						<td class=\"text-nowrap\">text</td>
						<td class=\"text-nowrap\">栏目介绍</td>
						<td>栏目的具体介绍。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">cate_link</td>
						<td class=\"text-nowrap\">string</td>
						<td class=\"text-nowrap\">跳转至</td>
						<td>该栏目跳转至相应的地址，不会显示栏目介绍。<mark>当栏目类型为链接时，此项有效</mark>。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">cate_parent_id</td>
						<td class=\"text-nowrap\">int</td>
						<td class=\"text-nowrap\">隶属栏目 ID</td>
						<td>栏目所属的上一级栏目，0 为“一级栏目”，无隶属关系。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">cate_trees</td>
						<td class=\"text-nowrap\">array</td>
						<td class=\"text-nowrap\">当前栏目的树形结构</td>
						<td>多维数组，按顺序列出当前栏目隶属的树形结构。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">cate_status</td>
						<td class=\"text-nowrap\">string</td>
						<td class=\"text-nowrap\">栏目状态</td>
						<td>show 为显示，hide 为隐藏。</td>
					</tr>
					<tr>
						<td class=\"text-nowrap\">alert</td>
						<td class=\"text-nowrap\">string</td>
						<td class=\"text-nowrap\">返回代码</td>
						<td>显示当前栏目的状态，详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=alert\" target=\"_blank\">返回代码</a>。</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<p>&nbsp;</p>

	<h4>返回结果示例</h4>
	<p>
<pre><code class=\"language-javascript\">{
    &quot;cate_id&quot;: &quot;2&quot;, //ID
    &quot;cate_name&quot;: &quot;技术支持&quot;, //名称
    &quot;cate_alias&quot;: &quot;support&quot;, //别名
    &quot;cate_parent_id&quot;: &quot;0 &quot;, //隶属于栏目
    &quot;cate_type&quot;: &quot;normal &quot;, //类型
    &quot;cate_tplDo&quot;: &quot;default&quot;, //栏目
    &quot;cate_content&quot;: &quot;&quot;, //内容
    &quot;urlRow&quot;: {
        &quot;cate_url&quot;: &quot;/cms/cate/support/id-2/&quot;, //URL
        &quot;page_attach&quot;: &quot;page-&quot; //分页附加
    },
    &quot;cate_trees&quot;: { //当前栏目的树形结构
        [
            &quot;0&quot;: {
                &quot;cate_id&quot;: &quot;2&quot;,
                &quot;cate_name&quot;: &quot;技术支持&quot;,
                &quot;cate_alias&quot;: &quot;support&quot;,
                &quot;cate_domain&quot;: &quot;&quot;,
                &quot;urlRow&quot;: {
                    &quot;cate_url&quot;: &quot;/cms/cate/support/id-2/&quot;,
                    &quot;page_attach&quot;: &quot;page-&quot;
                }
            }
        ]
    },
    &quot;alert&quot;: &quot;y110102&quot; //返回代码
}</code></pre>
	</p>";