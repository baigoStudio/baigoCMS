{* admin_groupForm.tpl 管理组编辑界面 *}
{if $smarty.get.group_id == 0}
	{$title_sub = $lang.page.add}
	{$sub_active = "form"}
{else}
	{$title_sub = $lang.page.edit}
	{$sub_active = "list"}
{/if}

{$cfg = [
	title          => "{$adminMod.group.main.title} - {$title_sub}",
	css            => "admin_form",
	menu_active    => "group",
	sub_active     => $sub_active,
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	colorbox       => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=group"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<form name="group_form" id="group_form" class="tform">

		<input type="hidden" name="token_session" value="{$common.token_session}" />
		<input type="hidden" name="act_post" value="submit" />
		<input type="hidden" name="group_id" value="{$tplData.groupRow.group_id}" />

		<div>

			<ol>
				{if $tplData.groupRow.group_id > 0}
					<li class="title_b">{$lang.label.id}: {$tplData.groupRow.group_id}</li>
					<li class="line_dashed"> </li>
				{/if}

				<li class="title">{$lang.label.groupType}<span id="msg_group_type">*</span></li>
				<li>
					{foreach $type.group as $key=>$value}
						<input type="radio" name="group_type" id="group_type_{$key}" {if $tplData.groupRow.group_type == $key}checked="checked"{/if} value="{$key}" class="validate" group="group_type" />
						<label for="group_type_{$key}">{$value}</label>
					{/foreach}
				</li>

				<li class="line_dashed"> </li>

				<li><button type="button" class="go_submit">{$lang.btn.submit}</button></li>
			</ol>

			<ul>
				<li class="title">{$lang.label.groupName}<span id="msg_group_name">*</span></li>
				<li class="field">
					<input type="text" name="group_name" id="group_name" value="{$tplData.groupRow.group_name}" class="validate middle" />
				</li>

				<li class="title">{$lang.label.groupAllow}<span id="msg_group_allow">*</span></li>
				<li class="field groupAdmin">
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
									<input type="checkbox" name="group_allow[{$key_m}][{$key_s}]" value="1" id="allow_{$key_m}_{$key_s}" {if $tplData.groupRow.group_allow[$key_m][$key_s] == 1}checked="checked"{/if} class="allow_{$key_m}" group="group_allow" />
									<label for="allow_{$key_m}_{$key_s}">{$value_s}</label>
								{/foreach}
							</li>
						{/foreach}
					</ol>
				</li>

				<li class="title">{$lang.label.groupNote}<span id="msg_group_note">*</span></li>
				<li class="field">
					<input type="text" name="group_note" id="group_note" value="{$tplData.groupRow.group_note}" class="validate middle" />
				</li>

				<li><button type="button" class="go_submit">{$lang.btn.submit}</button></li>
			</ul>

		</div>

	</form>

{include "include/admin_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_form = {
	group_name: {
		length: { min: 1, max: 30 },
		validate: { type: "ajax", format: "text" },
		msg: { id: "msg_group_name", too_short: "{$alert.x040201}", too_long: "{$alert.x040202}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
		ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=group&act_get=chkname", key: "group_name", type: "str", attach: "group_id={$tplData.groupRow.group_id}" }
	},
	group_note: {
		length: { min: 0, max: 30 },
		validate: { type: "str", format: "text" },
		msg: { id: "msg_group_note", too_long: "{$alert.x040204}" }
	},
	group_type: {
		length: { min: 1, max: 0 },
		validate: { type: "radio" },
		msg: { id: "msg_group_type", too_few: "{$alert.x040205}" }
	}
};
var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=group", btn_text: "{$lang.btn.ok}", btn_url: "{$cfg.str_url}" };

function group_type(group_type) {
	switch (group_type) {
		case "admin":
			$(".groupAdmin").show();
			$(".groupUser").hide();
		break;

		default:
			$(".groupAdmin").hide();
			$(".groupUser").show();
		break;
	}
}

$(document).ready(function(){
	var obj_validate_form = $("#group_form").baigoValidator(opts_validator_form);
	var obj_submit_form = $("#group_form").baigoSubmit(opts_submit_form);
	$(".go_submit").click(function(){
		if (obj_validate_form.validateSubmit()) {
			obj_submit_form.formSubmit();
		}
	});
	group_type("{$tplData.groupRow.group_type}");
	$("[name='group_type']").click(function(){
		var _group_type = $("[name='group_type']:checked").val();
		group_type(_group_type);
	});
	$("#group_form").baigoCheckall();
});
</script>

{include "include/html_foot.tpl" cfg=$cfg}

