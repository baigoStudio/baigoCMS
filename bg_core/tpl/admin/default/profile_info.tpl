{* profile_form.tpl 管理员编辑界面 *}
{function cate_list arr="" level=""}
	<dl class="list_baigo {if $level > 0}list_padding{/if}">
		{foreach $arr as $value}
			<dt>{$value.cate_name}</dt>
			<dd>
				<ul class="list-inline">
					{foreach $lang.allow as $key_s=>$value_s}
						<li>
							<span class="glyphicon glyphicon-{if $tplData.adminLogged.admin_allow_cate[$value.cate_id][$key_s] == 1 || isset($tplData.adminLogged.groupRow.group_allow.article[$key_s])}ok-circle text-success{else}remove-circle text-danger{/if}"></span>
							{$value_s}
						</li>
					{/foreach}
				</ul>
				{if $value.cate_childs}
					{cate_list arr=$value.cate_childs level=$value.cate_level}
				{/if}
			</dd>
		{/foreach}
	</dl>
{/function}

{$cfg = [
	title          => $lang.page.profile,
	menu_active    => "profile",
	sub_active     => "info",
	baigoValidator => "true",
	baigoSubmit    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=profile"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<li>{$lang.page.profile}</li>

	{include "include/admin_left.tpl" cfg=$cfg}

	<form name="profile_form" id="profile_form" autocomplete="off">
		<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
		<input type="hidden" name="act_post" value="info">

		<div class="row">
			<div class="col-md-9">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="form-group">
							<label class="control-label">{$lang.label.username}</label>
							<input type="text" name="admin_name" id="admin_name" class="form-control" readonly value="{$tplData.userRow.user_name}">
						</div>

						<div class="form-group">
							<div id="group_admin_mail">
								<label form="admin_mail" class="control-label">{$lang.label.mail}<span id="msg_admin_mail"></span></label>
								<input type="text" name="admin_mail" id="admin_mail" value="{$tplData.userRow.user_mail}" class="validate form-control">
							</div>
						</div>

						<div class="form-group">
							<div id="group_admin_nick">
								<label form="admin_nick" class="control-label">{$lang.label.nick}<span id="msg_admin_nick"></span></label>
								<input type="text" name="admin_nick" id="admin_nick" value="{$tplData.userRow.user_nick}" class="validate form-control">
							</div>
						</div>

						<div class="form-group">
							<button type="button" id="go_submit" class="btn btn-primary">{$lang.btn.save}</button>
						</div>

						<div class="form-group">
							<label class="control-label">{$lang.label.cateAllow}</label>
							{cate_list arr=$tplData.cateRows}
						</div>
					</div>
				</div>
			</div>

			{include "include/profile_left.tpl" cfg=$cfg}
		</div>

	</form>

{include "include/admin_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_form = {
		admin_mail: {
			length: { min: 0, max: 0 },
			validate: { type: "ajax", format: "email", group: "group_admin_mail" },
			msg: { id: "msg_admin_mail", too_short: "{$alert.x020207}", too_long: "{$alert.x020208}", format_err: "{$alert.x020209}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
			ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=admin&act_get=chkmail", key: "admin_mail", type: "str", attach: "admin_id={$tplData.adminLogged.admin_id}" }
		},
		admin_nick: {
			length: { min: 0, max: 30 },
			validate: { type: "str", format: "text", group: "group_admin_nick" },
			msg: { id: "msg_admin_nick", too_long: "{$alert.x020216}" }
		}
	};

	var opts_submit_form = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=profile",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	$(document).ready(function(){
		var obj_validate_form = $("#profile_form").baigoValidator(opts_validator_form);
		var obj_submit_form = $("#profile_form").baigoSubmit(opts_submit_form);
		$("#go_submit").click(function(){
			if (obj_validate_form.validateSubmit()) {
				obj_submit_form.formSubmit();
			}
		});
	})
	</script>

{include "include/html_foot.tpl" cfg=$cfg}
