{* opt_form.tpl 系统设置界面 *}
{$cfg = [
	title          => $lang.page.admin,
	css            => "admin",
	menu_active    => "opt",
	sub_active     => "mail",
	colorbox       => "true",
	baigoValidator       => "true",
	baigoSubmit    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=opt&act_get=mail"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<h1>{$adminMod.opt.main.title} - {$adminMod.opt.sub.mail.title}</h1>

	<form name="opt_form" id="opt_form">

		<input type="hidden" name="token_session" value="{$common.token_session}" />
		<input type="hidden" name="act_post" value="mail" />

		<ul>
			{foreach $opt["mail"] as $key=>$value}
				{if $tplData.optRows[$key].opt_value}
					{$_this_value = $tplData.optRows[$key].opt_value}
				{else}
					{$_this_value = $value.default}
				{/if}
				<li>{$value.label} {$value.note}<span id="msg_{$key}">{if $value.min > 0}*{/if}</span></li>
				<li>
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
						<textarea name="opt[{$key}]" id="{$key}" class="validate narrow">{$_this_value}</textarea>
					{else}
						<input type="text" value="{$_this_value}" name="opt[{$key}]" id="{$key}" class="validate" />
					{/if}
				</li>
			{/foreach}
			<li><button type="button" id="go_form">{$lang.btn.submit}</button></li>
		</ul>

		<div class="float_clear"></div>

	</form>

{include "include/admin_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_form = {
	{foreach $opt["mail"] as $key=>$value}
	"{$key}": {
		length: { min: {$value.min}, max: 900 },
		validate: { type: "{$value.type}", format: "{$value.format}" },
		msg: { id: "msg_{$key}", too_short: "{$alert.x040201}{$value.label}", too_long: "{$value.label}{$alert.x040502}" }
	},
	{/foreach}
};
var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=opt", btn_text: "{$lang.btn.ok}", btn_url: "{$cfg.str_url}" };

$(document).ready(function(){
	var obj_validator_form = $("#opt_form").baigoValidator(opts_validator_form);
	var obj_submit_form = $("#opt_form").baigoSubmit(opts_submit_form);
	$("#go_form").click(function(){
		if (obj_validator_form.validateSubmit()) {
			obj_submit_form.formSubmit();
		}
	});
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}
