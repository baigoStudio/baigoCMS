{* admin_callForm.tpl 管理组编辑界面 *}
{function cate_checkbox arr="" level=""}
	<ul class="list-unstyled{if $level > 0} list_padding{/if}">
		{foreach $arr as $value}
			<li>
				<div class="checkbox_baigo">
					<label for="call_cate_ids_{$value.cate_id}">
						<input type="checkbox" {if $value.cate_id|in_array:$tplData.callRow.call_cate_ids}checked{/if} value="{$value.cate_id}" name="call_cate_ids[]" id="call_cate_ids_{$value.cate_id}" class="call_cate_ids_{$value.cate_parent_id}">
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

{function cate_radio arr="" level=""}
	<ul class="list-unstyled{if $level > 0} list_padding{/if}">
		{foreach $arr as $value}
			<li>
				<div class="radio_baigo">
					<label for="call_cate_id_{$value.cate_id}">
						<input type="radio" {if $tplData.callRow.call_cate_id == $value.cate_id}checked{/if} value="{$value.cate_id}" name="call_cate_id" id="call_cate_id_{$value.cate_id}" {if !$value.cate_childs}disabled="disabled"{/if}>
						{$value.cate_name}
					</label>
				</div>

				{if $value.cate_childs}
					{cate_radio arr=$value.cate_childs level=$value.cate_level}
				{/if}
			</li>
		{/foreach}
	</ul>
{/function}

