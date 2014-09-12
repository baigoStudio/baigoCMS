{* install_1.tpl 登录界面 *}
{$cfg = [
	sub_title  => $lang.page.installBase,
	sub_active => "base",
	mod_help   => "upgrade",
	act_help   => "base"
]}

{include "include/upgrade_head.tpl" cfg=$cfg}

	<form name="install_form_base" id="install_form_base">
		<input type="hidden" name="token_session" value="{$common.token_session}">
		<input type="hidden" name="act_post" value="base">

		{include "include/install_form.tpl" cfg=$cfg}

		<div class="form-group">
			<label for="opt_BG_SITE_TPL" class="control-label">{$lang.label.tpl}<span id="msg_BG_SITE_TPL">*</span></label>
			<select name="opt[BG_SITE_TPL]" id="opt_BG_SITE_TPL" class="validate form-control input-lg">
				{foreach $tplData.tplRows as $key=>$value}
					{if $value["type"] == "dir"}
					<option {if $tplData.optRows.BG_SITE_TPL.opt_value == $value.name}selected{/if} value="{$value.name}">{$value.name}</option>
					{/if}
				{/foreach}
			</select>
		</div>

		<div class="form-group">
			<div class="btn-group">
				<button type="button" id="go_next" class="btn btn-primary btn-lg">{$lang.btn.save}</button>
				{include "include/upgrade_drop.tpl" cfg=$cfg}
			</div>
		</div>
	</form>

{include "include/install_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_form = {
		{foreach $opt["base"] as $key=>$value}
			{if $value.type == "str" || $value.type == "textarea"}
				{$str_msg_min = "too_short"}
				{$str_msg_max = "too_long"}
			{else}
				{$str_msg_min = "too_few"}
				{$str_msg_max = "too_many"}
			{/if}
			"opt_{$key}": {
				length: { min: {$value.min}, max: 900 },
				validate: { type: "{$value.type}", format: "{$value.format}" },
				msg: { id: "msg_{$key}", {$str_msg_min}: "{$alert.x060201}{$value.label}", {$str_msg_max}: "{$value.label}{$alert.x060202}", format_err: "{$value.label}{$alert.x060203}" }
			},
		{/foreach}
		"opt_BG_SITE_TPL": {
			length: { min: 1, max: 900 },
			validate: { type: "select" },
			msg: { id: "msg_BG_SITE_TPL", too_few: "{$alert.x060201}{$lang.label.tpl}" }
		}
	};

	var opts_submit_form = {
		ajax_url: "{$smarty.const.BG_URL_INSTALL}ajax.php?mod=upgrade",
		btn_text: "{$lang.btn.installNext}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$smarty.const.BG_URL_INSTALL}ctl.php?mod=upgrade&act_get=visit"
	};

	$(document).ready(function(){
		var obj_validator_form = $("#install_form_base").baigoValidator(opts_validator_form);
		var obj_submit_form = $("#install_form_base").baigoSubmit(opts_submit_form);
		$("#go_next").click(function(){
			if (obj_validator_form.validateSubmit()) {
				obj_submit_form.formSubmit();
			}
		});
	})
	</script>

</html>
