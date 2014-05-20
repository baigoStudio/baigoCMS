{*cate_form.php 栏目编辑界面*}
{function cate_list arr=""}
	{foreach $arr as $value}
		<option value="{$value.cate_id}" {if $tplData.cateRow.cate_parent_id == $value.cate_id}selected="selected"{/if}>
			{if $value.cate_level > 0}
				{for $_i=1 to $value.cate_level}
					&#160;&#160;&#160;&#160;&#160;&#160;
				{/for}
			{/if}
			{$value.cate_name}
		</option>

		{if $value.cate_childs}
			{cate_list arr=$value.cate_childs}
		{/if}

	{/foreach}
{/function}

{if $smarty.get.cate_id == 0}
	{$title_sub    = $lang.page.add}
	{$sub_active   = "form"}
{else}
	{$title_sub    = $lang.page.edit}
	{$sub_active   = "list"}
{/if}

{$cfg = [
	title          => "{$adminMod.cate.main.title} - {$title_sub}",
	css            => "admin_form",
	menu_active    => "cate",
	sub_active     => $sub_active,
	kindeditor     => "true",
	colorbox       => "true",
	baigoSubmit    => "true",
	baigoValidator => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=cate"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<form name="cate_form" id="cate_form" class="tform">

		<input type="hidden" name="token_session" value="{$common.token_session}" />
		<input type="hidden" name="act_post" id="act_post" value="submit" />
		<input type="hidden" name="cate_id" value="{$tplData.cateRow.cate_id}" />

		<div>
			<ol>
				{if $tplData.cateRow.cate_id > 0}
					<li class="title_b">{$lang.label.id}: {$tplData.cateRow.cate_id}</li>
					<li class="line_dashed"> </li>
				{/if}
				<li class="title">{$lang.label.cateParent}<span id="msg_cate_parent_id">*</span></li>
				<li>
					<select name="cate_parent_id" id="cate_parent_id" class="validate">
						<option value="">{$lang.option.pleaseSelect}</option>
						<option {if $tplData.cateRow.cate_parent_id == 0}selected="selected"{/if} value="0">{$lang.option.asParent}</option>
						{cate_list arr=$tplData.cateRows}
					</select>
				</li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.tpl}<span id="msg_cate_tpl">*</span></li>
				<li>
					<select name="cate_tpl" id="cate_tpl" class="validate">
						<option value="">{$lang.option.pleaseSelect}</option>
						<option {if $tplData.cateRow.cate_tpl == "inherit"}selected="selected"{/if} value="inherit">{$lang.option.tplInherit}</option>
						{foreach $tplData.tplRows as $value}
							{if $value["type"] == "dir"}
							<option {if $tplData.cateRow.cate_tpl == $value.name}selected="selected"{/if} value="{$value.name}">{$value.name}</option>
							{/if}
						{/foreach}
					</select>
				</li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.cateType}<span id="msg_cate_type">*</span></li>
				<li>
					{foreach $type.cate as $key=>$value}
						<input type="radio" name="cate_type" id="cate_type_{$key}" value="{$key}" class="validate" {if $tplData.cateRow.cate_type == $key}checked="checked"{/if} group="cate_type" />
						<label for="cate_type_{$key}">{$value}</label>
					{/foreach}
				</li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.cateStatus}<span id="msg_cate_status">*</span></li>
				<li>
					{foreach $status.cate as $key=>$value}
						<input type="radio" name="cate_status" id="cate_status_{$key}" value="{$key}" class="validate" {if $tplData.cateRow.cate_status == $key}checked="checked"{/if} group="cate_status" />
						<label for="cate_status_{$key}">{$value}</label>
					{/foreach}
				</li>

				{if $smarty.const.BG_MODULE_GEN &&$smarty.const.BG_MODULE_FTP}
					<li class="line_dashed"> </li>

					<li class="title">{$lang.label.cateDomain}<span id="msg_cate_domain"></span></li>
					<li class="field_in">
						<input type="text" name="cate_domain" id="cate_domain" value="{$tplData.cateRow.cate_domain}" class="validate" />
					</li>
					<li class="title">{$lang.label.cateFtpServ}<span id="msg_cate_ftp_serv"></span></li>
					<li class="field_in">
						<input type="text" name="cate_ftp_serv" id="cate_ftp_serv" value="{$tplData.cateRow.cate_ftp_serv}" />
					</li>
					<li class="title">{$lang.label.cateFtpPort}<span id="msg_cate_ftp_port"></span></li>
					<li class="field_in">
						<input type="text" name="cate_ftp_port" id="cate_ftp_port" value="{$tplData.cateRow.cate_ftp_port}" />
					</li>
					<li class="title">{$lang.label.cateFtpUser}<span id="msg_cate_ftp_user"></span></li>
					<li class="field_in">
						<input type="text" name="cate_ftp_user" id="cate_ftp_user" value="{$tplData.cateRow.cate_ftp_user}" />
					</li>
					<li class="title">{$lang.label.cateFtpPass}<span id="msg_cate_ftp_pass"></span></li>
					<li class="field_in">
						<input type="text" name="cate_ftp_pass" id="cate_ftp_pass" value="{$tplData.cateRow.cate_ftp_pass}" />
					</li>
					<li class="title">{$lang.label.cateFtpPath}<span id="msg_cate_ftp_path"></span></li>
					<li class="field_in">
						<input type="text" name="cate_ftp_path" id="cate_ftp_path" value="{$tplData.cateRow.cate_ftp_path}" />
					</li>
				{/if}

				<li class="line_dashed"> </li>

				<li><button type="button" class="go_submit">{$lang.btn.submit}</button></li>
			</ol>

			<ul>
				<li class="title">{$lang.label.cateName}<span id="msg_cate_name">*</span></li>
				<li class="field">
					<input type="text" name="cate_name" id="cate_name" value="{$tplData.cateRow.cate_name}" class="validate" />
				</li>

				<li class="title">{$lang.label.cateAlias}<span id="msg_cate_alias"></span></li>
				<li class="field">
					<input type="text" name="cate_alias" id="cate_alias" value="{$tplData.cateRow.cate_alias}" class="validate" />
				</li>

				<li class="title cate_single">{$lang.label.cateContent}<span id="msg_cate_content">*</span></li>
				<li class="insert cate_single">
					<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=upfile&act_get=form&target=editor&view=iframe" class="c_iframe">{$lang.href.uploadList}</a>
				</li>
				<li class="field cate_single">
					<textarea name="cate_content" id="cate_content">{$tplData.cateRow.cate_content}</textarea>
				</li>

				<li class="title cate_link">{$lang.label.cateLink}<span id="msg_cate_link"></span></li>
				<li class="field cate_link">
					<input type="text" name="cate_link" id="cate_link" value="{$tplData.cateRow.cate_link}" class="validate" />
				</li>

				<li><button type="button" class="go_submit">{$lang.btn.submit}</button></li>
			</ul>

		</div>

	</form>

