{* mark_list.tpl 标签列表 *}
{$cfg = [
	title          => "{$adminMod.article.main.title} - {$adminMod.article.sub.mark.title}",
	css            => "admin_slist",
	menu_active    => "article",
	sub_active     => "mark",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	colorbox       => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=mark&{$tplData.query}"
]}

{include "include/admin_head.tpl"}

	<div class="tlist">
		<div class="left_form">
			<form name="mark_form" id="mark_form">
				<input type="hidden" name="token_session" value="{$common.token_session}" />
				<input type="hidden" name="mark_id" value="{$tplData.markRow.mark_id}" />
				<input type="hidden" name="act_post" value="submit" />
				<ol>
					{if $tplData.markRow.mark_id > 0}
						<li class="title_b">{$lang.label.id}: {$tplData.markRow.mark_id}</li>
						<li class="line_dashed"> </li>
					{/if}
					<li class="title">{$lang.label.markName}<span id="msg_mark_name">*</span></li>
					<li><input type="text" name="mark_name" id="mark_name" value="{$tplData.markRow.mark_name}" class="validate" /></li>

					<li class="line_dashed"> </li>

					<li><button type="button" id="mark_add">{$lang.btn.submit}</button></li>
				</ol>
			</form>
		</div>

		<div class="right_list">

			<h5>
				<div><a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=mark&act_get=list">+ {$lang.href.add}</a></div>
				<form name="mark_search" id="mark_search" action="{$smarty.const.BG_URL_ADMIN}admin.php" method="get">
					<input type="hidden" name="mod" value="mark" />
					<input type="hidden" name="act_get" value="list" />
					<input type="text" name="key" value="{$tplData.search.key}" />
					<button type="submit">{$lang.btn.filter}</button>
				</form>
			</h5>

			<form name="mark_list" id="mark_list">

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
								<div class="float_left">{$lang.label.markName}</div>
							</li>
							<li class="float_clear"></li>
						</ol>
					</li>
					<li class="tbody">
						{foreach $tplData.markRows as $value}
						<ol id="mark_list_{$value.mark_id}">
							<li class="float_left">
								<div class="tmini"><input type="checkbox" name="mark_id[]" value="{$value.mark_id}" id="mark_id_{$value.mark_id}" group="mark_id" class="chk_all validate" /></div>
								<div class="tmini">{$value.mark_id}</div>
								<div class="float_left">
									<div class="title">
										{if $value.mark_name}
											{$value.mark_name}
										{else}
											{$lang.label.noname}
										{/if}
									</div>
									<div class="double">
										<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=mark&act_get=list&mark_id={$value.mark_id}&{$tplData.query}">{$lang.href.edit}</a>
									</div>
								</div>
							<li class="float_clear"></li>
						</ol>
						{/foreach}
					</li>
					<li class="tfoot">
						<ol>
							<li class="float_left">
								<div class="tshort"><span id="msg_mark_id"></span></div>
							</li>
							<li class="float_left">
								<div>
									<select name="act_post" id="act_post" class="validate">
										<option value="">{$lang.option.batch}</option>
										{foreach $status.mark as $key=>$value}
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
	mark_id: {
		length: { min: 1, max: 0 },
		validate: { type: "checkbox" },
		msg: { id: "msg_mark_id", too_few: "{$alert.x030202}" }
	},
	act_post: {
		length: { min: 1, max: 0 },
		validate: { type: "select" },
		msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
	}
};

var opts_validator_form = {
	mark_name: {
		length: { min: 1, max: 30 },
		validate: { type: "ajax", format: "text" },
		msg: { id: "msg_mark_name", too_short: "{$alert.x140201}", too_long: "{$alert.x140202}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
		ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=mark&act_get=chkname", key: "mark_name", type: "str", attach: "mark_id={$tplData.markRow.mark_id}" }
	}
};

var opts_submit_list = {
	ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=mark",
	confirm_id: "act_post",
	confirm_val: "del",
	confirm_msg: "{$lang.confirm.del}",
	btn_text: "{$lang.btn.ok}",
	btn_url: "{$cfg.str_url}"
};

var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=mark", btn_text: "{$lang.btn.ok}", btn_url: "{$cfg.str_url}" };

$(document).ready(function(){
	$(".chk_all").click(function(){
		var _mark_id = $(this).val();
		if ($(this).prop("checked")) {
			$("#mark_list_" + _mark_id).addClass("div_checked");
		} else {
			$("#mark_list_" + _mark_id).removeClass("div_checked");
		}
	});
	var obj_validate_list = $("#mark_list").baigoValidator(opts_validator_list);
	var obj_submit_list = $("#mark_list").baigoSubmit(opts_submit_list);
	$("#go_submit").click(function(){
		if (obj_validate_list.validateSubmit()) {
			obj_submit_list.formSubmit();
		}
	});
	var obj_validate_form = $("#mark_form").baigoValidator(opts_validator_form);
	var obj_submit_form = $("#mark_form").baigoSubmit(opts_submit_form);
	$("#mark_add").click(function(){
		if (obj_validate_form.validateSubmit()) {
			obj_submit_form.formSubmit();
		}
	});
	$("#mark_list").baigoCheckall();
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}

