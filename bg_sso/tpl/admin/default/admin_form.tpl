{* admin_form.tpl 管理员编辑界面 *}
{if $tplData.adminRow.admin_id == 0}
	{$str_titleSub = $lang.page.add}
	{$str_sub = "form"}
{else}
	{$str_titleSub = $lang.page.edit}
	{$str_sub = "list"}
{/if}

{$cfg = [
	title          => "{$adminMod.admin.main.title} - {$str_titleSub}",
	css            => "admin_form",
	menu_active    => "admin",
	sub_active     => $str_sub,
	baigoCheckall  => "true",
	colorbox       => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=admin"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<form name="admin_form" id="admin_form" class="tform" autocomplete="off">

		<input type="hidden" name="token_session" value="{$common.token_session}" />
		<input type="hidden" name="act_post" value="submit" />
		<input type="hidden" name="admin_id" value="{$tplData.adminRow.admin_id}" />

		<div>
			<ol>
				<li class="title">{$lang.label.status}<span id="msg_admin_status">*</span></li>
				<li>
					{foreach $status.admin as $key=>$value}
						<input type="radio" name="admin_status" id="admin_status_{$key}" value="{$key}" class="validate" {if $tplData.adminRow.admin_status == $key}checked="checked"{/if} group="admin_status" />
						<label for="admin_status_{$key}">{$value}</label>
					{/foreach}
				</li>

				<li class="line_dashed"> </li>

				<li><button type="button" class="go_form">{$lang.btn.submit}</button></li>
			</ol>

			<ul>
				<li class="title">{$lang.label.username}{if $tplData.adminRow.admin_id == 0}<span id="msg_admin_name">*</span>{/if}</li>
				<li class="field">
					<input type="text" name="admin_name" id="admin_name" value="{$tplData.adminRow.admin_name}" {if $tplData.adminRow.admin_id == 0}class="validate short"{else}readonly="readonly" class="short"{/if} />
				</li>

				<li class="title">{$lang.label.password}{if $tplData.adminRow.admin_id == 0}<span id="msg_admin_pass">*</span>{else}{$lang.label.onlymodi}{/if}</li>
				<li class="field">
					<input type="text" name="admin_pass" id="admin_pass" {if $tplData.adminRow.admin_id == 0}class="validate short"{else}class="short"{/if} />
				</li>

				<li class="title">{$lang.label.allow}<span id="msg_admin_allow">*</span></li>
				<li class="field">
					<ol>
						<li class="field">
							<input type="checkbox" id="chk_all" class="first" />
							<label for="chk_all">{$lang.label.all}</label>
						</li>

						{foreach $adminMod as $key_m=>$value_m}
							<li class="title">{$value_m.main.title}</li>
							<li class="field">
								<input type="checkbox" id="allow_{$key_m}" class="chk_all" />
								<label for="allow_{$key_m}">{$lang.label.all}</label>
								{foreach $value_m.allow as $key_s=>$value_s}
									<input type="checkbox" name="admin_allow[{$key_m}][{$key_s}]" value="1" id="allow_{$key_m}_{$key_s}" class="allow_{$key_m}" {if $tplData.adminRow.admin_allow[$key_m][$key_s] == 1}checked="checked"{/if} />
									<label for="allow_{$key_m}_{$key_s}">{$value_s}</label>
								{/foreach}
							</li>
						{/foreach}
					</ol>
				</li>

				<li class="title">{$lang.label.note}<span id="msg_admin_note">*</span></li>
				<li class="field">
					<input type="text" name="admin_note" id="admin_note" value="{$tplData.adminRow.admin_note}" class="validate" />
				</li>

				<li><button type="button" class="go_form">{$lang.btn.submit}</button></li>
			</ul>
		</div>

	</form>

{include "include/admin_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_form = {
	admin_name: {
		length: { min: 1, max: 30 },
		validate: { type: "ajax", format: "strDigit" },
		msg: { id: "msg_admin_name", too_short: "{$alert.x020201}", too_long: "{$alert.x020202}", format_err: "{$alert.x020203}" },
		ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=admin&act_get=chkname", key: "admin_name", type: "str", attach: "admin_id={$tplData.adminRow.admin_id}" }
	},
	admin_pass: {
		length: { min: 1, max: 0 },
		validate: { type: "str", format: "text" },
		msg: { id: "msg_admin_pass", too_short: "{$alert.x020205}" }
	},
	admin_note: {
		length: { min: 0, max: 30 },
		validate: { type: "str", format: "text" },
		msg: { id: "msg_admin_note", too_long: "{$alert.x020208}" }
	},
	admin_status: {
		length: { min: 1, max: 0 },
		validate: { type: "radio" },
		msg: { id: "msg_admin_status", too_few: "{$alert.x020209}" }
	}
};
var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=admin", btn_text: "{$lang.btn.ok}", btn_url: "{$cfg.str_url}" };

$(document).ready(function(){
	var obj_validator_form = $("#admin_form").baigoValidator(opts_validator_form);
	var obj_submit_form = $("#admin_form").baigoSubmit(opts_submit_form);
	$(".go_form").click(function(){
		if (obj_validator_form.validateSubmit()) {
			obj_submit_form.formSubmit();
		}
	});
	$("#admin_form").baigoCheckall();
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}
