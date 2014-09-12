{* install_1.tpl 登录界面 *}
{$cfg = [
	sub_title => $lang.page.installAdmin,
	mod_help   => "install",
	act_help   => "admin#auth"
]}
{include "include/install_head.tpl" cfg=$cfg}

	<form name="install_form_admin" id="install_form_admin" autocomplete="off">
		<input type="hidden" name="token_session" value="{$common.token_session}">
		<input type="hidden" name="act_post" value="auth">
		<input type="hidden" name="admin_status" value="enable">

		<div class="alert alert-warning">
			<h4>
				<span class="glyphicon glyphicon-warning-sign"></span>
				{$lang.text.installAuth}
			</h4>
		</div>

		<div class="form-group">
			<label for="admin_name" class="control-label">{$lang.label.username}<span id="msg_admin_name">*</span></label>
			<input type="text" name="admin_name" id="admin_name" class="validate form-control input-lg">
		</div>

		<div class="form-group">
			<label for="admin_pass" class="control-label">{$lang.label.password}<span id="msg_admin_pass">*</span></label>
			<input type="password" name="admin_pass" id="admin_pass" class="validate form-control input-lg">
		</div>

		<div class="form-group">
			<div class="btn-group">
				<button type="button" id="go_next" class="btn btn-primary btn-lg">{$lang.btn.complete}</button>
				{include "include/install_drop.tpl" cfg=$cfg}
			</div>
		</div>
	</form>


{include "include/install_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_form = {
		admin_name: {
			length: { min: 1, max: 30 },
			validate: { type: "ajax", format: "strDigit" },
			msg: { id: "msg_admin_name", too_short: "{$alert.x020201}", too_long: "{$alert.x020202}", format_err: "{$alert.x020203}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
			ajax: { url: "{$smarty.const.BG_URL_INSTALL}ajax.php?mod=install&act_get=chkauth", key: "admin_name", type: "str" }
		},
		admin_pass: {
			length: { min: 1, max: 0 },
			validate: { type: "str", format: "text" },
			msg: { id: "msg_admin_pass", too_short: "{$alert.x020210}" }
		}
	};
	var opts_submit_form = {
		ajax_url: "{$smarty.const.BG_URL_INSTALL}ajax.php?mod=install",
		btn_text: "{$lang.btn.installNext}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$smarty.const.BG_URL_INSTALL}ctl.php?mod=install&act_get=over"
	};

	$(document).ready(function(){
		var obj_validator_form = $("#install_form_admin").baigoValidator(opts_validator_form);
		var obj_submit_form = $("#install_form_admin").baigoSubmit(opts_submit_form);
		$("#go_next").click(function(){
			if (obj_validator_form.validateSubmit()) {
				obj_submit_form.formSubmit();
			}
		});
	})
	</script>

</html>