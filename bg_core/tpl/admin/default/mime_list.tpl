{* mime_list.php 允许上传类型列表 *}
{$cfg = [
	title          => "{$adminMod.upfile.main.title} - {$adminMod.upfile.sub.mime.title}",
	css            => "admin_slist",
	menu_active    => "upfile",
	sub_active     => "mime",
	baigoCheckall  => "true",
	colorbox       => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=mime&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<div class="tlist">
		<div class="left_form">
			<form name="mime_form" id="mime_form">
				<input type="hidden" name="token_session" value="{$common.token_session}" />
				<input type="hidden" name="act_post" value="submit" />
				<ol>
					<li class="title">{$lang.label.mimeName}<span id="msg_mime_name">*</span></li>
					<li>
						<input type="text" name="mime_name" id="mime_name" class="validate" />
					</li>

					<li class="line_dashed"> </li>

					<li class="title">{$lang.label.ext}<span id="msg_mime_ext">*</span></li>
					<li>
						<input type="text" name="mime_ext" id="mime_ext" class="validate" />
					</li>

					<li class="line_dashed"> </li>

					<li class="title">{$lang.label.note}<span id="msg_mime_note"></span></li>
					<li>
						<input type="text" name="mime_note" id="mime_note" class="validate" />
					</li>

					<li class="line_dashed"> </li>

					<li><button type="button" id="mime_add">{$lang.btn.add}</button></li>

					<li class="line_dashed"> </li>

					<li class="title">{$lang.label.mimeOften}</li>
					<li>
						{foreach $tplData.mimeRow as $key=>$value}
							<div>
								<input type="radio" value="{$key}" name="mime_name_often" class="mime_name_often" id="mime_name_often_{$key}" />
								<label for="mime_name_often_{$key}" title="{$value.note}">{$key}</label>
							</div>
						{/foreach}
					</li>

				</ol>
			</form>
		</div>

		<div class="right_list">

			<form name="mime_list" id="mime_list">

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
								<div class="float_left">{$lang.label.mimeName}</div>
							</li>
							<li class="float_right">
								<div class="tshort">{$lang.label.ext}</div>
								<div class="tshort">{$lang.label.note}</div>
							</li>
							<li class="float_clear"></li>
						</ol>
					</li>
					<li class="tbody">
						{foreach $tplData.mimeRows as $value}
							<ol id="mime_list_{$value.mime_id}">
								<li class="float_left">
									<div class="tmini"><input type="checkbox" name="mime_id[]" value="{$value.mime_id}" id="mime_id_{$value.mime_id}" class="chk_all validate" group="mime_id" /></div>
									<div class="tmini">{$value.mime_id}</div>
									<div class="float_left">{$value.mime_name}</div>
								</li>
								<li class="float_right">
									<div class="tshort">{$value.mime_ext}</div>
									<div class="tshort">{$value.mime_note}</div>
								</li>
								<li class="float_clear"></li>
							</ol>
						{/foreach}
					</li>
					<li class="tfoot">
						<ol>
							<li class="float_left">
								<div class="tshort"><span id="msg_mime_id"></span></div>
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
	mime_id: {
		length: { min: 1, max: 0 },
		validate: { type: "checkbox" },
		msg: { id: "msg_mime_id", too_few: "{$alert.x030202}" }
	}
};

var obj_mime_list = {$tplData.mimeJson};

var opts_validator_form = {
	mime_name: {
		length: { min: 1, max: 300 },
		validate: { type: "ajax", format: "text" },
		msg: { id: "msg_mime_name", too_short: "{$alert.x080201}", too_long: "{$alert.x080202}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
		ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=mime&act_get=chkname", key: "mime_name", type: "str" }
	},
	mime_ext: {
		length: { min: 1, max: 10 },
		validate: { type: "str", format: "text" },
		msg: { id: "msg_mime_ext", too_short: "{$alert.x080203}", too_long: "{$alert.x080204}" }
	},
	mime_note: {
		length: { min: 0, max: 300 },
		validate: { type: "str", format: "text" },
		msg: { id: "msg_mime_note", too_long: "{$alert.x080205}" }
	}
};

var opts_submit_list = {
	ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=mime",
	confirm_id: "act_post",
	confirm_val: "del",
	confirm_msg: "{$lang.confirm.del}",
	btn_text: "{$lang.btn.ok}",
	btn_url: "{$cfg.str_url}"
};

var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=mime", btn_text: "{$lang.btn.ok}", btn_url: "{$cfg.str_url}" };

$(document).ready(function(){
	$(".chk_all").click(function(){
		var _mime_id = $(this).val();
		if ($(this).prop("checked")) {
			$("#mime_list_" + _mime_id).addClass("div_checked");
		} else {
			$("#mime_list_" + _mime_id).removeClass("div_checked");
		}
	});

	var obj_validate_list = $("#mime_list").baigoValidator(opts_validator_list);
	var obj_submit_list = $("#mime_list").baigoSubmit(opts_submit_list);
	$("#go_submit").click(function(){
		if (obj_validate_list.validateSubmit()) {
			obj_submit_list.formSubmit();
		}
	});
	var obj_validate_form = $("#mime_form").baigoValidator(opts_validator_form);
	var obj_submit_form = $("#mime_form").baigoSubmit(opts_submit_form);
	$("#mime_add").click(function(){
		if (obj_validate_form.validateSubmit()) {
			obj_submit_form.formSubmit();
		}
	});
	//常用MIME
	$(".mime_name_often").click(function(){
		var _this_val = $(this).val();
		var _this_ext = obj_mime_list[_this_val].ext;
		var _this_note = obj_mime_list[_this_val].note;
		$("#mime_name").val(_this_val);
		$("#mime_ext").val(_this_ext);
		$("#mime_note").val(_this_note);
	});
	$("#mime_list").baigoCheckall();
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}

