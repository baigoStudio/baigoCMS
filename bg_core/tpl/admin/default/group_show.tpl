{* admin_groupForm.tpl 管理组编辑界面 *}
{$cfg = [
	title          => "{$adminMod.group.main.title} - {$lang.page.show}",
	css            => "admin_form",
	menu_active    => "group",
	sub_active     => "list"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<form class="tform">

		<div>
			<ol>
				<li class="title_b">
					{$lang.label.id}: {$tplData.groupRow.group_id}
				</li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.groupType}</li>
				<li>{$type.group[$tplData.groupRow.group_type]}</li>

				<li class="line_dashed"> </li>

				<li class="title_b">
					<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=group&act_get=form&group_id={$tplData.groupRow.group_id}">{$lang.href.edit}</a>
				</li>
			</ol>

			<ul>
				<li class="title">{$lang.label.groupName}</li>
				<li class="title_b">{$tplData.groupRow.group_name}</li>

				<li class="title">{$lang.label.groupAllow}</li>
				<li class="title">
					<ol>
						{foreach $adminMod as $key_m=>$value_m}
							<li class="title">{$value_m.main.title}</li>
							<li class="field">
								{foreach $value_m.allow as $key_s=>$value_s}
									<img src="{$smarty.const.BG_URL_IMAGE}allow_{if $tplData.groupRow.group_allow[$key_m][$key_s] == 1}y{else}x{/if}.png" />
									<label for="allow_{$key_m}_{$key_s}">{$value_s}</label>
								{/foreach}
							</li>
						{/foreach}
					</ol>
				</li>

				<li class="title">{$lang.label.groupNote}</li>
				<li class="title_b">{$tplData.groupRow.group_note}</li>

				<li class="title_b">
					<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=group&act_get=form&group_id={$tplData.groupRow.group_id}">{$lang.href.edit}</a>
				</li>

			</ul>
		</div>

	</form>

{include "include/admin_foot.tpl" cfg=$cfg}

{include "include/html_foot.tpl" cfg=$cfg}
