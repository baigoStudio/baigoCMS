{* app_form.tpl 管理员编辑界面 *}
{if $tplData.appRow.app_id == 0}
	{$str_titleSub = $lang.page.add}
	{$str_sub = "form"}
{else}
	{$str_titleSub = $lang.page.edit}
	{$str_sub = "list"}
{/if}

{$cfg = [
	title          => "{$adminMod.app.main.title} - {$str_titleSub}",
	css            => "admin_form",
	menu_active    => "app",
	sub_active     => $str_sub,
	baigoCheckall  => "true",
	colorbox       => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=app"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<form name="app_form" id="app_form" class="tform">

		<input type="hidden" name="token_session" value="{$common.token_session}" />
		<input type="hidden" name="act_post" value="submit" />
		<input type="hidden" name="app_id" value="{$tplData.appRow.app_id}" />

		<div>
			<ol>
				{if $tplData.appRow.app_id > 0}
					<li class="title_b">{$lang.label.id}: {$tplData.appRow.app_id}</li>
					<li class="line_dashed"> </li>
				{/if}

				<li class="title">{$lang.label.status}<span id="msg_app_status">*</span></li>
				<li>
					{foreach $status.app as $key=>$value}
						<input type="radio" name="app_status" id="app_status_{$key}" value="{$key}" class="validate" {if $tplData.appRow.app_status == $key}checked="checked"{/if} group="app_status" />
						<label for="app_status_{$key}">{$value}</label>
					{/foreach}
				</li>

				<li class="line_dashed"></li>

				<li class="title">{$lang.label.sync}<span id="msg_app_sync">*</span></li>
				<li>
					{foreach $status.appSync as $key=>$value}
						<input type="radio" name="app_sync" id="app_sync_{$key}" value="{$key}" class="validate" {if $tplData.appRow.app_sync == $key}checked="checked"{/if} group="app_sync" />
						<label for="app_sync_{$key}">{$value}</label>
					{/foreach}
				</li>

				<li class="line_dashed"></li>

				<li><button type="button" class="go_form">{$lang.btn.submit}</button></li>
			</ol>

			<ul>
				<li class="title">{$lang.label.appName}<span id="msg_app_name">*</span></li>
				<li class="field">
					<input type="text" name="app_name" id="app_name" value="{$tplData.appRow.app_name}" class="validate short" />
				</li>

				<li class="title">{$lang.label.appNotice}<span id="msg_app_notice">*</span></li>
				<li class="field">
					<input type="text" name="app_notice" id="app_notice" value="{$tplData.appRow.app_notice}" class="validate" />
				</li>

				<li class="title">{$lang.label.allow}<span id="msg_app_allow">*</span></li>
				<li class="field">
					<ol>
						<li class="field">
							<input type="checkbox" id="chk_all" class="first" />
							<label for="chk_all">{$lang.label.all}</label>
						</li>

						{foreach $allow as $key_m=>$value_m}
							<li class="title">{$value_m.title}</li>
							<li class="field">
								<input type="checkbox" id="allow_{$key_m}" class="chk_all" />
								<label for="allow_{$key_m}">{$lang.label.all}</label>
								{foreach $value_m.allow as $key_s=>$value_s}
									<input type="checkbox" name="app_allow[{$key_m}][{$key_s}]" value="1" id="allow_{$key_m}_{$key_s}" class="allow_{$key_m}" {if $tplData.appRow.app_allow[$key_m][$key_s] == 1}checked="checked"{/if} />
									<label for="allow_{$key_m}_{$key_s}">{$value_s}</label>
								{/foreach}
							</li>
						{/foreach}
					</ol>
				</li>

				<li class="title">{$lang.label.ipAllow}<span id="msg_app_ip_allow"></span></li>
				<li class="field">
					<textarea name="app_ip_allow" id="app_ip_allow" class="validate narrow">{$tplData.appRow.app_ip_allow}</textarea>
				</li>

				<li class="title">{$lang.label.ipBad}<span id="msg_app_ip_bad"></span></li>
				<li class="field">
					<textarea name="app_ip_bad" id="app_ip_bad" class="validate narrow">{$tplData.appRow.app_ip_bad}</textarea>
				</li>

				<li class="title">{$lang.label.note}<span id="msg_app_note"></span></li>
				<li class="field">
					<input type="text" name="app_note" id="app_note" value="{$tplData.appRow.app_note}" class="validate short" />
				</li>

				<li><button type="button" class="go_form">{$lang.btn.submit}</button></li>
			</ul>
		</div>
	</form>

{include "include/admin_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_form = {
	app_name: {
		length: { min: 1, max: 30 },
		validate: { type: "str", format: "text" },
		msg: { id: "msg_app_name", too_short: "{$alert.x050201}", too_long: "{$alert.x050202}" },
	},
	app_notice: {
		length: { min: 1, max: 3000 },
		validate: { type: "str", format: "url" },
		msg: { id: "msg_app_notice", too_short: "{$alert.x050207}", too_long: "{$alert.x050208}", format_err: "{$alert.x050209}" },
	},
	app_ip_allow: {
		length: { min: 0, max: 3000 },
		validate: { type: "str", format: "text" },
		msg: { id: "msg_app_ip_allow", too_long: "{$alert.x050210}" }
	},
	app_ip_bad: {
		length: { min: 0, max: 3000 },
		validate: { type: "str", format: "text" },
		msg: { id: "msg_app_ip_bad", too_long: "{$alert.x050211}" }
	},
	app_note: {
		length: { min: 0, max: 30 },
		validate: { type: "str", format: "text" },
		msg: { id: "msg_app_note", too_long: "{$alert.x050205}" },
	},
	app_status: {
		length: { min: 1, max: 0 },
		validate: { type: "radio" },
		msg: { id: "msg_app_status", too_few: "{$alert.x050206}" }
	},
	app_sync: {
		length: { min: 1, max: 0 },
		validate: { type: "radio" },
		msg: { id: "msg_app_sync", too_few: "{$alert.x050218}" }
	}
};
var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=app", btn_text: "{$lang.btn.ok}", btn_url: "{$cfg.str_url}" };

$(document).ready(function(){
	var obj_validator_form = $("#app_form").baigoValidator(opts_validator_form);
	var obj_submit_form = $("#app_form").baigoSubmit(opts_submit_form);
	$(".go_form").click(function(){
		if (obj_validator_form.validateSubmit()) {
			obj_submit_form.formSubmit();
		}
	});
	$("#app_form").baigoCheckall();
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}
