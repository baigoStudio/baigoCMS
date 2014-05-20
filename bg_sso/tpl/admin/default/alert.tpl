{* alert.tpl 提示信息界面 *}
{$cfg = [
	title  => $lang.page.alert,
	css    => "admin_alert"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<div class="tform">
		<h1>
			<img src="{$smarty.const.BG_URL_IMAGE}alert_{$smarty.get.alert|truncate:1:""}.png" alt="{$lang.page.alert}" />
			{$alert[$smarty.get.alert]}
		</h1>
		<h2><a href="javascript:history.go(-1);">{$lang.href.back}</a></h2>
		<h3>
			{$lang.label.alert} : {$smarty.get.alert}
		</h3>
	</div>

{include "include/admin_foot.tpl" cfg=$cfg}

{include "include/html_foot.tpl" cfg=$cfg}
