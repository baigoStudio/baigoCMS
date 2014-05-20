{* article_form.tpl 文章编辑 *}
{function cate_list arr_cate=""}
	{foreach $arr_cate as $value}
		<div>
			{if $value.cate_level > 0}
				{for $_i=1 to $value.cate_level}
					&#160;&#160;&#160;&#160;&#160;&#160;
				{/for}
			{/if}
			<input type="checkbox" {if $value.cate_id|in_array:$tplData.articleRow.cate_ids}checked="checked"{/if} value="{$value.cate_id}" name="cate_ids[]" id="cate_ids_{$value.cate_id}" class="validate" group="cate_ids" />
			<label for="cate_ids_{$value.cate_id}">{$value.cate_name}</label>
		</div>

		{if $value.cate_childs}
			{cate_list arr_cate=$value.cate_childs}
		{/if}
	{/foreach}
{/function}

{if $smarty.get.article_id == 0}
	{$title_sub = $lang.page.add}
	{$sub_active = "form"}
{else}
	{$title_sub = $lang.page.edit}
	{$sub_active = "list"}
{/if}

{$cfg = [
	title          => "{$adminMod.article.main.title} - {$title_sub}",
	css            => "admin_form",
	menu_active    => "article",
	sub_active     => $sub_active,
	baigoValidator => "true",
	baigoSubmit    => "true",
	kindeditor     => "true",
	colorbox       => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=article"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<form name="article_form" id="article_form" class="tform">

		<input type="hidden" name="token_session" value="{$common.token_session}" />
		<input type="hidden" name="act_post" id="act_post" value="submit" />
		<input type="hidden" name="article_id" value="{$tplData.articleRow.article_id}" />

		<div>
			<ol>
				{if $tplData.articleRow.article_id > 0}
					<li class="title_b">{$lang.label.id}: {$tplData.articleRow.article_id}</li>
					<li class="line_dashed"> </li>
				{/if}
				<li class="title">{$lang.label.articleCate}<span id="msg_cate_ids">*</span></li>
				<li>
					{cate_list arr_cate=$tplData.cateRows}
				</li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.status}<span id="msg_article_status">*</span></li>
				<li>
					{foreach $status.article as $key=>$value}
						<input type="radio" name="article_status" id="article_status_{$key}" {if $tplData.articleRow.article_status == $key}checked="checked"{/if} value="{$key}" class="validate" group="article_status" {if $tplData.adminLogged.admin_allow_sys.article.approve != 1}disabled="disabled"{/if} />
						<label for="article_status_{$key}">{$value}</label>
					{/foreach}
				</li>

				<li class="line_dashed"> </li>

				<li class="title">
					<input type="checkbox" {if $tplData.articleRow.article_time_pub > $smarty.now}checked="checked"{/if} id="article_deadline" />
					<label for="article_deadline">{$lang.label.deadline}</label>
					<span id="msg_article_time_pub"></span>
				</li>
				<li class="article_deadline">
					<input type="text" name="article_time_pub" id="article_time_pub" value="{$tplData.articleRow.article_time_pub|date_format:"%Y-%m-%d %H:%M"}" class="validate" />
				</li>
				<li class="article_deadline">{$lang.label.timeNote}</li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.box}<span id="msg_article_box">*</span></li>
				<li>
					<input type="radio" name="article_box" id="article_box_normal" {if $tplData.articleRow.article_box == "normal"}checked="checked"{/if} value="normal" class="validate" group="article_box" />
					<label for="article_box_normal">{$lang.label.normal}</label>
					<input type="radio" name="article_box" id="article_box_draft" {if $tplData.articleRow.article_box == "draft"}checked="checked"{/if} value="draft" class="validate" group="article_box" />
					<label for="article_box_draft">{$lang.label.draft}</label>
					<input type="radio" name="article_box" id="article_box_recycle" {if $tplData.articleRow.article_box == "recycle"}checked="checked"{/if} value="recycle" class="validate" group="article_box" />
					<label for="article_box_recycle">{$lang.label.recycle}</label>
				</li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.articleMark}</li>
				<li>
					<select name="article_mark_id">
						<option value="">{$lang.option.pleaseSelect}</option>
						 {foreach $tplData.markRows as $value}
							<option {if $value.mark_id == $tplData.articleRow.article_mark_id}selected="selected"{/if} value="{$value.mark_id}">{$value.mark_name}</option>
						 {/foreach}
					</select>
				</li>

				<li class="line_dashed"> </li>

				<li><button type="button" class="go_submit">{$lang.btn.submit}</button></li>
			</ol>

			<ul>
				<li class="title">{$lang.label.articleTitle}<span id="msg_article_title">*</span></li>
				<li class="field">
					<input type="text" name="article_title" id="article_title" value="{$tplData.articleRow.article_title}" class="validate" />
				</li>

				<li class="title">{$lang.label.articleContent}</li>
				<li class="insert">
					<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=upfile&act_get=form&target=editor&view=iframe" class="c_iframe">{$lang.href.uploadList}</a>
				</li>
				<li class="field">
					<textarea name="article_content" id="article_content">{$tplData.articleRow.article_content}</textarea>
				</li>

				<li class="title">{$lang.label.articleTag}{$lang.label.articleTagNote}<span id="msg_article_tag"></span></li>
				<li class="field">
					<input type="text" name="article_tag" id="article_tag" value="{$tplData.articleRow.article_tag}" class="validate" />
				</li>

				<li>
					<button type="button" class="go_submit">{$lang.btn.submit}</button>
					<input type="checkbox" id="article_more" name="article_more" {if $tplData.articleRow.article_link || $tplData.articleRow.article_excerpt}checked="checked"{/if} />
					{$lang.label.articleMore}
				</li>

				<li class="article_more title">{$lang.label.articleLink}{$lang.label.articleLinkNote}<span id="msg_article_link"></span></li>
				<li class="article_more field">
					<input type="text" name="article_link" id="article_link" value="{$tplData.articleRow.article_link}" class="validate" />
				</li>
				<li class="article_more title">{$lang.label.articleExcerpt}<span id="msg_article_excerpt"></span></li>
				<li class="article_more insert">
					<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=upfile&act_get=form&target=editor_excerpt&view=iframe" class="c_iframe">{$lang.href.uploadList}</a>
				</li>
				<li class="article_more field">
					<textarea name="article_excerpt" id="article_excerpt" class="validate excerpt">{$tplData.articleRow.article_excerpt}</textarea>
				</li>
				<li class="article_more">
					<button type="button" class="go_submit">{$lang.btn.submit}</button>
				</li>
			</ul>
		</div>

	</form>

