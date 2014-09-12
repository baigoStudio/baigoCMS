<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	{$adminMod.admin.main.title} - {$lang.href.toGroup}
</div>
<div class="modal-body">

	<form name="admin_form" id="admin_form">

		<input type="hidden" name="token_session" value="{$common.token_session}">
		<input type="hidden" name="act_post" value="toGroup">
		<input type="hidden" name="admin_id" value="{$tplData.adminRow.admin_id}">

		<div class="form-group">
			<label class="control-label">{$lang.label.id}</label>
			<p class="form-control-static">{$tplData.adminRow.admin_id}</p>
		</div>

		<div class="form-group">
			<label class="control-label">{$lang.label.username}</label>
			<p class="form-control-static">{$tplData.adminRow.userRow.user_name}</p>
		</div>

		<div class="form-group">
			<label class="control-label">{$lang.label.adminGroup}<span id="msg_group_id">*</span></label>
			<select name="group_id" id="group_id" class="validate form-control">
				<option value="">{$lang.option.pleaseSelect}</option>
				<option {if $tplData.adminRow.admin_group_id == 0}selected{/if} value="0">{$lang.option.noGroup}</option>
				{foreach $tplData.groupRows as $value}
					<option {if $tplData.adminRow.admin_group_id == $value.group_id}selected{/if} value="{$value.group_id}">{$value.group_name}</option>
				{/foreach}
			</select>
		</div>

	</form>

</div>
<div class="modal-footer">
	<button type="button" class="btn btn-primary" id="go_save">{$lang.btn.save}</button>
	<button type="button" class="btn btn-default" data-dismiss="modal">{$lang.btn.cancel}</button>
</div>

<script type="text/javascript">
var opts_validator_form = {
	group_id: {
		length: { min: 1, max: 0 },
		validate: { type: "select" },
		msg: { id: "msg_group_id", too_few: "{$alert.x020214}" }
	}
};

var opts_submit_form = {
	ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=admin",
	btn_text: "{$lang.btn.ok}",
	btn_close: "{$lang.btn.close}",
	btn_url: "{$cfg.str_url}"
};

$(document).ready(function(){
	var obj_validate_form = $("#admin_form").baigoValidator(opts_validator_form);
	var obj_submit_form = $("#admin_form").baigoSubmit(opts_submit_form);
	$("#go_save").click(function(){
		if (obj_validate_form.validateSubmit()) {
			obj_submit_form.formSubmit();
		}
	});
})
</script>