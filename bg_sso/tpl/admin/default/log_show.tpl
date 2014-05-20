{* admin_form.tpl 管理员编辑界面 *}
{$cfg = [
	title          => "{$adminMod.log.main.title} - {$lang.page.detail}",
	css            => "admin_form",
	menu_active    => "log",
	sub_active     => "list"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<form class="tform">
		<div>
			<ol>
				<li class="title_b">{$lang.label.id}: {$tplData.logRow.log_id}</li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.status}</li>
				<li>
					<img src="{$smarty.const.BG_URL_IMAGE}allow_{if $tplData.logRow.log_status == "read"}y{else}x{/if}.png" />
					<label>{$status.log[$tplData.logRow.log_status]}</label>
				</li>
			</ol>

			<ul>
				<li class="title">{$lang.label.content}</li>
				<li class="title_b">{$tplData.logRow.log_title}</li>

				<li class="title">{$lang.label.target}</li>
				<li class="title_b">
					{foreach $tplData.logRow.log_targets as $_key=>$_value}
						<div>
							{if $tplData.logRow.log_target_type == "opt"}
								{$type.logTarget[$tplData.logRow.log_target_type]}: {$_value.target_name}
							{else}
								<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod={$tplData.logRow.log_target_type}&act_get=show&{$tplData.logRow.log_target_type}_id={$_value.target_id}">
									{$type.logTarget[$tplData.logRow.log_target_type]}: {$_value.target_name} [ {$lang.label.id}: {$_value.target_id} ]
								</a>
							{/if}
						</div>
					{/foreach}
				</li>

				<li class="title">{$lang.label.type}</li>
				<li class="title_b">{$type.log[$tplData.logRow.log_type]}</li>

				<li class="title">{$lang.label.operator}</li>
				<li class="title_b">
					{if $tplData.logRow.log_type != "system"}
						<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod={$tplData.logRow.log_type}&act_get=show&{$tplData.logRow.log_type}_id={$tplData.logRow.log_operator_id}">{$tplData.logRow.log_operator_name}</a>
					{/if}
				</li>

				<li class="title">{$lang.label.result}</li>
				<li class="title_b">
					{$tplData.logRow.log_result|@debug_print_var}
				</li>
			</ul>
		</div>
	</form>

{include "include/admin_foot.tpl" cfg=$cfg}

{include "include/html_foot.tpl" cfg=$cfg}
