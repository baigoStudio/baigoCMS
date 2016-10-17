<?php
return "<h3>专题分发设置</h3>

    <p>
        <a href=\"{images}spec.jpg\" target=\"_blank\"><img src=\"{images}spec.jpg\" class=\"img-responsive\"></a>
    </p>

    <p>&nbsp;</p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">填写说明</div>
        <div class=\"panel-body\">
            <h4 class=\"text-info\">URL 前缀</h4>
            <p>此项用于专题的分发，如您的专题保存在同一台服务器上，可忽略此项目，并采用默认值，末尾请勿加 <kbd>/</kbd>。</p>

            <h4 class=\"text-info\">分发 FTP 地址</h4>
            <p><mark>以下选项根据不同系统，有可能无相应选项</mark>。此项用于专题的分发，需开启分发模块（开启方法请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=intro&act_get=faq#module\">常见问题</a>），如您想将专题分发到其他服务器，需填写本项。</p>

            <h4 class=\"text-info\">FTP 端口</h4>
            <p>请按照服务器提供商所提供的资料填写。</p>

            <h4 class=\"text-info\">FTP 用户名</h4>
            <p>请按照服务器提供商所提供的资料填写。</p>

            <h4 class=\"text-info\">FTP 密码</h4>
            <p>请按照服务器提供商所提供的资料填写。</p>

            <h4 class=\"text-info\">FTP 远程路径</h4>
            <p>请按照服务器提供商所提供的资料填写。</p>

            <h4 class=\"text-info\">FTP 被动模式</h4>
            <p>请按照服务器提供商所提供的资料填写。</p>
        </div>
    </div>

    <p>填写完毕，点击“保存“，保存成功后点击“下一步“。</p>

    <p>&nbsp;</p>

    <a name=\"spec_example\"></a>
    <h4>专题分发设置实例</h4>
    假设：
    <ol>
        <li>
            专题服务器 Web 服务的 URL 为 <mark>http://spec.domain.com</mark>，该 URL 的根目录指向 <mark>/web/domain/wwwroot</mark>；
        </li>
        <li>
            FTP 地址为 <mark>spec.domain.com</mark>，端口为 21，用户名为 username，密码为 password，FTP 账户的根目录为 <mark>/web</mark>；
        </li>
        <li>
            上传年月为 2014-05，上传后的文件名为 2504.jpg。
        </li>
    </ol>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">详细设置如下</div>
        <div class=\"panel-body\">
            <h4 class=\"text-info\">URL 前缀</h4>
            <p>http://spec.domain.com</p>

            <h4 class=\"text-info\">分发 FTP 地址</h4>
            <p>spec.domain.com</p>

            <h4 class=\"text-info\">FTP 端口</h4>
            <p>21</p>

            <h4 class=\"text-info\">FTP 用户名</h4>
            <p>username</p>

            <h4 class=\"text-info\">FTP 密码</h4>
            <p>password</p>

            <h4 class=\"text-info\">FTP 远程路径</h4>
            <p>/domain/wwwroot</p>

            <h4 class=\"text-info\">专题最终 URL</h4>
            <p class=\"text_break\">http://spec.domain.com/spec/2504/index.html</p>
        </div>
    </div>";
