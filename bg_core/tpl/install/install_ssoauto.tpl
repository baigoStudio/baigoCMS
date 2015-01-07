{* install_1.tpl 登录界面 *}
{$cfg = [
	sub_title  => $lang.page.installSsoAuto,
	mod_help   => "install",
	act_help   => "sso#auto"
]}
{include "include/install_head.tpl" cfg=$cfg}

	<form name="instal_form_ssoauto" id="instal_form_ssoauto">
		<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
		<input type="hidden" name="act_post" value="ssoAuto">

		<div class="alert alert-warning">
			<h4>
				<span class="glyphicon glyphicon-warning-sign"></span>
				{$lang.label.installSso}
			</h4>
		</div>

		<div class="form-group">
			<div class="btn-group">
				<button type="button" id="go_next" class="btn btn-primary btn-lg">{$lang.btn.submit}</button>
				{include "include/install_drop.tpl" cfg=$cfg}
			</div>
		</div>
	</form>

{include "include/install_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_submit_form = {
		ajax_url: "{$smarty.const.BG_URL_INSTALL}ajax.php?mod=install",
		btn_text: "{$lang.btn.stepNext}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$smarty.const.BG_URL_SSO}install/ctl.php?mod=install&act_get=auto&url={$tplData.url}&path={$tplData.path}&target=cms"
	};

	$(document).ready(function(){
		var obj_submit_form = $("#instal_form_ssoauto").baigoSubmit(opts_submit_form);
		$("#go_next").click(function(){
			obj_submit_form.formSubmit();
		});
	})
	</script>

</html>