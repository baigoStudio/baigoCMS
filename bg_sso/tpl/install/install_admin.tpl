{* install_1.tpl 登录界面 *}

{include "include/install_head.tpl" cfg=$cfg}

	<div class="page_head">
		{$lang.page.installStep}
		&raquo;
		{$lang.page.installAdmin}
	</div>

	<div class="page_body">
		<form name="instal_form_admin" id="instal_form_admin">
			<input type="hidden" name="token_session" value="{$common.token_session}" />
			<input type="hidden" name="act_post" value="admin">
			<input type="hidden" name="admin_status" value="enable">

			{foreach $adminMod as $key_m=>$value_m}
				{foreach $value_m.allow as $key_s=>$value_s}
					<input type="hidden" name="admin_allow[{$key_m}][{$key_s}]" value="1" />
				{/foreach}
			{/foreach}

			<ul>
				<li class="title">{$lang.label.username}<span id="msg_admin_name">*</span></li>
				<li class="field">
					<input type="text" name="admin_name" id="admin_name" class="validate" />
				</li>

				<li class="title">{$lang.label.password}<span id="msg_admin_pass">*</span></li>
				<li class="field">
					<input type="password" name="admin_pass" id="admin_pass" class="validate" />
				</li>

				<li class="title">{$lang.label.passwordConfirm}<span id="msg_admin_pass_confirm">*</span></li>
				<li class="field">
					<input type="password" name="admin_pass_confirm" id="admin_pass_confirm" class="validate" />
				</li>

				<li class="title">{$lang.label.note}<span id="msg_admin_note">*</span></li>
				<li class="field">
					<input type="text" name="admin_note" id="admin_note" value="{$tplData.adminRow.admin_note}" class="validate" />
				</li>

				<li class="line_dashed"> </li>

				<li>
					<button type="button" id="go_pre" class="float_left">{$lang.btn.installPre}</button>
					<button type="button" id="go_next" class="float_right">{$lang.btn.submit}</button>
				</li>
			<ul>
		</form>
	</div>

{include "include/install_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_form = {
		admin_name: {
			length: { min: 1, max: 30 },
			validate: { type: "text", format: "strDigit" },
			msg: { id: "msg_admin_name", too_short: "{$alert.x020201}", too_long: "{$alert.x020202}", format_err: "{$alert.x020203}" },
		},
		admin_pass: {
			length: { min: 1, max: 0 },
			validate: { type: "str", format: "text" },
			msg: { id: "msg_admin_pass", too_short: "{$alert.x020205}" }
		},
		admin_pass_confirm: {
			length: { min: 1, max: 0 },
			validate: { type: "str", format: "text" },
			msg: { id: "msg_admin_pass_confirm", too_short: "{$alert.x020211}" }
		},
		admin_note: {
			length: { min: 1, max: 30 },
			validate: { type: "str", format: "text" },
			msg: { id: "msg_admin_note", too_short: "{$alert.x020210}" }
		}
	};
	var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_INSATLL}ajax.php?mod=install", btn_text: "{$lang.btn.login}", btn_url: "{$smarty.const.BG_URL_ADMIN}admin.php" };

	$(document).ready(function(){
		var obj_validator_form = $("#instal_form_admin").baigoValidator(opts_validator_form);
		var obj_submit_form = $("#instal_form_admin").baigoSubmit(opts_submit_form);
		$("#go_pre").click(function(){
			window.location.href = "{$smarty.const.BG_URL_INSATLL}install.php?mod=install&act_get=reg";
		});
		$("#go_skip").click(function(){
			window.location.href = "{$smarty.const.BG_URL_INSTALL}install.php?mod=install&act_get=visit";
		});
		$("#go_next").click(function(){
			if (obj_validator_form.validateSubmit()) {
				obj_submit_form.formSubmit();
			}
		});
	})
	</script>

</html>