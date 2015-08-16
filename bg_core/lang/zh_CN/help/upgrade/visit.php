<?php
return "<h3>访问方式设置</h3>

	<p><img src=\"{images}visit.jpg\" class=\"img-responsive\"></p>

	<div class=\"panel panel-default\">
		<div class=\"panel-heading\">填写说明</div>
		<div class=\"panel-body\">
			<h4 class=\"text-info\">默认</h4>
			<p>此方式为 PHP 最常用的访问方式，使用查询串的方式访问网站，URL 的形式为 <span class=\"text-primary\">http://www.domain.com/index.php?mod=article&act_get=show&article_id=123</span>；优点是效率较高，兼容性好；缺点是 URL 友好度较差，对于搜索引擎的收录有一定影响。</p>

			<h4 class=\"text-info\">伪静态</h4>
			<p>此方式目前较为流行，使用友好的 URL 方式访问网站，URL 的形式为 <span class=\"text-primary\">http://www.domain.com/article/123</span>，此方式需要服务器支持 URL 重写 (URL Rewriting)，具体请查看 <a href=\"http://zh.wikipedia.org/wiki/URL_Rewriting\" target=\"_blank\">维基百科</a>；优点是 URL 较为友好，有利于搜索引擎的收录；缺点是效率相对较低，兼容性差，且需要重新配置服务器；在 Apache 环境下，如支持 URL 重写，安装程序会自动帮您设置，是否支持 URL 重写，请咨询服务器提供商。Nginx 环境下，需下载相关的配置文件，重新配置服务器，<a href=\"http://www.baigo.net/Products/baigoCMS/download.php\">点此下载配置文件</a>；IIS 环境暂不支持伪静态模式。</p>

			<h4 class=\"text-info\">纯静态</h4>
			<p><mark>根据不同系统，有可能无此选项</mark>。此方式为效率最高的访问方式，利用静态页面生成模块，将所有栏目、文章等内容生成为静态 HTML 文件，URL 的形式为 <span class=\"text-primary\">http://www.domain.com/article/123.html</span>，此方式需要额外安装静态页面生成模块；此方式的有点是效率最高，无数据库服务器压力，兼容性好，有利于搜索引擎的收录；缺点是占用硬盘空间相对较多，页面需要定时生成。</p>

			<h4 class=\"text-info\">生成静态文件</h4>
			<p><mark>根据不同系统，有可能无此选项</mark>。此选项决定生成静态文件的类型。</p>
		</div>
	</div>

	<p>填写完毕，点击“保存“，保存成功后点击“下一步“。</p>";
