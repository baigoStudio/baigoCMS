<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

/*-------------------------通用-------------------------*/
return array(
  'Selector'                              => '选择器',
  'Common selector'                       => '常用选择器',
  'Name'                                  => '名称',
  'Note'                                  => '备注',
  'Charset'                               => '字符集',
  'Filter'                                => '过滤',
  'Example'                               => '示例',
  'Result'                                => '结果',
  'Common charset'                        => '常用字符集',
  'HTML Source code'                      => 'HTML 源代码',
  'Gathering HTML Source code'            => '采集 HTML 代码',
  'Text'                                  => '文本',
  'Gathering plain text'                  => '采集纯文本',
  'HTML Attributes'                       => 'HTML 属性',
  'Optional as follows'                   => '可选如下几类',
  'Unsigned'                              => '无符号',
  'With <code>-</code> symbol'            => '带减号 <code>-</code>',
  'Remove the tag and the tag content (this can be any jQuery selector, such as: <code>-p,-.title</code>)' => '移除该标签以及标签内容（此时可以为任意的 jQuery 选择器，如：<code>-p,-.title</code>）',
  'When the [Gathering attribute] is "html", it indicates the HTML tag to be filtered out. When the [Gathering attribute] value is "text", it indicates the HTML tag to be retained (this can be an HTML tag, such as: <code>div,strong</ Code>).' => '当 [采集属性] 为 "html" 时，表示要过滤掉的 HTML 标签。当 [采集属性] 为 "text" 时，表示要保留的 HTML 标签（此时可以为 HTML 标签，如：<code>div,strong</code>）',
  'Gathering HTML Attributes, such as: "src", "href", "name", "data-src" ...<br>Such as: &lt;a <code>href="http://www.domail.com"</code>&gt;Link&lt;/a&gt;, red part is attribute (name="value")' => '采集 HTML 属性（如 src、href、name、data-src 等）<br>如：&lt;a <code>href="http://www.domail.com"</code>&gt;链接&lt;/a&gt;，红色部分为属性（名称="值"）',
  'All elements' => '所有元素',
  'The element with id="lastname"' => 'id="lastname" 的元素',
  'All elements with class="intro"' => '所有 class="intro" 的元素',
  'All &lt;p&gt; elements' => '所有 &lt;p&gt; 元素',
  'All elements with class="intro" and class="demo"' => '所有 class="intro" 且 class="demo" 的元素',
  'All &lt;p&gt; elements that are descendants of a &lt;div&gt; element' => '所有 &lt;div&gt; 后代的任何 &lt;p&gt; 元素',
  'All &lt;p&gt; elements that are a direct child of a &lt;div&gt; element' => '所有 &lt;div&gt; 子元素的任何 &lt;p&gt; 元素',
  'The first &lt;p&gt; element' => '第一个 &lt;p&gt; 元素',
  'The last &lt;p&gt; element' => '最后一个 &lt;p&gt; 元素',
  'All even &lt;tr&gt; elements' => '所有偶数 &lt;tr&gt; 元素',
  'All odd &lt;tr&gt; elements' => '所有奇数 &lt;tr&gt; 元素',
  'The fourth element in a list (index starts at 0)' => '列表中的第四个元素（索引 从 0 开始）',
  'List elements with an index greater than 3' => '列出索引大于 3 的元素',
  'List elements with an index less than 3' => '列出索引小于 3 的元素',
  'All &lt;input&gt; elements that are not empty' => '所有不为空的 &lt;input&gt; 元素',
  'All header elements &lt;h1&gt;, &lt;h2&gt; ...' => '所有标题元素 &lt;h1&gt;, &lt;h2&gt; ……',
  'All animated elements' => '所有动画元素',
  'All elements which contains the text "Hello"' => '所有包含 "Hello" 字符串的元素',
  'All elements that are empty' => '所有无子节点（元素）的元素',
  'All hidden &lt;p&gt; elements' => '所有隐藏的 &lt;p&gt; 元素',
  'All visible tables' => '所有可见的表格',
  'All &lt;tg&gt;, &lt;td&gt; and class="intro" elements' => '所有 &lt;tg&gt;, &lt;td&gt; 和 class="intro" 元素',
  'All elements with a href attribute' => '所有带有 href 属性的元素',
  'All elements with a href attribute value equal to "default.htm"' => '所有 href 属性的值等于 "default.htm" 的元素',
  'All elements with a href attribute value not equal to "default.htm"' => '所有 href 属性的值不等于 "default.htm" 的元素',
  'All elements with a href attribute value ending with ".jpg"' => '所有 href 属性的值包含以 ".jpg" 结尾的元素',
  'All &lt;input&gt; elements' => '所有 &lt;input&gt; 元素',
  'All &lt;input&gt; elements with type="text"' => '所有 type="text" 的 &lt;input&gt; 元素',
  'All &lt;input&gt; elements with type="password"' => '所有 type="password" 的 &lt;input&gt; 元素',
  'All &lt;input&gt; elements with type="radio"' => '所有 type="radio" 的 &lt;input&gt; 元素',
  'All &lt;input&gt; elements with type="checkbox"' => '所有 type="checkbox" 的 &lt;input&gt; 元素',
  'All &lt;input&gt; elements with type="submit"' => '所有 type="submit" 的 &lt;input&gt; 元素',
  'All &lt;input&gt; elements with type="reset"' => '所有 type="reset" 的 &lt;input&gt; 元素',
  'All &lt;input&gt; elements with type="button"' => '所有 type="button" 的 &lt;input&gt; 元素',
  'All &lt;input&gt; elements with type="image"' => '所有 type="image" 的 &lt;input&gt; 元素',
  'All &lt;input&gt; elements with type="file"' => '所有 type="file" 的 &lt;input&gt; 元素',
  'All enabled &lt;input&gt; elements' => '所有激活的 &lt;input&gt; 元素',
  'All disabled &lt;input&gt; elements' => '所有禁用的 &lt;input&gt; 元素',
  'All selected &lt;option&gt; elements' => '所有被选取的 &lt;option&gt; 元素',
  'All checked &lt;input&gt; elements' => '所有被选中的 &lt;input&gt; 元素',
);