{include "include/admin_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_form = {
	article_title: {
		length: { min: 1, max: 300 },
		validate: { type: "str", format: "text" },
		msg: { id: "msg_article_title", too_short: "{$alert.x120201}", too_long: "{$alert.x120202}" },
	},
	article_tag: {
		length: { min: 0, max: 900 },
		validate: { type: "str", format: "text" },
		msg: { id: "msg_article_tag", too_long: "{$alert.x120203}" }
	},
	article_link: {
		length: { min: 0, max: 900 },
		validate: { type: "str", format: "url" },
		msg: { id: "msg_article_link", too_long: "{$alert.x120204}", format_err: "{$alert.x120205}" }
	},
	article_excerpt: {
		length: { min: 0, max: 900 },
		validate: { type: "str", format: "text" },
		msg: { id: "msg_article_excerpt", too_long: "{$alert.x120206}" }
	},
	cate_ids: {
		length: { min: 1, max: 0 },
		validate: { type: "checkbox" },
		msg: { id: "msg_cate_ids", too_few: "{$alert.x120207}" }
	},
	article_status: {
		length: { min: 1, max: 0 },
		validate: { type: "radio" },
		msg: { id: "msg_article_status", too_few: "{$alert.x120208}" }
	},
	article_box: {
		length: { min: 1, max: 0 },
		validate: { type: "radio" },
		msg: { id: "msg_article_box", too_few: "{$alert.x120209}" }
	},
	article_time_pub: {
		length: { min: 1, max: 0 },
		validate: { type: "str", format: "datetime" },
		msg: { id: "msg_article_time_pub", too_short: "{$alert.x120210}", format_err: "{$alert.x120211}" }
	}
};
var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=article", btn_text: "{$lang.btn.ok}", btn_url: "{$cfg.str_url}" };

var editor = KindEditor.create("#article_content", k_options);
var editor_excerpt = KindEditor.create("#article_excerpt", k_options);

$(".c_iframe").colorbox({ iframe: true, width: "640px", height: "480px" });

function show_deadline() {
	if ($("#article_deadline").prop("checked")) {
		$(".article_deadline").show();
	} else {
		$(".article_deadline").hide();
	}
}

function show_more() {
	if ($("#article_more").prop("checked")) {
		$(".article_more").show();
	} else {
		$(".article_more").hide();
	}
}

$(document).ready(function(){
	show_deadline();
	show_more();

	var obj_validate_form = $("#article_form").baigoValidator(opts_validator_form);
	var obj_submit_form = $("#article_form").baigoSubmit(opts_submit_form);
	$(".go_submit").click(function(){
		editor.sync();
		editor_excerpt.sync();
		if (obj_validate_form.validateSubmit()) {
			obj_submit_form.formSubmit();
		}
	});
	$("#article_deadline").click(function(){
		show_deadline();
	});

	$("#article_more").click(function(){
		show_more();
	});
});
</script>

{include "include/html_foot.tpl" cfg=$cfg}

