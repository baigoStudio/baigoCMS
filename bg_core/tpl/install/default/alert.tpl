{* install_1.tpl 登录界面 *}
{$cfg = [
	sub_title => $lang.page.alert,
	mod_help   => "install",
	act_help   => "ext"
]}
{include "include/install_head.tpl" cfg=$cfg}

	<div class="alert alert-{if $tplData.status == "y"}success{else}danger{/if}">
		<span class="glyphicon glyphicon-{if $tplData.status == "y"}ok-circle{else}remove-circle{/if}"></span>
		{$alert[$tplData.alert]}
	</div>

	<p>
		{$lang.label.alert}
		:
		{$tplData.alert}
	</p>

	{if isset($install[$tplData.alert])}
		{$install[$tplData.alert]}
	{/if}

{include "include/install_foot.tpl" cfg=$cfg}
