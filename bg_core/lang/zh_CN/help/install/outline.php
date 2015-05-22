<?php
return "<h3>概述</h3>
	<p>将下载到的程序包解压，然后将所有文件上传到服务器，假设网站 URL 为 <span class=\"text-primary\">http://www.domain.com</span> 上传到根目录 /，以下说明均以此为例。</p>
	<div class=\"panel panel-default\">
		<div class=\"panel-heading\">目录结构说明</div>
		<div class=\"table-responsive\">
			<table class=\"table\">
				<thead>
					<tr>
						<th class=\"nowrap\">文件 / 文件夹</th>
						<th class=\"nowrap\">用途</th>
						<th>说明</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class=\"nowrap\">index.php</td>
						<td class=\"nowrap\">前台入口文件</td>
						<td>前台的入口文件，所有向浏览者展示的内容，均通过此文件实现。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">bg_admin</td>
						<td class=\"nowrap\">管理后台入口</td>
						<td>管理后台入口，所有后台管理功能，均通过此目录实现。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">bg_api</td>
						<td class=\"nowrap\">API 接口入口</td>
						<td>API 接口入口，所有提供给第三方的接口，均通过此目录实现。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">bg_cache</td>
						<td class=\"nowrap\">缓存文件</td>
						<td>缓存文件目录，所有系统的缓存，均保存在此。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">bg_config</td>
						<td class=\"nowrap\">配置文件</td>
						<td>配置文件目录，所有系统的配置信息，均保存在此。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">bg_core</td>
						<td class=\"nowrap\">系统内核</td>
						<td>系统内核，整个系统的重中之重，所有系统的核心功能，均保存在此。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">bg_help</td>
						<td class=\"nowrap\">帮助文档入口</td>
						<td>帮助文档入口，提供详细帮助信息。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">bg_install</td>
						<td class=\"nowrap\">安装程序入口</td>
						<td>安装程序入口，系统的初次安装、升级，均通过此目录实现。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">bg_sso</td>
						<td class=\"nowrap\">baigo SSO 单点登录系统</td>
						<td>单点登录系统目录，用户登录、管理员登录，均依赖于此系统。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">bg_static</td>
						<td class=\"nowrap\">静态文件</td>
						<td>静态文件目录，主要用于保存图片、CSS、JavaScript等静态文件。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">bg_tpl</td>
						<td class=\"nowrap\">模板文件</td>
						<td>模板文件目录，所有向浏览者展示的界面，均通过保存在此的模板文件实现。</td>
					</tr>
					<tr>
						<td class=\"nowrap\">bg_attach</td>
						<td class=\"nowrap\">附件</td>
						<td>附件目录，上传的图片、附件等，均保存在此。</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>";