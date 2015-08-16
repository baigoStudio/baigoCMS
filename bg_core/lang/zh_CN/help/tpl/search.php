<?php
return "<h3>搜索</h3>

	<p>文件名：<span class=\"text-primary\">search_show.tpl</span></p>
	<p>
		用于显示搜索结果。
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
						<td class=\"nowrap\">tplData.articleRows</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">文章列表</td>
						<td>搜索结果。详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl&act_get=article#articleRow\" target=\"_blank\">文章</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">tplData.search</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">搜索参数</td>
						<td>显示文章列表所需要的搜索参数，查看 <a href=\"#search\">tplData.search</a>。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">tplData.customs</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">自定义字段搜索数组</td>
						<td>多维数组，格式为 <code>\"custom_自定义字段 ID\" => \"关键词\"</code>，多个自定义字段时的例子：<code>array(\"custom_2\" => \"关键词\", \"custom_5\" => \"关键词\")</code></td>
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
						<td>详情请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=page\">分页参数</a></td>
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
						<td class=\"nowrap\">key</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">搜索关键词</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">customs</td>
						<td class=\"nowrap\">string</td>
						<td class=\"nowrap\">搜索字符串</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">cate_id</td>
						<td class=\"nowrap\">int</td>
						<td class=\"nowrap\">栏目 ID</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">urlRow</td>
						<td class=\"nowrap\">array</td>
						<td class=\"nowrap\">搜索 URL 数组</td>
						<td>search_url 为搜索 URL 地址，page_attach 为分页附加参数，主要用于分页。</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<p>&nbsp;</p>

	<a name=\"request\"></a>
	<h4>搜索请求</h4>

	<p>以 GET 形式发起搜索请求，搜索 URL 根据 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=opt#visit\">访问方式</a> 的设置不同而不同。</p>

	<div class=\"panel panel-default\">
		<div class=\"table-responsive\">
			<table class=\"table\">
				<thead>
					<tr>
						<th class=\"nowrap\">访问方式</th>
						<th>URL</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"nowrap\">默认</td>
						<td>./index.php?mod=search&act_get=show&key=关键词&customs=搜索字符串&cate_id=栏目 ID</td>
					</tr>

					<tr>
						<td class=\"nowrap\">伪静态</td>
						<td>./search/key-关键词/customs-搜索字符串/cate-栏目 ID</td>
					</tr>

					<tr>
						<td class=\"nowrap\">纯静态</td>
						<td>./search/key-关键词/customs-搜索字符串/cate-栏目 ID</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<p>&nbsp;</p>

	<a name=\"customs\"></a>
	<h4>搜索字符串</h4>

	<p>关于上述表格中的 <mark>搜索字符串</mark>，是指 baigo CMS 特有的用于自定义字段的字符串，其格式为 GET 查询串，例如 <code>2=关键词&5=关键词</code>，然后将查询串用 <mark>Base64</mark> 进行编码，最后将生成的字符串进行 URL 编码。</p>

	<p>在 HTML 页面中，建议使用 JavaScript 或 VBScript 以及 jQuery 等脚本将搜索内容序列化。</p>

	<p>关于 <mark>Base64</mark> 的编码方法，本系统内置一个 Base64 编码的 JavaScript 的插件，位于 ./bg_static/js/base64.js，只需在适当的地方载入该脚本，然后在需要进行 Base64 编码的地方使用函数 <code>Base64.encode(‘字符串’)</code> 即可，您还可在需要的时候，使用 <code>Base64.decode(‘Base64 字符串’)</code> 函数进行解码。</p>

	<p>&nbsp;</p>

	<h4>示例代码</h4>

	<p>HTML 表单</p>
	<p>
<pre><code class=\"language-markup\">&lt;form name=&quot;search&quot; id=&quot;search&quot;&gt;
  &lt;div class=&quot;form-group&quot;&gt;
    &lt;label class=&quot;control-label&quot;&gt;&#20851;&#38190;&#35789;&lt;/label&gt;
    &lt;input type=&quot;text&quot; name=&quot;key&quot; id=&quot;key&quot; value=&quot;&quot; class=&quot;form-control&quot; placeholder=&quot;&#20851;&#38190;&#35789;&quot;&gt;
  &lt;/div&gt;
  &lt;div class=&quot;form-group&quot;&gt;
    &lt;label class=&quot;control-label&quot;&gt;&#30005;&#21387;&lt;/label&gt;
    &lt;input type=&quot;text&quot; name=&quot;2&quot; value=&quot;&quot; class=&quot;customs form-control&quot; placeholder=&quot;&#30005;&#21387;&quot;&gt;
  &lt;/div&gt;
  &lt;div class=&quot;form-group&quot;&gt;
    &lt;label class=&quot;control-label&quot;&gt;&#24207;&#21015;&#21495;&lt;/label&gt;
    &lt;input type=&quot;text&quot; name=&quot;1&quot; value=&quot;&quot; class=&quot;customs form-control&quot; placeholder=&quot;&#24207;&#21015;&#21495;&quot;&gt;
  &lt;/div&gt;
  &lt;button type=&quot;button&quot; id=&quot;search_go&quot; class=&quot;btn btn-primary&quot;&gt;&#25628;&#32034;&lt;/button&gt;
&lt;/form&gt;</code></pre>
	</p>

	<p>jQuery</p>
	<p>
<pre><code class=\"language-javascript\">$(document).ready(function(){
  $(&quot;#search_go&quot;).click(function(){
    var _key = $(&quot;#key&quot;).val();
    var _customs = $(&quot;.customs&quot;).serialize();
    window.location.href = &quot;./search/key-&quot; + _key + &quot;-customs-&quot; + encodeURIComponent(Base64.encode(customs)) + &quot;/&quot;;
  });
})</code></pre>
	</p>";