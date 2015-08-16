<?php
return "<a name=\"list\"></a>
	<h3>所有调用</h3>
	<p>
		点左侧菜单“调用管理“，进入如下界面，可以对调用进行编辑、删除等操作。调用主要用于模板开发与 API 调用。
	</p>
	<p>
		<img src=\"{images}call_list.jpg\" class=\"img-responsive thumbnail\">
	</p>

	<hr>

	<a name=\"form\"></a>
	<h3>创建（编辑）调用</h3>
	<p>
		点左侧子菜单的“创建调用“或者点击调用列表的“编辑“菜单，进入如下界面，在此，您可以对调用进行各项操作。
	</p>

	<p>
		<div id=\"carousel_call\" class=\"carousel slide\" data-ride=\"carousel\">
			<ol class=\"carousel-indicators indicator_black\">
				<li data-target=\"#carousel_call\" data-slide-to=\"0\" class=\"active\"></li>
				<li data-target=\"#carousel_call\" data-slide-to=\"1\"></li>
				<li data-target=\"#carousel_call\" data-slide-to=\"2\"></li>
			</ol>

			<div class=\"carousel-inner\" role=\"listbox\">
				<div class=\"item active\">
					<img src=\"{images}call_form_article.jpg\">
					<div class=\"carousel-caption indicator_black\">文章列表、排行</div>
				</div>
				<div class=\"item\">
					<img src=\"{images}call_form_cate.jpg\">
					<div class=\"carousel-caption indicator_black\">栏目列表</div>
				</div>
				<div class=\"item\">
					<img src=\"{images}call_form_tag.jpg\">
					<div class=\"carousel-caption indicator_black\">TAG 列表</div>
				</div>
			</div>

			<a class=\"left carousel-control\" href=\"#carousel_call\" role=\"button\" data-slide=\"prev\">
				<span class=\"glyphicon glyphicon-chevron-left\"></span>
				<span class=\"sr-only\">Previous</span>
			</a>
			<a class=\"right carousel-control\" href=\"#carousel_call\" role=\"button\" data-slide=\"next\">
				<span class=\"glyphicon glyphicon-chevron-right\"></span>
				<span class=\"sr-only\">Next</span>
			</a>
		</div>
	</p>

	<div class=\"panel panel-default\">
		<div class=\"panel-heading\">填写说明</div>
		<div class=\"panel-body\">
			<h4 class=\"text-info\">调用名称</h4>
			<p>调用的名称，建议按照最终调用的位置和类型相结合进行命名，如：首页-顶部-栏目列表。</p>

			<div class=\"alert alert-success\">显示符合以下条件的内容 <mark>以下选项因调用类型有所不同</mark></div>

			<h4 class=\"text-info\">栏目</h4>
			<p>显示隶属于这些栏目的文章、子栏目等。调用类型为文章列表以及各种排行时，此为多选；类型为栏目列表时，此为单选且不能选无子栏目的选项，类型为 TAG 列表时，无此项。</p>

			<h4 class=\"text-info\">是否带图片</h4>
			<p>可选全部、仅显示带图片文章、仅显示无图片文章。仅在调用类型为文章列表时显示。</p>

			<h4 class=\"text-info\">标记</h4>
			<p>按 文章管理 - 标记 的设定，显示隶属于这些标记的文章。仅在调用类型为文章列表时显示。<a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=tag#mark\">标记</a> 详情。</p>

			<div class=\"alert alert-success\">其他</div>

			<h4 class=\"text-info\">调用类型</h4>
			<p>可选文章列表、日排行、周排行、月排行、年排行、总排行、栏目列表、TAG 列表。文章列表和所有排行，都是指安设定要求列出相关文章，栏目列表是指按设定要求列出相关栏目，TAG 列表是指按设定要求列出相关 TAG。</p>

			<h4 class=\"text-info\">状态</h4>
			<p>可选启用或禁用。</p>

			<h4 class=\"text-info\">显示数量</h4>
			<p><mark>显示前</mark> 是指显示排在最前的几条文章，<mark>排除前</mark> 是不显示排在最前的几条文章。</p>

			<h4 class=\"text-info\">显示字数</h4>
			<p>文章标题、栏目名称、TAG 等显示的字数，如字数超过这里的设定，将以省略号替代。</p>
		</div>
	</div>";
