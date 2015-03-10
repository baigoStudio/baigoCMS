<?php
return "<a name=\"list\"></a>
	<h3>文章列表</h3>
	<p class=\"text-info\">接口说明</p>
	<p>用于显示文章列表。</p>

	<p class=\"text-info\">URL</p>
	<p><span class=\"text-primary\">http://www.domain.com/bg_api/api.php?mod=article</span></p>

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
						<td class=\"nowrap\">key</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">false</td>
						<td>搜索关键词</td>
					</tr>
					<tr>
						<td class=\"nowrap\">year</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">false</td>
						<td>年份</td>
					</tr>
					<tr>
						<td class=\"nowrap\">month</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">false</td>
						<td>月份</td>
					</tr>
					<tr>
						<td class=\"nowrap\">cate_id</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">false</td>
						<td>栏目 ID</td>
					</tr>
					<tr>
						<td class=\"nowrap\">mark_ids</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">false</td>
						<td>标记 ID，多个 ID 请使用 | 分隔。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">spec_id</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">false</td>
						<td>专题 ID。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">tag_ids</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">false</td>
						<td>TAG ID，多个 ID 请使用 | 分隔。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">per_page</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">false</td>
						<td>每页显示文章数</td>
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
						<th class=\"nowrap\">键名</th>
						<th class=\"nowrap\">类型</th>
						<th class=\"nowrap\">说明</th>
						<th>备注</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"nowrap\">articleRows</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">文章列表</td>
						<td>符合搜索条件的所有文章。详情请查看 <a href=\"#result\">文章显示返回结果</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">pageRow</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">分页参数</td>
						<td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=page\" target=\"_blank\">分页参数</a>。</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<hr>

	<a name=\"get\"></a>
	<h3>文章显示</h3>
	<p class=\"text-info\">接口说明</p>
	<p>用于显示当前文章的详细信息。</p>

	<p class=\"text-info\">URL</p>
	<p><span class=\"text-primary\">http://www.domain.com/bg_api/api.php?mod=article</span></p>

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
						<td class=\"nowrap\">article_id</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">true</td>
						<td>文章 ID</td>
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
						<td class=\"nowrap\">tagRows</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">当前文章关联的 TAG</td>
						<td>所有与此文章关联的 TAG。详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=tag#tagRow\" target=\"_blank\">TAG</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">cateRow</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">当前文章所属栏目的详细信息</td>
						<td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=cate#cateRow\" target=\"_blank\">栏目</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">attachRow</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">当前文章附件的详细信息</td>
						<td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=attach\" target=\"_blank\">附件</a>。</td>
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
				</tbody>
			</table>
		</div>
	</div>";