{include "include/admin_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_form = {
	cate_name: {
		length: { min: 1, max: 300 },
		validate: { type: "ajax", format: "text" },
		msg: { id: "msg_cate_name", too_short: "{$alert.x110201}", too_long: "{$alert.x110202}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
		ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=cate&act_get=chkname", key: "cate_name", type: "str", attach: "cate_id={$tplData.cateRow.cate_id}&cate_parent_id={$tplData.cateRow.cate_parent_id}" }
	},
	cate_alias: {
		length: { min: 0, max: 300 },
		validate: { type: "ajax", format: "alphabetDigit" },
		msg: { id: "msg_cate_alias", too_long: "{$alert.x110204}", format_err: "{$alert.x110205}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
		ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=cate&act_get=chkalias", key: "cate_alias", type: "str", attach: "cate_id={$tplData.cateRow.cate_id}&cate_parent={$tplData.cateRow.cate_parent_id}" }
	},
	cate_link: {
		length: { min: 0, max: 3000 },
		validate: { type: "str", format: "url" },
		msg: { id: "msg_cate_link", too_long: "{$alert.x110211}", format_err: "{$alert.x110212}" }
	},
	cate_parent_id: {
		length: { min: 1, max: 0 },
		validate: { type: "select" },
		msg: { id: "msg_cate_parent_id", too_few: "{$alert.x110213}" }
	},
	cate_tpl: {
		length: { min: 1, max: 0 },
		validate: { type: "select" },
		msg: { id: "msg_cate_tpl", too_few: "{$alert.x110214}" }
	},
	cate_type: {
		length: { min: 1, max: 0 },
		validate: { type: "radio" },
		msg: { id: "msg_cate_type", too_few: "{$alert.x110215}" }
	},
	cate_status: {
		length: { min: 1, max: 0 },
		validate: { type: "radio" },
		msg: { id: "msg_cate_status", too_few: "{$alert.x110216}" }
	},
	cate_domain: {
		length: { min: 0, max: 3000 },
		validate: { type: "str", format: "url" },
		msg: { id: "msg_cate_domain", too_long: "{$alert.x110207}", format_err: "{$alert.x110208}" },
	}
};
var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=cate", btn_text: "{$lang.btn.ok}", btn_url: "{$cfg.str_url}" };

var editor = KindEditor.create("#cate_content", k_options);

$(".c_iframe").colorbox({ iframe: true, width: "640px", height: "480px" });

function cate_type(cate_type) {
	switch (cate_type) {
		case "single":
			$(".cate_single").show();
			$(".cate_link").hide();
		break;

		case "link":
			$(".cate_single").hide();
			$(".cate_link").show();
		break;

		default:
			$(".cate_single").hide();
			$(".cate_link").hide();
		break;
	}
}

$(document).ready(function(){
	cate_type("{$tplData.cateRow.cate_type}");

	var obj_validate_form  = $("#cate_form").baigoValidator(opts_validator_form);
	var obj_submit_form    = $("#cate_form").baigoSubmit(opts_submit_form);
	$(".go_submit").click(function(){
		editor.sync();
		if (obj_validate_form.validateSubmit()) {
			obj_submit_form.formSubmit();
		}
	});

	$("[name='cate_type']").click(function(){
		var _cate_type = $(this).val();
		cate_type(_cate_type);
	});
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}

