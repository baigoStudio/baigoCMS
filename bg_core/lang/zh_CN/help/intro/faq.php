<?php
return "<h3>常见问题</h3>
    <p>&nbsp;</p>

    <h4>问：经常出现令牌错误是什么原因？如何解决？</h4>

    <p>答：令牌是本系统的一种安全机制，每 5 分钟滚动更新一次，出现令牌错误的原因一般是开启了两个以上的管理窗口，也有可能是暂时性网络故障造成的。如果遇到令牌错误的问题，可将警告窗口关闭，将已经输入的内容妥善保存后，刷新当前页面便可解决。如果输入的内容较多，也可等待 5 分钟，系统再次更新令牌后再提交。</p>

    <p>&nbsp;</p>
    <div class=\"text-right\">
        <a href=\"#top\">
            <span class=\"glyphicon glyphicon-chevron-up\"></span>
            top
        </a>
    </div>
    <hr>
    <p>&nbsp;</p>

    <h4>问：我刚修改了栏目，但为何网站上显示的还是原来的内容？</h4>

    <p>答：由于本系统对栏目的信息保存采用了缓存机制，在修改栏目的时候，一般会更新缓存，但也有可能更新缓存失败，只需要在“栏目管理 &raquo; 所有栏目”界面，选中需要更新的栏目，然后在下方的批量操作下拉框中选择“更新缓存”，再点击提交便可。</p>

    <p>&nbsp;</p>
    <div class=\"text-right\">
        <a href=\"#top\">
            <span class=\"glyphicon glyphicon-chevron-up\"></span>
            top
        </a>
    </div>
    <hr>
    <p>&nbsp;</p>

    <h4>问：创建或编辑文章时，上传图片无法插入到内容中是什么原因？如何指定图片插入的位置？</h4>

    <p>答：创建或编辑文章时，内容编辑器还处于未激活状态，需要将其激活才能进行操作。激活方式非常简单，就是在编辑器的内容输入窗口里点击一下，看到输入光标闪烁变说明已经激活成功。如果要指定图片插入的位置，可以将光标移到该处，图片就可以顺利插入。</p>

    <p>&nbsp;</p>
    <div class=\"text-right\">
        <a href=\"#top\">
            <span class=\"glyphicon glyphicon-chevron-up\"></span>
            top
        </a>
    </div>
    <hr>
    <p>&nbsp;</p>

    <h4>问：为何生成文章时，有时候会显示暂时无法生成？</h4>

    <p>答：生成文章时，必须要满足文章本身已发布、定时上线的时间晚于当前时间、定时下线的时间早于当前时间、所隶属的栏目状态为显示等条件。</p>

    <p>&nbsp;</p>
    <div class=\"text-right\">
        <a href=\"#top\">
            <span class=\"glyphicon glyphicon-chevron-up\"></span>
            top
        </a>
    </div>
    <hr>
    <p>&nbsp;</p>

    <div>
        <h4>问：安装过程中出现“数据库无法连接”和“数据库名错误”错误如何解决？</h4>

        <p>答：安装过程中出现的“数据库无法连接”和“数据库名错误”错误又可能是系统提前生成了数据库配置文件，而配置文件的数据又不符合实际情况，解决方法是修改 ./bg_config/opt_dbconfig.inc.php 文件，填入正确的数据库信息，也可以删除该文件重新运行安装程序。</p>
    </div>

    <p>&nbsp;</p>
    <div class=\"text-right\">
        <a href=\"#top\">
            <span class=\"glyphicon glyphicon-chevron-up\"></span>
            top
        </a>
    </div>
    <hr>
    <p>&nbsp;</p>

    <div>
        <a name=\"module\"></a>
        <h4>问：如何开启“静态页面生成模块”和“FTP 分发模块”？</h4>

        <p>答：开启方法是修改 ./bg_config/config.inc.php 文件，找到 BG_MODULE_GEN 和 BG_MODULE_FTP 两个常量，这两个常量分别控制“静态页面生成模块”和“FTP 分发模块”的开启与关闭，将常量定义为 1 即表示开启，定义为 0 即表示关闭，如：</p>
        <p>
<pre><code class=\"language-php\">define(&quot;BG_MODULE_GEN&quot;, 1);
define(&quot;BG_MODULE_FTP&quot;, 1);
</code></pre>
        </p>
    </div>

    <p>&nbsp;</p>
    <div class=\"text-right\">
        <a href=\"#top\">
            <span class=\"glyphicon glyphicon-chevron-up\"></span>
            top
        </a>
    </div>
    <hr>
    <p>&nbsp;</p>

    <a name=\"static\"></a>
    <h4>问：请讲述一下纯静态模式的机制。</h4>

    <p>本系统的纯静态模式只选择生成最前的几页（此页数可以在“系统设置 -> 访问设置 -> 静态页数”进行自定义），超出部分将由伪静态页面负责显示。为何选择这种模式的解释如下：</p>

    <p>系统隶属于栏目、专题的文章较多时会设置分页，在纯静态模式下，系统需要逐页生成静态文件，随着时间的推移分页越来越多，如果系统按照总页数全部生成一遍会非常耗时。</p>

    <p>由于栏目的访问量会随着页码的增加而逐步减少，也就是说页码越靠前访问量越多，纯静态模式是为了应付日益增大的访问量而设置的，只需要减小访问量最大的一些页面就能有效的起到减负的作用。</p>

    <p>&nbsp;</p>
    <div class=\"text-right\">
        <a href=\"#top\">
            <span class=\"glyphicon glyphicon-chevron-up\"></span>
            top
        </a>
    </div>
    <hr>
    <p>&nbsp;</p>

    <a name=\"cate_urlMore\"></a>
    <h4>问：栏目内的 <code>{\$tplData.cateRow.cate_urlMore}</code> 更多分页 URL 与 <code>{\$tplData.cateRow.cate_url}</code> 当前栏目 URL 有什么区别？为何如此设定？</h4>

    <p>答：cate_urlMore 是专门为纯静态模式设置的。</p>

    <p>系统采取的纯静态机制请参考第一个问题，由此机制产生了一个问题，就是当分页超过“静态页数”时，访问者如何访问到后面的页码？因此便有了 cate_urlMore 这个参数，开发者在分页超过“静态页数”时，可以将访问者引导到这个 URL。</p>";