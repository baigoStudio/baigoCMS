{* admin_callForm.tpl 管理组编辑界面 *}
{function cate_checkbox arr_cate=""}
	{foreach $arr_cate as $value}
		<div class="field_text">
			{if $value.cate_level > 0}
				{for $_i=1 to $value.cate_level}
					&#160;&#160;&#160;&#160;&#160;&#160;
				{/for}
			{/if}

			<input type="checkbox" {if $value.cate_id|in_array:$tplData.callRow.call_cate_ids}checked="checked"{/if} value="{$value.cate_id}" name="call_cate_ids[]" id="call_cate_ids_{$value.cate_id}" class="call_cate_ids_{$value.cate_parent_id}" />
			<label for="call_cate_ids_{$value.cate_id}">{$value.cate_name}</label>
		</div>

		{if $value.cate_childs}
			{cate_checkbox arr_cate=$value.cate_childs}
		{/if}
	{/foreach}
{/function}

{function cate_radio arr_cate=""}
	{foreach $arr_cate as $value}
		<div class="field_text">
			{if $value.cate_level > 0}
				{for $_i=1 to $value.cate_level}
					&#160;&#160;&#160;&#160;&#160;&#160;
				{/for}
			{/if}

			<input type="radio" {if $tplData.callRow.call_cate_id == $value.cate_id}checked="checked"{/if} value="{$value.cate_id}" name="call_cate_id" id="call_cate_id_{$value.cate_id}" {if !$value.cate_childs}disabled="disabled"{/if} />
			<label for="call_cate_id_{$value.cate_id}">{$value.cate_name}</label>
		</div>

		{if $value.cate_childs}
			{cate_radio arr_cate=$value.cate_childs}
		{/if}
	{/foreach}
{/function}

{if $smarty.get.call_id == 0}
	{$title_sub = $lang.page.add}
	{$sub_active = "form"}
{else}
	{$title_sub = $lang.page.edit}
	{$sub_active = "list"}
{/if}

