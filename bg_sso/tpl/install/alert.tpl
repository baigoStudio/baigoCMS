{* install_1.tpl 登录界面 *}

{include "include/install_head.tpl" cfg=$cfg}

	<div class="page_head">
		<img src="{$smarty.const.BG_URL_STATIC}image/alert_{$smarty.get.alert|truncate:1:""}.png" alt="{$lang.page.alert}" />
		{$alert[$smarty.get.alert]}
	</div>

	<div class="page_body">
		{$install[$smarty.get.alert]}
	</div>

{include "include/install_foot.tpl" cfg=$cfg}
