{* alert.tpl 提示信息 *}
{$cfg = [
	title  => $tplData.cateRow.cate_name,
	css    => "alert"
]}

{include "include/pub_head.tpl" cfg=$cfg}

	<h1>
		<img src="{$smarty.const.BG_URL_IMAGE}alert_{$smarty.get.alert|truncate:1:""}.png" alt="提示信息" />
		{$alert[$smarty.get.alert]}
	</h1>
	<h2><a href="javascript:history.go(-1);">返回</a></h2>
	<h3>
		提示信息 : {$smarty.get.alert}
	</h3>

{include "include/pub_foot.tpl" cfg=$cfg}

{include "include/html_foot.tpl"}
