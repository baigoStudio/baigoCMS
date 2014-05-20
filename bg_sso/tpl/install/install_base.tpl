{* install_1.tpl 登录界面 *}

{include "include/install_head.tpl" cfg=$cfg}

	<div class="page_head">
		{$lang.page.installStep}
		&raquo;
		{$lang.page.installBase}
	</div>

	<div class="page_body">
		<form name="instal_form_base" id="instal_form_base">
			<input type="hidden" name="act_post" value="base">
			<ul>
				{foreach $opt["base"] as $key=>$value}
					{if $tplData.optRows[$key].opt_value}
						{$_this_value = $tplData.optRows[$key].opt_value}
					{else}
						{$_this_value = $value.default}
					{/if}
					<li class="title">{$value.label} {$value.note}<span id="msg_{$key}">{if $value.min > 0}*{/if}</span></li>
					<li class="field">
						{if $value.type == "select"}
							<select name="opt[{$key}]" id="{$key}" class="validate">
								{foreach $value.option as $_key=>$_value}
								<option {if $_this_value == $_key}selected="selected"{/if} value="{$_key}">{$_value}</option>
								{/foreach}
							</select>
						{else if $value.type == "radio"}
							{foreach $value.option as $_key=>$_value}
								<input type="radio" {if $_this_value == $_key}checked="checked"{/if} value="{$_key}" name="opt[{$key}]" id="{$key}_{$_key}" />
								<label for="{$key}_{$_key}">{$_value}</label>
							{/foreach}
						{else if $value.type == "textarea"}
							<textarea name="opt[{$key}]" id="{$key}" class="validate">{$_this_value}</textarea>
						{else}
							<input type="text" value="{$_this_value}" name="opt[{$key}]" id="{$key}" class="validate" />
						{/if}
					</li>
				{/foreach}

				<li class="line_dashed"> </li>

				<li>
					<button type="button" id="go_pre" class="float_left">{$lang.btn.installPre}</button>
					<button type="button" id="go_skip" class="float_left">{$lang.btn.skip}</button>
					<button type="button" id="go_next" class="float_right">{$lang.btn.submit}</button>
				</li>
			<ul>
		</form>
	</div>

{include "include/install_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_form = {
		{foreach $opt["base"] as $key=>$value}
		"{$key}": {
			length: { min: {$value.min}, max: 900 },
			validate: { type: "{$value.type}", format: "{$value.format}" },
			msg: { id: "msg_{$key}", too_short: "{$alert.x040201}{$value.label}", too_long: "{$value.label}{$alert.x040202}" }
		}{if !$value@last},{/if}
		{/foreach}
	};
	var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_INSATLL}ajax.php?mod=install", btn_text: "{$lang.btn.installNext}", btn_url: "{$smarty.const.BG_URL_INSATLL}install.php?mod=install&act_get=reg" };

	$(document).ready(function(){
		var obj_validator_form = $("#instal_form_base").baigoValidator(opts_validator_form);
		var obj_submit_form = $("#instal_form_base").baigoSubmit(opts_submit_form);
		$("#go_pre").click(function(){
			window.location.href = "{$smarty.const.BG_URL_INSATLL}install.php?mod=install&act_get=dbtable";
		});
		$("#go_skip").click(function(){
			window.location.href = "{$smarty.const.BG_URL_INSTALL}install.php?mod=install&act_get=reg";
		});
		$("#go_next").click(function(){
			if (obj_validator_form.validateSubmit()) {
				obj_submit_form.formSubmit();
			}
		});
	})
	</script>

</html>
