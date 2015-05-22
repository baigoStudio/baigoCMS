{* article_form.tpl 文章编辑 *}
{function cate_select arr="" level=""}
	{foreach $arr as $value}
		<option {if $value.cate_id == $tplData.articleRow.article_cate_id}selected{/if} {if $value.cate_type != "normal"}disabled{/if} value="{$value.cate_id}">
			{if $value.cate_level > 1}
				{for $_i=2 to $value.cate_level}
					&nbsp;&nbsp;
				{/for}
			{/if}
			{$value.cate_name}
		</option>

		{if $value.cate_childs}
			{cate_select arr=$value.cate_childs level=$value.cate_level}
		{/if}
	{/foreach}
{/function}

{function cate_checkbox arr="" level=""}
	<ul class="list-unstyled{if $level > 0} list_padding{/if}">
		{foreach $arr as $value}
			<li>
				<div class="checkbox_baigo">
					<label for="cate_ids_{$value.cate_id}">
						<input type="checkbox" {if $value.cate_id|in_array:$tplData.articleRow.cate_ids}checked{/if} {if $value.cate_type != "normal"}disabled{/if} value="{$value.cate_id}" name="cate_ids[]" id="cate_ids_{$value.cate_id}">
						{$value.cate_name}
					</label>
				</div>

				{if $value.cate_childs}
					{cate_checkbox arr=$value.cate_childs level=$value.cate_level}
				{/if}
			</li>
		{/foreach}
	</ul>
{/function}

{if $tplData.articleRow.article_id == 0}
	{$title_sub = $lang.page.add}
	{$sub_active = "form"}
{else}
	{$title_sub = $lang.page.edit}
	{$sub_active = "list"}
{/if}

