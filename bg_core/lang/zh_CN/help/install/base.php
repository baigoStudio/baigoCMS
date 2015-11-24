<?php
return "<h3>基本设置</h3>

	<p><img src=\"{images}base.jpg\" class=\"img-responsive\"></p>

	<div class=\"panel panel-default\">
		<div class=\"panel-heading\">填写说明</div>
		<div class=\"panel-body\">
			<h4 class=\"text-info\">网站名称</h4>
			<p>请按照自己意愿填写，如：<mark>baigo Studio</mark></p>

			<h4 class=\"text-info\">网站域名</h4>
			<p>请根据实际情况填写，如：<mark>www.domain.com</mark>，默认为当前网站域名。</p>

			<h4 class=\"text-info\">首页 URL</h4>
			<p>请根据实际情况填写，如：<mark>http://www.domain.com</mark>，默认为当前首页 URL，末尾请勿加 <mark>/</mark>。</p>

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

	<p>填写完毕，点击“保存“，保存成功后点击“下一步“。</p>";
