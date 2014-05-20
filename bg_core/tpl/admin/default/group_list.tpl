{* admin_groupList.tpl 后台用户组 *}
{$cfg = [
	title          => $adminMod.group.main.title,
	css            => "admin_list",
	menu_active    => "group",
	sub_active     => "list",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	colorbox       => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=group&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<h5>
		<div>
			<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=group&act_get=form">+ {$lang.href.add}</a>
		</div>
		<form name="group_search" id="group_search" action="{$smarty.const.BG_URL_ADMIN}admin.php" method="get">
			<input type="hidden" name="mod" value="group" />
			<input type="hidden" name="act_get" value="list" />
			<select name="type">
				<option value="">{$lang.option.allType}</option>
				{foreach $type.group as $key=>$value}
					<option {if $tplData.search.type == $key}selected="selected"{/if} value="{$key}">{$value}</option>
				{/foreach}
			</select>
			<input type="text" name="key" value="{$tplData.search.key}" />
			<button type="submit">{$lang.btn.filter}</button>
		</form>
	</h5>

	<form name="group_list" id="group_list" class="tlist">

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
						<div class="float_left">{$lang.label.group}</div>
					</li>
					<li class="float_right">
						<div class="tlarge">{$lang.label.groupNote}</div>
						<div class="tshort">{$lang.label.groupType}</div>
					</li>
					<li class="float_clear"></li>
				</ol>
			</li>
			<li class="tbody">
				{foreach $tplData.groupRows as $value}
					<ol id="group_list_{$value.group_id}">
						<li class="float_left">
							<div class="tmini"><input type="checkbox" name="group_id[]" value="{$value.group_id}" id="group_id_{$value.group_id}" class="chk_all validate" group="group_id" /></div>
							<div class="tmini">{$value.group_id}</div>
							<div class="float_left">
								<div class="title">{$value.group_name}</div>
								<div class="double">
									<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=group&act_get=show&group_id={$value.group_id}">{$lang.href.show}</a>
									&#160;|&#160;
									<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=group&act_get=form&group_id={$value.group_id}">{$lang.href.edit}</a>
								</div>
							</div>
						</li>
						<li class="float_right">
							<div class="tlarge">{$value.group_note}</div>
							<div class="tshort">{$type.group[$value.group_type]}</div>
						</li>
						<li class="float_clear"></li>
					</ol>
				{/foreach}
			</li>
			<li class="tfoot">
				<ol>
					<li class="float_left">
						<div class="tshort"><span id="msg_group_id"></span></div>
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
	group_id: {
		length: { min: 1, max: 0 },
		validate: { type: "checkbox" },
		msg: { id: "msg_group_id", too_few: "{$alert.x030202}" }
	},
	act_post: {
		length: { min: 1, max: 0 },
		validate: { type: "select" },
		msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
	}
};

var opts_submit_list = {
	ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=group",
	confirm_id: "act_post",
	confirm_val: "del",
	confirm_msg: "{$lang.confirm.del}",
	btn_text: "{$lang.btn.ok}",
	btn_url: "{$cfg.str_url}"
};

$(document).ready(function(){
	$(".chk_all").click(function(){
		var _group_id = $(this).val();
		if ($(this).prop("checked")) {
			$("#group_list_" + _group_id).addClass("div_checked");
		} else {
			$("#group_list_" + _group_id).removeClass("div_checked");
		}
	});
	var obj_validate_list = $("#group_list").baigoValidator(opts_validator_list);
	var obj_submit_list = $("#group_list").baigoSubmit(opts_submit_list);
	$("#go_submit").click(function(){
		if (obj_validate_list.validateSubmit()) {
			obj_submit_list.formSubmit();
		}
	});
	$("#group_list").baigoCheckall();
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}

