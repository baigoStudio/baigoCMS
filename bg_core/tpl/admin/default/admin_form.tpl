{* admin_form.tpl 管理员编辑界面 *}
{* 栏目显示函数（递归） *}
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

			<input type="checkbox" id="cate_{$value.cate_id}" class="chk_all" />
			<label for="cate_{$value.cate_id}">{$lang.label.all}</label>
			{foreach $lang.allow as $key_s=>$value_s}
				<input type="checkbox" name="admin_allow_cate[{$value.cate_id}][{$key_s}]" value="1" id="cate_{$value.cate_id}_{$key_s}" class="cate_{$value.cate_id}" {if $tplData.adminRow.admin_allow_cate[$value.cate_id][$key_s] == 1}checked="checked"{/if} group="admin_allow_cate" />
				<label for="cate_{$value.cate_id}_{$key_s}">{$value_s}</label>
			{/foreach}

		</li>

		{if $value.cate_childs}
			{cate_list arr=$value.cate_childs}
		{/if}

	{/foreach}
{/function}

{if $smarty.get.admin_id == 0}
	{$title_sub    = $lang.page.add}
	{$sub_active   = "form"}
{else}
	{$title_sub    = $lang.page.edit}
	{$sub_active   = "list"}
{/if}

{$cfg = [
	title          => "{$adminMod.admin.main.title} - {$title_sub}",
	css            => "admin_form",
	menu_active    => "admin",
	sub_active     => $sub_active,
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	colorbox       => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=admin"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<form name="admin_form" id="admin_form" class="tform" autocomplete="off">

		<input type="hidden" name="token_session" value="{$common.token_session}" />
		<input type="hidden" name="act_post" value="submit" />
		<input type="hidden" name="admin_id" value="{$tplData.adminRow.admin_id}" />

		<div>
			<ol>
				{if $tplData.adminRow.admin_id > 0}
					<li class="title_b">{$lang.label.id}: {$tplData.adminRow.admin_id}</li>
					<li class="line_dashed"> </li>
				{/if}
				<li class="title">{$lang.label.status}<span id="msg_admin_status">*</span></li>
				<li>
					{foreach $status.admin as $key=>$value}
						<input type="radio" name="admin_status" id="admin_status_{$key}" value="{$key}" class="validate" {if $tplData.adminRow.admin_status == $key}checked="checked"{/if} group="admin_status" />
						<label for="admin_status_{$key}">{$value}</label>
					{/foreach}
				</li>

				<li class="line_dashed"> </li>

				<li><button type="button" class="go_submit">{$lang.btn.submit}</button></li>
			</ol>

			<ul>
				<li class="title">{$lang.label.username}<span id="msg_admin_name">*</span></li>
				<li class="field">
					<input type="text" name="admin_name" id="admin_name" {if $tplData.adminRow.admin_id > 0}readonly="readonly" class="short"{else}class="validate short"{/if} value="{$tplData.adminRow.userRow.user_name}" />
				</li>

				<li class="title">{$lang.label.password}{if $tplData.adminRow.admin_id > 0}{$lang.label.modOnly}{else}<span id="msg_admin_pass">*</span>{/if}</li>
				<li class="field">
					<input type="text" name="admin_pass" id="admin_pass" {if $tplData.adminRow.admin_id > 0}class="short"{else}class="validate short"{/if} />
				</li>

				<li class="title">{$lang.label.mail}<span id="msg_admin_mail"></span></li>
				<li class="field">
					<input type="text" name="admin_mail" id="admin_mail" value="{$tplData.adminRow.userRow.user_mail}" {if $tplData.adminRow.admin_id > 0}class="short"{else}class="validate short"{/if} />
				</li>

				<li class="title">{$lang.label.note}<span id="msg_admin_note"></span></li>
				<li class="field">
					<input type="text" name="admin_note" id="admin_note" value="{$tplData.adminRow.admin_note}" class="validate short" />
				</li>

				<li class="title">{$lang.label.cateAllow}</li>
				<li class="field">
					<ol>
						<li class="field">
							<input type="checkbox" id="chk_all" class="first" />
							<label for="chk_all">{$lang.label.all}</label>
						</li>
						{cate_list arr=$tplData.cateRows}
					</ol>
				</li>

				<li><button type="button" class="go_submit">{$lang.btn.submit}</button></li>
			</ul>

		</div>

	</form>

{include "include/admin_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_form = {
	admin_name: {
		length: { min: 1, max: 0 },
		validate: { type: "ajax", format: "strDigit" },
		msg: { id: "msg_admin_name", too_short: "{$alert.x020201}", too_long: "{$alert.x020202}", format_err: "{$alert.x020203}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
		ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=admin&act_get=chkname", key: "admin_name", type: "str" }
	},
	admin_pass: {
		length: { min: 1, max: 0 },
		validate: { type: "str", format: "text" },
		msg: { id: "msg_admin_pass", too_short: "{$alert.x020210}" }
	},
	admin_mail: {
		length: { min: 0, max: 0 },
		validate: { type: "ajax", format: "email" },
		msg: { id: "msg_admin_mail", too_short: "{$alert.x020207}", too_long: "{$alert.x020208}", format_err: "{$alert.x020209}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
		ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=admin&act_get=chkmail", key: "admin_mail", type: "str", attach: "admin_id={$tplData.adminRow.admin_id}" }
	},
	admin_note: {
		length: { min: 0, max: 30 },
		validate: { type: "str", format: "text" },
		msg: { id: "msg_admin_note", too_long: "{$alert.x020212}" }
	},
	admin_status: {
		length: { min: 1, max: 0 },
		validate: { type: "radio" },
		msg: { id: "msg_admin_status", too_few: "{$alert.x020213}" }
	}
};
var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=admin", btn_text: "{$lang.btn.ok}", btn_url: "{$cfg.str_url}" };

$(document).ready(function(){
	var obj_validate_form = $("#admin_form").baigoValidator(opts_validator_form);
	var obj_submit_form = $("#admin_form").baigoSubmit(opts_submit_form);
	$(".go_submit").click(function(){
		if (obj_validate_form.validateSubmit()) {
			obj_submit_form.formSubmit();
		}
	});
	$("#admin_form").baigoCheckall();
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}
