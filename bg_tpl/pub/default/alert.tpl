{* alert.tpl 提示信息 *}
{$cfg = [
	title  => "提示信息"
]}

{include "include/pub_head.tpl" cfg=$cfg}

	<div class="alert alert-{if $tplData.status == "y"}success{else}danger{/if}">
		<h3>
			<span class="glyphicon glyphicon-{if $tplData.status == "y"}ok-circle{else}remove-circle{/if}"></span>
			{$alert[$tplData.alert]}
		</h3>

		<p>
			<a href="javascript:history.go(-1);">
				<span class="glyphicon glyphicon-chevron-left"></span>
				返回
			</a>
		</p>

		<p>
			提示信息 : {$tplData.alert}
		</p>
	</div>

{include "include/pub_foot.tpl" cfg=$cfg}

{include "include/html_foot.tpl"}
