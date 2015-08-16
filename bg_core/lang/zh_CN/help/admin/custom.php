<?php
return "<a name=\"list\"></a>
	<h3>自定义字段</h3>
	<p>点左侧菜单系统设置的“自定义字段“子菜单，进入如下界面，可以对自定义字段进行编辑、删除、改变状态等操作。自定义字段顾名思义是用来自定义的，当管理员在发布文章等操作时，如发现现有的字段无法满足时，便可以创建自定义字段项目来实现，如：创建文章时，管理员需要增加一个型号字段，便可在此创建。</p>
	<p><img src=\"{images}custom_list.jpg\" class=\"img-responsive thumbnail\"></p>

	<hr>

	<a name=\"form\"></a>
	<h3>创建（编辑）自定义字段</h3>
	<p>点“创建“或者点击自定义字段列表的“编辑“菜单，进入如下界面，在此，您可以对自定义字段进行各项操作。</p>

	<div class=\"panel panel-default\">
		<div class=\"panel-heading\">填写说明</div>
		<div class=\"panel-body\">
			<h4 class=\"text-info\">字段名称</h4>
			<p>自定义字段的名称。</p>

			<h4 class=\"text-info\">类型</h4>
			<p>目前只开放文章自定义字段。</p>

			<h4 class=\"text-info\">状态</h4>
			<p>可选启用、禁用。</p>

			<h4 class=\"text-info\">隶属于字段</h4>
			<p>字段所属的上一级字段，不限层次，如无隶属，则选择“作为一级字段”。</p>
		</div>
	</div>";