{if $tplData.callRow.call_id == 0}
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
	baigoCheckall  => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call&act_get=list">{$adminMod.call.main.title}</a></li>
	<li>{$title_sub}</li>

	{include "include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<ul class="list-inline">
			<li>
				<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call&act_get=list">
					<span class="glyphicon glyphicon-chevron-left"></span>
					{$lang.href.back}
				</a>
			</li>
			<li>
				<a href="{$smarty.const.BG_URL_HELP}?lang=zh_CN&mod=help&act=call#form" target="_blank">
					<span class="glyphicon glyphicon-question-sign"></span>
					{$lang.href.help}
				</a>
			</li>
		</ul>
	</div>

	<form name="call_form" id="call_form">

		<input type="hidden" name="token_session" value="{$common.token_session}">
		<input type="hidden" name="act_post" value="submit">
		<input type="hidden" name="call_id" value="{$tplData.callRow.call_id}">

		<div class="row">
			<div class="col-md-9">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="form-group">
							<div id="group_call_name">
								<label for="call_name" class="control-label">{$lang.label.callName}<span id="msg_call_name">*</span></label>
								<input type="text" name="call_name" id="call_name" value="{$tplData.callRow.call_name}" class="validate form-control">
							</div>
						</div>

						<div id="call_article">
							<div class="alert alert-success">{$lang.label.callFilter}</div>

							<div class="form-group">
								<label class="control-label">{$lang.label.callCate}</label>
								<div class="checkbox_baigo">
									<label for="call_cate_ids_0">
										<input type="checkbox" id="call_cate_ids_0">
										{$lang.label.cateAll}
									</label>
								</div>
								{cate_checkbox arr=$tplData.cateRows}
							</div>

							<div class="form-group">
								<label for="call_attach" class="control-label">{$lang.label.callAttach}</label>
								<select id="call_attach" name="call_attach" class="form-control">
									{foreach $type.callAttach as $key=>$value}
										<option {if $tplData.callRow.call_attach == $key}checked{/if} value="{$key}">{$value}</option>
									{/foreach}
								</select>
							</div>

							<label class="control-label">{$lang.label.callMark}<span id="msg_call_mark_ids"></span></label>
							<div class="form-group">
								{foreach $tplData.markRows as $key=>$value}
									<label for="call_mark_ids_{$value.mark_id}" class="checkbox-inline">
										<input type="checkbox" {if $value.mark_id|in_array:$tplData.callRow.call_mark_ids}checked{/if} value="{$value.mark_id}" name="call_mark_ids[]" id="call_mark_ids_{$value.mark_id}">
										{$value.mark_name}
									</label>
								{/foreach}
							</div>

							<div class="alert alert-success">{$lang.label.callShow}</div>

							<label class="control-label">{$lang.label.showBase}<span id="msg_call_show_article">*</span></label>
							<div class="form-group">
								<label for="call_show_cate" class="checkbox-inline">
									<input type="checkbox" name="call_show[cate]" {if $tplData.callRow.call_show.cate == "show"}checked{/if} id="call_show_cate" value="show" group="call_show_article" class="validate">
									{$lang.label.cateName}
								</label>

								<label for="call_show_title" class="checkbox-inline">
									<input type="checkbox" name="call_show[title]" {if $tplData.callRow.call_show.title == "show"}checked{/if} id="call_show_title" value="show" group="call_show_article" class="validate">
									{$lang.label.articleTitle}
								</label>

								<label for="call_show_excerpt" class="checkbox-inline">
									<input type="checkbox" name="call_show[excerpt]" {if $tplData.callRow.call_show.excerpt == "show"}checked{/if} id="call_show_excerpt" value="show" group="call_show_article" class="validate">
									{$lang.label.articleExcerpt}
								</label>

								<label for="call_show_tag" class="checkbox-inline">
									<input type="checkbox" name="call_show[tag]" {if $tplData.callRow.call_show.tag == "show"}checked{/if} id="call_show_tag" value="show" group="call_show_article" class="validate">
									{$lang.label.articleTag}
								</label>
							</div>

							<div class="form-group">
								<label for="call_show_img" class="control-label">{$lang.label.callShowImg}</label>
								<select id="call_show_img" name="call_show[img]" class="form-control">
									<option {if $tplData.callRow.call_show.img == "none"}checked{/if} value="none">{$lang.option.noImg}</option>
									<option {if $tplData.callRow.call_show.img == "original"}checked{/if} value="original">{$lang.option.original}</option>

									{foreach $tplData.thumbRows as $key=>$value}
										<option {if $tplData.callRow.call_show.img == "{$value.thumb_width}_{$value.thumb_height}_{$value.thumb_type}"}checked{/if} value="{$value.thumb_width}_{$value.thumb_height}_{$value.thumb_type}">
										{$value.thumb_width}x{$value.thumb_height} {$type.thumb[$value.thumb_type]}
										</option>
									{/foreach}
								</select>
							</div>

							<div class="form-group">
								<label for="call_show_time" class="control-label">{$lang.label.datetime}</label>
								<select id="call_show_time" name="call_show[time]" class="form-control">
									<option {if $tplData.callRow.call_show.time == "none"}checked{/if} value="none">{$lang.option.noTime}</option>

									<option {if $tplData.callRow.call_show.time == "{$smarty.const.BG_SITE_DATESHORT} {$smarty.const.BG_SITE_TIMESHORT}"}checked{/if} value="{$smarty.const.BG_SITE_DATESHORT} {$smarty.const.BG_SITE_TIMESHORT}">
										{$smarty.now|date_format:"{$smarty.const.BG_SITE_DATESHORT} {$smarty.const.BG_SITE_TIMESHORT}"}
									</option>

									<option {if $tplData.callRow.call_show.time == "{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}checked{/if} value="{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}">
										{$smarty.now|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}
									</option>

									<option {if $tplData.callRow.call_show.time == "{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIME}"}checked{/if} value="{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIME}">
										{$smarty.now|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIME}"}
									</option>

									<option {if $tplData.callRow.call_show.time == "{$smarty.const.BG_SITE_DATESHORT}"}checked{/if} value="{$smarty.const.BG_SITE_DATESHORT}">
										{$smarty.now|date_format:$smarty.const.BG_SITE_DATESHORT}
									</option>

									<option {if $tplData.callRow.call_show.time == "{$smarty.const.BG_SITE_DATE}"}checked{/if} value="{$smarty.const.BG_SITE_DATE}">
										{$smarty.now|date_format:$smarty.const.BG_SITE_DATE}
									</option>

									<option {if $tplData.callRow.call_show.time == "{$smarty.const.BG_SITE_TIMESHORT}"}checked{/if} value="{$smarty.const.BG_SITE_TIMESHORT}">
										{$smarty.now|date_format:$smarty.const.BG_SITE_TIMESHORT}
									</option>

									<option {if $tplData.callRow.call_show.time == "{$smarty.const.BG_SITE_TIME}"}checked{/if} value="{$smarty.const.BG_SITE_TIME}">
										{$smarty.now|date_format:$smarty.const.BG_SITE_TIME}
									</option>
								</select>
							</div>

						</div>

						<div id="call_cate">
							<div class="alert alert-success">{$lang.label.callFilter}</div>

							<div class="form-group">
								<label class="control-label">{$lang.label.callCate}</label>
								<div class="radio_baigo">
									<label for="call_cate_id_0">
										<input type="radio" {if $tplData.callRow.call_cate_id == 0}checked{/if} value="0" name="call_cate_id" id="call_cate_id_0">
										{$lang.label.cateAll}
									</label>
								</div>
								{cate_radio arr=$tplData.cateRows}
							</div>
						</div>

						<div class="form-group">
							<button type="button" class="go_submit btn btn-primary">{$lang.btn.submit}</button>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="well">
					{if $tplData.callRow.call_id > 0}
						<div class="form-group">
							<label class="control-label">{$lang.label.id}</label>
							<p class="form-control-static">{$tplData.callRow.call_id}</p>
						</div>
					{/if}

					<div class="form-group">
						<label for="call_type" class="control-label">{$lang.label.callType}<span id="msg_call_type">*</span></label>
						<select id="call_type" name="call_type" class="validate form-control">
							<option value="">{$lang.option.pleaseSelect}</option>
							{foreach $type.call as $key=>$value}
								<option {if $tplData.callRow.call_type == $key}selected{/if} value="{$key}">{$value}</option>
							{/foreach}
						</select>
					</div>

					{if $smarty.const.BG_MODULE_GEN}
						<div class="form-group">
							<label for="call_file" class="control-label">{$lang.label.callFile}<span id="msg_call_file">*</span></label>
							<select name="call_file" id="call_file" class="validate form-control">
								<option value="">{$lang.option.pleaseSelect}</option>
								{foreach $type.callFile as $key=>$value}
									<option {if $tplData.callRow.call_file == $key}selected{/if} value="{$key}">{$value}</option>
								{/foreach}
							</select>
						</div>
					{/if}

					<label class="control-label">{$lang.label.status}<span id="msg_call_status">*</span></label>
					<div class="form-group">
						{foreach $status.call as $key=>$value}
							<label for="call_status_{$key}" class="radio-inline">
								<input type="radio" name="call_status" id="call_status_{$key}" value="{$key}" class="validate" {if $tplData.callRow.call_status == $key}checked{/if} group="call_status">
								{$value}
							</label>
						{/foreach}
					</div>

					<div class="alert alert-success">{$lang.label.callAmount}</div>

					<div class="form-group">
						<label for="call_amount_top" class="control-label">{$lang.label.callAmoutTop}<span id="msg_call_amount_top">*</span></label>
						<input type="text" name="call_amount[top]" id="call_amount_top" value="{$tplData.callRow.call_amount.top}" class="validate form-control">
					</div>

					<div class="form-group">
						<label for="call_amount_except" class="control-label">{$lang.label.callAmoutExcept}<span id="msg_call_amount_except">*</span></label>
						<input type="text" name="call_amount[except]" id="call_amount_except" value="{$tplData.callRow.call_amount.except}" class="validate form-control">
					</div>

					<div class="form-group">
						<label for="call_trim" class="control-label">{$lang.label.callTrim}<span id="msg_call_trim">*</span></label>
						<input type="text" name="call_trim" id="call_trim" value="{$tplData.callRow.call_trim}" class="validate form-control">
					</div>

					<div class="form-group">
						<label for="call_css" class="control-label">{$lang.label.callCss}<span id="msg_call_css"></span></label>
						<input type="text" name="call_css" id="call_css" value="{$tplData.callRow.call_css}" class="validate form-control">
					</div>
				</div>
			</div>
		</div>
	</form>

{include "include/admin_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_form = {
		call_name: {
			length: { min: 1, max: 300 },
			validate: { type: "ajax", format: "text", group: "group_call_name" },
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
			validate: { type: "str", format: "text" },
			msg: { id: "msg_call_css", too_long: "{$alert.x170214}" }
		},
		call_show_article: {
			length: { min: 1, max: 0 },
			validate: { type: "checkbox" },
			msg: { id: "msg_call_show_article", too_few: "{$alert.x170216}" }
		}
	};
	var opts_submit_form = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=call",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	function call_type(call_type) {
		switch (call_type) {
			case "cate":
				$("#call_article").hide();
				$("#call_cate").show();
			break;

			case "tag":
				$("#call_article").hide();
				$("#call_cate").hide();
			break;

			default:
				$("#call_article").show();
				$("#call_cate").hide();
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

