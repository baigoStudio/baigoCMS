{* pub_head.tpl 前台头部 *}
{include "include/html_head.tpl"}

	<header class="navbar navbar-default navbar-static-top">
		<div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
					<span class="sr-only">nav</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{$smarty.const.PRD_CMS_URL}" target="_blank">{$smarty.const.BG_SITE_NAME}</a>
			</div>
			<nav class="collapse navbar-collapse bs-navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					{foreach $tplData.cateRows as $_key=>$_value}
					<li>
						<a href="{$_value.urlRow.cate_url}">
							{$_value.cate_name}
						</a>
					</li>
					{/foreach}
				</ul>
			</nav>
		</div>
	</header>

	<div class="container">

