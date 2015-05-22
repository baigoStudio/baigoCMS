<?php
return "<a name=\"admin\"></a>
	<h3>创建管理员</h3>
	<p>本操作将向 SSO 注册新用户，并自动将新注册的用户授权为超级管理员，拥有所有的管理权限。如果您之前已经部署有 baigo SSO，并且不想注册新用户，只希望使用原有的 SSO 用户作为管理员，请查看 <a href=\"#auth\">授权为管理员</a>。</p>
	<p><img src=\"{images}admin.jpg\" class=\"img-responsive\"></p>
	<div class=\"panel panel-default\">
		<div class=\"panel-heading\">填写说明</div>
		<div class=\"panel-body\">
			<h4 class=\"text-info\">用户名</h4>
			<p>请根据实际情况填写。</p>
			<h4 class=\"text-info\">密码</h4>
			<p>请根据实际情况填写。</p>
			<h4 class=\"text-info\">确认密码</h4>
			<p>请根据实际情况填写。</p>

			<h4 class=\"text-info\">昵称</h4>
			<p>请根据实际情况填写。</p>
		</div>
	</div>
	<p>填写完毕，点击提交，提交成功后，点击下一步。</p>
	<hr>

	<a name=\"auth\"></a>
	<h3>授权为管理员</h3>
	<p>本操作将用您输入的 SSO 用户作为管理员，拥有所有的管理权限。您必须输入该用户的用户名和密码才能进行授权。</p>
	<p><img src=\"{images}auth.jpg\" class=\"img-responsive\"></p>
	<hr>
	<a name=\"sso\"></a>
	<h3>自动部署 SSO 后创建管理员</h3>
	<p>自动部署 SSO 后，安装程序将会自动跳转到本界面面，本操作将同时为 CMS 与 SSO 创建管理员，拥有所有的管理权限。请牢记用户名与密码。</p>
	<p><img src=\"{images}ssoAdmin.jpg\" class=\"img-responsive\"></p>";
