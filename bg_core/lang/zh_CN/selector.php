<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

return array(
    array(
        array(
            '*',
            '*',
            '所有元素',
        ),
        array(
            '#<i>id</i>',
            '#lastname',
            'id=&quot;lastname&quot; 的元素',
        ),
        array(
            '.<i>class</i>',
            '.intro',
            '所有 class=&quot;intro&quot; 的元素',
        ),
        array(
            '<i>element</i>',
            'p',
            '所有 &lt;p&gt; 元素',
        ),
        array(
            '.<i>class</i>.<i>class</i>',
            '.intro.demo',
            '所有 class=&quot;intro&quot; 且 class=&quot;demo&quot; 的元素',
        ),
        array(
            '<i>element</i> <i>element</i>',
            'h1 em',
            '所有 h1 后代的任何 em 元素',
        ),
        array(
            '<i>element</i> &gt; <i>element</i>',
            'h1 &gt; em',
            '所有 h1 子元素的任何 em 元素',
        ),
    ),
    array(
        array(
            ':first',
            'p:first',
            '第一个 &lt;p&gt; 元素',
        ),
        array(
            ':last',
            'p:last',
            '最后一个 &lt;p&gt; 元素',
        ),
        array(
            ':even',
            'tr:even',
            '所有偶数 &lt;tr&gt; 元素',
        ),
        array(
            ':odd',
            'tr:odd',
            '所有奇数 &lt;tr&gt; 元素',
        ),
    ),
    array(
        array(
            ':eq(<i>index</i>)',
            'ul li:eq(3)',
            '列表中的第四个元素（index 从 0 开始）',
        ),
        array(
            ':gt(<i>no</i>)',
            'ul li:gt(3)',
            '列出 index 大于 3 的元素',
        ),
        array(
            ':lt(<i>no</i>)',
            'ul li:lt(3)',
            '列出 index 小于 3 的元素',
        ),
        array(
            ':not(<i>selector</i>)',
            'input:not(:empty)',
            '所有不为空的 input 元素',
        ),
    ),
    array(
        array(
            ':header',
            ':header',
            '所有标题元素 &lt;h1&gt; - &lt;h6&gt;',
        ),
        array(
            ':animated',
            '&nbsp;',
            '所有动画元素',
        ),
    ),
    array(
        array(
            ':contains(<i>text</i>)',
            ':contains(\'W3School\')',
            '包含指定字符串的所有元素',
        ),
        array(
            ':empty',
            ':empty',
            '无子（元素）节点的所有元素',
        ),
        array(
            ':hidden',
            'p:hidden',
            '所有隐藏的 &lt;p&gt; 元素',
        ),
        array(
            ':visible',
            'table:visible',
            '所有可见的表格',
        ),
    ),
    array(
        array(
            's1,s2,s3',
            'th,td,.intro',
            '所有带有匹配选择的元素',
        ),
    ),
    array(
        array(
            '[<i>attribute</i>]',
            '[href]',
            '所有带有 href 属性的元素',
        ),
        array(
            '[<i>attribute</i>=<i>value</i>]',
            '[href=\'#\']',
            '所有 href 属性的值等于 '#' 的元素',
        ),
        array(
            '[<i>attribute</i>!=<i>value</i>]',
            '[href!=\'#\']',
            '所有 href 属性的值不等于 '#' 的元素',
        ),
        array(
            '[<i>attribute</i>$=<i>value</i>]',
            '[href$=\'.jpg\']',
            '所有 href 属性的值包含以 &quot;.jpg&quot; 结尾的元素',
        ),
    ),
    array(
        array(
            ':input',
            ':input',
            '所有 &lt;input&gt; 元素',
        ),
        array(
            ':text',
            ':text',
            '所有 type=&quot;text&quot; 的 &lt;input&gt; 元素',
        ),
        array(
            ':password',
            ':password',
            '所有 type=&quot;password&quot; 的 &lt;input&gt; 元素',
        ),
        array(
            ':radio',
            ':radio',
            '所有 type=&quot;radio&quot; 的 &lt;input&gt; 元素',
        ),
        array(
            ':checkbox',
            ':checkbox',
            '所有 type=&quot;checkbox&quot; 的 &lt;input&gt; 元素',
        ),
        array(
            ':submit',
            ':submit',
            '所有 type=&quot;submit&quot; 的 &lt;input&gt; 元素',
        ),
        array(
            ':reset',
            ':reset',
            '所有 type=&quot;reset&quot; 的 &lt;input&gt; 元素',
        ),
        array(
            ':button',
            ':button',
            '所有 type=&quot;button&quot; 的 &lt;input&gt; 元素',
        ),
        array(
            ':image',
            ':image',
            '所有 type=&quot;image&quot; 的 &lt;input&gt; 元素',
        ),
        array(
            ':file',
            ':file',
            '所有 type=&quot;file&quot; 的 &lt;input&gt; 元素',
        ),
    ),
    array(
        array(
            ':enabled',
            ':enabled',
            '所有激活的 input 元素',
        ),
        array(
            ':disabled',
            ':disabled',
            '所有禁用的 input 元素',
        ),
        array(
            ':selected',
            ':selected',
            '所有被选取的 input 元素',
        ),
        array(
            ':checked',
            ':checked',
            '所有被选中的 input 元素',
        ),
    ),
);