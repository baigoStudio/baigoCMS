{* admin_head.tpl 管理后台头部，包含菜单 *}
{include "include/html_head.tpl"}

<body>

<dl class="global_head">
	<dt class="head_name">{$smarty.const.BG_SITE_NAME}</dt>
	<dd class="head_logo"><a href="{$smarty.const.PRD_CMS_URL}" target="_blank">{$smarty.const.PRD_CMS_NAME}</a></dd>
	<dd class="float_clear"></dd>
</dl>

<dl class="page_head">
	<dt class="head_title">{$lang.page.admin}</dt>
	<dd class="head_name">{$cfg.title}</dd>
	<dd class="head_menu">
		<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=admin&act_get=my">{$tplData.adminLogged.admin_name}</a>
		{if $tplData.adminLogged.admin_note}[ {$tplData.adminLogged.admin_note} ]{/if}
		&#160;|&#160;
		<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=admin&act_get=my">{$lang.href.passModi}</a>
		&#160;|&#160;
		<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=logon&act_get=logout">{$lang.href.logout}</a>
	</dd>
	<dd class="float_clear"></dd>
</dl>


<dl class="page_body">
	<dt>
		<ul>
			{foreach $adminMod as $key_m=>$value_m}
				<li id="menu_{$key_m}"><a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod={$value_m.main.mod}">{$value_m.main.title}</a></li>
				<li>
					<ol id="sub_{$key_m}">
						{foreach $value_m.sub as $key_s=>$value_s}
							<li id="sub_{$key_m}_{$key_s}"><a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod={$value_s.mod}&act_get={$value_s.act_get}">{$value_s.title}</a></li>
						{/foreach}
					</ol>
				</li>
			{/foreach}
		</ul>
	</dt>

	<dd>