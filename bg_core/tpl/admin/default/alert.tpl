{* alert.tpl 提示信息界面 *}
{if $smarty.get.view}
	{$str_tpl = $smarty.get.view}
	{$str_css = "admin_{$smarty.get.view}_alert"}
{else}
	{$str_tpl = "admin"}
	{$str_css = "admin_alert"}
{/if}

{$cfg = [
	title  => $lang.page.alert,
	css    => $str_css
]}

{include "include/{$str_tpl}_head.tpl" cfg=$cfg}

	<div class="tform">
		<h1>
			<img src="{$smarty.const.BG_URL_IMAGE}alert_{$smarty.get.alert|truncate:1:""}.png" alt="{$lang.page.alert}" />
			{$alert[$smarty.get.alert]}
		</h1>
		<h2>{$lang.text[$smarty.get.alert]}</h2>
		<h2><a href="javascript:history.go(-1);">{$lang.href.back}</a></h2>
		<h3>
			{$lang.label.alert} : {$smarty.get.alert}
		</h3>
	</div>

{include "include/{$str_tpl}_foot.tpl" cfg=$cfg}
{include "include/html_foot.tpl" cfg=$cfg}
