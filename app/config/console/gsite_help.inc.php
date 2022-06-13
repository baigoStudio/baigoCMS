<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿编辑
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
  return 'Access denied';
}

return array(
  'attr_qlist' => array(
    'html'  => array(
      'title' => 'HTML Source code',
      'note'  => 'Gathering HTML Source code',
    ),
    'text'  => array(
      'title' => 'Text',
      'note'  => 'Gathering plain text',
    ),
    'attr'  => array(
      'title' => 'HTML Attributes',
      'note'  => 'Gathering HTML Attributes, such as: "src", "href", "name", "data-src" ...<br>Such as: &lt;a <code>href="http://www.domail.com"</code>&gt;Link&lt;/a&gt;, red part is attribute (name="value")',
    ),
  ),
  'filter' => array(
    'minus'  => array(
      'title' => 'With <code>-</code> symbol',
      'note'  => 'Remove the tag and the tag content (this can be any jQuery selector, such as: <code>-p,-.title</code>)',
    ),
    'none'  => array(
      'title' => 'Unsigned',
      'note'  => 'When the [Gathering attribute] is "html", it indicates the HTML tag to be filtered out. When the [Gathering attribute] value is "text", it indicates the HTML tag to be retained (this can be an HTML tag, such as: <code>div,strong</ Code>).',
    ),
  ),
  'selector' => array(
    array(
      'selector' => '*',
      'example'  => '*',
      'result'   => 'All elements',
    ),
    array(
      'selector' => '#id',
      'example'  => '#lastname',
      'result'   => 'The element with id="lastname"',
    ),
    array(
      'selector' => '.class',
      'example'  => '.intro',
      'result'   => 'All elements with class="intro"',
    ),
    array(
      'selector' => 'element',
      'example'  => 'p',
      'result'   => 'All &lt;p&gt; elements',
    ),
    array(
      'selector' => '.class.class',
      'example'  => '.intro.demo',
      'result'   => 'All elements with class="intro" and class="demo"',
    ),
    array(
      'selector' => 'element element',
      'example'  => 'div p',
      'result'   => 'All &lt;p&gt; elements that are descendants of a &lt;div&gt; element',
    ),
    array(
      'selector' => 'element &gt; element',
      'example'  => 'div &gt; p',
      'result'   => 'All &lt;p&gt; elements that are a direct child of a &lt;div&gt; element',
    ),
    array( ),
    array(
      'selector' => ':first',
      'example'  => 'p:first',
      'result'   => 'The first &lt;p&gt; element',
    ),
    array(
      'selector' => ':last',
      'example'  => 'p:last',
      'result'   => 'The last &lt;p&gt; element',
    ),
    array(
      'selector' => ':even',
      'example'  => 'tr:even',
      'result'   => 'All even &lt;tr&gt; elements',
    ),
    array(
      'selector' => ':odd',
      'example'  => 'tr:odd',
      'result'   => 'All odd &lt;tr&gt; elements',
    ),
    array( ),
    array(
      'selector' => ':eq(index)',
      'example'  => 'ul li:eq(3)',
      'result'   => 'The fourth element in a list (index starts at 0)',
    ),
    array(
      'selector' => ':gt(no)',
      'example'  => 'ul li:gt(3)',
      'result'   => 'List elements with an index greater than 3',
    ),
    array(
      'selector' => ':lt(no)',
      'example'  => 'ul li:lt(3)',
      'result'   => 'List elements with an index less than 3',
    ),
    array(
      'selector' => ':not(selector)',
      'example'  => 'input:not(:empty)',
      'result'   => 'All &lt;input&gt; elements that are not empty',
    ),
    array( ),
    array(
      'selector' => ':header',
      'example'  => ':header',
      'result'   => 'All header elements &lt;h1&gt;, &lt;h2&gt; ...',
    ),
    array(
      'selector' => ':animated',
      'example'  => '&nbsp;',
      'result'   => 'All animated elements',
    ),
    array( ),
    array(
      'selector' => ':contains(text)',
      'example'  => ':contains("Hello")',
      'result'   => 'All elements which contains the text "Hello"',
    ),
    array(
      'selector' => ':empty',
      'example'  => ':empty',
      'result'   => 'All elements that are empty',
    ),
    array(
      'selector' => ':hidden',
      'example'  => 'p:hidden',
      'result'   => 'All hidden &lt;p&gt; elements',
    ),
    array(
      'selector' => ':visible',
      'example'  => 'table:visible',
      'result'   => 'All visible tables',
    ),
    array( ),
    array(
      'selector' => 's1,s2,s3',
      'example'  => 'th,td,.intro',
      'result'   => 'All &lt;tg&gt;, &lt;td&gt; and class="intro" elements',
    ),
    array( ),
    array(
      'selector' => '[attribute]',
      'example'  => '[href]',
      'result'   => 'All elements with a href attribute',
    ),
    array(
      'selector' => '[attribute=value]',
      'example'  => '[href="default.htm"]',
      'result'   => 'All elements with a href attribute value equal to "default.htm"',
    ),
    array(
      'selector' => '[attribute!=value]',
      'example'  => '[href!="default.htm"]',
      'result'   => 'All elements with a href attribute value not equal to "default.htm"',
    ),
    array(
      'selector' => '[attribute$=value]',
      'example'  => '[href$=".jpg"]',
      'result'   => 'All elements with a href attribute value ending with ".jpg"',
    ),
    array( ),
    array(
      'selector' => ':input',
      'example'  => ':input',
      'result'   => 'All &lt;input&gt; elements',
    ),
    array(
      'selector' => ':text',
      'example'  => ':text',
      'result'   => 'All &lt;input&gt; elements with type="text"',
    ),
    array(
      'selector' => ':password',
      'example'  => ':password',
      'result'   => 'All &lt;input&gt; elements with type="password"',
    ),
    array(
      'selector' => ':radio',
      'example'  => ':radio',
      'result'   => 'All &lt;input&gt; elements with type="radio"',
    ),
    array(
      'selector' => ':checkbox',
      'example'  => ':checkbox',
      'result'   => 'All &lt;input&gt; elements with type="checkbox"',
    ),
    array(
      'selector' => ':submit',
      'example'  => ':submit',
      'result'   => 'All &lt;input&gt; elements with type="submit"',
    ),
    array(
      'selector' => ':reset',
      'example'  => ':reset',
      'result'   => 'All &lt;input&gt; elements with type="reset"',
    ),
    array(
      'selector' => ':button',
      'example'  => ':button',
      'result'   => 'All &lt;input&gt; elements with type="button"',
    ),
    array(
      'selector' => ':image',
      'example'  => ':image',
      'result'   => 'All &lt;input&gt; elements with type="image"',
    ),
    array(
      'selector' => ':file',
      'example'  => ':file',
      'result'   => 'All &lt;input&gt; elements with type="file"',
    ),
    array( ),
    array(
      'selector' => ':enabled',
      'example'  => ':enabled',
      'result'   => 'All enabled &lt;input&gt; elements',
    ),
    array(
      'selector' => ':disabled',
      'example'  => ':disabled',
      'result'   => 'All disabled &lt;input&gt; elements',
    ),
    array(
      'selector' => ':selected',
      'example'  => ':selected',
      'result'   => 'All selected &lt;option&gt; elements',
    ),
    array(
      'selector' => ':checked',
      'example'  => ':checked',
      'result'   => 'All checked &lt;input&gt; elements',
    ),
  ),
);
