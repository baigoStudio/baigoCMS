{* admin_show.tpl 管理员编辑界面 *}

{$cfg = [
	title          => "{$adminMod.admin.main.title} - {$lang.page.show}",
	css            => "admin_form",
	menu_active    => "admin",
	sub_active     => "list"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<form class="tform">

		<input type="hidden" name="token_session" value="{$common.token_session}" />
		<input type="hidden" name="act_post" value="submit" />
		<input type="hidden" name="admin_id" value="{$tplData.adminRow.admin_id}" />

		<div>
			<ol>
				<li class="title">{$lang.label.status}</li>
				<li>
					<img src="{$smarty.const.BG_URL_IMAGE}allow_{if $tplData.adminRow.admin_status == "enable"}y{else}x{/if}.png" />
					<label>{$status.admin[$tplData.adminRow.admin_status]}</label>
				</li>

				<li class="line_dashed"> </li>

				<li class="title_b">
					<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=admin&act_get=form&admin_id={$tplData.adminRow.admin_id}">{$lang.href.edit}</a>
				</li>
			</ol>

			<ul>
				<li class="title">{$lang.label.username}</li>
				<li class="title_b">{$tplData.adminRow.admin_name}</li>

				<li class="title">{$lang.label.allow}</li>
				<li class="title">
					<ol>
						{foreach $adminMod as $key_m=>$value_m}
							<li class="title">{$value_m.main.title}</li>
							<li class="field">
								{foreach $value_m.allow as $key_s=>$value_s}
									<img src="{$smarty.const.BG_URL_IMAGE}allow_{if $tplData.adminRow.admin_allow[$key_m][$key_s] == 1}y{else}x{/if}.png" />
									<label>{$value_s}</label>
								{/foreach}
							</li>
						{/foreach}
					</ol>
				</li>

				<li class="title">{$lang.label.note}</li>
				<li class="title_b">{$tplData.adminRow.admin_note}</li>

				<li class="title_b">
					<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=admin&act_get=form&admin_id={$tplData.adminRow.admin_id}">{$lang.href.edit}</a>
				</li>
			</ul>
		</div>

	</form>

{include "include/admin_foot.tpl" cfg=$cfg}

{include "include/html_foot.tpl" cfg=$cfg}
