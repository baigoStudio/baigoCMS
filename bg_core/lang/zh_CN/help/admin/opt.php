<?php
return "<a name=\"base\"></a>
    <h3>基本设置</h3>
    <p>
        点右上角菜单“系统设置“，进入如下界面，可以对系统进行设置。
    </p>
    <p>
        <img src=\"{images}opt_base.jpg\" class=\"img-responsive thumbnail\">
    </p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">填写说明</div>
        <div class=\"panel-body\">
            <h4 class=\"text-info\">网站名称</h4>
            <p>请按照自己意愿填写，如：<mark>baigo Studio</mark></p>

            <h4 class=\"text-info\">网站域名</h4>
            <p>请根据实际情况填写，如：<mark>www.domain.com</mark>，默认为当前网站域名。</p>

            <h4 class=\"text-info\">首页 URL</h4>
            <p>请根据实际情况填写，如：<mark>http://www.domain.com</mark>，默认为当前首页 URL，末尾请勿加 <kbd>/</kbd>。</p>

            <h4 class=\"text-info\">每页显示数</h4>
            <p>前台页面、API 接口，在对文章、TAG 等进行分页的时候，每一页所显示的数量，默认为 30。其中 API 接口可利用参数来设定每页的显示数，详情查看 <a href=\"{BG_URL_HELP}ctl.php?mod=api&act_get=article\" target=\"_blank\">API 接口文档</a></p>

            <h4 class=\"text-info\">关联文章显示数</h4>
            <p>关联文章可以在文章显示页显示，文章 TAG 方式关联，既与当前显示的文章拥有同样 TAG 的文章将会被显示，默认为 10.</p>

            <h4 class=\"text-info\">文章摘要截取字数</h4>
            <p>文章摘要现在可以选择类型，其中自动截取方式将会由系统自己截取文章内容的最前面部分的文字，默认为 100.</p>

            <h4 class=\"text-info\">时区</h4>
            <p>请根据当地实际情况填写，默认为 Etc/GMT+8，即北京时间。</p>

            <h4 class=\"text-info\">日期格式</h4>
            <p>部分页面显示日期的格式，此日期为完整的日期格式，默认为 xxxx-xx-xx（年-月-日）。</p>

            <h4 class=\"text-info\">短日期格式</h4>
            <p>部分页面显示日期的格式，此日期为缩短的日期格式，不显示年份，默认为 xx-xx（月-日）。</p>

            <h4 class=\"text-info\">时间格式</h4>
            <p>部分页面显示时间的格式，此日期为完整的时间格式，默认为 xx:xx:xx（时:分:秒）。</p>

            <h4 class=\"text-info\">短时间格式</h4>
            <p>部分页面显示时间的格式，此日期为缩短的时间格式，不显示秒，默认为 xx:xx（时:分）。</p>
        </div>
    </div>

    <hr>

    <a name=\"dbconfig\"></a>
    <h3>数据库设置</h3>
    <p>
        点右上角子菜单“数据库设置“，进入如下界面，可以对数据库进行设置。
    </p>
    <p>
        <img src=\"{images}opt_dbconfig.jpg\" class=\"img-responsive thumbnail\">
    </p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">填写说明</div>
        <div class=\"panel-body\">
            <h4 class=\"text-info\">数据库服务器</h4>
            <p>请按照服务器提供商所提供的资料填写。</p>

            <h4 class=\"text-info\">数据库名称</h4>
            <p>请按照服务器提供商所提供的资料填写。</p>

            <h4 class=\"text-info\">数据库用户名</h4>
            <p>请按照服务器提供商所提供的资料填写。</p>

            <h4 class=\"text-info\">数据库密码</h4>
            <p>请按照服务器提供商所提供的资料填写。</p>

            <h4 class=\"text-info\">数据库编码</h4>
            <p>一般为 <mark>utf8</mark>，请按照服务器提供商所提供的资料填写。</p>

            <h4 class=\"text-info\">数据表名前缀</h4>
            <p>默认为 <mark>cms_</mark>，推荐用默认值。</p>
        </div>
    </div>

    <hr>

    <a name=\"visit\"></a>
    <h3>访问方式</h3>
    <p>
        点右上角子菜单“访问方式“，进入如下界面，可以对访问方式进行设置。
    </p>
    <p>
        <img src=\"{images}opt_visit.jpg\" class=\"img-responsive thumbnail\">
    </p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">填写说明</div>
        <div class=\"panel-body\">
            <h4 class=\"text-info\">默认</h4>
            <p>此方式为 PHP 最常用的访问方式，使用查询串的方式访问网站，URL 的形式为 <span class=\"text-primary\">http://www.domain.com/index.php?mod=article&act_get=show&article_id=123</span>；优点是效率较高，兼容性好；缺点是 URL 友好度较差，对于搜索引擎的收录有一定影响。</p>

            <h4 class=\"text-info\">伪静态</h4>
            <p>此方式目前较为流行，使用友好的 URL 方式访问网站，URL 的形式为 <span class=\"text-primary\">http://www.domain.com/article/123</span>，此方式需要服务器支持 URL 重写 (URL Rewriting)，具体请查看 <a href=\"http://www.baike.com/wiki/URL重写\" target=\"_blank\">互动百科</a>；优点是 URL 较为友好，有利于搜索引擎的收录；缺点是效率相对较低，兼容性差，且需要重新配置服务器；在 Apache 环境下，如支持 URL 重写，安装程序会自动帮您设置，是否支持 URL 重写，请咨询服务器提供商。Nginx 环境下，需下载相关的配置文件，重新配置服务器，<a href=\"http://www.baigo.net/cms/\">点此下载配置文件</a>；IIS 环境暂不支持伪静态模式。</p>

            <h4 class=\"text-info\">纯静态</h4>
            <p><mark>根据不同系统，有可能无此选项。</mark>此方式为效率最高的访问方式，利用静态页面生成模块，将所有栏目、文章等内容生成为静态 HTML 文件，URL 的形式为 <span class=\"text-primary\">http://www.domain.com/article/123.html</span>，此方式需要额外安装静态页面生成模块；此方式的有点是效率最高，无数据库服务器压力，兼容性好，有利于搜索引擎的收录；缺点是占用硬盘空间相对较多，页面需要定时生成。</p>

            <h4 class=\"text-info\">生成静态文件</h4>
            <p><mark>根据不同系统，有可能无此选项。</mark>此选项决定生成静态文件的类型。</p>
        </div>
    </div>

    <hr>

    <a name=\"upload\"></a>
    <h3>上传设置</h3>

    <p>
        <img src=\"{images}opt_upload.jpg\" class=\"img-responsive thumbnail\">
    </p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">填写说明</div>
        <div class=\"panel-body\">
            <h4 class=\"text-info\">允许上传大小</h4>
            <p>允许上传的文件大小，超过此数值，系统将禁止上传，单位请查看下设置项；默认为 200 KB</p>

            <h4 class=\"text-info\">允许上传单位</h4>
            <p>文件大小的单位，可选 KB、MB，默认为 KB。</p>

            <h4 class=\"text-info\">允许同时上传数</h4>
            <p>允许同时上传的文件数量，默认可以同时上传 10 个。</p>

            <h4 class=\"text-info\">绑定 URL</h4>
            <p>此项用于附件的分发，如您的附件保存在同一台服务器上，可忽略此项目，并采用默认值，末尾请勿加 <kbd>/</kbd>。</p>

            <h4 class=\"text-info\">分发 FTP 地址</h4>
            <p><mark>以下选项根据不同系统，有可能无相应选项。</mark>此项用于附件的分发，需要额外安装分发模块，如您想将附件保存在其他服务器上，需填写本项。详情请查看 <a href=\"#example\">附件分发设置实例</a></p>

            <h4 class=\"text-info\">FTP 端口</h4>
            <p>请按照服务器提供商所提供的资料填写。</p>

            <h4 class=\"text-info\">FTP 用户名</h4>
            <p>请按照服务器提供商所提供的资料填写。</p>

            <h4 class=\"text-info\">FTP 密码</h4>
            <p>请按照服务器提供商所提供的资料填写。</p>

            <h4 class=\"text-info\">FTP 远程路径</h4>
            <p>请按照服务器提供商所提供的资料填写。</p>
        </div>
    </div>

    <hr>

    <a name=\"example\"></a>
    <h4>附件分发设置实例</h4>
    假设：
    <ol>
        <li>
            图片服务器 Web 服务的 URL 为 <mark>http://image.domain.com</mark>，该 URL 的根目录指向 <mark>/web/domain/wwwroot</mark>；
        </li>
        <li>
            FTP 地址为 <mark>image.domain.com</mark>，端口为 21，用户名为 username，密码为 password，FTP 账户的根目录为 <mark>/web</mark>；
        </li>
        <li>
            上传年月为 2014-05，上传后的文件名为 2504.jpg。
        </li>
    </ol>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">详细设置如下</div>
        <div class=\"panel-body\">
            <h4 class=\"text-info\">绑定 URL</h4>
            <p>http://image.domain.com</p>

            <h4 class=\"text-info\">分发 FTP 地址</h4>
            <p>image.domain.com</p>

            <h4 class=\"text-info\">FTP 端口</h4>
            <p>21</p>

            <h4 class=\"text-info\">FTP 用户名</h4>
            <p>username</p>

            <h4 class=\"text-info\">FTP 密码</h4>
            <p>password</p>

            <h4 class=\"text-info\">FTP 远程路径</h4>
            <p>/domain/wwwroot</p>

            <h4 class=\"text-info\">附件最终 URL</h4>
            <p class=\"text_break\">http://image.domain.com/upfile/2014/05/2504.jpg</p>
        </div>
    </div>

    <hr>

    <a name=\"sso\"></a>
    <h3>SSO 设置</h3>
    <p>
        点右上角子菜单“SSO 设置“，进入如下界面，可以对 SSO 设置进行设置。baigo CMS 的用户以及后台登录需要 baigo SSO 支持，baigo SSO 的部署方式，请查看 <a href=\"http://www.baigo.net/sso/\" target=\"_blank\">baigo SSO 官方网站</a>。
    </p>

    <p>
        <img src=\"{images}opt_sso.jpg\" class=\"img-responsive thumbnail\">
    </p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">填写说明</div>
        <div class=\"panel-body\">
            <h4 class=\"text-info\">API 接口 URL</h4>
            <p>baigo SSO API 接口的 URL</p>

            <h4 class=\"text-info\">APP ID</h4>
            <p>baigo SSO 应用的 APP ID</p>

            <h4 class=\"text-info\">APP KEY</h4>
            <p>baigo SSO 应用的 APP KEY</p>

            <h4 class=\"text-info\">同步登录</h4>
            <p>如为开启状态，当用户在本站登录的时候，所有部署在 baigo SSO 下的网站将同步登录，当用户切换到这些网站时，无需再次登录。</p>
        </div>
    </div>";

