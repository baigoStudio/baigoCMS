{* tag_list.tpl 标签列表 *}
{$cfg = [
	title          => "{$adminMod.article.main.title} - {$adminMod.article.sub.tag.title}",
	css            => "admin_slist",
	menu_active    => "article",
	sub_active     => "tag",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	colorbox       => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=tag&{$tplData.query}"
]}

{include "include/admin_head.tpl"}

	<div class="tlist">
		<div class="left_form">
			<form name="tag_form" id="tag_form">
				<input type="hidden" name="token_session" value="{$common.token_session}" />
				<input type="hidden" name="tag_id" value="{$tplData.tagRow.tag_id}" />
				<input type="hidden" name="act_post" value="submit" />
				<ol>
					{if $tplData.tagRow.tag_id > 0}
						<li class="title_b">{$lang.label.id}: {$tplData.tagRow.tag_id}</li>
						<li class="line_dashed"> </li>
					{/if}
					<li class="title">{$lang.label.tagName}<span id="msg_tag_name">*</span></li>
					<li><input type="text" value="{$tplData.tagRow.tag_name}" name="tag_name" id="tag_name" class="validate" /></li>

					<li class="line_dashed"> </li>

					<li class="title">{$lang.label.status}<span id="msg_tag_status">*</span></li>
					<li>
						{foreach $status.tag as $key=>$value}
							<input type="radio" name="tag_status" id="tag_status_{$key}" {if $tplData.tagRow.tag_status == $key}checked="checked"{/if} value="{$key}" class="validate" group="tag_status" />
							<label for="tag_status_{$key}">{$value}</label>
						{/foreach}
					</li>

					<li class="line_dashed"> </li>

					<li><button type="button" id="tag_add">{$lang.btn.submit}</button></li>
				</ol>
			</form>
		</div>

		<div class="right_list">
			<h5>
				<div><a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=tag&act_get=list">+ {$lang.href.add}</a></div>
				<form name="tag_search" id="tag_search" action="{$smarty.const.BG_URL_ADMIN}admin.php" method="get">
					<input type="hidden" name="mod" value="tag" />
					<input type="hidden" name="act_get" value="list" />
					<select name="status">
						<option value="">{$lang.option.allStatus}</option>
						{foreach $status.tag as $key=>$value}
							<option {if $tplData.search.status == $key}selected="selected"{/if} value="{$key}">{$value}</option>
						{/foreach}
					</select>
					<input type="text" name="key" value="{$tplData.search.key}" />
					<button type="submit">{$lang.btn.filter}</button>
				</form>
			</h5>

			<form name="tag_list" id="tag_list">
				<input type="hidden" name="token_session" value="{$common.token_session}" />
				<ul>
					<li class="thead">
						<ol>
							<li class="float_left">
								<div class="tmini">
									<input type="checkbox" name="chk_all" id="chk_all" class="first" />
									{$lang.label.all}
								</div>
								<div class="tmini">{$lang.label.id}</div>
								<div class="float_left">{$lang.label.tagName}</div>
							</li>
							<li class="float_right">
								<div class="tshort">{$lang.label.status}</div>
								<div class="tshort">{$lang.label.articleCount}</div>
							</li>
							<li class="float_clear"></li>
						</ol>
					</li>
					<li class="tbody">
						{foreach $tplData.tagRows as $value}
						<ol id="tag_list_{$value.tag_id}">
							<li class="float_left">
								<div class="tmini"><input type="checkbox" name="tag_id[]" value="{$value.tag_id}" id="tag_id_{$value.tag_id}" group="tag_id" class="chk_all validate" /></div>
								<div class="tmini">{$value.tag_id}</div>
								<div class="float_left">
									<div class="title {$value.tag_status}">
										{if $value.tag_name}
											{$value.tag_name}
										{else}
											{$lang.label.noname}
										{/if}
									</div>
									<div class="double">
										<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=tag&act_get=list&tag_id={$value.tag_id}&{$tplData.query}">{$lang.href.edit}</a>
									</div>
								</div>
							</li>
							<li class="float_right {$value.tag_status}">
								<div class="tshort">{$status.tag[$value.tag_status]}</div>
								<div class="tshort">{$value.tag_article_count}</div>
							</li>
							<li class="float_clear"></li>
						</ol>
						{/foreach}
					</li>
					<li class="tfoot">
						<ol>
							<li class="float_left">
								<div class="tshort"><span id="msg_tag_id"></span></div>
							</li>
							<li class="float_left">
								<div>
									<select name="act_post" id="act_post" class="validate">
										<option value="">{$lang.option.batch}</option>
										{foreach $status.tag as $key=>$value}
											<option value="{$key}">{$value}</option>
										{/foreach}
										<option value="del">{$lang.option.del}</option>
									</select>
									<button type="button" id="go_submit">{$lang.btn.submit}</button>
									<span id="msg_act_post"></span>
								</div>
							</li>
							<li class="float_clear"></li>
						</ol>
					</li>
				</ul>
			</form>

			<h6>
				<ul>
					<li class="float_right">
						{include "include/page.tpl" cfg=$cfg}
					</li>
					<li class="float_clear"></li>
				</ul>
			</h6>
		</div>
	</div>

{include "include/admin_foot.tpl"}

<script type="text/javascript">
var opts_validator_list = {
	tag_id: {
		length: { min: 1, max: 0 },
		validate: { type: "checkbox" },
		msg: { id: "msg_tag_id", too_few: "{$alert.x030202}" }
	},
	act_post: {
		length: { min: 1, max: 0 },
		validate: { type: "select" },
		msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
	}
};

var opts_validator_form = {
	tag_name: {
		length: { min: 1, max: 30 },
		validate: { type: "ajax", format: "text" },
		msg: { id: "msg_tag_name", too_short: "{$alert.x130201}", too_long: "{$alert.x130202}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
		ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=tag&act_get=chkname", key: "tag_name", type: "str", attach: "tag_id={$tplData.tagRow.tag_id}" }
	},
	tag_status: {
		length: { min: 1, max: 0 },
		validate: { type: "radio" },
		msg: { id: "msg_tag_status", too_few: "{$alert.x130204}" }
	}
};

var opts_submit_list = {
	ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=tag",
	confirm_id: "act_post",
	confirm_val: "del",
	confirm_msg: "{$lang.confirm.del}",
	btn_text: "{$lang.btn.ok}",
	btn_url: "{$cfg.str_url}"
};

var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=tag", btn_text: "{$lang.btn.ok}", btn_url: "{$cfg.str_url}" };

$(document).ready(function(){
	$(".chk_all").click(function(){
		var _tag_id = $(this).val();
		if ($(this).prop("checked")) {
			$("#tag_list_" + _tag_id).addClass("div_checked");
		} else {
			$("#tag_list_" + _tag_id).removeClass("div_checked");
		}
	});
	var obj_validate_list = $("#tag_list").baigoValidator(opts_validator_list);
	var obj_submit_list = $("#tag_list").baigoSubmit(opts_submit_list);
	$("#go_submit").click(function(){
		if (obj_validate_list.validateSubmit()) {
			obj_submit_list.formSubmit();
		}
	});
	var obj_validate_form = $("#tag_form").baigoValidator(opts_validator_form);
	var obj_submit_form = $("#tag_form").baigoSubmit(opts_submit_form);
	$("#tag_add").click(function(){
		if (obj_validate_form.validateSubmit()) {
			obj_submit_form.formSubmit();
		}
	});
	$("#tag_list").baigoCheckall();
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}

