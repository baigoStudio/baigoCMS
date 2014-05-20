{* admin_callList.tpl 后台用户组 *}
{$cfg = [
	title          => $adminMod.call.main.title,
	css            => "admin_list",
	menu_active    => "call",
	sub_active     => "list",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	colorbox       => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=call&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}


	<h5>
		<div>
			<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=call&act_get=form">+ {$lang.href.add}</a>
		</div>
		<form name="call_search" id="call_search" action="{$smarty.const.BG_URL_ADMIN}admin.php" method="get">
			<input type="hidden" name="mod" value="call" />
			<input type="hidden" name="act_get" value="list" />
			<select name="type">
				<option value="">{$lang.option.allType}</option>
				{foreach $type.call as $key=>$value}
					<option {if $tplData.search.type == $key}selected="selected"{/if} value="{$key}">{$value}</option>
				{/foreach}
			</select>
			<input type="text" name="key" value="{$tplData.search.key}" />
			<button type="submit">{$lang.btn.filter}</button>
		</form>
	</h5>

	<form name="call_list" id="call_list" class="tlist">

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
						<div class="float_left">{$lang.label.callName}</div>
					</li>
					<li class="float_right">
						<div class="tshort">{$lang.label.callType}</div>
					</li>
					<li class="float_clear"></li>
				</ol>
			</li>
			<li class="tbody">
				{foreach $tplData.callRows as $value}
					<ol id="call_list_{$value.call_id}">
						<li class="float_left">
							<div class="tmini"><input type="checkbox" name="call_id[]" value="{$value.call_id}" id="call_id_{$value.call_id}" class="chk_all validate" group="call_id" /></div>
							<div class="tmini">{$value.call_id}</div>
							<div class="float_left">
								<div class="title">{$value.call_name}</div>
								<div class="double"><a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=call&act_get=form&call_id={$value.call_id}">{$lang.href.edit}</a></div>
							</div>
						</li>
						<li class="float_right">
							<div class="tshort">{$type.call[$value.call_type]}</div>
						</li>
						<li class="float_clear"></li>
					</ol>
				{/foreach}
			</li>
			<li class="tfoot">
				<ol>
					<li class="float_left">
						<div class="tshort"><span id="msg_call_id"></span></div>
					</li>
					<li class="float_left">
						<div>
							<input type="hidden" id="act_post" name="act_post" value="del" />
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

{include "include/admin_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_list = {
	call_id: {
		length: { min: 1, max: 0 },
		validate: { type: "checkbox" },
		msg: { id: "msg_call_id", too_few: "{$alert.x030202}" }
	},
	act_post: {
		length: { min: 1, max: 0 },
		validate: { type: "select" },
		msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
	}
};

var opts_submit_list = {
	ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=call",
	confirm_id: "act_post",
	confirm_val: "del",
	confirm_msg: "{$lang.confirm.del}",
	btn_text: "{$lang.btn.ok}",
	btn_url: "{$cfg.str_url}"
};

$(document).ready(function(){
	$(".chk_all").click(function(){
		var _call_id = $(this).val();
		if ($(this).prop("checked")) {
			$("#call_list_" + _call_id).addClass("div_checked");
		} else {
			$("#call_list_" + _call_id).removeClass("div_checked");
		}
	});
	var obj_validate_list = $("#call_list").baigoValidator(opts_validator_list);
	var obj_submit_list = $("#call_list").baigoSubmit(opts_submit_list);
	$("#go_submit").click(function(){
		if (obj_validate_list.validateSubmit()) {
			obj_submit_list.formSubmit();
		}
	});
	$("#call_list").baigoCheckall();
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}
