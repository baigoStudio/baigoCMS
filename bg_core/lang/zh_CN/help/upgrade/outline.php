<?php
return "<h3>概述</h3>
	<ol>
		<li>升级前请务必 <mark>备份数据库</mark> 如果您在最初部署 baigo CMS 时，采用了高级部署方式，修改了 <mark>./config/config.inc.php</mark> 文件，请同时备份该文件；</li>
		<li><mark>./config/config_sample.inc.php</mark> 文件，可能随时会增加或删除一部分配置信息，在您升级前，务必对比 <mark>./config/config.inc.php</mark> 和 <mark>./config/config.inc.php</mark> 两个文件，将新增加的配置信息添加至 <mark>./config/config.inc.php</mark> 文件中；</li>
		<li>将下载到的程序包解压，然后将所有文件上传到服务器，假设首页 URL 为 <span class=\"text-primary\">http://www.domain.com</span> 上传到根目录 <mark>/</mark>，以下说明均以此为例；</li>
		<li>登录后台，即用浏览器打开 <span class=\"text-primary\">http://www.domain.com/bg_admin/</span> 系统将自动跳转到升级界面。或者直接用浏览器打开 <span class=\"text-primary\">http://www.domain.com/bg_install/ctl.php?mod=upgrade</span></li>
		<li>关于高级部署方式，请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=deploy\">高级部署</a>。</li>
	</ol>";
