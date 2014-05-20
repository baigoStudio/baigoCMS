{* logon.tpl 登录界面 *}
{if $smarty.get.view}
	{$str_tpl = $smarty.get.view}
	{$str_css = "admin_{$smarty.get.view}_logon"}
{else}
	{$str_tpl = "logon"}
	{$str_css = "admin_logon"}
{/if}

{$cfg = [
	title          => $lang.page.adminLogin,
	css            => $str_css,
	reloadImg      => "true",
	baigoValidator => "true"
]}

{include "include/{$str_tpl}_head.tpl" cfg=$cfg}

	<ul class="page_head">
		<li class="head_title">{$lang.page.adminLogin}</li>
		<li class="head_name">{$smarty.const.BG_SITE_NAME}</li>
		<li class="float_clear"></li>
	</ul>

	<div class="page_body">

		<form action="{$smarty.const.BG_URL_ADMIN}admin.php?mod=logon" method="post" id="login_form">
			<input type="hidden" name="act_post" value="login" />
			<input type="hidden" name="token_session" value="{$common.token_session}" />
			<input type="hidden" name="forward" value="{$tplData.forward}" />
			<input type="hidden" name="view" value="{$tplData.view}" />

			<div class="msg">
				{if $smarty.get.alert}
					{$alert[$smarty.get.alert]}
				{/if}
			</div>

			<ul>
				<li>
					<ol>
						<li class="label">{$lang.label.username}</li>
						<li class="field"><input type="text" name="admin_name" id="admin_name" class="validate" /></li>
						<li class="float_clear"></li>
					</ol>
					<span class="msg" id="msg_admin_name">*</span>
					<div class="float_clear"></div>
				</li>
				<li>
					<ol>
						<li class="label">{$lang.label.password}</li>
						<li class="field"><input type="password" name="admin_pass" id="admin_pass" class="validate" /></li>
						<li class="float_clear"></li>
					</ol>
					<span class="msg" id="msg_admin_pass">*</span>
					<div class="float_clear"></div>
				</li>
				<li>
					<ol>
						<li class="label">{$lang.label.seccode}</li>
						<li class="field">
							<input type="text" name="seccode" id="seccode" class="validate" />
							<a href="javascript:reloadImg('seccodeImg', '{$smarty.const.BG_URL_ADMIN}admin.php?mod=seccode&act_get=make');" title="{$lang.alt.seccode}">
								<img src="{$smarty.const.BG_URL_ADMIN}admin.php?mod=seccode&act_get=make" id="seccodeImg" alt="{$lang.alt.seccode}" />
							</a>
						</li>
						<li class="float_clear"></li>
					</ol>
					<span class="msg" id="msg_seccode">*</span>
					<div class="float_clear"></div>
				</li>
			</ul>

			<div class="float_clear"></div>

			<div class="btn_logon"><a href="javascript:void(0);" id="go_submit">{$lang.btn.login}</a></div>

			<div class="msg">

			</div>

		</form>

	</div>

	<div class="page_foot">
		<a href="{$smarty.const.PRD_CMS_URL}" target="_blank">{$smarty.const.PRD_CMS_POWERED} {$smarty.const.PRD_CMS_NAME} {$smarty.const.PRD_CMS_VER}</a>
	</div>

{include "include/{$str_tpl}_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_form = {
	admin_name: {
		length: { min: 1, max: 30 },
		validate: { type: "str", format: "strDigit" },
		msg: { id: "msg_admin_name", too_short: "{$alert.x010201}", too_long: "{$alert.x010202}", format_err: "{$alert.x010203}" }
	},
	admin_pass: {
		length: { min: 1, max: 0 },
		validate: { type: "str", format: "text" },
		msg: { id: "msg_admin_pass", too_short: "{$alert.x010212}" }
	},
	seccode: {
		length: { min: 4, max: 4 },
		validate: { type: "ajax", format: "text" },
		msg: { id: "msg_seccode", too_short: "{$alert.x030201}", too_long: "{$alert.x030201}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
		ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=seccode&act_get=chk", key: "seccode", type: "str" }
	}
};

function go_login() {
	var obj_validate_form = $("#login_form").baigoValidator(opts_validator_form);
	if (obj_validate_form.validateSubmit()) {
		$("#login_form").submit();
	}
}

$(document).ready(function(){
	$("#go_submit").click(function(){
		go_login();
	});
	$("body").keydown(function(_e){
		if (_e.keyCode == 13) {
			go_login();
		}
	});
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}
