{* alert.tpl 提示信息 *}
{$cfg = [
	title  => $tplData.cateRow.cate_name,
	css    => "alert"
]}

{include "include/pub_head.tpl" cfg=$cfg}

	<h1>
		<img src="{$smarty.const.BG_URL_IMAGE}alert_{$tplData.alert|truncate:1:""}.png" alt="提示信息">
		{$alert[$tplData.alert]}
	</h1>
	<h2><a href="javascript:history.go(-1);">返回</a></h2>
	<h3>
		提示信息 : {$tplData.alert}
	</h3>

{include "include/pub_foot.tpl" cfg=$cfg}

{include "include/html_foot.tpl"}
