{* admin_form.tpl 管理员编辑界面 *}
{function cate_list arr=""}
	{foreach $arr as $value}
		<li class="title">
			{if $value.cate_level > 0}
				{for $_i=1 to $value.cate_level}
					&#160;&#160;&#160;&#160;&#160;&#160;
				{/for}
			{/if}
			{$value.cate_name}
		</li>

		<li class="field">
			{if $value.cate_level > 0}
				{for $_i=1 to $value.cate_level}
					&#160;&#160;&#160;&#160;&#160;&#160;
				{/for}
			{/if}

			{foreach $lang.allow as $key_s=>$value_s}
				<img src="{$smarty.const.BG_URL_IMAGE}allow_{if $tplData.adminLogged.admin_allow_cate[$value.cate_id][$key_s] == 1 || $tplData.adminLogged.admin_allow_sys.article[$key_s]}y{else}x{/if}.png" />
				<label for="cate_{$value.cate_id}_{$key_s}">{$value_s}</label>
			{/foreach}
		</li>

		{if $value.cate_childs}
			{cate_list arr=$value.cate_childs}
		{/if}

	{/foreach}
{/function}

{$cfg = [
	title          => $lang.page.adminMy,
	css            => "admin_form",
	baigoValidator => "true",
	baigoSubmit    => "true",
	colorbox       => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=admin"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<form name="admin_form" id="admin_form" class="tform" autocomplete="off">

		<input type="hidden" name="token_session" value="{$common.token_session}" />
		<input type="hidden" name="act_post" value="my" />
		<input type="hidden" name="admin_id" value="{$tplData.adminLogged.admin_id}" />

		<div>
			<ol>
				<li class="title_b">{$lang.label.id}: {$tplData.adminLogged.admin_id}</li>
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
					<input type="text" name="admin_name" id="admin_name" readonly="readonly" class="short" value="{$tplData.adminLogged.admin_name}" />
				</li>

				<li class="title">{$lang.label.passwordOld}<span id="msg_admin_pass">*</span></li>
				<li class="field">
					<input type="password" name="admin_pass" id="admin_pass" class="validate short" />
				</li>

				<li class="title">{$lang.label.passwordNew}{$lang.label.modOnly}</li>
				<li class="field">
					<input type="password" name="admin_pass_new" id="admin_pass_new" class="short" />
				</li>

				<li class="title">{$lang.label.passwordConfirm}{$lang.label.modOnly}</li>
				<li class="field">
					<input type="password" name="admin_pass_confirm" id="admin_pass_confirm" class="short" />
				</li>

				<li class="title">{$lang.label.mail}<span id="msg_admin_mail"></span></li>
				<li class="field">
					<input type="text" name="admin_mail" id="admin_mail" value="{$tplData.userRow.user_mail}" class="validate short" />
				</li>

				<li class="title">{$lang.label.note}</li>
				<li class="field">
					<input type="text" name="admin_note" id="admin_note" value="{$tplData.adminLogged.admin_note}" readonly="readonly" class="short" />
				</li>

				<li><button type="button" id="go_submit">{$lang.btn.submit}</button></li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.cateAllow}</li>
				<li>
					<ol>
						{cate_list arr=$tplData.cateRows}
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
		msg: { id: "msg_admin_pass", too_short: "{$alert.x020210}" }
	},
	admin_mail: {
		length: { min: 0, max: 0 },
		validate: { type: "ajax", format: "email" },
		msg: { id: "msg_admin_mail", too_short: "{$alert.x020207}", too_long: "{$alert.x020208}", format_err: "{$alert.x020209}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
		ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=admin&act_get=chkmail", key: "admin_mail", type: "str", attach: "admin_id={$tplData.adminLogged.admin_id}" }
	}
};
var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=admin", btn_text: "{$lang.btn.ok}", btn_url: "{$cfg.str_url}" };

$(document).ready(function(){
	var obj_validate_form = $("#admin_form").baigoValidator(opts_validator_form);
	var obj_submit_form = $("#admin_form").baigoSubmit(opts_submit_form);
	$("#go_submit").click(function(){
		if (obj_validate_form.validateSubmit()) {
			obj_submit_form.formSubmit();
		}
	});
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}
