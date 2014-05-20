{* admin_my.tpl 管理员编辑界面 *}
{$cfg = [
	title          => $lang.page.adminMy,
	css            => "admin_form",
	colorbox       => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=admin&act_get=my"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<form name="admin_my" id="admin_my" autocomplete="off" class="tform">

		<input type="hidden" name="token_session" value="{$common.token_session}" />
		<input type="hidden" name="act_post" value="my" />

		<div>
			<ol>
				<li class="title_b">
					{$lang.label.id}: {$tplData.adminLogged.admin_id}
				</li>
				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.status}</li>
				<li>
					<img src="{$smarty.const.BG_URL_IMAGE}allow_{if $tplData.adminLogged.admin_status == "enable"}y{else}x{/if}.png" />
					<label>{$status.admin[$tplData.adminLogged.admin_status]}</label>
				</li>
			</ol>

			<ul>
				<li class="title">{$lang.label.username}</li>
				<li class="field">
					<input type="text" name="admin_name" id="admin_name" value="{$tplData.adminLogged.admin_name}" readonly="readonly" class="short" />
				</li>

				<li class="title">{$lang.label.passwordOld}<span id="msg_admin_pass">*</span></li>
				<li class="field">
					<input type="password" name="admin_pass" id="admin_pass" class="validate short" />
				</li>

				<li class="title">{$lang.label.passwordNew} {$lang.label.onlymodi}</li>
				<li class="field">
					<input type="password" name="admin_pass_new" id="admin_pass_new" class="short" />
				</li>

				<li class="title">{$lang.label.passwordConfirm} {$lang.label.onlymodi}</li>
				<li class="field">
					<input type="password" name="admin_pass_confirm" id="admin_pass_confirm" class="short" />
				</li>

				<li class="title">{$lang.label.note}</li>
				<li class="field">
					<input type="text" name="admin_note" id="admin_note" value="{$tplData.adminLogged.admin_note}" readonly="readonly" />
				</li>

				<li><button type="button" id="go_form">{$lang.btn.submit}</button></li>

				<li class="title">{$lang.label.groupAllow}</li>
				<li class="title">
					<ol>
						{foreach $adminMod as $key_m=>$value_m}
							<li class="title">{$value_m.main.title}</li>
							<li class="field">
								{foreach $value_m.allow as $key_s=>$value_s}
									<img src="{$smarty.const.BG_URL_IMAGE}allow_{if $tplData.adminLogged.admin_allow[$key_m][$key_s] == 1}y{else}x{/if}.png" />
									<label for="allow_{$key_m}_{$key_s}">{$value_s}</label>
								{/foreach}
							</li>
						{/foreach}
					</ol>
				</li>

			</ul>
		</div>

	</form>

{include "include/admin_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_form = {
	admin_pass: {
		length: { min: 1, max: 0 },
		validate: { type: "str", format: "text" },
		msg: { id: "msg_admin_pass", too_short: "{$alert.x020205}" }
	}
};
var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=admin", btn_text: "{$lang.btn.ok}", btn_url: "{$cfg.str_url}" };

$(document).ready(function(){
	var obj_validator_form = $("#admin_my").baigoValidator(opts_validator_form);
	var obj_submit_form = $("#admin_my").baigoSubmit(opts_submit_form);
	$("#go_form").click(function(){
		if (obj_validator_form.validateSubmit()) {
			obj_submit_form.formSubmit();
		}
	});
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}
