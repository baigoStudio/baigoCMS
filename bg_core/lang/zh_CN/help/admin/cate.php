<?php
return "<a name=\"list\"></a>
	<h3>所有栏目</h3>
	<p>
		点左侧菜单栏目管理，进入如下界面，可以对栏目进行编辑、删除、改变状态、刷新缓存等操作。
	</p>

	<p>
		<img src=\"{images}cate_list.jpg\" class=\"img-responsive thumbnail\">
	</p>

	<hr>

	<a name=\"form\"></a>
	<h3>创建（编辑）栏目</h3>
	<p>
		点左侧子菜单的创建栏目或者点击栏目列表的编辑菜单，进入如下界面。在此，您可以对栏目进行各项操作。
	</p>

	<p>
		<div id=\"carousel_cate\" class=\"carousel slide\" data-ride=\"carousel\">
			<ol class=\"carousel-indicators indicator_black\">
				<li data-target=\"#carousel_cate\" data-slide-to=\"0\" class=\"active\"></li>
				<li data-target=\"#carousel_cate\" data-slide-to=\"1\"></li>
				<li data-target=\"#carousel_cate\" data-slide-to=\"2\"></li>
			</ol>

			<div class=\"carousel-inner\">
				<div class=\"item active\">
					<img src=\"{images}cate_form_normal.jpg\">
					<div class=\"carousel-caption indicator_black\">普通栏目</div>
				</div>
				<div class=\"item\">
					<img src=\"{images}cate_form_single.jpg\">
					<div class=\"carousel-caption indicator_black\">单页</div>
				</div>
				<div class=\"item\">
					<img src=\"{images}cate_form_link.jpg\">
					<div class=\"carousel-caption indicator_black\">跳转到</div>
				</div>
			</div>

			<a class=\"left carousel-control\" href=\"#carousel_cate\" data-slide=\"prev\">
				<span class=\"glyphicon glyphicon-chevron-left\"></span>
				<span class=\"sr-only\">Previous</span>
			</a>
			<a class=\"right carousel-control\" href=\"#carousel_cate\" data-slide=\"next\">
				<span class=\"glyphicon glyphicon-chevron-right\"></span>
				<span class=\"sr-only\">Next</span>
			</a>
		</div>
	</p>

	<div class=\"panel panel-default\">
		<div class=\"panel-heading\">填写说明</div>
		<div class=\"panel-body\">
			<h4 class=\"text-info\">栏目名称</h4>
			<p>栏目的名称。</p>

			<h4 class=\"text-info\">别名</h4>
			<p>栏目的英文别名，只能使用英文字母。此项一般用户 URL，当访问方式设置为伪静态或纯静态，别名会显示在浏览的地址栏，如：http://www.domain.com/cate/<mark>service</mark>/3/，高亮部分既为别名</p>

			<h4 class=\"text-info\">每页显示数</h4>
			<p>每页显示的文章数。</p>

			<h4 class=\"text-info\">栏目内容</h4>
			<p>栏目的具体内容，点击插入或上传，可以上传图片、附件，或者把已上传的图片、附件插入到文章内容中。<mark>当栏目类型选择单页时，此项可以填写</mark>。</p>

			<h4 class=\"text-info\">跳转至</h4>
			<p>该栏目将直接跳转至相应的地址，不会显示栏目内容。<mark>当栏目类型选择链接时，此项可以填写</mark>。</p>

			<h4 class=\"text-info\">隶属于栏目</h4>
			<p>栏目所属的上一级栏目，不限层次，如无隶属，则选择”作为一级栏目“。</p>

			<h4 class=\"text-info\">模板</h4>
			<p>栏目所使用的模板，模板添加、制作方法，请查看 <a href=\"{BG_URL_HELP}ctl.php?mod=tpl\">模板文档</a>。也可以选择“继承上一级”，系统会根据上一级的模板生成页面，如当前栏目为一级栏目，则继承“系统设置”的有关选项。</p>

			<h4 class=\"text-info\">栏目类型</h4>
			<p>可选普通、单页、链接。单页是指该栏目没有下属的文章，只显示栏目的具体内容，适合联系方式、单位介绍等，链接是指该栏目直接跳转到指定的地址。</p>

			<h4 class=\"text-info\">栏目状态</h4>
			<p>可选显示或隐藏。</p>
		</div>
	</div>

	<hr>

	<h3>栏目排序</h3>
	<p>
		点击栏目列表的排序菜单，进入如下界面。在此，您可以对栏目进行排序操作。
	</p>

	<p>
		<img src=\"{images}cate_order.jpg\" class=\"img-responsive thumbnail\">
	</p>";