{$cfg = [
	title          => "{$adminMod.article.main.title} - {$title_sub}",
	menu_active    => "article",
	sub_active     => $sub_active,
	baigoValidator => "true",
	baigoSubmit    => "true",
	tinymce        => "true",
	datepicker     => "true",
	tagmanager     => "true",
	upload         => "true",
	tokenReload    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=list">{$adminMod.article.main.title}</a></li>
	<li>{$title_sub}</li>

	{include "include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<ul class="list-inline">
			<li>
				<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=list">
					<span class="glyphicon glyphicon-chevron-left"></span>
					{$lang.href.back}
				</a>
			</li>
			<li>
				<a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=article#form" target="_blank">
					<span class="glyphicon glyphicon-question-sign"></span>
					{$lang.href.help}
				</a>
			</li>
		</ul>
	</div>

	<form name="article_form" id="article_form">
		<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
		<input type="hidden" name="act_post" id="act_post" value="submit">
		<input type="hidden" name="article_id" value="{$tplData.articleRow.article_id}">

		<div class="row">
			<div class="col-md-9">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="form-group">
							<div id="group_article_title">
								<label class="control-label">{$lang.label.articleTitle}<span id="msg_article_title">*</span></label>
								<input type="text" name="article_title" id="article_title" value="{$tplData.articleRow.article_title}" class="validate form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label">
								{$lang.label.articleContent}
								<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&act_get=form&view=iframe" class="btn btn-success btn-xs" data-toggle="modal" data-target="#attach_modal">
									<span class="glyphicon glyphicon-picture"></span>
									{$lang.href.uploadList}
								</a>
							</label>
							<textarea name="article_content" id="article_content" class="tinymce text_bg">{$tplData.articleRow.article_content}</textarea>
						</div>

						<label class="control-label">{$lang.label.excerptType}</label>

						<div class="form-group">
							{foreach $type.excerpt as $key=>$value}
								<label for="article_excerpt_type_{$key}" class="radio-inline">
									<input type="radio" name="article_excerpt_type" id="article_excerpt_type_{$key}" {if $tplData.articleRow.article_excerpt_type == $key}checked{/if} value="{$key}" class="article_excerpt_type">
									{$value}
								</label>
							{/foreach}
						</div>

						<div id="group_article_excerpt">
							<div class="form-group">
								<label class="control-label">
									{$lang.label.articleExcerpt}
									<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&act_get=form&view=iframe" class="btn btn-success btn-xs" data-toggle="modal" data-target="#attach_modal">
										<span class="glyphicon glyphicon-picture"></span>
										{$lang.href.uploadList}
									</a>
								</label>
								<textarea name="article_excerpt" id="article_excerpt" class="tinymce text_md">{$tplData.articleRow.article_excerpt}</textarea>
							</div>
						</div>

						<div class="row">
							{foreach $tplData.customRows as $key=>$value}
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">{$value.custom_name}<span id="msg_article_custom_{$value.custom_id}"></span></label>
										<input type="text" name="article_custom[{$value.custom_id}]" value="{if isset($tplData.articleRow.article_custom[{$value.custom_id}])}{$tplData.articleRow.article_custom[{$value.custom_id}]}{/if}" class="form-control">
									</div>
								</div>
							{/foreach}
						</div>

						<label class="control-label">{$lang.label.articleTag}<span id="msg_article_tag"></span></label>

						<div class="form-group form-inline">
							<input type="text" name="article_tag" id="article_tag" class="form-control tm-input tm-input-success">
							<button type="button" class="btn btn-info tm-btn" id="tag_add">{$lang.btn.add}</button>
						</div>

						<div class="form-group">
							<div id="group_article_link" {if $tplData.articleRow.article_link}class="has-warning"{/if}>
								<label class="control-label">{$lang.label.articleLink}<span id="msg_article_link"></span></label>
								<input type="text" name="article_link" id="article_link" value="{$tplData.articleRow.article_link}" class="validate form-control">
								<p class="help-block">{$lang.label.articleLinkNote}</p>
							</div>
						</div>

						<div class="form-group">
							<button type="button" class="go_submit btn btn-primary">{$lang.btn.save}</button>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="well">
					{if $tplData.articleRow.article_id > 0}
						<div class="form-group">
							<label class="control-label">{$lang.label.id}</label>
							<p class="form-control-static">{$tplData.articleRow.article_id}</p>
						</div>
					{/if}

					<div class="form-group">
						<label class="control-label">{$lang.label.articleCate}<span id="msg_article_cate_id">*</span></label>
						<select name="article_cate_id" id="article_cate_id" class="validate form-control">
							<option value="">{$lang.option.pleaseSelect}</option>
							{cate_select arr=$tplData.cateRows}
						</select>
					</div>

					<div class="checkbox">
						<label for="cate_ids_checkbox">
							<input type="checkbox" {if count($tplData.articleRow.cate_ids) > 1}checked{/if} data-toggle="collapse" data-target="#cate_ids_input" id="cate_ids_checkbox">
							{$lang.label.articleBelong}
						</label>
					</div>

					<div class="form-group">
						<div class="collapse{if count($tplData.articleRow.cate_ids) > 1} in{/if}" id="cate_ids_input">
							{cate_checkbox arr=$tplData.cateRows}
						</div>
					</div>

					<label class="control-label">{$lang.label.status}<span id="msg_article_status">*</span></label>
					<div class="form-group">
						{foreach $status.article as $key=>$value}
							<div class="radio_baigo">
								<label for="article_status_{$key}">
									<input type="radio" name="article_status" id="article_status_{$key}" {if $tplData.articleRow.article_status == $key}checked{/if} value="{$key}" class="validate" group="article_status">
									{$value}
								</label>
							</div>
						{/foreach}
					</div>

					<label class="control-label">{$lang.label.box}<span id="msg_article_box">*</span></label>
					<div class="form-group">
						<div class="radio_baigo">
							<label for="article_box_normal">
								<input type="radio" name="article_box" id="article_box_normal" {if $tplData.articleRow.article_box == "normal"}checked{/if} value="normal" class="validate" group="article_box">
								{$lang.label.normal}
							</label>
						</div>
						<div class="radio_baigo">
							<label for="article_box_draft">
								<input type="radio" name="article_box" id="article_box_draft" {if $tplData.articleRow.article_box == "draft"}checked{/if} value="draft" class="validate" group="article_box">
								{$lang.label.draft}
							</label>
						</div>
						<div class="radio_baigo">
							<label for="article_box_recycle">
								<input type="radio" name="article_box" id="article_box_recycle" {if $tplData.articleRow.article_box == "recycle"}checked{/if} value="recycle" class="validate" group="article_box">
								{$lang.label.recycle}
							</label>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label">{$lang.label.articleMark}</label>
						<select name="article_mark_id" class="form-control">
							<option value="">{$lang.option.noMark}</option>
							{foreach $tplData.markRows as $value}
								<option {if $value.mark_id == $tplData.articleRow.article_mark_id}selected{/if} value="{$value.mark_id}">{$value.mark_name}</option>
							{/foreach}
						</select>
					</div>

					<div class="form-group">
						<div class="checkbox">
							<label for="deadline_checkbox">
								<input type="checkbox" {if $tplData.articleRow.article_time_pub > $smarty.now}checked{/if} data-toggle="collapse" data-target="#deadline_input" id="deadline_checkbox">
								{$lang.label.deadline}
								<span id="msg_article_time_pub"></span>
							</label>
						</div>
					</div>

					<div id="deadline_input" class="collapse{if $tplData.articleRow.article_time_pub > $smarty.now} in{/if}">
						<div class="form-group">
							<input type="text" name="article_time_pub" id="article_time_pub" value="{$tplData.articleRow.article_time_pub|date_format:"%Y-%m-%d %H:%M"}" class="validate form-control input_date">
							<p class="help-block">{$lang.label.timeNote}</p>
						</div>
					</div>

					<label class="control-label">{$lang.label.articleSpec}</label>

					<div class="form-group">
						<div class="input-group">
							<input type="text" name="spec_key" id="spec_key" class="form-control" placeholder="{$lang.label.key}">
							<span class="input-group-btn">
								<button type="button" class="btn btn-info" id="spec_search">{$lang.btn.searchSpec}</button>
							</span>
						</div>
					</div>

					<div class="form-group">
						<select name="article_spec_id" class="form-control">
							<option value="">{$lang.option.noSpec}</option>
							{if $tplData.specRow.spec_name}
								<option {if $tplData.specRow.spec_id == $tplData.articleRow.article_spec_id}selected{/if} value="{$tplData.specRow.spec_id}">{$tplData.specRow.spec_name}</option>
							{/if}
							<optgroup label="{$lang.option.pleaseSelect}" id="spec_list"></optgroup>
						</select>
					</div>
					<div class="form-group" id="spec_page"></div>
				</div>
			</div>
		</div>

	</form>

	<div class="modal fade" id="attach_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content"></div>
		</div>
	</div>

{include "include/admin_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	function reload_spec(_key, _page) {
		$("#spec_list").empty();
		$("#spec_page").empty();

		$.getJSON("{$smarty.const.BG_URL_ADMIN}ajax.php?mod=spec&act_get=list&key=" + _key + "&page=" + _page, function(result){

			_str_appent_page = "<ul class=\"pager\">";
				_str_appent_page += "<li class=\"previous";
				if (result.pageRow.page <= 1) {
					_str_appent_page += " disabled";
				}
				_str_appent_page += "\">";
					if (result.pageRow.page <= 1) {
						_str_appent_page += "<span title=\"{$lang.href.pagePrev}\">&laquo; {$lang.href.pagePrev}</span>";
					} else {
						_str_appent_page += "<a href=\"javascript:reload_spec('" + _key + "', " + (result.pageRow.page - 1) + ");\" title=\"{$lang.href.pagePrev}\">&laquo; {$lang.href.pagePrev}</a>";
					}
				_str_appent_page += "</li>";

				_str_appent_page += "<li class=\"next";
				if (result.pageRow.page >= result.pageRow.total) {
					_str_appent_page += " disabled";
				}
				_str_appent_page += "\">";
					if (result.pageRow.page >= result.pageRow.total) {
						_str_appent_page += "<span title=\"{$lang.href.pageNext}\">{$lang.href.pageNext} &raquo;</span>";
					} else {
						_str_appent_page += "<a href=\"javascript:reload_spec('" + _key + "', " + (result.pageRow.page + 1) + ");\" title=\"{$lang.href.pageNext}\">{$lang.href.pageNext} &raquo;</a>";
					}
				_str_appent_page += "</li>";
			_str_appent_page += "</ul>";

			$("#spec_page").append(_str_appent_page);

			$.each(result.specRows, function(i_spec, field_spec){
				_str_appent_spec = "<option value=\"" + field_spec.spec_id + "\">" +
					field_spec.spec_name;
				"</option>";

				$("#spec_list").append(_str_appent_spec);
			});
		});
	}

	var opts_validator_form = {
		article_title: {
			length: { min: 1, max: 300},
			validate: { type: "str", format: "text", group: "group_article_title" },
			msg: { id: "msg_article_title", too_short: "{$alert.x120201}", too_long: "{$alert.x120202}" }
		},
		article_link: {
			length: { min: 0, max: 900 },
			validate: { type: "str", format: "url", group: "group_article_link" },
			msg: { id: "msg_article_link", too_long: "{$alert.x120204}", format_err: "{$alert.x120205}" }
		},
		article_excerpt: {
			length: { min: 0, max: 900 },
			validate: { type: "str", format: "text" },
			msg: { id: "msg_article_excerpt", too_long: "{$alert.x120206}" }
		},
		article_cate_id: {
			length: { min: 1, max: 0 },
			validate: { type: "select" },
			msg: { id: "msg_article_cate_id", too_few: "{$alert.x120207}" }
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

	var opts_submit_form = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=article",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	function excerpt_type(_excerpt_type) {
		if (_excerpt_type == "manual") {
			$("#group_article_excerpt").show();
		} else {
			$("#group_article_excerpt").hide();
		}
	}

	$(document).ready(function(){
		reload_spec("", 1);
		excerpt_type("{$tplData.articleRow.article_excerpt_type}");
		$("#attach_modal").on("hidden.bs.modal", function() {
		    $(this).removeData("bs.modal");
		});

		$(".article_excerpt_type").click(function(){
			var _excerpt_type = $(this).val();
			excerpt_type(_excerpt_type);
		});

		var obj_validate_form = $("#article_form").baigoValidator(opts_validator_form);
		var obj_submit_form   = $("#article_form").baigoSubmit(opts_submit_form);
		$(".go_submit").click(function(){
			tinyMCE.triggerSave();
			if (obj_validate_form.validateSubmit()) {
				obj_submit_form.formSubmit();
			}
		});
		$(".input_date").datetimepicker(opts_datetimepicker);

		var obj_tagMan = jQuery("#article_tag").tagsManager({
			{if $tplData.articleRow.article_tags}
				prefilled: {$tplData.articleRow.article_tags},
			{/if}
			maxTags: 5,
			backspace: ""
		});

		$("#article_tag").typeahead({
			limit: 200,
			prefetch: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=tag&act_get=list"
		}).on("typeahead:selected", function (e, d) {
			obj_tagMan.tagsManager("pushTag", d.value);
		});

		$("#tag_add").on("click", function (e) {
			var _str_tag = $("#article_tag").val();
			obj_tagMan.tagsManager("pushTag", _str_tag);
		});

		$("#spec_search").click(function(){
			var _key = $("#spec_key").val();
			reload_spec(_key, 1);
		});
	});
	</script>

{include "include/html_foot.tpl" cfg=$cfg}

