{* upfile_insert.php 插入菜单 *}
	<h5>
		<ul>
			<li class="float_left">
				<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=upfile&act_get=list&target={$tplData.search.target}&tpl=insert&view=iframe" {if $smarty.get.act_get == "list"}class="tab_active"{/if}>{$lang.href.upfileList}</a>
				<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=upfile&act_get=form&target={$tplData.search.target}&view=iframe" {if $smarty.get.act_get == "form"}class="tab_active"{/if}>{$lang.href.upload}</a>
			</li>
			<li class="float_right">
				<button type="button" id="ok">{$lang.btn.ok}</button>
			</li>
			<li class="float_clear"></li>
		</ul>
	</h5>
