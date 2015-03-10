<?php
return "<a name=\"list\"></a>" .
	"<h3>所有群组</h3>" .
	"<p>" .
	"	点左侧菜单群组管理，进入如下界面，可以对群组进行编辑、删除等操作。" .
	"</p>" .
	"<p>" .
	"	<img src=\"{images}group_list.jpg\" class=\"img-responsive thumbnail\">" .
	"</p>" .

	"<hr>" .

	"<a name=\"form\"></a>" .
	"<h3>创建（编辑）群组</h3>" .
	"<p>" .
	"	点左侧子菜单的创建群组或者点击群组列表的编辑菜单，进入如下界面，在此，您可以对群组进行各项操作。" .
	"</p>" .
	"<p>" .
	"	<img src=\"{images}group_form.jpg\" class=\"img-responsive thumbnail\">" .
	"</p>" .

	"<div class=\"panel panel-default\">" .
	"	<div class=\"panel-heading\">填写说明</div>" .
	"	<div class=\"panel-body\">" .
	"		<h4 class=\"text-info\">组名</h4>" .
	"		<p>群组的名称。</p>" .

	"		<h4 class=\"text-info\">系统权限</h4>" .
	"		<p>管理员拥有的系统权限。此处的权限均是系统级的，如：文章管理，只要在此选择了相应权限，则所有隶属于这个组的管理员将拥有所有栏目的相应权限。</p>" .

	"		<h4 class=\"text-info\">备注</h4>" .
	"		<p>群组的备注。</p>" .

	"		<h4 class=\"text-info\">类型</h4>" .
	"		<p>可选用户组或管理组。</p>" .

	"		<h4 class=\"text-info\">状态</h4>" .
	"		<p>可选启用或禁用。</p>" .
	"	</div>" .
	"</div>";