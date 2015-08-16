<?php
return "<a name=\"list\"></a>
	<h3>API 授权设置</h3>
	<p>点左侧菜单系统设置的“API 授权设置”子菜单，进入如下界面，可以对应用进行编辑、删除、改变状态等操作。API 主要用于二次开发，当程序员需要使用本系统的 API 接口时，必须创建响应的应用，并将响应的权限赋予应用，API 接口才能够正常读取。</p>
	<p><img src=\"{images}app_list.jpg\" class=\"img-responsive thumbnail\"></p>

	<hr>

	<a name=\"form\"></a>
	<h3>创建（编辑）应用</h3>
	<p>点“创建”或者点击应用列表的“编辑”菜单，进入如下界面，在此，您可以对应用进行各项操作。</p>
	<p><img src=\"{images}app_form.jpg\" class=\"img-responsive thumbnail\"></p>

	<div class=\"panel panel-default\">
		<div class=\"panel-heading\">填写说明</div>
		<div class=\"panel-body\">
			<h4 class=\"text-info\">应用名称</h4>
			<p>应用的名称。</p>

			<h4 class=\"text-info\">权限</h4>
			<p>选择该应用具备的各种权限。</p>

			<h4 class=\"text-info\">允许通信的 IP</h4>
			<p>允许与 baigo SSO 进行通信的 IP 地址，每行一个 IP 地址，可使用通配符 <mark>*</mark>，如：<mark>192.168.1.*</mark>，此时，只有 <mark>192.168.1</mark> 网段的 IP 地址 <mark>允许</mark> 通信。</p>

			<h4 class=\"text-info\">禁止通信的 IP</h4>
			<p>禁止与 baigo SSO 进行通信的 IP 地址，每行一个 IP 地址，可使用通配符 <mark>*</mark>，如：<mark>192.168.1.*</mark>，此时，<mark>192.168.1</mark> 网段的 IP 地址 <mark>禁止</mark> 通信。</p>

			<h4 class=\"text-info\">状态</h4>
			<p>可选启用、禁用。</p>
		</div>
	</div>

	<hr>

	<a name=\"show\"></a>
	<h3>查看应用</h3>
	<p>点应用列表的“查看”菜单，进入如下界面。在此，您获取调用 API 接口所需要的信息。如果 APP KEY 泄露，可以在此点击“重置 APP KEY”按钮来进行更换，原 APP KEY 将作废。</p>

	<p><img src=\"{images}app_show.jpg\" class=\"img-responsive thumbnail\"></p>";
