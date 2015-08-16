<?php
return "<a name=\"page\"></a>
	<h3>分页参数</h3>
	<p>
		在所有需要用到分页的地方，都有该参数，如：栏目、文章、专题等，对象名一般为 <code>pageRow</code>。
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

	<h4>PHP 示例代码</h4>
	<p>如使用 PHP 来处理分页参数，可以使用 PHP 的 <code>json_decode()</code> 函数将分页参数转换为数组，关于此函数，详情请查看 <a href=\"http://www.php.net/manual/zh/function.json-decode.php\">PHP 文档</a>。</p>
	<p>
<pre><code class=\"language-php\">echo(&quot;&lt;ul&gt;&quot;);
  if (\$pageRow[&quot;page&quot;] &gt; 1) {
    echo(&quot;&lt;li&gt;&quot;);
      echo(&quot;&lt;a href='page=1'&gt;&#39318;&#39029;&lt;/a&gt;&quot;);
    echo(&quot;&lt;/li&gt;&quot;);
  }

  if (\$pageRow[&quot;p&quot;] * 10 &gt; 0) {
    echo(&quot;&lt;li&gt;&quot;);
      echo(&quot;&lt;a href='page=&quot; . \$pageRow[&quot;p&quot;] * 10 . &quot;'&gt;&#19978;&#21313;&#39029;&lt;/a&gt;&quot;);
    echo(&quot;&lt;/li&gt;&quot;);
  }

  echo(&quot;&lt;li&gt;&quot;);
    if (\$pageRow[&quot;page&quot;] &lt;= 1) {
      echo(&quot;&lt;span&gt;&amp;laquo;&lt;/span&gt;&quot;);
    } else {
      echo(&quot;&lt;a href='page=&quot; . \$pageRow[&quot;page&quot;] - 1 . &quot;'&gt;&amp;laquo;&lt;/a&gt;&quot;);
    }
  echo(&quot;&lt;/li&gt;&quot;);

  for (\$_iii = \$pageRow[&quot;begin&quot;]; \$_iii &lt;= \$pageRow[&quot;end&quot;]; \$_iii++) {
   echo(&quot; &lt;li&gt;&quot;);
      if (\$_iii == \$pageRow[&quot;page&quot;]) {
        echo(&quot;&lt;span&gt;&quot; . \$_iii . &quot;&lt;/span&gt;&quot;);
      } else {
        echo(&quot;&lt;a href='page=&quot; . \$_iii . &quot;'&gt;&quot; . \$_iii . &quot;&lt;/a&gt;&quot;);
      }
    echo(&quot;&lt;/li&gt;&quot;);
  }

  echo(&quot;&lt;li&gt;&quot;);
    if (\$pageRow[&quot;page&quot;] &gt;= \$pageRow[&quot;total&quot;]) {
      echo(&quot;&lt;span&gt;&amp;raquo;&lt;/span&gt;&quot;);
    } else {
      echo(&quot;&lt;a href='page=&quot; . \$pageRow[&quot;page&quot;] + 1 . &quot;'&gt;&amp;raquo;&lt;/a&gt;&quot;);
    }
  echo(&quot;&lt;/li&gt;&quot;);

  if (\$_iii &lt; \$pageRow[&quot;total&quot;]) {
    echo(&quot;&lt;li&gt;&quot;);
      echo(&quot;&lt;a href='page=&quot; . \$_iii . &quot;'&gt;&#19979;&#21313;&#39029;&lt;/a&gt;&quot;);
    echo(&quot;&lt;/li&gt;&quot;);
  }

  if (\$pageRow[&quot;page&quot;] &lt; \$pageRow[&quot;total&quot;]) {
    echo(&quot;&lt;li&gt;&quot;);
      echo(&quot;&lt;a href='page=&quot; . \$pageRow[&quot;total&quot;] . &quot;'&gt;&#26411;&#39029;&lt;/a&gt;&quot;);
    echo(&quot;&lt;/li&gt;&quot;);
  }
echo(&quot;&lt;/ul&gt;&quot;);</code></pre>
	</p>";
