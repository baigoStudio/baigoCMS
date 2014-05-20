{* admin_groupForm.tpl 管理组编辑界面 *}
{$cfg = [
	title          => "{$adminMod.upfile.main.title} - {$adminMod.upfile.sub.thumb.title}",
	css            => "admin_slist",
	menu_active    => "upfile",
	sub_active     => "thumb",
	baigoCheckall  => "true",
	colorbox       => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=thumb&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<div class="tlist">
		<div class="left_form">
			<form name="thumb_form" id="thumb_form">

				<input type="hidden" name="token_session" value="{$common.token_session}" />
				<input type="hidden" name="act_post" value="submit" />
				<ol>
					<li class="title">{$lang.label.thumbWidth}<span id="msg_thumb_width">*</span></li>
					<li>
						<input type="text" name="thumb_width" id="thumb_width" class="validate" />
					</li>

					<li class="line_dashed"> </li>

					<li class="title">{$lang.label.thumbHeight}<span id="msg_thumb_height">*</span></li>
					<li>
						<input type="text" name="thumb_height" id="thumb_height" class="validate" />
					</li>

					<li class="line_dashed"> </li>

					<li class="title">{$lang.label.thumbType}<span id="msg_thumb_type">*</span></li>
					<li>
						{foreach $type.thumb as $_key=>$_value}
							<input type="radio" name="thumb_type" id="thumb_type_{$_key}" {if $_key == "ratio"}checked="checked"{/if} value="{$_key}" class="validate" group="thumb_type" />
							<label for="thumb_type_{$_key}">{$_value}</label>
						{/foreach}
					</li>

					<li class="line_dashed"> </li>

					<li><button type="button" id="thumb_add">{$lang.btn.add}</button></li>
				</ol>
			</form>
		</div>

		<div class="right_list">

			<form name="thumb_list" id="thumb_list">

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
								<div class="float_left">{$lang.label.thumbWidth} X {$lang.label.thumbHeight}</div>
							</li>
							<li class="float_right">
								<div class="tlong">{$lang.label.thumbCall}</div>
								<div class="tshort">{$lang.label.thumbType}</div>
							</li>
							<li class="float_clear"></li>
						</ol>
					</li>
					<li class="tbody">
						{foreach $tplData.thumbRows as $value}
							<ol id="thumb_list_{$value.thumb_id}">
								<li class="float_left">
									<div class="tmini"><input type="checkbox" name="thumb_id[]" value="{$value.thumb_id}" id="thumb_id_{$value.thumb_id}" group="thumb_id" class="chk_all validate" /></div>
									<div class="tmini">{$value.thumb_id}</div>
									<div class="float_left">{$value.thumb_width} X {$value.thumb_height}</div>
								</li>
								<li class="float_right">
									<div class="tlong">thumb_{$value.thumb_width}_{$value.thumb_height}_{$value.thumb_type}</div>
									<div class="tshort">{$type.thumb[$value.thumb_type]}</div>
								</li>
								<li class="float_clear"></li>
							</ol>
						{/foreach}
					</li>
					<li class="tfoot">
						<ol>
							<li class="float_left">
								<div class="tshort"><span id="msg_thumb_id"></span></div>
							</li>
							<li class="float_left">
								<div>
									<input type="hidden" name="act_post" id="act_post" value="del" />
									<button type="button" id="go_submit">{$lang.btn.del}</button>
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

{include "include/admin_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_list = {
	thumb_id: {
		length: { min: 1, max: 0 },
		validate: { type: "checkbox" },
		msg: { id: "msg_thumb_id", too_few: "{$alert.x030202}" }
	}
};

var opts_validator_form = {
	thumb_width: {
		length: { min: 1, max: 0 },
		validate: { type: "str", format: "int" },
		msg: { id: "msg_thumb_width", too_short: "{$alert.x090201}", format_err: "{$alert.x090202}" },
	},
	thumb_height: {
		length: { min: 1, max: 0 },
		validate: { type: "str", format: "int" },
		msg: { id: "msg_thumb_height", too_short: "{$alert.x090203}", format_err: "{$alert.x090204}" }
	},
	thumb_type: {
		length: { min: 1, max: 0 },
		validate: { type: "radio" },
		msg: { id: "msg_thumb_type", too_few: "{$alert.x090205}" }
	}
};

var opts_submit_list = {
	ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=thumb",
	confirm_id: "act_post",
	confirm_val: "del",
	confirm_msg: "{$lang.confirm.del}",
	btn_text: "{$lang.btn.ok}",
	btn_url: "{$cfg.str_url}"
};

var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=thumb", btn_text: "{$lang.btn.ok}", btn_url: "{$cfg.str_url}" };

$(document).ready(function(){
	$(".chk_all").click(function(){
		var _thumb_id = $(this).val();
		if ($(this).prop("checked")) {
			$("#thumb_list_" + _thumb_id).addClass("div_checked");
		} else {
			$("#thumb_list_" + _thumb_id).removeClass("div_checked");
		}
	});
	var obj_validate_list = $("#thumb_list").baigoValidator(opts_validator_list);
	var obj_submit_list = $("#thumb_list").baigoSubmit(opts_submit_list);
	$("#go_submit").click(function(){
		if (obj_validate_list.validateSubmit()) {
			obj_submit_list.formSubmit();
		}
	});
	var obj_validate_form = $("#thumb_form").baigoValidator(opts_validator_form);
	var obj_submit_form = $("#thumb_form").baigoSubmit(opts_submit_form);
	$("#thumb_add").click(function(){
		if (obj_validate_form.validateSubmit()) {
			obj_submit_form.formSubmit();
		}
	});
	$("#thumb_list").baigoCheckall();
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}
