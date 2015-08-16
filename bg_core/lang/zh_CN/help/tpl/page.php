<?php
return "<a name=\"page\"></a>
	<h3>分页参数</h3>
	<p>
		在所有需要用到分页的地方，都有该参数，如：栏目、TAG、专题、搜索等。参数的数组名一般为 <code>{\$tplData.pageRow}</code>。在模板中需要根据参数来进行分页，详情请查看系统默认模板 <mark>./bg_tpl/pub/default/include/page.tpl</mark>。
	</p>
	<div class=\"panel panel-default\">
		<div class=\"table-responsive\">
			<table class=\"table\">
				<thead>
					<tr>
						<th class=\"nowrap\">键名</th>
						<th>说明</th>
						<th>备注</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"nowrap\">page</td>
						<td>当前页码</td>
						<td> </td>
					</tr>
					<tr>
						<td class=\"nowrap\">p</td>
						<td>分组数</td>
						<td>页数过多时，需要将分页按钮分成若干组，系统默认是 10 页一组。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">begin</td>
						<td>分组起始页码</td>
						<td>每一个分组的开始页码。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">end</td>
						<td>分组结束页码</td>
						<td>每一个分组的结束页码。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">total</td>
						<td>总页数</td>
						<td> </td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<p>&nbsp;</p>

	<h4>Smarty 示例代码</h4>
	<p>
<pre><code class=\"language-smarty\">&lt;ul&gt;
  {if \$tplData.pageRow.page &gt; 1}
    &lt;li&gt;
      &lt;a href=&quot;page-1&quot;&gt;&#39318;&#39029;&lt;/a&gt;
    &lt;/li&gt;
  {/if}

  {if \$tplData.pageRow.p * 10 &gt; 0}
    &lt;li&gt;
      &lt;a href=&quot;page-{\$tplData.pageRow.p * 10}&quot;&gt;&#19978;&#21313;&#39029;&lt;/a&gt;
    &lt;/li&gt;
  {/if}

  &lt;li&gt;
    {if \$tplData.pageRow.page &lt;= 1}
      &lt;span&gt;&amp;laquo;&lt;/span&gt;
    {else}
      &lt;a href=&quot;page-{\$tplData.pageRow.page - 1}&quot;&gt;&amp;laquo;&lt;/a&gt;
    {/if}
  &lt;/li&gt;

  {for \$_iii = \$tplData.pageRow.begin to \$tplData.pageRow.end}
    &lt;li&gt;
      {if \$_iii == \$tplData.pageRow.page}
        &lt;span&gt;{\$_iii}&lt;/span&gt;
      {else}
        &lt;a href=&quot;page-{\$_iii}&quot;&gt;{\$_iii}&lt;/a&gt;
      {/if}
    &lt;/li&gt;
  {/for}

  &lt;li&gt;
    {if \$tplData.pageRow.page &gt;= \$tplData.pageRow.total}
      &lt;span&gt;&amp;raquo;&lt;/span&gt;
    {else}
      &lt;a href=&quot;page-{\$tplData.pageRow.page + 1}&quot;&gt;&amp;raquo;&lt;/a&gt;
    {/if}
  &lt;/li&gt;

  {if \$_iii &lt; \$tplData.pageRow.total}
    &lt;li&gt;
      &lt;a href=&quot;page-{\$_iii}&quot;&gt;&#19979;&#21313;&#39029;&lt;/a&gt;
    &lt;/li&gt;
  {/if}

  {if \$tplData.pageRow.page &lt; \$tplData.pageRow.total}
    &lt;li&gt;
      &lt;a href=&quot;page-{\$tplData.pageRow.total}&quot;&gt;&#26411;&#39029;&lt;/a&gt;
    &lt;/li&gt;
  {/if}
&lt;/ul&gt;</code></pre>
	<p>";
