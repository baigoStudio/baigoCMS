{* admin_toGroupForm.tpl 加入组界面 *}
{$cfg = [
	title          => $lang.page.admin,
	css            => "admin_iframe",
	baigoValidator => "true",
	baigoSubmit    => "true",
	colorbox       => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=admin"
]}

{include "include/iframe_head.tpl" cfg=$cfg}

	<h1>{$adminMod.admin.main.title} - {$lang.href.toGroup}</h1>

	<form name="admin_form" id="admin_form">

		<input type="hidden" name="token_session" value="{$common.token_session}" />
		<input type="hidden" name="act_post" value="toGroup" />
		<input type="hidden" name="admin_id" value="{$tplData.adminRow.admin_id}" />

		<ul>
			<li class="title">{$lang.label.username}</li>
			<li class="title_b">{$tplData.adminRow.userRow.user_name}</li>

			<li class="title">{$lang.label.adminGroup}<span id="msg_group_id">*</span></li>
			<li class="field">
				<select name="group_id" id="group_id" class="validate">
					<option value="">{$lang.option.pleaseSelect}</option>
					<option {if $tplData.adminRow.admin_group_id == 0}selected="selected"{/if} value="0">{$lang.option.noGroup}</option>
					{foreach $tplData.groupRows as $value}
						<option {if $tplData.adminRow.admin_group_id == $value.group_id}selected="selected"{/if} value="{$value.group_id}">{$value.group_name}</option>
					{/foreach}
				</select>
			</li>

			<li><button type="button" id="go_submit">{$lang.btn.submit}</button></li>
		</ul>

	</form>

{include "include/iframe_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_form = {
	group_id: {
		length: { min: 1, max: 0 },
		validate: { type: "select" },
		msg: { id: "msg_group_id", too_few: "{$alert.x020214}" }
	}
};
var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=admin", btn_text: "{$lang.btn.ok}", btn_url: "{$cfg.str_url}" };

$(document).ready(function(){
	var obj_validate_form = $("#admin_form").baigoValidator(opts_validator_form);
	var obj_submit_form = $("#admin_form").baigoSubmit(opts_submit_form);
	$("#go_submit").click(function(){
		if (obj_validate_form.validateSubmit()) {
			obj_submit_form.formSubmit();
		}
	});
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}