{$cfg = [
	title          => "{$adminMod.call.main.title} - {$title_sub}",
	css            => "admin_form",
	menu_active    => "call",
	sub_active     => $sub_active,
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	colorbox       => "true",
	baigoCheckall  => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=call"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<form name="call_form" id="call_form" class="tform">

		<input type="hidden" name="token_session" value="{$common.token_session}" />
		<input type="hidden" name="act_post" value="submit" />
		<input type="hidden" name="call_id" value="{$tplData.callRow.call_id}" />

		<div>
			<ol>
				{if $tplData.callRow.call_id > 0}
					<li class="title_b">{$lang.label.id}: {$tplData.callRow.call_id}</li>
					<li class="line_dashed"> </li>
				{/if}
				<li class="title">{$lang.label.callType}<span id="msg_call_type">*</span></li>
				<li>
					<select id="call_type" name="call_type" class="validate">
						<option value="">{$lang.option.pleaseSelect}</option>
						{foreach $type.call as $key=>$value}
							<option {if $tplData.callRow.call_type == $key}selected="selected"{/if} value="{$key}">{$value}</option>
						{/foreach}
					</select>
				</li>

				<li class="line_dashed"> </li>

				{if $smarty.const.BG_MODULE_GEN}
					<li class="title">{$lang.label.callFile}<span id="msg_call_file">*</span></li>
					<li>
						<select name="call_file" id="call_file" class="validate">
							<option value="">{$lang.option.pleaseSelect}</option>
							{foreach $type.callFile as $key=>$value}
								<option {if $tplData.callRow.call_file == $key}selected="selected"{/if} value="{$key}">{$value}</option>
							{/foreach}
						</select>
					</li>
					<li class="line_dashed"> </li>
				{/if}

				<li class="title">{$lang.label.status}<span id="msg_call_status">*</span></li>
				<li>
					{foreach $status.call as $key=>$value}
						<input type="radio" name="call_status" id="call_status_{$key}" value="{$key}" class="validate" {if $tplData.callRow.call_status == $key}checked="checked"{/if} group="call_status" />
						<label for="call_status_{$key}">{$value}</label>
					{/foreach}
				</li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.callAmount}</li>
				<li>
					<label>{$lang.label.callAmoutTop}</label>
					<input type="text" name="call_amount[top]" id="call_amount_top" value="{$tplData.callRow.call_amount.top}" class="validate short" />
					<span id="msg_call_amount_top">*</span>
				</li>
				<li>
					<label>{$lang.label.callAmoutExcept}</label>
					<input type="text" name="call_amount[except]" id="call_amount_except" value="{$tplData.callRow.call_amount.except}" class="validate short" />
					<span id="msg_call_amount_except">*</span>
				</li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.callTrim}<span id="msg_call_trim">*</span></li>
				<li>
					<input type="text" name="call_trim" id="call_trim" value="{$tplData.callRow.call_trim}" class="validate" />
				</li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.callCss}<span id="msg_call_css"></span></li>
				<li>
					<input type="text" name="call_css" id="call_css" value="{$tplData.callRow.call_css}" class="validate" />
				</li>

				<li class="line_dashed"> </li>

				<li><button type="button" class="go_submit">{$lang.btn.submit}</button></li>
			</ol>

			<ul>
				<li class="title">{$lang.label.callName}<span id="msg_call_name">*</span></li>
				<li class="field">
					<input type="text" name="call_name" id="call_name" value="{$tplData.callRow.call_name}" class="validate middle" />
				</li>

				<li class="title_b call_article">{$lang.label.callFilter}</li>

				<li class="title call_article">{$lang.label.callCate}</li>
				<li class="field call_article">
					<div class="field_text">
						<input type="checkbox" id="call_cate_ids_0" />
						<label for="call_cate_id_0">{$lang.label.cateAll}</label>
					</div>
					{cate_checkbox arr_cate=$tplData.cateRows}
				</li>

				<li class="title call_article">{$lang.label.callUpfile}<span id="msg_call_upfile"></span></li>
				<li class="field call_article">
					<select id="call_upfile" name="call_upfile">
						{foreach $type.callUpfile as $key=>$value}
							<option {if $tplData.callRow.call_upfile == $key}selected="selected"{/if} value="{$key}">{$value}</option>
						{/foreach}
					</select>
				</li>

				<li class="title call_article">{$lang.label.callMark}<span id="msg_call_mark_ids"></span></li>
				<li class="field call_article">
					{foreach $tplData.markRows as $key=>$value}
						<input type="checkbox" {if $value.mark_id|in_array:$tplData.callRow.call_mark_ids}checked="checked"{/if} value="{$value.mark_id}" name="call_mark_ids[]" id="call_mark_ids_{$value.mark_id}" />
						<label for="call_mark_ids_{$value.mark_id}">{$value.mark_name}</label>
					{/foreach}
				</li>

				<li class="title_b call_article">{$lang.label.callShow}</li>

				<li class="title call_article">{$lang.label.callShow}<span id="msg_call_show_article">*</span></li>
				<li class="field call_article">
					<input type="checkbox" name="call_show[cate]" {if $tplData.callRow.call_show.cate == "show"}checked="checked"{/if} id="call_show_cate" value="show" group="call_show_article" class="validate" />
					<label for="call_show_cate">{$lang.label.cateName}</label>

					<input type="checkbox" name="call_show[title]" {if $tplData.callRow.call_show.title == "show"}checked="checked"{/if} id="call_show_title" value="show" group="call_show_article" class="validate" />
					<label for="call_show_title">{$lang.label.articleTitle}</label>

					<input type="checkbox" name="call_show[excerpt]" {if $tplData.callRow.call_show.excerpt == "show"}checked="checked"{/if} id="call_show_excerpt" value="show" group="call_show_article" class="validate" />
					<label for="call_show_excerpt">{$lang.label.articleExcerpt}</label>

					<input type="checkbox" name="call_show[tag]" {if $tplData.callRow.call_show.tag == "show"}checked="checked"{/if} id="call_show_tag" value="show" group="call_show_article" class="validate" />
					<label for="call_show_tag">{$lang.label.articleTag}</label>
				</li>

				<li class="title call_article">{$lang.label.callShowImg}<span id="msg_call_show_img"></span></li>
				<li class="field call_article">
					<select id="call_show_img" name="call_show[img]">
						<option {if $tplData.callRow.call_show.img == "none"}selected="selected"{/if} value="none">{$lang.option.noImg}</option>
						<option {if $tplData.callRow.call_show.img == "original"}selected="selected"{/if} value="original">{$lang.option.original}</option>
						{foreach $tplData.thumbRows as $key=>$value}
							<option {if $tplData.callRow.call_show.img == "{$value.thumb_width}_{$value.thumb_height}_{$value.thumb_type}"}selected="selected"{/if} value="{$value.thumb_width}_{$value.thumb_height}_{$value.thumb_type}">{$value.thumb_width}x{$value.thumb_height} {$type.thumb[$value.thumb_type]}</option>
						{/foreach}
					</select>
				</li>

				<li class="title call_article">{$lang.label.datetime}<span id="msg_call_show_time"></span></li>
				<li class="field call_article">
					<select id="call_show_time" name="call_show[time]">
						<option {if $tplData.callRow.call_show.time == "none"}selected="selected"{/if} value="none">{$lang.option.noImg}</option>
						<option {if $tplData.callRow.call_show.time == "{$smarty.const.BG_SITE_DATESHORT} {$smarty.const.BG_SITE_TIMESHORT}"}selected="selected"{/if} value="{$smarty.const.BG_SITE_DATESHORT} {$smarty.const.BG_SITE_TIMESHORT}">{$smarty.now|date_format:"{$smarty.const.BG_SITE_DATESHORT} {$smarty.const.BG_SITE_TIMESHORT}"}</option>
						<option {if $tplData.callRow.call_show.time == "{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}selected="selected"{/if} value="{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}">{$smarty.now|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}</option>
						<option {if $tplData.callRow.call_show.time == "{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIME}"}selected="selected"{/if} value="{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIME}">{$smarty.now|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIME}"}</option>
						<option {if $tplData.callRow.call_show.time == "{$smarty.const.BG_SITE_DATESHORT}"}selected="selected"{/if} value="{$smarty.const.BG_SITE_DATESHORT}">{$smarty.now|date_format:$smarty.const.BG_SITE_DATESHORT}</option>
						<option {if $tplData.callRow.call_show.time == "{$smarty.const.BG_SITE_DATE}"}selected="selected"{/if} value="{$smarty.const.BG_SITE_DATE}">{$smarty.now|date_format:{$smarty.const.BG_SITE_DATE}}</option>
						<option {if $tplData.callRow.call_show.time == "{$smarty.const.BG_SITE_TIMESHORT}"}selected="selected"{/if} value="{$smarty.const.BG_SITE_TIMESHORT}">{$smarty.now|date_format:$smarty.const.BG_SITE_TIMESHORT}</option>
						<option {if $tplData.callRow.call_show.time == "{$smarty.const.BG_SITE_TIME}"}selected="selected"{/if} value="{$smarty.const.BG_SITE_TIME}">{$smarty.now|date_format:$smarty.const.BG_SITE_TIME}</option>
					</select>
				</li>

				<li class="title_b call_cate">{$lang.label.callFilter}</li>

				<li class="title call_cate">{$lang.label.callCate}</li>
				<li class="field call_cate">
					<div class="field_text">
						<input type="radio" {if $tplData.callRow.call_cate_id == 0}checked="checked"{/if} value="0" name="call_cate_id" id="call_cate_id_0" />
						<label for="call_cate_id_0">{$lang.label.cateAll}</label>
					</div>
					{cate_radio arr_cate=$tplData.cateRows}
				</li>

				<li class="title call_cate">{$lang.label.callShow}<span id="msg_call_show_cate">*</span></li>

				<li class="field call_cate">
					<input type="checkbox" name="call_show[cateName]" {if $tplData.callRow.call_show.cateName == "show"}checked="checked"{/if} id="call_show_cateName" value="show" group="call_show_cate" class="validate" />
					<label for="call_show_cateName">{$lang.label.cateName}</label>

					<input type="checkbox" name="call_show[cateContent]" {if $tplData.callRow.call_show.cateContent == "show"}checked="checked"{/if} id="call_show_cateContent" value="show" group="call_show_cate" class="validate" />
					<label for="call_show_cateContent">{$lang.label.cateContent}</label>
				</li>

				<li><button type="button" class="go_submit">{$lang.btn.submit}</button></li>
			</ul>
		</div>

	</form>

{include "include/admin_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_form = {
	call_name: {
		length: { min: 1, max: 300 },
		validate: { type: "ajax", format: "text" },
		msg: { id: "msg_call_name", too_short: "{$alert.x170201}", too_long: "{$alert.x170202}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
		ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=call&act_get=chkname", key: "call_name", type: "str", attach: "call_id={$tplData.callRow.call_id}" }
	},
	call_type: {
		length: { min: 1, max: 0 },
		validate: { type: "select" },
		msg: { id: "msg_call_type", too_few: "{$alert.x170204}" }
	},
	call_file: {
		length: { min: 1, max: 0 },
		validate: { type: "select" },
		msg: { id: "msg_call_file", too_few: "{$alert.x170205}" }
	},
	call_status: {
		length: { min: 1, max: 0 },
		validate: { type: "radio" },
		msg: { id: "msg_call_status", too_few: "{$alert.x170206}" }
	},
	call_amount_top: {
		length: { min: 1, max: 0 },
		validate: { type: "str", format: "int" },
		msg: { id: "msg_call_amount_top", too_short: "{$alert.x170207}", format_err: "{$alert.x170208}" }
	},
	call_amount_except: {
		length: { min: 1, max: 0 },
		validate: { type: "str", format: "int" },
		msg: { id: "msg_call_amount_except", too_short: "{$alert.x170209}", format_err: "{$alert.x170210}" }
	},
	call_trim: {
		length: { min: 1, max: 0 },
		validate: { type: "str", format: "int" },
		msg: { id: "msg_call_trim", too_short: "{$alert.x170211}", format_err: "{$alert.x170212}" }
	},
	call_css: {
		length: { min: 0, max: 300 },
		validate: { type: "str", format: "strDigit" },
		msg: { id: "msg_call_css", too_long: "{$alert.x170214}", format_err: "{$alert.x170215}" }
	},
	call_show_article: {
		length: { min: 1, max: 0 },
		validate: { type: "checkbox" },
		msg: { id: "msg_call_show_article", too_few: "{$alert.x170216}" }
	},
	call_show_cate: {
		length: { min: 1, max: 0 },
		validate: { type: "checkbox" },
		msg: { id: "msg_call_show_cate", too_few: "{$alert.x170216}" }
	}
};
var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=call", btn_text: "{$lang.btn.ok}", btn_url: "{$cfg.str_url}" };

function call_type(call_type) {
	switch (call_type) {
		case "cate":
			$(".call_article").hide();
			$(".call_cate").show();
		break;

		case "tag":
			$(".call_article").hide();
			$(".call_cate").hide();
		break;

		default:
			$(".call_article").show();
			$(".call_cate").hide();
		break;
	}
}

$(document).ready(function(){
	var obj_validate_form = $("#call_form").baigoValidator(opts_validator_form);
	var obj_submit_form = $("#call_form").baigoSubmit(opts_submit_form);
	$(".go_submit").click(function(){
		if (obj_validate_form.validateSubmit()) {
			obj_submit_form.formSubmit();
		}
	});

	$("#call_form").baigoCheckall();

	call_type("{$tplData.callRow.call_type}");

	$("#call_type").change(function(){
		var _call_type = $(this).val();
		call_type(_call_type);
	});

	$("#call_form").baigoCheckall();
});
</script>

{include "include/html_foot.tpl" cfg=$cfg}

