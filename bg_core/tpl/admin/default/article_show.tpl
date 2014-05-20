{* article_form.tpl 文章编辑 *}
{function cate_list arr_cate=""}
	{foreach $arr_cate as $value}
		{if $value.cate_id|in_array:$tplData.articleRow.cate_ids}
			<div>
				{if $value.cate_level > 0}
					{for $_i=1 to $value.cate_level}
						&#160;&#160;&#160;&#160;&#160;&#160;
					{/for}
				{/if}
					<img src="{$smarty.const.BG_URL_IMAGE}allow_y.png" />
					<label>{$value.cate_name}</label>
			</div>
		{/if}

		{if $value.cate_childs}
			{cate_list arr_cate=$value.cate_childs}
		{/if}
	{/foreach}
{/function}

{$cfg = [
	title          => "{$adminMod.article.main.title} - {$lang.page.show}",
	css            => "admin_form",
	menu_active    => "article",
	sub_active     => $sub_active
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<form class="tform">

		<div>
			<ol>
				{if $tplData.articleRow.article_id > 0}
					<li class="title_b">{$lang.label.id}: {$tplData.articleRow.article_id}</li>
					<li class="line_dashed"> </li>
				{/if}
				<li class="title">{$lang.label.articleCate}</li>
				<li>
					{cate_list arr_cate=$tplData.cateRows}
				</li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.status}</li>
				<li>
					<img src="{$smarty.const.BG_URL_IMAGE}allow_{if $tplData.articleRow.article_status == "pub"}y{else}x{/if}.png" />
					<label>{$status.article[$tplData.articleRow.article_status]}</label>
				</li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.timePub}</li>
				<li>
					{$tplData.articleRow.article_time_pub|date_format:"%Y-%m-%d %H:%M"}
				</li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.box}</li>
				<li>
					<img src="{$smarty.const.BG_URL_IMAGE}allow_{if $tplData.articleRow.article_box == "normal"}y{else}x{/if}.png" />
					<label>{$lang.label[$tplData.articleRow.article_box]}</label>
				</li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.articleMark}</li>
				<li>
					 {foreach $tplData.markRows as $value}
						{if $value.mark_id == $tplData.articleRow.article_mark_id}{$value.mark_name}{/if}
					 {/foreach}
				</li>

				<li class="line_dashed"> </li>

				<li class="title_b">
					<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=article&act_get=form&article_id={$tplData.articleRow.article_id}">{$lang.href.edit}</a>
				</li>
			</ol>

			<ul>
				<li class="title">{$lang.label.articleTitle}</li>
				<li class="field">
					{$tplData.articleRow.article_title}
				</li>

				<li class="title">{$lang.label.articleContent}</li>
				<li class="field">
					{$tplData.articleRow.article_content}
				</li>

				<li class="title">{$lang.label.articleTag}</li>
				<li class="field">
					{$tplData.articleRow.article_tag}
				</li>

				<li class="title">{$lang.label.articleLink}</li>
				<li class="field">
					{$tplData.articleRow.article_link}
				</li>
				<li class="title">{$lang.label.articleExcerpt}</li>
				<li class="field">
					{$tplData.articleRow.article_excerpt}
				</li>
				<li class="title_b">
					<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=article&act_get=form&article_id={$tplData.articleRow.article_id}">{$lang.href.edit}</a>
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

